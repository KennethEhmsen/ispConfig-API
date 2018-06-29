<?php
namespace ispConfig\Sites\APS;

use ispConfig\Request;

class AvailablePackagesList extends Request
{
    /** @var string  */
    protected $Method = 'sites_aps_available_packages_list';
    /** @var string */
    public $session_id;
    /** @var array */
    public $params;

    /**
     * @param string $session_id
     * @param array $params
     *      all_packages    bool
     */
    public function __construct($session_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->params = $params;
    }
}