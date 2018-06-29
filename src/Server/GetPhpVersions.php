<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 14:48
 */

namespace ispConfig\Server;

use ispConfig\Request;

class GetPhpVersions extends Request
{
    /** @var string  */
    protected $Method = 'server_get_php_versions';
    /** @var string */
    public $session_id;
    /** @var int */
    public $server_id;
    /** @var mixed */
    public $php;

    /**
     * GetPhpVersions constructor.
     * @param string $session_id
     * @param int $server_id
     * @param mixed $php
     */
    public function __construct($session_id, $server_id, $php)
    {
        $this->session_id = $session_id;
        $this->server_id = $server_id;
        $this->php = $php;
    }
}