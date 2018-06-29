<?php
namespace ispConfig\Dns\PTR;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_ptr_delete';
}