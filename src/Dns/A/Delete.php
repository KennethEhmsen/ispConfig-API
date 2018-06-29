<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:56
 */

namespace ispConfig\Dns\A;

use ispConfig\Dns\Delete as ParentDelete;

class Delete extends ParentDelete
{
    protected $Method = 'dns_a_delete';
}