<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:43
 */

namespace ispConfig\Dns\A;

use ispConfig\Dns\Add as ParentAdd;

class Add extends ParentAdd
{
    protected $Method = 'dns_a_add';
}