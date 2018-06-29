<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:10
 */

namespace ispConfig\Dns;

use ispConfig\Request;

class Add extends Request
{
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var array  */
    public $params;

    /**
     * Update constructor.
     * @param string $session_id
     * @param int $client_id
     * @param array $params Parameters:
     *      server_id   int(11)
     *      zone        int(11)
     *      name        varchar(64)
     *      type        enum('a','aaaa','alias','cname','hinfo','mx''naptr','ns','ptr','rp','srv','txt')
     *      data        varchar(255)
     *      aux         int(11)
     *      ttl         int(11)
     *      active      enum('n','y')
     *      stamp       timestamp
     *      serial      int(10)
     * Returns the ID of the newly added resource record.
     */
    public function __construct($session_id, $client_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->params = $params;
    }

    /**
     * @return mixed|void
     * @throws \SoapFault
     * @throws \ispConfig\Exceptions\ispConfigCannotConnectException
     * @throws \ispConfig\Exceptions\ispConfigNoSessionException
     * @throws \ispConfig\Exceptions\ispConfigMissingConfiguration
     */
    public function send()
    {
        if(empty($this->Method)) {
            throw new \ispConfig\Exceptions\ispConfigMissingConfiguration();
        }
        parent::send();
    }
}