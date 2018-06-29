<?php
namespace ispConfig\Mail\Policy;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_policy_delete';
}