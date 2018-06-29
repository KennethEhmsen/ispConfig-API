<?php
namespace ispConfig\Mail\Transport;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_transport_delete';
}