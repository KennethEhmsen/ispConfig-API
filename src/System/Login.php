<?php
namespace ispConfig\System;

use ispConfig\Request;

class Login extends Request
{
    /** @var string  */
    protected $Method = 'login';
    /** @var string  */
    public $username;
    /** @var string  */
    public $password;


    /**
     * Login constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}