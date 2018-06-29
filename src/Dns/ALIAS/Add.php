<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:45
 */

namespace ispConfig\Dns\ALIAS;

use ispConfig\Dns\Add as ParentAdd;

class Add extends ParentAdd
{
    protected $Method = 'dns_alias_add';
}