<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));

 
    
if(isset($_REQUEST['pro_id'])){
    $yourProId = $_REQUEST['pro_id'];
   
$cartHelper = Mage::helper('checkout/cart');
$items = $cartHelper->getCart()->getItems();
foreach ($items as $item) {
if ($item->getProduct()->getId() == $yourProId) {
    //$qty = $item->getQty() - 1; // check if greater then 0 or set it to what you want
    
        Mage::getSingleton('checkout/cart')->removeItem($item->getId());    
    
        $cartHelper->getCart()->save();
        break;
    }
}
}
?>
<?php echo Mage::app()->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar_ajax.phtml')->toHtml(); ?>