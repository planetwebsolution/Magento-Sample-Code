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
 * Adminhtml customer grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Pws_Managebrands_Block_Adminhtml_Managebrands_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
		$this->setId('managebrandsGrid');
        $this->setDefaultSort('facebookfeedback_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    	
    }

   
    protected function _prepareCollection()
    {
       
       $collection = Mage::getModel('managebrands/managebrands')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
        $this->addColumn('facebookfeedback_id',
            array(
                'header'=> Mage::helper('managebrands')->__('Feedback No'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'facebookfeedback_id',
        ));
		
		$this->addColumn('facebookfeedback_satisfactionlevel',
            array(
                'header'=> Mage::helper('managebrands')->__('Customer Satisfaction Level with Skull Shaver'),
                'index' => 'facebookfeedback_satisfactionlevel',
		'renderer'  => 'Pws_Managebrands_Block_Adminhtml_Managebrands_Renderer_Viewimage',
        ));
		
        $this->addColumn('facebookfeedback_recommend',
            array(
                'header'=> Mage::helper('managebrands')->__('How likely you would recommend Skull Shaver'),
                'index' => 'facebookfeedback_recommend',
				//'renderer'  => 'Pws_Managebrands_Block_Adminhtml_Managebrands_Renderer_Viewimage',
        ));

        $this->addColumn('facebookfeedback_productquality',
            array(
                'header'=> Mage::helper('managebrands')->__('Product Quality'),
                'index' => 'facebookfeedback_productquality',
		'renderer'  => 'Pws_Managebrands_Block_Adminhtml_Managebrands_Renderer_Viewimage',
				
        ));
	$this->addColumn('facebookfeedback_yourexperience',
            array(
                'header'=> Mage::helper('managebrands')->__('Customer experience with our Shavers'),
                'index' => 'facebookfeedback_yourexperience',
		'renderer'  => 'Pws_Managebrands_Block_Adminhtml_Managebrands_Renderer_Viewimage',
				
        ));
	$this->addColumn('facebookfeedback_feebback',
            array(
                'header'=> Mage::helper('managebrands')->__('Customer Feedback'),
                'index' => 'facebookfeedback_feebback',
				
        ));
	
		
        return parent::_prepareColumns();
    }

   
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        //return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
