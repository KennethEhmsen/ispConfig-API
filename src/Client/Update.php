<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018-06-29
 * Time: 09:39
 */

namespace ispConfig\Client;

use ispConfig\Request;

class Update extends Request
{
    /** @var string  */
    protected $Method = 'client_update';
    /** @var string */
    public $session_id;
    /** @var int */
    public $client_id;
    /** @var int */
    public $reseller_id;
    /** @var array */
    public $params;

    /**
     * Constructor.
     * @param string $session_id
     * @param int $client_id
     * @param int $reseller_id
     * @param array $params List of parameters:
     *      company_name        varchar(64)
     *      contact_name        varchar(64)
     *      customer_no         varchar(64)
     *      vat_id              varchar(64)
     *      street              varchar(255)
     *      zip                 varchar(32)
     *      city                varchar(64)
     *      state               varchar(32)
     *      country             char(2)
     *      telephone           varchar(32)
     *      mobile              varchar(32)
     *      fax                 varchar(32)
     *      email               varchar(255)
     *      internet            varchar(255)
     *      icq                 varchar(16)
     *      notes               text
     *      default_mailserver  int(11)
     *      limit_maildomain    int(11)
     *      limit_mailbox       int(11)
     *      limit_mailalias     int(11)
     *      limit_mailaliasdomain   int(11)
     *      limit_mailforward   int(11)
     *      limit_mailcatchall  int(11)
     *      limit_mailrouting   int(11)
     *      limit_mailfilter    int(11)
     *      limit_fetchmail     int(11)
     *      limit_mailquota     int(11)
     *      limit_spamfilter_wblist     int(11)
     *      limit_spamfilter_user       int(11)
     *      limit_spamfilter_policy     int(11)
     *      default_webserver   int(11)
     *      limit_web_ip        text
     *      limit_web_domain    int(11)
     *      limit_web_quota     int(11)
     *      web_php_options     varchar(255)
     *      limit_web_subdomain     int(11)
     *      limit_web_aliasdomain   int(11)
     *      limit_ftp_user      int(11)
     *      limit_shell_user    int(11)
     *      ssh_chroot          varchar(255)
     *      limit_webdav_user   int(11)
     *      default_dnsserver   int(11)
     *      limit_dns_zone      int(11)
     *      limit_dns_slave_zone    int(11)
     *      limit_dns_record    int(11)
     *      default_dbserver    int(11)
     *      limit_database      int(11)
     *      limit_cron          int(11)
     *      limit_cron_type     enum('url','chrooted','full')
     *      limit_cron_frequency    int(11)
     *      limit_traffic_quota     int(11)
     *      limit_client        varchar(64)
     *      parent_client_id    int(11)
     *      username            varchar(64)
     *      password            varchar(64)
     *      language            char(2)
     *      usertheme           varchar(32)
     *      template_master     int(11)
     *      template_additional     varchar(255)
     *      created_at          bigint(20)
     * @returns int Returns the number of affected rows
     */
    public function __construct($session_id, $client_id, $reseller_id, $params = [])
    {
        $this->session_id = $session_id;
        $this->client_id = $client_id;
        $this->reseller_id = $reseller_id;
        $this->params = $params;
    }
}