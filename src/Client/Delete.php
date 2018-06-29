<?php
namespace ispConfig\Client;

use ispConfig\Get as ParentDelete;

class Delete extends ParentDelete
{
    /** @var string  */
    protected $Method = 'client_delete';
}