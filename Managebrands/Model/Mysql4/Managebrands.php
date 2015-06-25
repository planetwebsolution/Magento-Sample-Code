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
class Pws_Managebrands_Model_Mysql4_Managebrands extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the quickrfq_id refers to the key field in your database table.
        $this->_init('managebrands/managebrands', 'facebookfeedback_id');
    }
}