<?php
namespace ispConfig\Interfaces;

interface Update
{
    public function __construct($session_id, $client_id, $primary_id, $params = []);
}