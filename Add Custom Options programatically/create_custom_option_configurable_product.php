<?php
include_once('app/Mage.php');
umask(0);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
set_time_limit(0);
ini_set('memory_limit','2048M');
$row = 0;
// Assign this array in product
$rownew = 0;

//Size Attribute Id
$size_attribuate_array =  array('81'=>'70a','82'=>'70b','83'=>'70c','84'=>'70d','85'=>'75a','86'=>'75b','87'=>'75c','88'=>'75d','89'=>'80a','90'=>'80b','91'=>'80c','92'=>'80d','93'=>'85a','94'=>'85b','95'=>'85c','96'=>'85d','97'=>'L','98'=>'M','99'=>'ML','100'=>'ONE SIZE','101'=>'S','102'=>'SM','103'=>'XL','104'=>'XS','105'=>'XXL');

$color_attribuate_array = array('147'=>'anthracilte','148'=>'anthracite','143'=>'Ash','172'=>'ash rose','131'=>'BKHGS','123'=>'BLACK','156'=>'black check','113'=>'BLAck DIAMOND CROCHET','166'=>'Black iris','178'=>'BLACK/GOLD','133'=>'BLK','183'=>'BLK/GOLD','127'=>'BLK/GREY','185'=>'BLK/LION','124'=>'BLK/WHITE','132'=>'BLKSD','122'=>'Blue','170'=>'blue glow','184'=>'BLUE JEANS','111'=>'BLUE RAY SHANTUNG','173'=>'blush','119'=>'CASSIS SHANTUNG','114'=>'CLOVER MODAL','152'=>'coal grey','151'=>'COFFEE','154'=>'dark  red','174'=>'Dark forest','165'=>'Dusty Night','146'=>'dusty olive','115'=>'EOS','161'=>'floral print','179'=>'GOLD','163'=>'Greige Melange','126'=>'Grey','182'=>'GREY/BLACK','108'=>'HEATHER STR CLV','136'=>'HGR','135'=>'HGRAY','130'=>'HPNST','129'=>'HSNST','175'=>'ink','120'=>'KLEIN BLUE CEOCHET','155'=>'light blue','144'=>'LIGHT MELANGE','181'=>'LION','117'=>'LORELIE VOILE','164'=>'Midium Grey','153'=>'midnight navy','168'=>'Mineral','157'=>'mineral check','140'=>'natural','112'=>'NIRVANA','176'=>'nude','139'=>'off white','116'=>'ONYX','150'=>'pale khaki','145'=>'PHANTOM','149'=>'ple khaki','109'=>'PYTHON','121'=>'Red','125'=>'RED/ BLK','106'=>'ROSIE','118'=>'SC CLOVER','110'=>'SC GISELE CROCHET','107'=>'SCARLET','180'=>'SILVER','167'=>'Silver Melange','142'=>'skin','171'=>'smoke','134'=>'STEEL','169'=>'tender rose','137'=>'TNAVY','138'=>'TRNVY','162'=>'twilight blue','160'=>'twilight blue check','159'=>'violet blue check','158'=>'violet blue stripe','141'=>'WHITE','128'=>'White/BLK','177'=>'WINE');

$manufacture_arrtibute = array('10'=>'Alexander Wang','71'=>'Beyond Yoga','63'=>'Cette','70'=>'E Shave','69'=>'Emilio Cavalini','68'=>'Hanro','67'=>'Ivanka Trump','14'=>'newbrand','66'=>'Pamela Man','65'=>'Vitamin A','64'=>'X By Gottex');
//$size_attribuate_array = array('73'=>'L','74'=>'M','75'=>'ML','72'=>'ONE SIZE','76'=>'S','77'=>'SM','78'=>'XL','79'=>'XS','80'=>'XXL');
//End here

//per declare varibles
$last_inserted_sku = '';

