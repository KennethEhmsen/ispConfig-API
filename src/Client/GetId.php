<?php
namespace ispConfig\Client;


use ispConfig\Request;

class GetId extends Request
{
    /** @var string  */
    protected $Method = 'client_get_id';
    /** @var string */
    public $session_id;
    /** @var int */
    public $sys_userid;

    /**
     * Constructor.
     * @param string $session_id
     * @param int $sys_userid
     */
    public function __construct($session_id, $sys_userid)
    {
        $this->session_id = $session_id;
        $this->sys_userid = $sys_userid;
    }

}