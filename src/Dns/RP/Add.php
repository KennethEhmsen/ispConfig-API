<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:48
 */

namespace ispConfig\Dns\RP;

use ispConfig\Dns\Add as ParentAdd;

class Add extends ParentAdd
{
    protected $Method = 'dns_rp_add';
}