<?php
class Excellence_Fee_Model_Sales_Quote_Address_Total_Fee extends Mage_Sales_Model_Quote_Address_Total_Abstract{
	protected $_code = 'fee';

	public function collect(Mage_Sales_Model_Quote_Address $address)
	{
		parent::collect($address);

		$this->_setAmount(0);
		$this->_setBaseAmount(0);

		$items = $this->_getAddressItems($address);
		if (!count($items)) {
			return $this; //this makes only address type shipping to come through
		}


		$quote = $address->getQuote();

		if(Excellence_Fee_Model_Fee::canApply($address)){
			$exist_amount = $quote->getFeeAmount();
			//$fee = Excellence_Fee_Model_Fee::getFee()
			
			 $quote = Mage::getModel('checkout/cart')->getQuote();
    $items = $quote->getAllVisibleItems();
    
    foreach ($items as $item) {
        $product = $item->getProduct();
       
            $categories = $product->getCategoryCollection()
                        ->addAttributeToSelect('name')
                        ->addAttributeToFilter('is_active', array('eq' => 1));
            foreach($categories as $cat) {
				$catid[] = $cat->getId();
                
            }
            
    }
	//echo "<pre>";
	//print_r(array_count_values($catid));
	$cat_array = array_count_values($catid);
	
	$total_handling_fee = 0;
	foreach(array_count_values($catid) as $catid => $catcont )
	{
		//echo $catid . " == ". $catcont."<pre>";
		for($i = 1; $i <= $catcont ; $i++){
			$h_fee = Mage::getModel('catalog/category')->load($catid)->getData('handling_fee'.$i);
			$total_handling_fee += $h_fee ;
		}
		
	}
	//echo "Total Fee: " .$total_handling_fee;
    //die();
			
			
			$config_option = Mage::app()->getStore()->getConfig('tab1/general/max_handling_fee');
			if($total_handling_fee > $config_option){
				$final_total_handling_fee = $config_option;
			} 
			else
			{
				$final_total_handling_fee = $total_handling_fee;
				
			}
		
			$fee = $final_total_handling_fee;
			$balance = $fee - $exist_amount;
			// 			$balance = $fee;

			//$this->_setAmount($balance);
			//$this->_setBaseAmount($balance);

			$address->setFeeAmount($balance);
			$address->setBaseFeeAmount($balance);
				
			$quote->setFeeAmount($balance);

			$address->setGrandTotal($address->getGrandTotal() + $address->getFeeAmount());
			$address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseFeeAmount());
		}
	}

	public function fetch(Mage_Sales_Model_Quote_Address $address)
	{
		$amt = $address->getFeeAmount();
		$address->addTotal(array(
				'code'=>$this->getCode(),
				'title'=>Mage::helper('fee')->__('Handling Fee'),
				'value'=> $amt
		));
		return $this;
	}
}