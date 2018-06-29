<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 09:27
 */

namespace ispConfig\System;

use ispConfig\Request;

class Logout extends Request
{
    /** @var string  */
    protected $Method = 'logout';
    /** @var string  */
    public $session_id;

    public function __construct($sessionId) {
        $this->session_id = $sessionId;
    }

}