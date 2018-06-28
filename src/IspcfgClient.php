<?php
/**
 * @author Jonas Marklén <txc@txc.se>
 * @author Ben Lake <me@benlake.org>
 * @license GNU Lesser Public License v3 (http://opensource.org/licenses/lgpl-3.0.html)
 * @copyright Copyright (c) 2011, Ben Lake
 * @link http://benlake.org/projects/show/ispconfigclient
 *
 * This file is part of the ISPConfig PHP Client.
 *
 * ISPConfig PHP Client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ISPConfig PHP Client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with ISPConfig PHP Client. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * This software is is NO WAY affiliated with ISPConfig. The license of this client does
 * not extend to ISPConfig itself!
 * ISPConfig is Copyright (c) 2007, Till Brehm, projektfarm Gmbh, All rights reserved.
 * You can find the source at http://www.ispconfig.org/ispconfig-3/
 */

namespace ispConfig;

use ispConfig\Exceptions\IspcfgAuthFailed;
use ispConfig\Exceptions\IspcfgCannotConnectException;
use ispConfig\Exceptions\IspcfgException;
use ispConfig\Exceptions\IspcfgInvalidClientException;
use ispConfig\Exceptions\IspcfgInvalidDomainException;
use ispConfig\Exceptions\IspcfgNoSessionException;
use ispConfig\Exceptions\IspcfgUnknownServerException;
use SoapClient;
use SoapFault;

/**
 * Remote API client for ISPConfig3 to support logical operations of Lollipop.
 * Instantiate one object per server you wish to make adjustments to. Do not connect to server1
 * to modify server2 (at least for now as there is no way to specify your server id explicitly).
 * MUST be able to connect over SSL!
 *
 * @package ispconfig3
 * @version 0.1
 */
class ispConfigClient
{
    protected $host;
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
        $opts = [
            'location' => 'https://' . $host . ':' . $port . '/' . $path,
            'uri' => 'http://' . $host . '/remote/',
            'exceptions' => true,
            //'trace' => true,
        ];

        // create soap client in non-wsdl mode
        $this->soap = new SoapClient(null, $opts);

