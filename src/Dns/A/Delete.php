<?php
namespace ispConfig\Dns\A;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_a_delete';
}