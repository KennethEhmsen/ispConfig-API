<?php
namespace ispConfig\OpenVZ;

use ispConfig\Request;

class GetFreeIp extends Request
{
    /** @var string  */
    protected $Method = 'openvz_get_free_ip';
    /** @var string */
    public $session_id;
    /** @var int */
    public $server_id;

    /**
     * @param string $session_id
     * @param int $server_id
     */
    public function __construct($session_id, $server_id = 0)
    {
        $this->session_id = $session_id;
        $this->server_id = $server_id;
    }
}