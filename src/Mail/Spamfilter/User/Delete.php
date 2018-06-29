<?php
namespace ispConfig\Mail\Spamfilter\User;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_spamfilter_user_delete';
}