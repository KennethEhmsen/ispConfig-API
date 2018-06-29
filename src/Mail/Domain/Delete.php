<?php
namespace ispConfig\Mail\Domain;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'mail_domain_delete';
}