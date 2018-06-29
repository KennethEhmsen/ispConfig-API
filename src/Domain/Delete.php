<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:00
 */

namespace ispConfig\Domain;

use ispConfig\Request;

class Delete extends Request
{
    /** @var string  */
    protected $Method = 'domains_domain_delete';
    /** @var string */
    public $session_id;
    /** @var int */
    public $primary_id;

    /**
     * @param string $session_id
     * @param int $primary_id
     */
    public function __construct($session_id, $primary_id)
    {
        $this->session_id = $session_id;
        $this->primary_id = $primary_id;
    }
}