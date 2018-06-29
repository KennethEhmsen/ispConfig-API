<?php
namespace ispConfigClient;

use ispConfig\Exceptions\ispConfigAuthFailed;
use ispConfig\Exceptions\ispConfigCannotConnectException;
use ispConfig\Exceptions\ispConfigException;
use ispConfig\Exceptions\ispConfigInvalidClientException;
use ispConfig\Exceptions\ispConfigInvalidDomainException;
use ispConfig\Exceptions\ispConfigMissingConfiguration;
use ispConfig\Exceptions\ispConfigNoSessionException;
use ispConfig\Exceptions\ispConfigUnknownServerException;
use SoapFault;

/**
 * Remote API client for ISPConfig3 to support logical operations of Lollipop.
 * Instantiate one object per server you wish to make adjustments to. Do not connect to server1
 * to modify server2 (at least for now as there is no way to specify your server id explicitly).
 * MUST be able to connect over SSL!
 *
 * @package ispConfig-API
 * @version 0.2.0
 *
 * @see https://git.ispconfig.org/ispconfig/ispconfig3/tree/master/remoting_client/API-docs
 */
class ispConfigClient
{
    protected $server_id;
    protected $soap;
    protected $client_username;
    protected $client_id;
    protected $session_id;

    /**
     * @param string the hostname of the ISPConfig3 server
     * @param string the client username this client will manipulate
     * @param int [8080] the port number
     * @param string [remote/index.php] the path of the web services endpoint
     */
    function __construct($host, $client_username, $port = 8080, $path = 'remote/index.php')
    {
        \ispConfig\Request::setCredentials($host, $port, $path);
        $this->client_username = $client_username;
    }

    /**
     * Login to the remote interface (also fetches the server id and client id needed
     * by all other commands)
     * @param $user
     * @param $pass
     * @throws ispConfigAuthFailed
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigInvalidClientException
     * @throws ispConfigUnknownServerException
     * @throws ispConfigNoSessionException
     * @throws ispConfigMissingConfiguration
     */
    public function login($user, $pass)
    {
        try {
            $login = new \ispConfig\System\Login($user, $pass);
            $this->session_id = $login->send();
        } catch (SoapFault $e) {
            if (strpos($e->getMessage(), 'login failed') !== false) {
                throw new ispConfigAuthFailed($e->getMessage(), 403);
            } else {
                throw new ispConfigCannotConnectException($e->getMessage(), 0);
            }
        }

        // grab the client id necessary for any other command
        $this->client_id = $this->fetchClientId($this->client_username);
        $this->server_id = $this->fetchServerId(\ispConfig\Request::$host);
    }

