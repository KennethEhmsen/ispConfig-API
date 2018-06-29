<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:57
 */

namespace ispConfig\Dns\ALIAS;

use ispConfig\Dns\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_alias_delete';
}