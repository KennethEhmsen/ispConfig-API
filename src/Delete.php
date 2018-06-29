<?php
namespace ispConfig;

use ispConfig\Interfaces\Delete as DeleteInterface;

class Delete extends Request implements DeleteInterface
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