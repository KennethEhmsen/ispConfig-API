<?php
namespace ispConfig\Mail\Whitelist;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_whitelist_delete';
}