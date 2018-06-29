<?php
namespace ispConfig\Sites\Cron;

use ispConfig\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'sites_cron_delete';
}