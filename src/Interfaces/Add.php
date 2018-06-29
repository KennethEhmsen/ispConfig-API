<?php
namespace ispConfig\Interfaces;

interface Add
{
    public function __construct($session_id, $client_id, $params = []);
}