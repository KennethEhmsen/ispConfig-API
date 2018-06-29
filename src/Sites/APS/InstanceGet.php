<?php
namespace ispConfig\Sites\APS;

use ispConfig\Request;

class InstanceGet extends Request
{
    /** @var string  */
    protected $Method = 'sites_aps_instance_get';
    /** @var string */
    public $session_id;
    /** @var int */
    public $primary_id;

    /**
     * @param string $session_id
     * @param int $primary_id
     */
    public function __construct($session_id, $primary_id)
    {
        $this->session_id = $session_id;
        $this->primary_id = $primary_id;
    }
}