<?php
namespace ispConfig\Dns\TXT;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_txt_delete';
}