    /**
     * Adds a subdomain to one of the clients domains. Does the following:
     * 1. Adds a A record for <name>.tld
     * 2. Adds an MX record for <name>.tld to mail.tld
     * @todo maybe some basic validation on the TLD and IP?
     * @param $tld
     * @param $name
     * @param $ip
     * @return boolean
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigInvalidDomainException
     * @throws ispConfigMissingConfiguration
     * @throws ispConfigNoSessionException
     */
    public function addSubdomain($tld, $name, $ip)
    {
        $this->checkSession();

        $zone_id = $this->fetchZoneId($tld);

        // add the A record
        $params = [
            'server_id' => $this->server_id,
            'zone' => $zone_id,
            'type' => 'A',
            'name' => $name,
            'data' => $ip,
            'ttl' => '86400',
            'active' => 'y',
        ];
        try {
            $dns = new \ispConfig\Dns\A\Add($this->session_id, $this->client_id, $params);
            $dns->send();
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        // add the MX record
        $params = [
            'server_id' => $this->server_id,
            'zone' => $zone_id,
            'type' => 'MX',
            'name' => $name . '.' . $tld . '.',
            'data' => 'mail.' . $tld . '.',
            'ttl' => '86400',
            'aux' => '10',
            'active' => 'y',
        ];
        try {
            $dns = new \ispConfig\Dns\MX\Add($this->session_id, $this->client_id, $params);
            $dns->send();
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        return true;
    }

    /**
     * Setup mail for a domain and setup default SPAM policy.
     * @param string the domain to add
     * @return boolean
     * @throws ispConfigMissingConfiguration
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigNoSessionException
     */
    public function addMailDomain($domain)
    {
        $this->checkSession();

        // Add domain to mailserver
        $params = [
            'server_id' => $this->server_id,
            'domain' => $domain,
            'active' => 'y',
        ];
        try {
            $mail = new \ispConfig\Mail\Domain\Add($this->session_id, $this->client_id, $params);
            $mail->send();
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        // Add spam policy for domain
        $params = [
            'server_id' => $this->server_id,
            'priority' => 5,
            'policy_id' => 5, // Normal
            'email' => '@' . $domain,
            'fullname' => '@' . $domain,
            'local' => 'Y',
        ];
        try {
            $spamfilter = new \ispConfig\Mail\Spamfilter\User\Add($this->session_id, $this->client_id, $params);
            $spamfilter->send();
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        return true;
    }

    /**
     * Add a new mail account to domain with SPAM policy
     * @param $domain
     * @param $mailbox
     * @param $passwd
     * @param int $quota
     * @param string $spam
     * @return boolean
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigMissingConfiguration
     * @throws ispConfigNoSessionException
     */
    public function addMailAccount($domain, $mailbox, $passwd, $quota = 50, $spam = 'normal')
    {
        $this->checkSession();

        switch ($spam) {
            default:
                $spam = 5;
                break;
        }

        // Add mail user
        $params = [
            'server_id' => $this->server_id,
            'email' => $mailbox . '@' . $domain,
            'name' => $mailbox,
            'password' => $passwd,
            'quota' => intval($quota) * pow(1024, 2), // bytes converted to MB
            'postfix' => 'y', // enable receiving
            'homedir' => '/var/vmail',
            'maildir' => '/var/vmail/' . $domain . '/' . $mailbox,
            'uid' => 5000,
            'gid' => 5000,
        ];
        try {
            $mail = new \ispConfig\Mail\User\Add($this->session_id, $this->client_id, $params);
            $mail->send();
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        // Add mail user's spam policy
        $params = [
            'server_id' => $this->server_id,
            'priority' => 10,
            'policy_id' => $spam, // Normal
            'email' => $mailbox . '@' . $domain,
            'fullname' => $mailbox,
            'local' => 'Y',
        ];
        try {
            $spamfilter = new \ispConfig\Mail\Spamfilter\User\Add($this->session_id, $this->client_id, $params);
            $spamfilter->send();
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        return true;
    }

    /**
     * Remove a top-level domain and associated records from DNS.
     * @param string $domain the fully qualified domain name (or subdomain)
     * @return boolean true on success
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigInvalidDomainException if the domain does not exist
     * @throws ispConfigMissingConfiguration
     * @throws ispConfigNoSessionException
     */
    public function removeDomain($domain)
    {
        $this->checkSession();

        try {
            $dns = new \ispConfig\Domain\Delete($this->session_id, $domain);
            $dns->send();

            if (empty($r)) {
                throw new ispConfigInvalidDomainException('Domain ' . $domain . ' was not found');
            }
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        return true;
    }

    /**
     * Remove a mail domain, all associated users, and any spam settings for the domain or users.
     * @param string the fully qualified domain name (or subdomain)
     * @return boolean true on success
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigInvalidDomainException if the domain does not exist
     * @throws ispConfigMissingConfiguration
     * @throws ispConfigNoSessionException
     */
    public function removeMailDomain($domain)
    {
        $this->checkSession();

        try {
            $mail = new \ispConfig\Mail\Domain\GetByDomain($this->session_id, $domain);
            $r = $mail->send();

            if (empty($r)) {
                throw new ispConfigInvalidDomainException('Domain ' . $domain . ' was not found');
            }

            $domain_id = $r[0]['domain_id'];

            /*
            $this->removeMailAccounts($domain);
            $mail = new \ispConfig\Mail\Spamfilter\User\Delete();
            $mail->send();
            $this->soap->mail_spamfilter_user_delete_by_email($this->session_id, '@' . $domain);
            */

            $mail = new \ispConfig\Mail\Domain\Delete($this->session_id, $domain_id);
            $mail->send();
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage());
        }

        return true;
    }


    /**
     * Logout of the remote interface
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigMissingConfiguration
     * @throws ispConfigNoSessionException
     */
    public function logout()
    {
        $this->checkSession();

        try {
            $logout = new \ispConfig\System\Logout($this->session_id);
            $logout->send();
            $this->session_id = null;
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage(), 500);
        } catch (ispConfigCannotConnectException $e) {
            throw $e;
        } catch (ispConfigNoSessionException $e) {
            throw $e;
        }
    }

    /**
     * Logout if the object is destroyed and logout was not called.
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigMissingConfiguration
     */
    public function __destruct()
    {
        if (!is_null($this->session_id)) {
            try {
                $this->logout();
            } catch (ispConfigException $e) {
                // Something abnormal happened, return throw the error to user
                throw $e;
            } catch (ispConfigNoSessionException $e) {
                // Should never happen
            }
        }
    }

    /**
     * Retrieve the server id from the specified IP address.
     * @param string the server's hostname or IP address
     * @return string
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigMissingConfiguration
     * @throws ispConfigNoSessionException
     * @throws ispConfigUnknownServerException
     */
    protected function fetchServerId($host)
    {
        // TODO make IPv6 aware
        if (preg_match('/^\d+/', $host) != 1) {
            $ip = gethostbyname($host);
        } else {
            $ip = $host;
        }

        if (empty($ip)) {
            throw new ispConfigException('Unable to determine IP for host ' . $host);
        }

        try {
            $server = new \ispConfig\Server\GetServerIdByIp($this->session_id, $ip);
            $server_id = $server->send();

            if (is_array($server_id)) {
                $server_id = array_pop($server_id);
            }

            if ($server_id === false || !isset($server_id['server_id'])) {
                throw new ispConfigUnknownServerException('No server found with IP ' . $ip);
            }

            $server_id = $server_id['server_id'];

        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage(), 500);
        }
        return $server_id;
    }

    /**
     * Retrieve the client id from the provided username. This value is necessary for nearly
     * every other commands.
     * @param string the client username
     * @return int
     * @throws ispConfigCannotConnectException
     * @throws ispConfigException
     * @throws ispConfigInvalidClientException if the client is not found
     * @throws ispConfigNoSessionException
     * @throws ispConfigMissingConfiguration
     */
    protected function fetchClientId($username)
    {
        try {
            $client = new \ispConfig\Client\GetByUsername($this->session_id, $username);
            $client_id = $client->send();

            if ($client_id === false || !isset($client_id['client_id'])) {
                throw new ispConfigInvalidClientException('Client username not found');
            }

            $client_id = $client_id['client_id'];

        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage(), 500);
        }
        return $client_id;
    }

    /**
     * Retrieve the zone id for a domain which is an internal identifier needed when
     * calling dns related commands.
     * TODO cache zone id lookups performed while this object is alive
     * @param string the domain name to fetch the zone id for
     * @return integer
     * @throws ispConfigInvalidDomainException
     * @throws ispConfigException
     * @throws ispConfigNoSessionException
     * @throws ispConfigCannotConnectException
     * @throws ispConfigMissingConfiguration
     */
    protected function fetchZoneId($root_tld)
    {
        // the value returned will have a trailing dot so add for comparison
        $root_tld .= '.';
        $zone_id = null;

        try {
            $zone = new \ispConfig\Dns\GetByUser($this->session_id, $this->client_id, $this->server_id);
            $zones = $zone->send();
            if (is_array($zones)) {
                foreach ($zones as $z) {
                    if ($z['origin'] == $root_tld) {
                        $zone_id = $z['id'];
                        break;
                    }
                }
            } else {
                throw new ispConfigInvalidDomainException('The domain ' . $root_tld . ' is not valid for this client');
            }
        } catch (SoapFault $e) {
            throw new ispConfigException($e->getMessage(), 500);
        }
        return $zone_id;
    }

    /**
     * Verify we've logged into the remote interface successfully.
     * @throws ispConfigNoSessionException
     */
    protected function checkSession()
    {
        if (is_null($this->session_id)) {
            throw new ispConfigNoSessionException('Please login first!');
        }
    }
}