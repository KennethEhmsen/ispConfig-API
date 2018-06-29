<?php
namespace ispConfig\Dns;

use ispConfig\Request;

class RRGetAllByZone extends Request
{
    /** @var string  */
    protected $Method = 'dns_rr_get_all_by_zone';
    /** @var string */
    public $session_id;
    /** @var int */
    public $zone_id;

    /**
     * Update constructor.
     * @param string $session_id
     * @param int $zone_id
     */
    public function __construct($session_id, $zone_id)
    {
        $this->session_id = $session_id;
        $this->zone_id = $zone_id;
    }
}