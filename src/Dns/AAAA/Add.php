<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:44
 */

namespace ispConfig\Dns\AAAA;

use ispConfig\Dns\Add as ParentAdd;

class Add extends ParentAdd
{
    protected $Method = 'dns_aaaa_add';
}