<?php
namespace ispConfig\Dns\AAAA;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_aaaa_delete';
}