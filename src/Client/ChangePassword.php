<?php
namespace ispConfig\Client;

use ispConfig\Request;

class ChangePassword extends Request
{
    /** @var string  */
    protected $Method = 'client_change_password';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var string */
    public $new_password;

    /**
     * Constructor.
     * @param string $session_id
     * @param int $client_id
     * @param string $new_password
     */
    public function __construct($session_id, $client_id, $new_password)
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->new_password = $new_password;
    }
}