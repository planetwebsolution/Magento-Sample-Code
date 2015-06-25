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
 
class Pws_Managebrands_Block_Adminhtml_Managebrands_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
        protected function _prepareForm()
        {
       		$form = new Varien_Data_Form(array(
                                        'id' => 'edit_form',
                                        //'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                        'method' => 'post',
										'enctype' => 'multipart/form-data',
                                     )
       		 );
			 
		$form->setUseContainer(true);
        $this->setForm($form);
        $fieldset = $form->addFieldset('edit_form', array('legend'=>Mage::helper('managebrands')->__('Feedback Information')));
       
	   
		$getSizeChartId = $this->getRequest()->getParam('id');
		 
		$fieldset->addField('facebookfeedback_satisfactionlevel', 'text', array(
            'label'     => Mage::helper('managebrands')->__('Customer Satisfaction Level with Skull Shaver'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'facebookfeedback_satisfactionlevel',
	    'renderer'  => 'Pws_Managebrands_Block_Adminhtml_Managebrands_Renderer_Viewimage',
        ));
		 
		 
		 
		 $fieldset->addField('facebookfeedback_recommend', 'text', array(
          'label'     => Mage::helper('managebrands')->__('How likely you would recommend Skull Shaver'),
          'required'  => false,
          'name'      => 'facebookfeedback_recommend',
        )); 
 		 
		 
		 
		 $fieldset->addField('facebookfeedback_productquality', 'text', array(
            'label'     => Mage::helper('managebrands')->__('Product Quality'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'facebookfeedback_productquality',
        ));
		
	 $fieldset->addField('facebookfeedback_yourexperience', 'text', array(
            'label'     => Mage::helper('managebrands')->__('Customer experience with our Shavers'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'facebookfeedback_yourexperience',
        ));
		
	 $fieldset->addField('facebookfeedback_feebback', 'text', array(
            'label'     => Mage::helper('managebrands')->__('Customer Feedback'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'facebookfeedback_feebback',
        ));
			
 
        if ( Mage::getSingleton('adminhtml/session')->getmanagebrandsData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getmanagebrandsData());
            Mage::getSingleton('adminhtml/session')->setmanagebrandsData(null);
        } elseif ( Mage::registry('managebrands_data') ) {
            $form->setValues(Mage::registry('managebrands_data')->getData());
        }
        return parent::_prepareForm();
    }
}