//end of this code
if (($handle_new = fopen("csv_19_12_2014.csv", "r")) !== FALSE) 
{
     while (($datanew = fgetcsv($handle_new, 1000000, ",")) !== FALSE)
	{
            $numnew = count($datanew);
            $rownew++;
            if($rownew > 1)
            {
	       
	       $data_category_ids = trim($datanew[0]);
	       $data_Brand = trim($datanew[1]);
	       $data_Category = trim($datanew[2]);
	       $data_Parent_Sku = trim($datanew[3]);
	       $data_Variant =trim($datanew[4]);
	       $data_status =trim($datanew[5]);
	       $data_Style =trim($datanew[6]);
	       $data_Size =trim($datanew[7]);
	       $data_name =trim($datanew[8]);
	       $data_color =trim($datanew[9]);
	       $data_image =trim($datanew[10]);
	       $data_small_image =trim($datanew[11]);
	       $data_thumbnail =trim($datanew[12]);
	       $data_price =trim($datanew[13]);
	       $data_special_price =trim($datanew[14]);
	       $data_qty =trim($datanew[15]);
	       $data_description =trim($datanew[16]);
	       $data_short_description =trim($datanew[17]);
	       $data_PIC_NAME = trim($datanew[18]);
	       
	       ///////// THIS IS MAIN CATEGORY ID ////////
	       
	       if(trim(strtolower($data_Category))=='femme')
	       {
		    $parentCategoryId = '3';
	       }
	       
	       if(trim(strtolower($data_Category))  == 'homme')
	       {
		    $parentCategoryId = '8';
	       }
	       
	       ///////// END OF THIS CODE ////////////////
	       
	       
	       $Category_Name_Here =  $data_category_ids;
	       $strtolower_categoryname = strtolower($Category_Name_Here);
	       //$parentCategoryId = trim($data[2]);
	       $childCategory_first = array();
	       $cat = Mage::getModel('catalog/category')->load($parentCategoryId);
	       $childCategory_first = Mage::getModel('catalog/category')->getCollection()
		    ->addAttributeToFilter('is_active', true)
		    ->addIdFilter($cat->getChildren())
		    ->addAttributeToFilter('name', $strtolower_categoryname)
		    ->getFirstItem();
	       if ($childCategory_first->getId() !== null) 
	       {
		    $Coming_child_category_id = $childCategory_first->getId();
		    
		    $simpleProduct = array();
		    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		    $simpleProduct = Mage::getModel('catalog/product');
		    try {
			 
		    $coming_size_attribute = $data_Size;
		    $size_result = '';
		    if(in_array($coming_size_attribute,$size_attribuate_array))
		    {
			 $size_result = array_search($coming_size_attribute,$size_attribuate_array);
		    }
			
		    $coming_color_attribute = $data_color;
		    $color_result = '';
		    if(in_array($coming_color_attribute,$color_attribuate_array))
		    {
			 $color_result = array_search($coming_color_attribute,$color_attribuate_array);
		    }
		    
		    $coming_manufacture_attribute = $data_Brand;
		    $brand_result = '';
		    if(in_array($coming_manufacture_attribute,$manufacture_arrtibute))
		    {
			 $brand_result = array_search($coming_manufacture_attribute,$manufacture_arrtibute);
		    }
			// Simple product
			
			 $simpleProduct
			     ->setWebsiteIds(array(1,2))
			     ->setAttributeSetId(4)
			     ->setTypeId('simple')
			     ->setCreatedAt(strtotime('now'))
			     ->setSku($data_Variant)
			     ->setName($data_name)
			     ->setProductSize($size_result)
			     ->setProductColorFragrance($color_result)
			     ->setManufacturer($brand_result)
			     ->setWeight(4)
			     ->setStatus(1)
			     ->setTaxClassId(2)
			     ->setVisibility(1)
			     ->setPrice($data_price)
			     ->setSpecialPrice($data_special_price)
			     ->setDescription($data_description)
			     ->setShortDescription($data_short_description)
			     ->setStockData(array(
				     'use_config_manage_stock' => 0, //'Use config settings' checkbox
				     'manage_stock' => 1, //manage stock
				     'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
				     'is_in_stock' => 1, //Stock Availability
				     'qty' => $data_qty //qty
				 )
			     )
			     ->setCategoryIds(array($parentCategoryId, $Coming_child_category_id)); //assign product to categories
			     $simpleProduct->save();
			
			// End of this code
			$product = array ();
			      $product = Mage::getModel('catalog/product')->load($simpleProduct->getId());
			      $attributeCode = Mage::helper('shopbybrand/brand')->getAttributeCode();
			      /* edit by cuong */
			      $attributeCode = strtolower($attributeCode);
			      /* end edit by cuong */
			      $oldOptionId = Mage::getModel('catalog/product')->load($product->getId())->getData($attributeCode);
			      $optionId = $product->getData($attributeCode);
			      if ($optionId != 0) {
				  $oldBrand = Mage::getModel('shopbybrand/brand')->load($oldOptionId, 'option_id');
				  $productIds = $oldBrand->getData('product_ids');
				  $pos = strpos($productIds, $product->getId());
				  if ($pos == 0) {
				      if ($product->getId() == $productIds) {
					  $productIds = '';
				      } else {
					  $productIds = str_replace($product->getId() . ',', '', $productIds);
				      }
				  } elseif ($pos > 0) {
				      $productIds = str_replace(',' . $product->getId(), '', $productIds);
				  }
				  $oldBrand->setProductIds($productIds)->save();
				  $newBrand = Mage::getModel('shopbybrand/brand')->load($optionId, 'option_id');
				  if ($newBrand->getData('product_ids')) {
				      $newProductIds = $newBrand->getData('product_ids') . ',' . $product->getId();
				  } else {
				      $newProductIds = $product->getId();
				  }
				  $newBrand->setProductIds($newProductIds)->save();
			      }
			      unset($product);
			      unset($simpleProduct);
			
			echo 'Product Save for row number '.$rownew.'<br>';
			
		    } catch (Exception $e) {
			Mage::log($e->getMessage());
			echo $e->getMessage();
		    }
		    
     	       }
	       else
	       {
		    echo '<b> First Lavel category has not found , Please check  row number '.$rownew.'<br></b>';
		    
	       }
	    }
	}    
}
fclose($handle_new);
//End Here
?>