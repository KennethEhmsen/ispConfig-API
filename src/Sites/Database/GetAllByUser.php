<?php
namespace ispConfig\Sites\Database;

use ispConfig\Request;

class GetAllByUser extends Request
{
    /** @var string  */
    protected $Method = 'sites_database_get_all_by_user';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;

    /**
     * @param string $session_id
     * @param int $client_id
     */
    public function __construct($session_id, $client_id)
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
    }
}