<?php
namespace ispConfig\System;

use ispConfig\Request;

class GetFunctionList extends Request
{
    /** @var string  */
    protected $Method = 'get_function_list';
    /** @var string */
    public $session_id;

    public function __construct($session_id)
    {
        $this->session_id = $session_id;
    }
}