<?php

 /**
 * Quickrfq extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   FME
 * @package    FME_Quickrfq
 * @author     Malik Tahir Mehmood<malik.tahir786@gmail.com>
 * @copyright  Copyright 2010 © free-magentoextensions.com All right reserved
 */
 
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('managebrands')};
CREATE TABLE {$this->getTable('managebrands')} (
  `facebookfeedback_id` int(11) unsigned NOT NULL auto_increment,
  `facebookfeedback_satisfactionlevel` varchar(255) NULL,
  `facebookfeedback_recommend` varchar(255) NULL,
  `facebookfeedback_productquality` varchar(255) NOT NULL default '',
  `facebookfeedback_yourexperience` varchar(255) NOT NULL default '',
  `facebookfeedback_feebback` varchar(255) NOT NULL default '',
  PRIMARY KEY (`facebookfeedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 