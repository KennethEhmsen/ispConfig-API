<?php
namespace ispConfig\Dns\ALIAS;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_alias_delete';
}