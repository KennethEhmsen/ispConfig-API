<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 15:56
 */

namespace ispConfig\Dns\CNAME;

use ispConfig\Dns\Get as ParentGet;

class Get extends ParentGet
{
    protected $Method = 'dns_cname_get';
}