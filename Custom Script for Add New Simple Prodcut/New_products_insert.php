<?php
include_once('app/Mage.php');
umask(0);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); 
$row = 0;
set_time_limit(0);
ini_set('memory_limit','2048M');
//***** FETCH ALL VALUES OF ALL ATTRUBUTES **********

//THIS IS FOR PRIMARY ATTRIBUTE VALUES
$Primary_attribute_code = "primary_attribute"; 
$Primary_attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $Primary_attribute_code); 
$Primary_attribute_options = $Primary_attribute_details->getSource()->getAllOptions(false);
$Primary_Attribute_option_values = array();
$Primary_Attribute_option_values_ids = array();
foreach($Primary_attribute_options as $Primary_option)
{ 
	$Primary_Attribute_option_values[]= trim($Primary_option["label"]);	
	$Primary_Attribute_option_values_ids[]= trim($Primary_option["value"]);			
}
//END OF THIS CODE

//THIS IS FOR SECONDARY ATTRIBUTE VALUES
$Secondary_attribute_code = "sub_attribute"; 
$Secondary_attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $Secondary_attribute_code); 
$Secondary_attribute_options = $Secondary_attribute_details->getSource()->getAllOptions(false);
$Secondary_Attribute_option_values = array();
$Secondary_Attribute_option_values_ids = array();
foreach($Secondary_attribute_options as $Secondary_option)
{ 
	$Secondary_Attribute_option_values[]= trim($Secondary_option["label"]);	
	$Secondary_Attribute_option_values_ids[]= trim($Secondary_option["value"]);			
}
//END OF THIS CODE

//THIS IS FOR THE BRAND ATTRIBUTE VALUES
$Brand_attribute_code = "manufacturer"; 
$Brand_attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $Brand_attribute_code); 
$Brand_attribute_options = $Brand_attribute_details->getSource()->getAllOptions(false);
$Brand_Attribute_option_values = array();
$Brand_Attribute_option_values_ids = array();
foreach($Brand_attribute_options as $Brand_option)
{ 
	$Brand_Attribute_option_values[]= trim($Brand_option["label"]);	
	$Brand_Attribute_option_values_ids[]= trim($Brand_option["value"]);
}
//END OF THIS CODE


