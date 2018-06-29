<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:47
 */

namespace ispConfig\Dns\MX;

use ispConfig\Add as ParentAdd;

class Add extends ParentAdd
{
    protected $Method = 'dns_mx_add';
}