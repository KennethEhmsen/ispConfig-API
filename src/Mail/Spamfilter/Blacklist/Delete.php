<?php
namespace ispConfig\Mail\Spamfilter\Blacklist;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_spamfilter_blacklist_delete';
}