//**************** END OF THIS CODE *****************
if (($handle = fopen("csv/NewData/Product.csv", "r")) !== FALSE) 
{
    while (($data = fgetcsv($handle, 100000000, ",")) !== FALSE)
	{
        $num = count($data);
        $row++;
		
		if($row > 1 && $data[1] !='')
		{
			//********** SOME DEFINED VARIABLES *******************
				$Product_Sku_Name = trim($data[1]);
				$Product_Name = trim($data[2]);
				$Product_Weight = trim($data[4]);
				$Product_Base_Price = trim($data[5]);
				$Product_Short_Description = trim($data[6]);
				$Product_Full_Description = trim($data[7]);
				$Product_Meta_Keyword = trim($data[10]);
				$Product_Meta_Description = trim($data[11]);
				$Product_Qty = trim($data[12]);
				$Product_Main_Category = trim($data[24]);
				$Product_Sub_Category = trim($data[25]);
				$Product_Primary_Attribute = trim($data[26]);
				$Product_Sub_Attribute = trim($data[27]);
				$Product_Sub_Attribute_2 = trim($data[28]);
				$Product_Gender_Attribute = trim($data[29]);
				$Product_Special_Price = trim($data[34]);
				$Product_Thumbnail_Image = trim($data[35]);
				$Product_Other_Image = trim($data[36]);
				$Product_Manufacture_Name = trim($data[48]);
				$Product_Manufacture_Category = trim($data[48]);
				$Product_Main_Category_id = '';
				$Product_Sub_Category_id = '';
				$Product_Primary_Attribute_id = '';
				$Product_Secondary_Attribute_id = '';
				$Product_Secondary_Attribute_2_id = '';
				$Product_Brand_Attribute_id = '';
				$Product_Gender_Attribute_id = '';
				$Product_Manufacture_Category_id = '';
				$Final_all_category_id_array = array();
				
			//*********** END OF THIS CODE ************************	
			
			//*********** CALCULATION OF main_category,Sub_category,Primary_attribute,sub_attribute,sub_attribute2,gender_attribute ******
				
				//MAIN CATEGORY CALCULATION
				
				switch($Product_Main_Category)
				{
				 	case "ACCESSORIES":
					$Product_Main_Category_id = '366';
					break;
					case "CASUAL APPAREL":
					$Product_Main_Category_id = '370';
					break;
					case "HELMETS & RIDING GEAR":
					$Product_Main_Category_id = '371';
					break;
					case "PARTS":
					$Product_Main_Category_id = '368';
					break;
					case "TIRES":
					$Product_Main_Category_id = '367';
					break;
					case "WHEELS":
					$Product_Main_Category_id = '369';
					break;
					default:
					$Product_Main_Category_id = '';
					
				}
				//END HERE
				
				if($Product_Main_Category_id != '')
				{
					$Final_all_category_id_array[] = $Product_Main_Category_id;
					//SUB CATEGORY CALCULATION 
					if($Product_Sub_Category != '')
					{
						$childCategoryName = $Product_Sub_Category;
						$parentCategoryId = $Product_Main_Category_id;
						$parentCategory = Mage::getModel('catalog/category')->load($parentCategoryId);
						$childCategory = Mage::getModel('catalog/category')->getCollection()
							->addAttributeToFilter('is_active', true)
							->addIdFilter($parentCategory->getChildren())
							->addAttributeToFilter('name', $childCategoryName)
							->getFirstItem();
					
						$Product_Sub_Category_id = $childCategory->getId();	
						$Final_all_category_id_array[] = $Product_Sub_Category_id;
					}
					//END HERE
					
					//PRIMARY ATTRIBUTE CALCULATIONS
					if($Product_Primary_Attribute != '')
					{
						if(in_array($Product_Primary_Attribute,$Primary_Attribute_option_values))
						{
							$Primary_index_key = array_search($Product_Primary_Attribute,$Primary_Attribute_option_values);
							$Product_Primary_Attribute_id = $Primary_Attribute_option_values_ids[$Primary_index_key];
						}
					}
					//END HERE
					
					//SECONDARY ATTRIBUTE CALCULATIONS
					if($Product_Sub_Attribute != '')
					{
						if(in_array($Product_Sub_Attribute,$Secondary_Attribute_option_values))
						{
							$Secondary_index_key = array_search($Product_Sub_Attribute,$Secondary_Attribute_option_values);
							$Product_Secondary_Attribute_id = $Secondary_Attribute_option_values_ids[$Secondary_index_key];
						}
					}
					//END HERE
					
					//BRAND ATTRIBUTE CALCULATION
					if($Product_Manufacture_Name != '')
					{
						if(in_array($Product_Manufacture_Name,$Brand_Attribute_option_values))
						{
							$Brand_index_key = array_search($Product_Manufacture_Name,$Brand_Attribute_option_values);
							$Product_Brand_Attribute_id = $Brand_Attribute_option_values_ids[$Brand_index_key];
						}
					}
					//END HERE
					
					//GENDER ATTRIBUTE CALCULATION
					if($Product_Gender_Attribute != '')
					{
						switch($Product_Gender_Attribute)
						{
							case "MENS":
							$Product_Gender_Attribute_id = '628';
							break;
							case "WOMENS":
							$Product_Gender_Attribute_id = '629';
							break;
							case "YOUTH":
							$Product_Gender_Attribute_id = '1607';
							break;
							default:
							$Product_Gender_Attribute_id = '';
						}
					}
					//END HERE
					
					//SHOP BY BRAND CATEGORY CALCULATION
					if($Product_Manufacture_Category != '')
					{
						$Final_all_category_id_array[] = 349;
						
						$ManufactureCategoryName = $Product_Manufacture_Category;
						$parentCategoryId_Manufacture = 349;
						$parentCategory_Manufacture = Mage::getModel('catalog/category')->load($parentCategoryId_Manufacture);
						$childCategory_Manufacture = Mage::getModel('catalog/category')->getCollection()
							->addAttributeToFilter('is_active', true)
							->addIdFilter($parentCategory_Manufacture->getChildren())
							->addAttributeToFilter('name', $ManufactureCategoryName)
							->getFirstItem();
					
						$Product_Manufacture_Category_id = $childCategory_Manufacture->getId();	
						$Final_all_category_id_array[] = $Product_Manufacture_Category_id;
					}
					//END HERE
					
					$Final_categoryIds_values = implode(',',$Final_all_category_id_array);
					$product = array();
					$product = Mage::getModel('catalog/product');
					$product->setSku($Product_Sku_Name);
					$product->setName($Product_Name);
					$product->setDescription($Product_Full_Description);
					$product->setShortDescription($Product_Short_Description);
					$product->setPrice($Product_Base_Price);
					$product->setTypeId('simple');
					$product->setAttributeSetId(4);
					$product->setCategoryIds($Final_categoryIds_values);
					$product->setWeight($Product_Weight);
					$product->setTaxClassId("");
					$product->setVisibility(4);
					$product->setStatus(1);
					$product->setSpecialPrice($Product_Special_Price);
					$product->setMetaKeyword($Product_Meta_Keyword);
					$product->setMetaDescription($Product_Meta_Description);
					$product->setPrimaryAttribute($Product_Primary_Attribute_id);
					$product->setSubAttribute($Product_Secondary_Attribute_id);
					$product->setManufacturer($Product_Brand_Attribute_id);
					$product->setGenderAttribute($Product_Gender_Attribute_id);
					$product->setWebsiteIds(array(1));					 
					$stockData = $product->getStockData();
					$stockData['qty'] = $Product_Qty;
					$stockData['is_in_stock'] = 1;
					$stockData['manage_stock'] = 1;
					$stockData['use_config_manage_stock'] = 0;
					$product->setStockData($stockData);
					$product->save();
					
					echo 'Save All Values for Row Number '.$row.'<br/>';
					$ProductId = $product->getId();
					//IMAGE CALCULATIONS
					unset($product);
					$product = array();
					
					if($Product_Thumbnail_Image != '' && $Product_Other_Image !='')
					{
						$product = Mage::getModel('catalog/product')->load($ProductId);
					
						$mediaArray = array(
							'thumbnail'   => $Product_Thumbnail_Image,
							'image'       => $Product_Other_Image,
								);
						$importDir = Mage::getBaseDir('media') . DS . 'import/';
						foreach($mediaArray as $imageType => $fileName)
						{
							$filePath = $importDir.$fileName;

							if (file_exists($filePath)) 
							{
								
								try
								{
									if($imageType == 'thumbnail')
									{
									$product->addImageToMediaGallery($filePath,array('small_image','thumbnail'), false, false);
									}
									else
									{
									$product->addImageToMediaGallery($filePath, $imageType, false, false);
									}
								} 
								catch(Exception $e)
								{
									echo $e->getMessage();
								}

							} 
							else 
							{
								echo "Product does not have an image or the path is incorrect. Path was: {$filePath} Row number {$row}<br/>";
							}

						}
						$product->save();
					}
					unset($product);
					$product = array();
					
					//END HERE
					
				}
			
			//********************************************* END OF THIS CODE *************************************************************
		}
	}
}	
	
