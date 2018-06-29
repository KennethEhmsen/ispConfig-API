<?php
namespace ispConfig\Mail\User;

use ispConfig\Request;

class Backup extends Request
{
    /** @var string  */
    protected $Method = 'mail_user_backup';
    /** @var string */
    public $session_id;
    /** @var int */
    public $primary_id;
    /** @var string */
    public $action_type;

    /**
     * @param string $session_id
     * @param int $primary_id
     * @param string $action_type Must be either ~backup_download_mail~ or backup_restore_mail
     */
    public function __construct($session_id, $primary_id, $action_type)
    {
        $this->session_id = $session_id;
        $this->primary_id = $primary_id;
        $this->action_type = $action_type;
    }
}