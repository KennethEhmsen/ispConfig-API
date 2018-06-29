<?php
namespace ispConfig\Dns\MX;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_mx_delete';
}