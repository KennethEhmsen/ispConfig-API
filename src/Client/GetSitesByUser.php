<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 09:40
 */

namespace ispConfig\Client;


use ispConfig\Request;

class GetSitesByUser extends Request
{
    /** @var string  */
    protected $Method = 'client_get_sites_by_user';
    /** @var string */
    public $session_id;
    /** @var int */
    public $sys_userid;
    /** @var int */
    public $sys_groupid;

    /**
     * Constructor.
     * @param string $session_id
     * @param int $sys_userid
     * @param int $sys_groupid
     */
    public function __construct($session_id, $sys_userid, $sys_groupid)
    {
        $this->session_id = $session_id;
        $this->sys_userid = $sys_userid;
        $this->sys_groupid = $sys_groupid;
    }
}