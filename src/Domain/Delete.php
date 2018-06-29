<?php
namespace ispConfig\Domain;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    /** @var string  */
    protected $Method = 'domains_domain_delete';
}