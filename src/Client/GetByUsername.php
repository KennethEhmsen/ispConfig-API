<?php
namespace ispConfig\Client;

use ispConfig\Request;

class GetByUsername extends Request
{
    /** @var string  */
    protected $Method = 'client_get_by_username';
    /** @var string */
    public $session_id;
    /** @var int */
    public $username;

    /**
     * @param string $session_id
     * @param string $username
     */
    public function __construct($session_id, $username)
    {
        $this->session_id = $session_id;
        $this->username = $username;
    }

}