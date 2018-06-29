<?php
namespace ispConfig\Server;

use ispConfig\Request;

class Get extends Request
{
    /** @var string  */
    protected $Method = 'server_get';
    /** @var string */
    public $session_id;
    /** @var int */
    public $server_id;
    /** @var string */
    public $section;

    /**
     * @param string $session_id
     * @param int $server_id
     * @param string $section
     */
    public function __construct($session_id, $server_id, $section = '')
    {
        $this->session_id = $session_id;
        $this->server_id = $server_id;
        $this->section = $section;
    }
}