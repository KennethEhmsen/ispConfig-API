<?php
namespace ispConfig\Dns;

use ispConfig\Update as ParentUpdate;

class Update extends ParentUpdate
{
    protected $Method = 'dns_zone_update';

    /**
     * @param string $session_id
     * @param int $client_id
     * @param int $primary_id
     * @param array $params Parameters:
     *      server_id   int(11)
     *      origin      varchar(255)
     *      ns          varchar(255)
     *      mbox        varchar(255)
     *      serial      int(11)
     *      refresh     int(11)
     *      retry       retry(11)
     *      expire      int(11)
     *      minimum     int(11)
     *      ttl         int(11)
     *      active      enum('n','y')
     *      xfer        varchar(255)
     *      also_notify varchar(255)
     *      update_acl  varchar(255)
     * Returns the ID of the newly added dns zone.
     */
}