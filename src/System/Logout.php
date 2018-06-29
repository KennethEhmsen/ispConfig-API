<?php
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