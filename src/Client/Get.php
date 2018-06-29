<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 09:39
 */

namespace ispConfig\Client;


use ispConfig\Request;

class Get extends Request
{
    /** @var string  */
    protected $Method = 'client_get';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;

    /**
     * Constructor.
     * @param string $session_id
     * @param string $client_id
     */
    public function __construct($session_id, $client_id)
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
    }
}