<?php
namespace ispConfig\Dns\HINFO;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_hinfo_delete';
}