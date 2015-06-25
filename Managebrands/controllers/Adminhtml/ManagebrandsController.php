<?php 
class Pws_Managebrands_Adminhtml_ManagebrandsController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
		$this->_title($this->__('Manage Facebook Feedback'));
			 
		$this->loadLayout();
       $this->renderLayout();
	}
	
	public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('managebrands/adminhtml_managebrands_grid')->toHtml()
        );
    }
	
	 public function editAction()
    {
      $managebrandsId     = $this->getRequest()->getParam('id');
       
		$managebrandsModel  = Mage::getModel('managebrands/managebrands')->load($managebrandsId);
 

        if ($managebrandsModel->getFacebookfeedbackId() || $managebrandsId == 0) {
 
 
            Mage::register('managebrands_data', $managebrandsModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('managebrands/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('managebrands/adminhtml_managebrands_edit'));
                 //->_addLeft($this->getLayout()->createBlock('customchart/adminhtml_alllist_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('<module>')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
	
	
	 public function saveAction()
	{
	}
	
	
	public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $managebrandsModel = Mage::getModel('managebrands/managebrands');
               
                $managebrandsModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
	
	
	public function newAction()
    {
        $this->_forward('edit');
    }
	
}
?>