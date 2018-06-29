<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 21:13
 */

namespace ispConfig\Interfaces;


interface Get
{
    public function __construct($session_id, $primary_id);
}