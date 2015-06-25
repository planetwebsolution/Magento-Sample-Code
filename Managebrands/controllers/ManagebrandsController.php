<?php 
class Pws_Managebrands_ManagebrandsController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
		$this->_title($this->__('Manage Facebook Feedback'));
			 
		$this->loadLayout();
        $this->renderLayout();
	}
}
?>