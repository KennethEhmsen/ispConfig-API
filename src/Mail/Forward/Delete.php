<?php
namespace ispConfig\Mail\Forward;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_forward_delete';
}