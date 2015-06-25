<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));
$allcodes = array(
'0' => 'sales/report_order',
'1' => 'tax/report_tax',
'2' => 'sales/report_shipping',
'3' => 'sales/report_invoiced',
'4' => 'sales/report_refunded',
'5' => 'salesrule/report_rule',
'6' => 'sales/report_bestsellers',
'7' => 'reports/report_product_viewed',

);

try {
foreach ($allcodes as $collectionName) {
Mage::getResourceModel($collectionName)->aggregate();
/// print_r($tr);
}
Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Lifetime statistics have been updated.'));
} catch (Mage_Core_Exception $e) {
Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
} catch (Exception $e) {
Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to refresh lifetime statistics.'));
Mage::logException($e);
}
?>