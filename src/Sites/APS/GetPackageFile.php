<?php
namespace ispConfig\Sites\APS;

use ispConfig\Request;

class GetPackageFile extends Request
{
    /** @var string  */
    protected $Method = 'sites_aps_get_package_file';
    /** @var string */
    public $session_id;
    /** @var int */
    public $primary_id;
    /** @var string */
    public $filename;

    /**
     * @param string $session_id
     * @param int $primary_id
     * @param string $filename
     */
    public function __construct($session_id, $primary_id, $filename)
    {
        $this->session_id = $session_id;
        $this->primary_id = $primary_id;
        $this->filename = $filename;
    }

}