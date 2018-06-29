<?php
namespace ispConfig\Mail\CatchAll;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_catchall_delete';
}