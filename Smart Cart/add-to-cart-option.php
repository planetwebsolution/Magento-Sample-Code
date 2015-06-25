<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));
$product_id = '';
    
    if(isset($_REQUEST['pro_id'])){
    $product_id = $_REQUEST['pro_id'];
    }else{
        $product_id = '';
    }
    $obj = Mage::getModel('catalog/product');
    $_product = $obj->load($product_id);
    $sku = $_product->getSku();


try{
// usage /scripts/addToCart.php?product_id=838&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;qty=1
// product_id OR sku is required
// get query string
if (!isset($_GET['option'])) { $option = ''; } else { $option = $_GET['option']; }
if (!isset($_GET['option_name'])) { $option_name = ''; } else { $option_name = $_GET['option_name']; }
if (!isset($_GET['count'])) { $count = ''; } else { $count = $_GET['count']; }
//$option = explode(',',$option);
//$option_name = explode(',',$option_name);
$newarray = array();
for($i=0;$i<$count;$i++){
$newarray[$option_name[$i]] = $option[$i];
}
//$newarray = explode(',', $newarray);
//print_r($newarray);




//if (!isset($_GET['option1'])) { $option1 = ''; } else { $option1 = $_GET['option1']; }
//if (!isset($_GET['option1_name'])) { $option1_name = ''; } else { $option1_name = $_GET['option1_name']; }
//if (!isset($_GET['option2'])) { $option2 = ''; } else { $option2 = $_GET['option2']; }
//if (!isset($_GET['option2_name'])) { $option2_name = ''; } else { $option2_name = $_GET['option2_name']; }


//if (!isset($_GET['pro_id'])) { $product_id = ''; } else { $product_id = $_GET['product_id']; }
if (!isset($_GET['qty'])) { $qty = '1'; } else { $qty = $_GET['qty']; }
if ($sku != ""){
$product_id = Mage::getModel('catalog/product')->getIdBySku("$sku");
if ($product_id == '') {
$session->addError("<strong>Product Not Added</strong><br />The SKU you entered ($sku) was not found.");
}
}
$request = Mage::app()->getRequest();
$product = Mage::getModel('catalog/product')->load($product_id);
$session = Mage::getSingleton('core/session', array('name'=>'frontend'));
$cart = Mage::helper('checkout/cart')->getCart();


//if($option1 != '' && $option2 != ''):
$params = array(
'product' => $product_id,
'qty' => $qty,
'options' => $newarray

);
//elseif($option1 != '' && $option2 == ''):
//$params = array(
//'product' => $product_id,
//'qty' => $qty,
//'options' => array(
//                  $option1_name => $option1
//                  //30=>105
//                  )
//
//);
//else:
//$params = array(
//'product' => $product_id,
//'qty' => $qty
//);
//endif;


//$cart->addProduct($product, $qty, $params);
$cart->addProduct($product, $params);
$session->setLastAddedProductId($product->getId());
$session->setCartWasUpdated(true);
$cart->save();
$result = "{'result':'success'}";
//echo $result;
} catch (Exception $e) {
$result = "{'result':'error'";
$result .= ", 'message': '".$e->getMessage()."'}";
//echo $result;
}
?>


        <?php echo Mage::app()->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar_ajax.phtml')->toHtml() ?>
    