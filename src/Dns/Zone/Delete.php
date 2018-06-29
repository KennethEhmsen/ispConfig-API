<?php
namespace ispConfig\Dns\Zone;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_zone_delete';
}