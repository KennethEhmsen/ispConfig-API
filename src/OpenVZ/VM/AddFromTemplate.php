<?php
namespace ispConfig\OpenVZ\VM;

use ispConfig\Request;

class AddFromTemplate extends Request
{
    /** @var string  */
    protected $Method = 'openvz_vm_add_from_template';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var int */
    public $ostemplate_id;
    /** @var int */
    public $template_id;
    /** @var array */
    public $override_params;

    /**
     * @param string $session_id
     * @param int $client_id
     * @param int $ostemplate_id
     * @param int $template_id
     * @param array $override_params
     */
    public function __construct($session_id, $client_id, $ostemplate_id, $template_id, $override_params = [])
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->ostemplate_id = $ostemplate_id;
        $this->template_id = $template_id;
        $this->override_params = $override_params;
    }
}