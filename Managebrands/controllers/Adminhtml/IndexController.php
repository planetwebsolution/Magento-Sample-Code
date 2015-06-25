<?php 
class Pws_Managebrands_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
		$this->_title($this->__('Manage Facebook Feedback'));
			 
		$this->loadLayout();
       $this->renderLayout();
	}
	
	
}
?>