<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));

 
    
if(isset($_REQUEST['pro_id'])){
    $yourProId = $_REQUEST['pro_id'];
 if (!isset($_GET['qty'])) { $qty = '1'; } else { $qty = $_GET['qty']; }   
$cartHelper = Mage::helper('checkout/cart');
$items = $cartHelper->getCart()->getItems();
foreach ($items as $item) {
if ($item->getProduct()->getId() == $yourProId) {
    //$qty = $item->getQty() - 1; // check if greater then 0 or set it to what you want
    if($qty == 0) {
        Mage::getSingleton('checkout/cart')->removeItem($item->getId());    
    } else {
            $item->setQty($qty);
        }
        $cartHelper->getCart()->save();
        break;
    }
}
}
?>
<?php echo Mage::app()->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar_ajax.phtml')->toHtml(); ?>
    