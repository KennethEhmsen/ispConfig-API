<?php
namespace ispConfig\Mail\User\Filter;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_user_filter_delete';
}