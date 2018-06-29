<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:10
 */

namespace ispConfig;

use ispConfig\Interfaces\Get as GetInterface;

class Get extends Request implements GetInterface
{
    /** @var string */
    public $session_id;
    /** @var int */
    public $primary_id;

    /**
     * Get constructor.
     * @param string $session_id
     * @param int $primary_id
     */
    public function __construct($session_id, $primary_id)
    {
        $this->session_id = $session_id;
        $this->primary_id = $primary_id;
    }
}