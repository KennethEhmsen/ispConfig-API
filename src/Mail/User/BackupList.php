<?php
namespace ispConfig\Domain;

use ispConfig\Request;

class BackupList extends Request
{
    /** @var string  */
    protected $Method = 'mail_user_backup_list';
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