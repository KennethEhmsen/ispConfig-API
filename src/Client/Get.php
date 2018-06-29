<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 09:39
 */

namespace ispConfig\Client;

use ispConfig\Get as ParentGet;

class Get extends ParentGet
{
    /** @var string  */
    protected $Method = 'client_get';
}