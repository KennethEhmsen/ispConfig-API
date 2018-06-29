<?php
namespace ispConfig\Dns;

use ispConfig\Request;

class SetStatus extends Request
{
    protected $Method = 'dns_zone_get';
    /** @var string */
    public $session_id;
    /** @var int */
    public $primary_id;
    /** @var string */
    public $status;

    /**
     * Get constructor.
     * @param string $session_id
     * @param int $primary_id
     * @param string $status Either 'active' or 'inactive'
     */
    public function __construct($session_id, $primary_id, $status)
    {
        $this->session_id = $session_id;
        $this->primary_id = $primary_id;
        $this->status = $status;
    }
}