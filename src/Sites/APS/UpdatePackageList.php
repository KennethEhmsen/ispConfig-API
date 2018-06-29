<?php
namespace ispConfig\Sites\APS;

use ispConfig\Request;

class UpdatePackageList extends Request
{
    /** @var string  */
    protected $Method = 'sites_aps_update_package_list';
    /** @var string */
    public $session_id;

    /**
     * @param string $session_id
     */
    public function __construct($session_id)
    {
        $this->session_id = $session_id;
    }
}