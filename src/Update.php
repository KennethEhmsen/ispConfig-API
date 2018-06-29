<?php
namespace ispConfig;

use ispConfig\Interfaces\Update as UpdateInterface;

class Update extends Request implements UpdateInterface
{
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var int */
    public $primary_id;
    /** @var array  */
    public $params;

    /**
     * @param string $session_id
     * @param int $client_id
     * @param int $primary_id
     * @param array $params
     */
    public function __construct($session_id, $client_id, $primary_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->primary_id = $primary_id;
        $this->params = $params;
    }
}