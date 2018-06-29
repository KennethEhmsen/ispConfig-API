<?php
namespace ispConfig\Dns\NS;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_ns_delete';
}