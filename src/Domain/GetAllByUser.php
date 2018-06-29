<?php
namespace ispConfig\Domain;

use ispConfig\Request;

class GetAllByUser extends Request
{
    /** @var string  */
    protected $Method = 'domains_get_all_by_user';
    /** @var string */
    public $session_id;
    /** @var int */
    public $group_id;

    /**
     * @param string $session_id
     * @param int $group_id
     */
    public function __construct($session_id, $group_id)
    {
        $this->session_id = $session_id;
        $this->group_id = $group_id;
    }
}