<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:10
 */

namespace ispConfig;

use ispConfig\Interfaces\Add as AddInterface;

class Add extends Request implements AddInterface
{
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var array  */
    public $params;

    /**
     * Update constructor.
     * @param string $session_id
     * @param int $client_id
     * @param array $params
     */
    public function __construct($session_id, $client_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->params = $params;
    }
}