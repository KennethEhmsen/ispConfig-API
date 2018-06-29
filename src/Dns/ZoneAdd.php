<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 16:30
 */

namespace ispConfig\Dns;

use ispConfig\Request;

class ZoneAdd extends Request
{
    /** @var string  */
    protected $Method = 'dns_zone_add';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var array  */
    public $params;

    /**
     * @param string $session_id
     * @param int $client_id
     * @param array $params Parameters:
     *      server_id   int(11)
     *      origin      varchar(255)
     *      ns          varchar(255)
     *      mbox        varchar(255)
     *      serial      int(11)
     *      refresh     int(11)
     *      retry       retry(11)
     *      expire      int(11)
     *      minimum     int(11)
     *      ttl         int(11)
     *      active      enum('n','y')
     *      xfer        varchar(255)
     *      also_notify varchar(255)
     *      update_acl  varchar(255)
     * Returns the ID of the newly added dns zone.
     */
    public function __construct($session_id, $client_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->params = $params;
    }
}