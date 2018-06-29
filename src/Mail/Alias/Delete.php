<?php
namespace ispConfig\Mail\Alias;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_alias_delete';
}