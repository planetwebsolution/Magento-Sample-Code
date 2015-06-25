<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));

?>


        <?php echo Mage::app()->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar_ajax.phtml')->toHtml() ?>
    