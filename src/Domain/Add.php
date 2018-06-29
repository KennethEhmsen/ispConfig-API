<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:00
 */

namespace ispConfig\Domain;

use ispConfig\Request;

class Add extends Request
{
    /** @var string  */
    protected $Method = 'domains_domain_add';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var array */
    public $params;

    /**
     * @param string $session_id
     * @param int $client_id
     * @param array $params List of parameters:
     *      domain        varchar(255)
     */
    public function __construct($session_id, $client_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->params = $params;
    }
}