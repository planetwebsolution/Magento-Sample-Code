<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));
//$cart = Mage::getSingleton('checkout/cart');
//$address = $cart->getQuote()->getShippingAddress();
//print_r($address);
//die(); [postcode] => 10014 [country_id] => US
//$shipping = Mage::getModel('shipping/shipping');        
//    $result=$shipping->collectRatesByAddress($address)->getResult();
//    $newrates = array();
//    $newrateCodes = array();
//    $shippingRates=$result->getAllRates();
//    foreach ($shippingRates as $rate) {
//        if ($rate instanceof Mage_Shipping_Model_Rate_Result_Error) {
//            $errors[$rate->getCarrierTitle()] = 1;
//        } else {
//            $k = $rate->getCarrierTitle().' - '.$rate->getMethodTitle();
//            $k = $rate->getCarrier() . '_' . $rate->getMethod();
//
//            if ($address->getFreeShipping()) {
//                $price = 0;
//            } else {
//                $price = $rate->getPrice();
//            }
//
//            if ($price) {
//                $price = Mage::helper('tax')->getShippingPrice($price, false, $address);
//            }
//
//            echo $newrates[$k] = $price;
//            echo $newrateCodes[$k] = $rate->getCarrierTitle().' - '.$rate->getMethodTitle().'<br>';
//        }
//    }
//

// Change to your postcode / country.
//$zipcode = '55511';
$country = 'US';
 if(isset($_REQUEST['zipcode'])){
    $zipcode = $_REQUEST['zipcode'];
    }else{
        $zipcode = '';
    }
// Update the cart's quote.
$cart = Mage::getSingleton('checkout/cart');
$address = $cart->getQuote()->getShippingAddress();
$address->setCountryId($country)
        ->setPostcode($zipcode)
        ->setCollectShippingrates(true);
$cart->save();

// Find if our shipping has been included.
$rates = $address->collectShippingRates()
                 ->getGroupedAllShippingRates();
if($zipcode != ''):
echo '<ul class="estimate_class">';
foreach ($rates as $carrier) {
    //echo $carrier['carrier_title'];
    $old_career = '';
    foreach ($carrier as $rate) {
        //print_r($rate->getData());
        //echo $rate['carrier'];
        $new_career = $rate['carrier_title'];
        if($old_career != $new_career){
            echo '<li>';
            echo '<strong>';
            echo $new_career;
            echo '</strong>';
            echo '</li>';
        }
        
        echo '<li class="list_estimate">';
        echo $rate['method_title'].' $';
        echo number_format($rate['price'],2);
        echo '</li>';
        $old_career = $rate['carrier_title'];
        
        
    }
}
echo '</ul>';
endif;
?>