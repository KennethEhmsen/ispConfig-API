<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:56
 */

namespace ispConfig\Dns\PTR;

use ispConfig\Dns\Update as ParentUpdate;

class Update extends ParentUpdate
{
    protected $Method = 'dns_ptr_update';
}