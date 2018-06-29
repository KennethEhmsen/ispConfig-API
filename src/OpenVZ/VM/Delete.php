<?php
namespace ispConfig\OpenVZ\VM;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'openvz_vm_delete';
}