        $this->client_username = $client_username;
        $this->host = $host;
    }

    /**
     * Login to the remote interface (also fetches the server id and client id needed
     * by all other commands)
     * @param $user
     * @param $pass
     * @throws IspcfgAuthFailed
     * @throws IspcfgCannotConnectException
     * @throws IspcfgException
     * @throws IspcfgInvalidClientException
     * @throws IspcfgUnknownServerException
     */
    public function login($user, $pass)
    {
        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->session_id = $this->soap->login($user, $pass);
        } catch (SoapFault $e) {
            if (strpos($e->getMessage(), 'login failed') !== false) {
                throw new IspcfgAuthFailed($e->getMessage(), 403);
            } else {
                throw new IspcfgCannotConnectException($e->getMessage(), 0);
            }
        }

        // grab the client id necessary for any other command
        $this->client_id = $this->fetchClientId($this->client_username);
        $this->server_id = $this->fetchServerId($this->host);
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
     * @throws IspcfgException
     * @throws IspcfgInvalidDomainException
     * @throws IspcfgNoSessionException
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
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->dns_a_add($this->session_id, $this->client_id, $params);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
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
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->dns_mx_add($this->session_id, $this->client_id, $params);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
        }

        return true;
    }

    /**
     * Setup mail for a domain and setup default SPAM policy.
     * @param string the domain to add
     * @return boolean
     * @throws IspcfgException
     * @throws IspcfgNoSessionException
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
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->mail_domain_add($this->session_id, $this->client_id, $params);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
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
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->mail_spamfilter_user_add($this->session_id, $this->client_id, $params);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
        }

        return true;
    }

    /**
     * Add a new mail account to domain with SPAM policy
     * @param string the domain the email account is being added to
     * @param string the name (that which precedes @) of the mail account
     * @param string the password for the mail account
     * @param integer [50] number in MB of mail quota
     * @param string [normal] the spam policy to set for the mail account
     * @return boolean
     * @throws IspcfgException
     * @throws IspcfgNoSessionException
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
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->mail_user_add($this->session_id, $this->client_id, $params);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
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
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->mail_spamfilter_user_add($this->session_id, $this->client_id, $params);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
        }

        return true;
    }

    /**
     * Remove a top-level domain and associated records from DNS.
     * @param string $domain the fully qualified domain name (or subdomain)
     * @return boolean true on success
     * @throws IspcfgInvalidDomainException if the domain does not exist
     * @throws IspcfgException
     * @throws IspcfgNoSessionException
     */
    public function removeDomain($domain)
    {
        $this->checkSession();

        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $r = $this->soap->dns_delete_all($this->session_id, $domain);

            if (empty($r)) {
                throw new IspcfgInvalidDomainException('Domain ' . $domain . ' was not found');
            }
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
        }

        return true;
    }

    /**
     * Remove a subdomain and associated records from DNS.
     * Removes a subdomain to from a top level domain and any A, CNAME, MX records that are related.
     * TODO maybe some basic validation on the TLD and IP?
     * @param $tld
     * @param $name
     * @return
     * @throws IspcfgException
     * @throws IspcfgNoSessionException
     */
    public function removeSubdomain($tld, $name)
    {
        $this->checkSession();

        try {
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->soap->dns_delete_subdomain($this->session_id, $tld, $name);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
        }
    }

    /**
     * Remove a mail domain, all associated users, and any spam settings for the domain or users.
     * @param string the fully qualified domain name (or subdomain)
     * @return boolean true on success
     * @throws IspcfgInvalidDomainException if the domain does not exist
     * @throws IspcfgException
     * @throws IspcfgNoSessionException
     */
    public function removeMailDomain($domain)
    {
        $this->checkSession();

        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $r = $this->soap->mail_domain_get_by_domain($this->session_id, $domain);

            if (empty($r)) {
                throw new IspcfgInvalidDomainException('Domain ' . $domain . ' was not found');
            }

            $domain_id = $r[0]['domain_id'];

            $this->removeMailAccounts($domain);

            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->mail_spamfilter_user_delete_by_email($this->session_id, '@' . $domain);
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->mail_domain_delete($this->session_id, $domain_id);
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
        }

        return true;
    }

    /**
     * Remove all mail accounts for a mail domain.
     * @param string $domain the fully qualified domain name (or subdomain)
     * @param array $only optional list of mail accounts to delete, all are delete if not specified (<user>@domain.com)
     * @return boolean false if no users were found, true if any were found and successfully removed
     * @throws IspcfgException
     * @throws IspcfgNoSessionException
     */
    public function removeMailAccounts($domain, $only = [])
    {
        $this->checkSession();

        // affix the domain to each specified user to make comparison tolerable
        if (!empty($only)) {
            foreach ($only as $k => $u) {
                $only[$k] = $u . '@' . $domain;
            }
        }

        try {
            // TODO should probably add a parameter or method to only bring back specified users
            /** @noinspection PhpUndefinedMethodInspection */
            $users = $this->soap->mail_domain_get_users($this->session_id, $domain);

            if (empty($users)) {
                return false;
            }

            foreach ($users as $r) {
                if (!empty($only) && array_search($r['email'], $only, true) === false) {
                    continue;
                }

                /** @noinspection PhpUndefinedMethodInspection */
                $this->soap->mail_spamfilter_user_delete_by_email($this->session_id, $r['email']);
                /** @noinspection PhpUndefinedMethodInspection */
                $this->soap->mail_user_delete($this->session_id, $r['mailuser_id']);
            }
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage());
        }

        return true;
    }

    /**
     * Logout of the remote interface
     * @throws IspcfgNoSessionException
     * @throws IspcfgException
     */
    public function logout()
    {
        $this->checkSession();

        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->soap->logout($this->session_id);
            $this->session_id = null;
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage(), 500);
        }
    }

    /**
     * Logout if the object is destroyed and logout was not called.
     * @throws IspcfgException
     */
    public function __destruct()
    {
        if (!is_null($this->session_id)) {
            try {
                $this->logout();
            } catch (IspcfgException $e) {
                // Something abnormal happened, return throw the error to user
                throw $e;
            } catch (IspcfgNoSessionException $e) {
                // Should never happen
            }
        }
    }

    /**
     * Retrieve the server id from the specified IP address.
     * @param string the server's hostname or IP address
     * @return string
     * @throws IspcfgException
     * @throws IspcfgUnknownServerException
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
            throw new IspcfgException('Unable to determine IP for host ' . $host);
        }

        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $server_id = $this->soap->server_get_serverid_by_ip($this->session_id, $ip);

            if (is_array($server_id)) {
                $server_id = array_pop($server_id);
            }

            if ($server_id === false || !isset($server_id['server_id'])) {
                throw new IspcfgUnknownServerException('No server found with IP ' . $ip);
            }

            $server_id = $server_id['server_id'];

        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage(), 500);
        }
        return $server_id;
    }

    /**
     * Retrieve the client id from the provided username. This value is necessary for nearly
     * every other commands.
     * @param string the client username
     * @return integer
     * @throws IspcfgInvalidClientException if the client is not found
     * @throws IspcfgException
     */
    protected function fetchClientId($username)
    {
        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $client_id = $this->soap->client_get_by_username(
                $this->session_id,
                $username
            );

            if ($client_id === false || !isset($client_id['client_id'])) {
                throw new IspcfgInvalidClientException('Client username not found');
            }

            $client_id = $client_id['client_id'];

        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage(), 500);
        }
        return $client_id;
    }

    /**
     * Retrieve the zone id for a domain which is an internal identifier needed when
     * calling dns related commands.
     * TODO cache zone id lookups performed while this object is alive
     * @param string the domain name to fetch the zone id for
     * @return integer
     * @throws IspcfgInvalidDomainException
     * @throws IspcfgException
     */
    protected function fetchZoneId($root_tld)
    {
        // the value returned will have a trailing dot so add for comparison
        $root_tld .= '.';
        $zone_id = null;

        try {
            /** @noinspection PhpUndefinedMethodInspection */
            $zones = $this->soap->dns_zone_get_by_user(
                $this->session_id,
                $this->client_id,
                $this->server_id
            );
            if (is_array($zones)) {
                foreach ($zones as $z) {
                    if ($z['origin'] == $root_tld) {
                        $zone_id = $z['id'];
                        break;
                    }
                }
            } else {
                throw new IspcfgInvalidDomainException('The domain ' . $root_tld . ' is not valid for this client');
            }
        } catch (SoapFault $e) {
            throw new IspcfgException($e->getMessage(), 500);
        }
        return $zone_id;
    }

    /**
     * Verify we've logged into the remote interface successfully.
     * @throws IspcfgNoSessionException
     */
    protected function checkSession()
    {
        if (is_null($this->session_id)) {
            throw new IspcfgNoSessionException('Please login first!');
        }
    }

}