<?php
namespace ispConfig\Sites\APS;

use ispConfig\Request;

class GetPackageSettings extends Request
{
    /** @var string  */
    protected $Method = 'sites_aps_get_package_settings';
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