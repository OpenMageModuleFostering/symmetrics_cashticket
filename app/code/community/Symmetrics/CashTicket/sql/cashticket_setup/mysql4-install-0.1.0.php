<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;

$installer->startSetup();

// create table for saving cashticket configurations
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('symmetrics_cashticket')};
    CREATE TABLE {$this->getTable('symmetrics_cashticket')} (
      `item_id` int(11) NOT NULL auto_increment,
      `enable` tinyint NOT NULL,
      `currency_code` varchar(3) NOT NULL,
      `merchant_id` varchar(20) NOT NULL,
      `business_type` varchar(5) NOT NULL,
      `reporting_criteria` varchar(8) NOT NULL,
      `locale` varchar(10) NOT NULL,
      `path_pem_test` varchar(255) NOT NULL,
      `path_pem_live` varchar(255) NOT NULL,
      `path_cert` varchar(255) NOT NULL,
      `sslcert_pass` varchar(255) NOT NULL,
      `sandbox` enum('1', '0') NOT NULL,
      `created_time` datetime default NULL,
      `update_time` datetime default NULL,
      PRIMARY KEY  (`item_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 
