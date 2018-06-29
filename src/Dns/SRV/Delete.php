<?php
namespace ispConfig\Dns\SRV;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_srv_delete';
}