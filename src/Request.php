<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 08:47
 */

namespace ispConfig;

use ispConfig\Exceptions\ispConfigCannotConnectException;
use ispConfig\Exceptions\ispConfigNoSessionException;
use SoapClient;
use SoapFault;

class Request
{
    /** @var string */
    protected $Method;
    /** @var bool */
    private $test;
    /** @var SoapClient */
    private $client;
    /** @var string  */
    private $host;
    /** @var int  */
    private $port;
    /** @var string  */
    private $path;
    /** @var Monolog */
    private $log;

    public $session_id;

    public function __getLastRequest()
    {
        return $this->client->__getLastRequest();
    }

    /**
     * @param string $host
     * @param int $port
     * @param string $path
     */
    public function setCredentials($host, $port = 8080, $path = 'remote/index.php')
    {
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
    }

    /**
     * @return mixed
     * @throws SoapFault
     * @throws ispConfigNoSessionException
     * @throws ispConfigCannotConnectException
     */
    function send() {
        //$responseObjectName = $this->Method.'Result';

        if($this->Method !== 'login') {
            if (is_null($this->session_id)) {
                throw new ispConfigNoSessionException('Please login first!');
            }
        }

        if(empty($this->host) || empty($this->port) || empty($this->path)) {
            throw new ispConfigCannotConnectException();
        }

        $location = 'https://' . $this->host . ':' . $this->port . '/' . $this->path;
        $parsedUrl = parse_url($location);

        try {
            $opts = [
                'location' => $location,
                'uri' => 'http://' . $this->host . $parsedUrl['path'] . '/',
                'exceptions' => true,
                'trace'        => !$this->test,
                'features'     => SOAP_SINGLE_ELEMENT_ARRAYS,
            ];

            // create soap client in non-wsdl mode
            $this->client = new SoapClient(null, $opts);

            $response = $this->client->__soapCall($this->Method, [["request" => $this]]);
        }
        catch (SoapFault $e) {
            throw $e;
        }

        //return $response->$responseObjectName;
        return $response;
    }
}