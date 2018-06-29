<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 14:48
 */

namespace ispConfig\Server;

use ispConfig\Request;

class GetServerIdByIp extends Request
{
    /** @var string  */
    protected $Method = 'server_get_serverid_by_ip';
    /** @var string */
    public $session_id;
    /** @var string */
    public $ipaddress;

    /**
     * GetServerIdByIp constructor.
     * @param string $session_id
     * @param string $ipaddress
     */
    public function __construct($session_id, $ipaddress)
    {
        $this->session_id = $session_id;
        $this->ipaddress = $ipaddress;
    }

}