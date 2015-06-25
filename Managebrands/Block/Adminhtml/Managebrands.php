<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog manage products block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Pws_Managebrands_Block_Adminhtml_Managebrands extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * Set template
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('managebrands/managebrands.phtml');
    }
	
	protected function _prepareLayout()
    {
        //$this->_addButton('add_new', array(
        //    'label'   => Mage::helper('managebrands')->__('Add New Brand'),
        //    'onclick' => "setLocation('{$this->getUrl('*/*/new')}')",
        //    'class'   => 'add'
        //));
		$this->setChild('grid', $this->getLayout()->createBlock('managebrands/adminhtml_managebrands_grid', 'managebrands.grid'));
        return parent::_prepareLayout();
    }
 
 	public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    } 
}
