<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 09:40
 */

namespace ispConfig\Client;


use ispConfig\Request;

class TemplatesGetAll extends Request
{
    /** @var string  */
    protected $Method = 'client_templates_get_all';
    /** @var string */
    public $session_id;

    /**
     * Constructor.
     * @param string $session_id
     */
    public function __construct($session_id)
    {
        $this->session_id = $session_id;
    }

}