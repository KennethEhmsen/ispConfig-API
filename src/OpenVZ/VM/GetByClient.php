<?php
namespace ispConfig\OpenVZ\VM;

use ispConfig\Request;

class GetByClient extends Request
{
    /** @var string  */
    protected $Method = 'openvz_vm_get_by_client';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;

    /**
     * @param string $session_id
     * @param int $client_id
     */
    public function __construct($session_id, $client_id)
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
    }
}