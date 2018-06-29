<?php
namespace ispConfig\Dns\CNAME;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_cname_delete';
}