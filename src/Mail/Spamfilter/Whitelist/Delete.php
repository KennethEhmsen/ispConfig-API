<?php
namespace ispConfig\Mail\Spamfilter\Whitelist;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_spamfilter_whitelist_delete';
}