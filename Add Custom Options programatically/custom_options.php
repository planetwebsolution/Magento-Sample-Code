<?php
include_once('app/Mage.php');
umask(0);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); 
$row = 0;
$productmodel = Mage::getModel('catalog/product');
if (($handle = fopen("csv/product_options.csv", "r")) !== FALSE) 
{
$LastInserted_SKU_ID = '';
$LastInserted_OPTIONS_NAME = '';
    while (($data = fgetcsv($handle, 2000, ",")) !== FALSE)
	{
        $num = count($data);
        $row++;
		
		if($row > 129479)
		{
			
			if($data[2] != NULL && isset($data[2]))
			{
			
				if($data[0] == '' && $data[1]=='')
				{
					$LastInserted_SKU_ID = $LastInserted_SKU_ID;
					$LastInserted_OPTIONS_NAME = $LastInserted_OPTIONS_NAME;
					$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $LastInserted_SKU_ID);
					
					if(!empty($_product))
					{
					$options = $_product->getProductOptionsCollection();
					$All_title_value = array();
					$Values_collections = array();
					$Final_values_collections = array();
					$value_arrays = array();
					$_product->setHasOptions(1);
					
					if (isset($options))
							 { 
								foreach ($options as $o)
								 { 
										$title = $o->getTitle();
										$All_title_value[] = $title;
										
										if($title == $LastInserted_OPTIONS_NAME)
										{
										
										$Values_collections = $o->getValuesCollection();
										$check11= array();
											
												foreach($o->getValues() as $valuesKey => $valuesVal)
												{
												$check11[] = $valuesVal->getTitle();
												}
										
											$price = $data[3];
											if($price == '')
											{
											$price = 0;
											}
									if(!in_array($data[2],$check11))
										{
												$value = Mage::getModel('catalog/product_option_value'); 
		
												$value->setOption($o) 
												
												->setTitle($data[2]) 
												
												->setSku("product sku")
												
												->setPriceType("fixed")
												
												->setSortOrder(0)
												
												->setPrice($price)
												
												/**
												this ligne is important (relation forigien key) for related this new value
												to specific option
												*/
												
												->setOptionId($o->getId());
												
												$value->save();
												$_product->Save();
										}
									else
										{
										echo '<br>Cannot save same value again, Thanks ROW NO:-'.$row.'';
										}
											}
								 }
								 
							
														
														
														
														
																	
								 
							  }	 
							  
					}		  
				}
				else
				{
					$LastInserted_SKU_ID = $data[0];
					$LastInserted_OPTIONS_NAME = $data[1];
					$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $LastInserted_SKU_ID);
					if(!empty($_product))
					{
					$options = $_product->getProductOptionsCollection();
					$All_title_value = array();
				
					$_product->setHasOptions(1);
							if (isset($options))
							 { 
								foreach ($options as $o)
								 { 
										$title = $o->getTitle();
										$All_title_value[] = $title; 
								 }
							 
							
							 
										if(in_array($LastInserted_OPTIONS_NAME,$All_title_value))
										{
											//'already exist options';	
											echo '<br>Cannot save same value again, Thanks ROW NO:-'.$row.'';
										}
										else
										{
											//'new custom options';
											$value_arrays = array();
											$opt = Mage::getModel('catalog/product_option');
											$opt->setProduct($_product);
											
											$OPTION_Title = $data[2];
											$price = $data[3];
											if($price == '')
											{
											$price = 0;
											}
											//$_product->setHasOptions(1);
											$value_arrays[] =  array('is_delete'     => 0,
											  'title'         => $OPTION_Title,
											  'price_type'    => 'fixed',
											  'price'         => $price,
											  'sku'           => 'product sku',
											  'option_type_id'=> -1,);
											
											$optionArray = array(
												'is_delete' => 0,
												'title' => $LastInserted_OPTIONS_NAME,
												'previous_group' => '',
												'previous_type' => '',
												'type' => 'drop_down',  //can be radio, drop_down, file, area...
												'is_require' => 0,
												'sort_order' => 0,
												'values' => $value_arrays
											);
											
											$opt->addOption($optionArray);
											$opt->saveOptions();
											$_product->Save();
											echo '<br>SAVE OPTIONS ROW NO:-'.$row.'';
										}
							 
							 
							 
							 }
							 else
							 {
								//'New Custom Options';
							 		
									$LastInserted_SKU_ID = $data[0];
									$LastInserted_OPTIONS_NAME = $data[1];
									$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $LastInserted_SKU_ID);
									$options = $_product->getProductOptionsCollection();
									$All_title_value = array();
									$_product->setHasOptions(1);
							if (isset($options))
							 { 
								foreach ($options as $o)
								 { 
										$title = $o->getTitle();
										$All_title_value[] = $title; 
								 }
							 
							 
							 
										if(in_array($LastInserted_OPTIONS_NAME,$All_title_value))
										{
											//'already exist options';	
											echo '<br>YOU cannot do anything. Please keep trying ROW NO:-'.$row.'';
										}
										else
										{
											//'new custom options';
											$value_arrays = array();
											$opt = Mage::getModel('catalog/product_option');
											$opt->setProduct($_product);
											
											$OPTION_Title = $data[2];
											$price = $data[3];
											if($price == '')
											{
											$price = 0;
											}
											
											$value_arrays[] =  array('is_delete'     => 0,
											  'title'         => $OPTION_Title,
											  'price_type'    => 'fixed',
											  'price'         => $price,
											  'sku'           => 'product sku',
											  'option_type_id'=> -1,);
											
											$optionArray = array(
												'is_delete' => 0,
												'title' => $LastInserted_OPTIONS_NAME,
												'previous_group' => '',
												'previous_type' => '',
												'type' => 'drop_down',  //can be radio, drop_down, file, area...
												'is_require' => 0,
												'sort_order' => 0,
												'values' => $value_arrays
											);
											
											$opt->addOption($optionArray);
											$opt->saveOptions();
											$_product->Save();
											echo '<br>SAVE OPTIONS ROW NO:-'.$row.'';
										}
							 	}
							 }	 
					}
				}
			
			if($row == 130653)
			{	
			die();	
			}
			}
		}
	}
}			