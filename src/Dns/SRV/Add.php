<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:49
 */

namespace ispConfig\Dns\SRV;

use ispConfig\Dns\Add as ParentAdd;

class Add extends ParentAdd
{
    protected $Method = 'dns_srv_add';
}