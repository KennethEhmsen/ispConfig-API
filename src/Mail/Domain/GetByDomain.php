<?php
namespace ispConfig\Mail\Domain;

use ispConfig\Request;

class GetByDomain extends Request
{
    /** @var string */
    public $session_id;
    /** @var string */
    public $domain;

    /**
     * Update constructor.
     * @param string $session_id
     * @param string $domain
     */
    public function __construct($session_id, $domain)
    {
        $this->session_id = $session_id;
        $this->domain = $domain;
    }
}