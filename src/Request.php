<?php
namespace ispConfig;

use ispConfig\Exceptions\ispConfigCannotConnectException;
use ispConfig\Exceptions\ispConfigMissingConfiguration;
use ispConfig\Exceptions\ispConfigNoSessionException;
use SoapClient;
use SoapFault;

class Request
{
    /** @var string */
    protected $Method;
    /** @var bool */
    private static $test;
    /** @var SoapClient */
    private static $client;
    /** @var string  */
    public static $host;
    /** @var int  */
    private static $port;
    /** @var string  */
    private static $path;
    /** @var string */
    public $session_id;

    /**
     * @throws ispConfigCannotConnectException
     */
    private static function connect()
    {
        if (empty(self::$host) || empty(self::$port) || empty(self::$path)) {
            throw new ispConfigCannotConnectException();
        }

        $location = 'https://' . self::$host . ':' . self::$port . '/' . self::$path;
        $parsedUrl = parse_url($location);

        $opts = [
            'location' => $location,
            'uri' => 'http://' . self::$host . $parsedUrl['path'] . '/',
            'exceptions' => true,
            'trace' => !self::$test,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
        ];

        // create soap client in non-wsdl mode
        self::$client = new SoapClient(null, $opts);
    }

    public function __getLastRequest()
    {
        return self::$client->__getLastRequest();
    }

    /**
     * @param string $host
     * @param int $port
     * @param string $path
     */
    public static function setCredentials($host, $port = 8080, $path = 'remote/index.php')
    {
        self::$host = $host;
        self::$port = $port;
        self::$path = $path;
    }

    /**
     * @return mixed
     * @throws SoapFault
     * @throws ispConfigNoSessionException
     * @throws ispConfigCannotConnectException
     * @throws ispConfigMissingConfiguration
     */
    function send() {
        //$responseObjectName = $this->Method.'Result';

        if(empty($this->Method)) {
            throw new ispConfigMissingConfiguration();
        }

        if($this->Method !== 'login') {
            if (is_null($this->session_id)) {
                throw new ispConfigNoSessionException('Please login first!');
            }
        }

        if(empty(self::$client)) {
            self::connect();
        }

        try {
            $response = self::$client->__soapCall($this->Method, [['request' => $this]]);
        }
        catch (SoapFault $e) {
            throw $e;
        }

        //return $response->$responseObjectName;
        return $response;
    }
}