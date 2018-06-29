<?php
namespace ispConfig\Mail\Blacklist;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_blacklist_delete';
}