<?php
namespace ispConfig\Sites\APS;

use ispConfig\Request;

class InstanceDelete extends Request
{
    /** @var string  */
    protected $Method = 'sites_aps_instance_delete';
    /** @var string */
    public $session_id;
    /** @var int */
    public $primary_id;
    /** @var array */
    public $params;

    /**
     * @param string $session_id
     * @param int $primary_id
     * @param array $params
     *      keep_database       boolean
     */
    public function __construct($session_id, $primary_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->primary_id = $primary_id;
        $this->params = $params;
    }
}