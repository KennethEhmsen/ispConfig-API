<?php
namespace ispConfig\OpenVZ\IP;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'openvz_ip_delete';
}