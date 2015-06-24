<?php
include_once('../app/Mage.php');

Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);
Mage::app('admin');
Mage::register('isSecureArea', 1);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);


set_time_limit(0);
ini_set('memory_limit','2048M');


$gp_edited_array = array();
$row = 1;
if (($handle = fopen("csv/webupload.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
		
		if($row > 1566  && $row < 1570 && $data[0] != NULL && $data[1] != NULL && $data[2] != NULL && $data[6] != NULL && $data[7] != NULL && $data[8] != NULL && $data[10] != NULL ){ // use $row > 1 for start the product upload
		
				//echo $data[1];
				//die();
				$top_main_cat_id = '';
				
				$storeid = 0; //fix for all products
				$top_category = trim(strtoupper($data[6]));  
				$gender_category = trim(strtoupper($data[8]));
				$brand_category_name = trim(strtoupper($data[7])); //NIKE
                               
                                
                                
                                
				$top_justarrcatid = 394;
				$top_comingsooncatid = 395;
				$top_closecatid = 396;
				$main_brand_id = '';
				$second_brand_id = '';
				$brandcatid = '';
				switch($brand_category_name){
					
					case 'AIR BALANCE' :
                                                $main_brand_id = 485;
                                                $second_brand_id = 516;
						if($gender_category == "MEN"){
							$brandcatid = 532;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 533;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 534;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 535;
						}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
							$brandcatid = 536;
						}
					break;
                                    
                                        case 'SEDAGATTI' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 515;
						if($gender_category == "MEN"){
							$brandcatid = 528;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 529;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 530;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 531;
						}
					break;
                                    
                                        case 'AND1' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 517;
						if($gender_category == "MEN"){
							$brandcatid = 537;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 538;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 539;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 540;
						}
					break;
                                    
                                        case 'BOB MARLEY' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 518;
						if($gender_category == "MEN"){
							$brandcatid = 541;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 542;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 543;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 544;
						}
					break;
                                    
                                        case 'CADILLAC' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 519;
						if($gender_category == "MEN"){
							$brandcatid = 545;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 546;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 547;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 548;
						}
					break;
                                    
                                        case 'FILA' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 520;
						if($gender_category == "MEN"){
							$brandcatid = 549;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 550;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 551;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 552;
						}
					break;
                                    
                                        case 'GOL (SOCCER)' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 521;
						if($gender_category == "MEN"){
							$brandcatid = 553;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 554;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 555;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 556;
						}
					break;
                                    
                                        case 'LUGZ' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 522;
						if($gender_category == "MEN"){
							$brandcatid = 557;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 558;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 559;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 560;
						}
					break;
                                    
                                        case 'MOUNTAIN GEAR' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 523;
						if($gender_category == "MEN"){
							$brandcatid = 561;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 562;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 563;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 564;
						}
					break;
                                    
                                        case 'PHAT FARM' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 527;
						if($gender_category == "MEN"){
							$brandcatid = 565;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 566;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 567;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 568;
						}
					break;
                                    
                                        case 'ASCICS' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 524;
						if($gender_category == "MEN"){
							$brandcatid = 569;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 570;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 571;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 572;
						}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
							$brandcatid = 573;
						}
					break;
                                    
                                        case 'BABY PHAT' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 525;
						if($gender_category == "MEN"){
							$brandcatid = 574;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 575;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 576;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 577;
						}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
							$brandcatid = 578;
						}
					break;
                                    
                                        case 'OFF BRAND' :
                                            $main_brand_id = 485;
                                                $second_brand_id = 526;
						if($gender_category == "MEN"){
							$brandcatid = 579;
						}elseif($gender_category == "WOMEN"){
							$brandcatid = 580;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$brandcatid = 581;
						}elseif($gender_category == "INFANT"){
							$brandcatid = 581;
						}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
							$brandcatid = 582;
						}
					break;
				}
				
				switch($top_category){
				case 'SANDAL SLIPPER' :
                                    $top_main_cat_id = 483;
					if($gender_category == "MEN"){
						$topcatid = 505;
						
					}elseif($gender_category == "WOMEN"){
						$topcatid = 506;
						
					}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
						$topcatid = 507;
						
					}elseif($gender_category == "INFANT"){
						$topcatid = 508;
						
					}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
						$topcatid = 509;
						
					}
				
				
				break;
				case 'SNEAKERS' :
                                        $top_main_cat_id = 478;
					if($gender_category == "MEN"){
						$topcatid = 486;
						
					}elseif($gender_category == "WOMEN"){
						$topcatid = 487;
						
					}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
						$topcatid = 488;
						
					}elseif($gender_category == "INFANT"){
						$topcatid = 489;
						
					}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
						$topcatid = 490;
						
					}
				
				break;
				case 'BOOTS' :
                                        $top_main_cat_id = 480;
				
					if($gender_category == "MEN"){
						$topcatid = 496;
						
					}elseif($gender_category == "WOMEN"){
						$topcatid = 497;
						
					}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
						$topcatid = 498;
						
					}elseif($gender_category == "INFANT"){
						$topcatid = 499;
						
					}
				break;
				case 'SHOES' :
                                    $top_main_cat_id = 479;
					if($gender_category == "MEN"){
						$topcatid = 491;
						
					}elseif($gender_category == "WOMEN"){
						$topcatid = 492;
						
					}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
						$topcatid = 493;
						
					}elseif($gender_category == "INFANT"){
						$topcatid = 494;
					}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
						$topcatid = 495;
						
					}
				
				break;
				case 'SOCCER' :
                                        $top_main_cat_id = 484;
					if($gender_category == "MEN"){
						$topcatid = 510;
					}elseif($gender_category == "WOMEN"){
						$topcatid = 511;
					}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
						$topcatid = 512;
					}elseif($gender_category == "INFANT"){
						$topcatid = 513;
					}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
						$topcatid = 514;
					}
				break;
			    
				 case 'HIKING' :
                                                $top_main_cat_id = 481;
                                               
						if($gender_category == "MEN"){
							$topcatid = 500;
						}elseif($gender_category == "WOMEN"){
							$topcatid = 501;
						}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
							$topcatid = 502;
						}elseif($gender_category == "INFANT"){
							$topcatid = 503;
						}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
							$topcatid = 504;
						}
					break;
                            
                                case 'SANDALS' :
                                        $top_main_cat_id = 483;
					if($gender_category == "MEN"){
						$topcatid = 505;
					}elseif($gender_category == "WOMEN"){
						$topcatid = 506;
					}elseif($gender_category == "CHILD" || $gender_category == "YOUTH"){
						$topcatid = 507;
					}elseif($gender_category == "INFANT"){
						$topcatid = 508;
					}elseif($gender_category == "KIDS" || $gender_category == "JUNIOR" || $gender_category == "JUNIORS"){
						$topcatid = 509;
					}
				break;
				}
				
				
				
			 
			  /*******ADD CATEGORY **********/
                          
                          if($topcatid == '' || $topcatid == NULL || $second_brand_id == '' || $second_brand_id == NULL || $brandcatid == '' || $brandcatid == NULL):
                          
                          
                          
                          
			$new_bcat_id = '';
			$old_cat_id = '';
			
			
			  $brand_category_name = strtoupper($data[7]); //NIKE
			  
			  $category_name = strtoupper($data[6]); //SNEAKERS
			  
			  if($top_main_cat_id != '' || $top_main_cat_id != NULL){
                          if($topcatid == '' || $topcatid == NULL){ // top brands category
                        
                          
			  
				  /***Load topcategory to check the sub category already exists or not **/
			  $collect = Mage::getModel('catalog/category')->load($top_main_cat_id);
			  $coll = $collect->getChildrenCategories();
				  
				  foreach($coll as $bcatid):
				//echo trim(strtoupper($catid->getName())) ."==". trim(strtoupper($category_name))."<br>";
					if(trim(strtoupper($bcatid->getName())) == trim(strtoupper($gender_category))) {
						$topcatid = $bcatid->getId();
                                               
                                                
                                            
					}
				endforeach ;
                            
				
					if($topcatid == '' || $topcatid == NULL){
                                        
                                        
					$general = array();
					
					//get a new category object
					  $category = Mage::getModel('catalog/category');
					  $category->setStoreId($storeid); //default/all
					  $general['name'] = $gender_category;
                                          
					  echo $general['path'] = "1/288/".$top_main_cat_id; // 1/2 is root catalog, form can be "1/2/14/23", where 23 is the parent of the new category
                                          
					  $general['description'] = $gender_category;
					  $general['display_mode'] = "PRODUCTS_AND_PAGE"; //static block and the products are shown on the page
					  $general['is_active'] = 1;
					  $general['is_anchor'] = 1;
                                          
					  $category->addData($general);
                                          
					  $category->save();
					  echo $topcatid = $category->getId(); //new cat id for ex id of SNEAKERS,SANDAL SLIPPER etc...
                                          
				  }else{
						$topcatid = $topcatid; //Set old cat id to new one
                                                
                                             
				  }
				  
			  }
			  }
                          if($second_brand_id == '' || $second_brand_id == NULL){

                            
                          //brand main
                          
                          
                          $collect_brand = Mage::getModel('catalog/category')->load(485);
			  $coll_brand = $collect_brand->getChildrenCategories();
                          foreach($coll_brand as $bcatid_brand):
				//echo trim(strtoupper($catid->getName())) ."==". trim(strtoupper($category_name))."<br>";
					if(trim(strtoupper($bcatid_brand->getName())) == trim(strtoupper($brand_category_name))) {
						$second_brand_id = $bcatid_brand->getId();
                                                
                                            
					}
				endforeach ;
                            
				
					if($second_brand_id == '' || $second_brand_id == NULL){

					$general = array();
					
					//get a new category object
					  $category = Mage::getModel('catalog/category');
					  $category->setStoreId($storeid); //default/all
					  $general['name'] = $brand_category_name;
					  $general['path'] = "1/288/485"; // 1/2 is root catalog, form can be "1/2/14/23", where 23 is the parent of the new category
					  $general['description'] = $brand_category_name;
					  $general['display_mode'] = "PRODUCTS_AND_PAGE"; //static block and the products are shown on the page
					  $general['is_active'] = 1;
					  $general['is_anchor'] = 1; // 
					  $category->addData($general);
					  $category->save();
					  $second_brand_id = $category->getId(); //new cat id for ex id of SNEAKERS,SANDAL SLIPPER etc...
				  }else{
						$second_brand_id = $second_brand_id; //Set old cat id to new one
                                                
                                             
				  }
                                  
                          }
                          if($brandcatid == '' || $brandcatid == NULL){

                                  //brand subcategory
                          
                          
                          
                          $collect_brand_sub = Mage::getModel('catalog/category')->load($second_brand_id);
			  $coll_brand_sub = $collect_brand_sub->getChildrenCategories();
                          foreach($coll_brand_sub as $bcatid_brand_sub):
				//echo trim(strtoupper($catid->getName())) ."==". trim(strtoupper($category_name))."<br>";
					if(trim(strtoupper($bcatid_brand_sub->getName())) == trim(strtoupper($gender_category))) {
						$brandcatid = $bcatid_brand_sub->getId();
                                               
                                            
					}
				endforeach ;
                            
				
					if($brandcatid == '' || $brandcatid == NULL){
					$general = array();
					
					//get a new category object
					  $category = Mage::getModel('catalog/category');
					  $category->setStoreId($storeid); //default/all
					  $general['name'] = $gender_category;
					  $general['path'] = "1/288/485"."/".$second_brand_id; // 1/2 is root catalog, form can be "1/2/14/23", where 23 is the parent of the new category
					  $general['description'] = $gender_category;
					  $general['display_mode'] = "PRODUCTS_AND_PAGE"; //static block and the products are shown on the page
					  $general['is_active'] = 1;
					  $general['is_anchor'] = 1; // 
					  $category->addData($general);
					  $category->save();
					  $brandcatid = $category->getId(); //new cat id for ex id of SNEAKERS,SANDAL SLIPPER etc...
				  }else{
						$brandcatid = $brandcatid; //Set old cat id to new one
                                                
                                             
				  }
                          }
                                  endif;
			  
			/*******ADD CATEGORY END **********/

			
			/**************INSERT/EDIT PRODUCTS****************/
			if($data[3] == '' || $data[3] == NULL) $data[3] = 0; //PPK
			if($data[4] == '' || $data[4] == NULL) $data[4] = 0; // QTY
			//if($data[15] == '' || $data[15] == NULL) $data[15] = ''; // Web Desc
			//if($data[16] == '' || $data[16] == NULL) $data[16] = ''; // Web Break Down
			
			$price = ($data[2] * $data[3]) ;
			$no_to_show = $data[11];
			if($no_to_show == 'F'){
				$no_to_show_id = 78;
			}else{
				$no_to_show_id = 79;
			}
			$prod_status = trim(strtoupper($data[9]));
			if($prod_status == 'NEW'){
				$prod_status_id = 32;
			}else{
				$prod_status_id = 33;
			}
			
			$arrival_date = $data[13];
			if($arrival_date != ''){
			//echo $arrival_date;
			//die();
				list($mm,$dd,$yy) = explode("/", $arrival_date);
				if(($mm != '' || $mm != NULL) && ($dd != '' || $dd != NULL) && ($yy != '' || $yy != NULL)){
					$arrival_date_stamp = mktime(0, 0, 0, $mm, $dd, $yy);
				}else{
					$arrival_date_stamp = NULL ;
				}
			}else{
				$arrival_date_stamp = NULL ;
			}
			
			$special = $data[14];
			if($special == 'F'){
				$special_offer = 37;
			}else{
				$special_offer = 36;
			}
			
			$gender = trim($data[8]); //MEN, Women etc...
			$product_type = strtoupper(trim($data[6]));
			switch($product_type){
			
			case 'BOOTS':
				$product_type_id = 85;
			break;	
			case 'SNEAKERS':
				$product_type_id = 87;
			break;	
			case 'SANDAL SLIPPER':
				$product_type_id = 86;
			break;	
			case 'SHOES':
				$product_type_id = 84;
			break;	
			case 'SOCCER':
				$product_type_id = 83;
			break;	
			case 'HIKING':
				$product_type_id = 88;
			break;	
			}
			
			switch($gender){
				case 'JUNIOR':
				case 'KIDS':
					$gender_id = 8;
				break;	
				case 'YOUTH':
				case 'CHILD':
					$gender_id = 6;
				break;	
				case 'MEN':
					$gender_id = 7;
				break;	
				case 'WOMEN':
					$gender_id = 4;
				break;	
				case 'INFANT':
					$gender_id = 5;
				break;	
				
				
			}
			//echo $arrival_date_stamp;
			//echo $data[15] ."<br>";
			//echo $data[16] ."<br>";
			
			/**********Check Group Product added or not ********/
			
			$gp_sku = utf8_encode($data[10]); //we use gorup id as a sku of group product
			// fetch write database connection that is used in Mage_Core module
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');
			$bRs = $write->query("select entity_id from catalog_product_entity where sku = '".$gp_sku."' and type_id = 'grouped' ");
			$brow = $bRs->fetch();
			$grouped_product_id = $brow['entity_id'];
			
			$bRs2 = $write->query("select option_id from eav_attribute_option_value where value = '".utf8_encode($data[7])."' and store_id  = '0' ");
			$brow2 = $bRs2->fetch();
			$product_collection = $brow2['option_id'];
			
			if($grouped_product_id == '' || $grouped_product_id == NULL){ // insert grouped product
			
					$api = new Mage_Catalog_Model_Product_Api();
				 
					$attribute_api = new Mage_Catalog_Model_Product_Attribute_Set_Api();
					$attribute_sets = $attribute_api->items();
					 
					$productData = array();
					$productData['website_ids'] = array(1);
					/*if($new_bcat_id != '' or $new_bcat_id != null){
					$productData['categories'] = array($new_subcat_id, $new_bcat_id); 
					}else{
					$productData['categories'] = array($new_subcat_id);
					}*/
				 
					$productData['status'] = 1;
					$productData['visibility'] = 4; //catalog-search
					 
					$productData['name'] = $gp_sku;
					$productData['description'] = utf8_encode($data[15]);
					$productData['short_description'] = utf8_encode($data[16]);
					 
					$productData['price'] = $price;
					$productData['weight'] = 1.00;
					$productData['tax_class_id'] =2; 
					
					$productData['product_collection'] = $product_collection; 
					$productData['no_to_show'] = $no_to_show_id; 
					$productData['product_group'] = utf8_encode($data[10]); 
					$productData['product_status'] = $prod_status_id; 
					$productData['offer'] = $special_offer; 
					$productData['page_layout'] ='two_columns_left';
					$productData['unit_price'] =$data[2];
					$productData['unit_per_case'] =$data[3];
					$productData['news_from_date'] =$arrival_date_stamp;
					$productData['new_arrivals'] = time();//current time stamp
					$productData['product_shipping_type'] =$product_type_id;
					
					
					
					try {	 
						$grouped_product_id = $api->create('grouped','4',$gp_sku,$productData);
					echo "Group Product SKU: ".trim($gp_sku). "has been Saved. <br />";
						}
						catch (Exception $ex) {
							//Handle the error
							echo 'Caught exception: ',  $ex->getMessage(), "\n";
			
						} 
					//print_r($new_product_id);
					 
					$stockItem = Mage::getModel('cataloginventory/stock_item');
					$stockItem->loadByProduct( $grouped_product_id );
					 
					$stockItem->setData('use_config_manage_stock', 1);
					$stockItem->setData('qty', trim($data[4]));
					$stockItem->setData('min_qty', 0);
					$stockItem->setData('use_config_min_qty', 1);
					$stockItem->setData('min_sale_qty', 0);
					$stockItem->setData('use_config_max_sale_qty', 1);
					$stockItem->setData('max_sale_qty', 0);
					$stockItem->setData('use_config_max_sale_qty', 1);
					$stockItem->setData('is_qty_decimal', 0);
					$stockItem->setData('backorders', 0);
					$stockItem->setData('notify_stock_qty', 0);
					$stockItem->setData('is_in_stock', 1);
					$stockItem->setData('tax_class_id', 2);
					 
					$stockItem->save();
					
			
					$filepath = '';
					$filename = utf8_encode($data[5]);
					$ext = strtolower(substr($filename,strlen($filename)-3,3));
					$filenamenew = substr($filename,0,strlen($filename)-3);
					$newfileLower = $filenamenew.$ext;
					$filepathlower = Mage::getBaseDir('media').'/import/'.$newfileLower;
					
					
					$ext2 = strtoupper(substr($filename,strlen($filename)-3,3));
					$filenamenew2 = substr($filename,0,strlen($filename)-3);
					$newfileUpper = $filenamenew2.$ext2;
					$filepathupper = Mage::getBaseDir('media').'/import/'.$newfileUpper;
					
					if ( file_exists($filepathlower) ) {
						$filepath = $filepathlower;
					}else{
						$filepath = $filepathupper;
					}

					
					//$filepath = Mage::getBaseDir('media').'/import/'.$newfile;
					if ( file_exists($filepath) ) {
					$product = Mage::getModel('catalog/product')->load($grouped_product_id);
					$product->setMediaGallery (array('images'=>array (), 'values'=>array ()));
					$product->addImageToMediaGallery ($filepath, array ('image','small_image','thumbnail'), false, false);
					Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
			 
					try {
						$product->save();
						echo "SKU: ".trim($gp_sku). " Images has been Saved. <br />";
					}
						catch (Exception $ex) {
							//Handle the error
						echo 'Caught exception: ',  $ex->getMessage(), "\n";
			
					}
					}else{
						echo trim($data[0])." Product does not have an image or the path is incorrect. Path was: {$filepath}<br/>";
					}
					$gp_edited_array[] = $gp_sku; //GROUP ITEM Added..Use to check No need to update it again.
			
			}else{ //Edit Grouped products
			
				if(!in_array($gp_sku, $gp_edited_array)){
				
				Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
	
						//***********DELETE Existing Images************/
						$loadpro=Mage::getModel('catalog/product')->load($grouped_product_id);
						$mediaApi = Mage::getModel("catalog/product_attribute_media_api");
						$mediaApiItems = $mediaApi->items($loadpro->getId());
						 
						foreach($mediaApiItems as $item) {
							$datatemp=$mediaApi->remove($loadpro->getId(), $item['file']);
						}
						
						$loadpro->save(); 
						//**********************************************
						
						//load product
						$gproduct = Mage::getModel("catalog/product")->load($grouped_product_id);
						
						if($gproduct) {
							//Update product details
							$gproduct->setStatus(1); 
							$gproduct->setName(utf8_encode(trim($gp_sku)));
							$gproduct->setDescription(utf8_encode($data[15]));
							$gproduct->setShortDescription(utf8_encode($data[16]));
							$gproduct->setPrice($price);
							$gproduct->setUnitPrice($data[2]);
							$gproduct->setUnitPerCase($data[3]);
							$gproduct->setNoToShow($no_to_show_id);
							$gproduct->setProductStatus($prod_status_id);
							$gproduct->setNewsFromDate($arrival_date_stamp);
							$gproduct->setNewArrivals(time());
							$gproduct->setOffer($special_offer);
							$gproduct->setProductCollection($product_collection);
							$gproduct->setProductShippingType($product_type_id);
							
							
							
							//using the setAttributeName we can update any other detail of the product.
					
							try { 
								$gproduct->save(); 
								echo "SKU: ".trim($gp_sku). "has been UPDATED. <br />";
							}catch(Exception $ex) { 
								//Handle the error 
								echo 'Caught exception: Update Error: SKU: '.trim($gp_sku).":" ,  $ex->getMessage(), "\n";
							} 
						}
						
						$filepath = '';
						$filename = utf8_encode($data[5]);
						$ext = strtolower(substr($filename,strlen($filename)-3,3));
						$filenamenew = substr($filename,0,strlen($filename)-3);
						$newfileLower = $filenamenew.$ext;
						$filepathlower = Mage::getBaseDir('media').'/import/'.$newfileLower;
						
						
						$ext2 = strtoupper(substr($filename,strlen($filename)-3,3));
						$filenamenew2 = substr($filename,0,strlen($filename)-3);
						$newfileUpper = $filenamenew2.$ext2;
						$filepathupper = Mage::getBaseDir('media').'/import/'.$newfileUpper;
						//die();
						
						if ( file_exists($filepathlower) ) {
							$filepath = $filepathlower;
						}else{
							$filepath = $filepathupper;
						}
	
						
						//$filepath = Mage::getBaseDir('media').'/import/'.$newfile;
						if ( file_exists($filepath) ) {
						$product = Mage::getModel('catalog/product')->load($grouped_product_id);
						$product->setMediaGallery (array('images'=>array (), 'values'=>array ()));
						$product->addImageToMediaGallery ($filepath, array ('image','small_image','thumbnail'), false, false);
						Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
				 
						try {
							$product->save();
							echo "SKU: ".trim($gp_sku). " Images has been Saved. <br />";
						}
							catch (Exception $ex) {
								//Handle the error
							echo 'Caught exception: ',  $ex->getMessage(), "\n";
				
						}
						}else{
							echo trim($data[0])." Product does not have an image or the path is incorrect. Path was: {$filepath}<br/>";
						}
				
				$gp_edited_array[] = $gp_sku;
				
						//*********Remove existing category from group product****************************
						$writeConnection = Mage::getSingleton('core/resource')->getConnection('core_write');
						$delQuery = 'Delete from catalog_category_product where product_id ='.$grouped_product_id;
						$writeConnection->query($delQuery);
						
						//******************************************************
				
				}//end if inarray
			
			}
			/************GROUP PRODUCT END***************/
			
			//*******Chekc SKU and Group Name is not simillar**********/
			if(trim($data[0]) == trim($data[10])){
				$simple_sku = trim($data[0])."-001";
			}else{
				$simple_sku = trim($data[0]) ;
			}
			
		
			//********************************************/
			
			

			/******* CHECK SIMPLE PRODUCT EXIST OR NOT ********/
			
			$id = Mage::getModel('catalog/product')->getIdBySku($simple_sku);
			//die("OK");
			if ($id){
				//echo "SKU exists";
				/******** EDIT SIMPLE PRODUCT ********/
				//Mage::setIsDeveloperMode(true);
				//Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));

				Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

					//load product
					$product = Mage::getModel("catalog/product")->load($id);
					if($product) {
						//Update product details
						$product->setStatus(1); 
						$product->setName(utf8_encode(trim($data[1])));
						$product->setDescription(utf8_encode($data[15]));
						$product->setShortDescription(utf8_encode($data[16]));
						$product->setPrice($price);
						$product->setUnitPrice($data[2]);
						$product->setUnitPerCase($data[3]);
						$product->setNoToShow($no_to_show_id);
						$product->setProductStatus($prod_status_id);
						$product->setNewsFromDate($arrival_date_stamp);
						$product->setOffer($special_offer);
						$product->setGender($gender_id);
						$product->setProductShippingType($product_type_id);
						$product->setProductCollection($product_collection);
						
						
						//using the setAttributeName we can update any other detail of the product.
				
						try { 
							$product->save(); 
							echo "SKU: ".$simple_sku. "has been UPDATED. <br />";
						}catch(Exception $ex) { 
							//Handle the error 
							echo 'Caught exception: Update Error: SKU: '.$simple_sku.":" ,  $ex->getMessage(), "\n";
						} 
					}
					
					if($product) {
						$stockItem =Mage::getModel('cataloginventory/stock_item')->loadByProduct($id);
						$stockItemId = $stockItem->getId();
					 
					 	try { 
						$stockItem->setData('manage_stock', 1);
						$stockItem->setData('is_in_stock', 1);
						$stockItem->setData('qty', (integer)trim($data[4]));
					 
						$stockItem->save();
						
								/*****Associate simple product into Group product******/
								$products_links = Mage::getModel('catalog/product_link_api');
								$products_links->assign ("grouped",$grouped_product_id,$id); 
								/**************************************************/

						echo "SKU: ".$simple_sku. " Stock has been UPDATED. <br />";
						}catch(Exception $ex) { 
							//Handle the error 
							echo 'Caught exception: Stock Update Error: SKU: '.$simple_sku.":" ,  $ex->getMessage(), "\n";
						} 
					}
			
				
			}else{
				//echo "SKU does not exist";
			
			/*******insert simple product into databse*******/
			
		$api = new Mage_Catalog_Model_Product_Api();
     
		$attribute_api = new Mage_Catalog_Model_Product_Attribute_Set_Api();
		$attribute_sets = $attribute_api->items();
		 
		$productData = array();
		$productData['website_ids'] = array(1);
	//	$productData['categories'] = array($new_subcat_id);
	 
		$productData['status'] = 1;
		$productData['visibility'] = 1; //not visible individualy
		 
		$productData['name'] = utf8_encode(trim($data[1]));
		$productData['description'] = utf8_encode($data[15]);
		$productData['short_description'] = utf8_encode($data[16]);
		 
		$productData['price'] = $price;
		$productData['weight'] = 1.00;
		$productData['tax_class_id'] =2; 
		
		$productData['product_collection'] = $product_collection; 
		$productData['no_to_show'] = $no_to_show_id; 
		$productData['product_group'] = utf8_encode($data[10]); 
		$productData['product_status'] = $prod_status_id; 
		$productData['offer'] = $special_offer; 
		$productData['page_layout'] ='two_columns_left';
		$productData['unit_price'] =$data[2];
		$productData['unit_per_case'] =$data[3];
		$productData['news_from_date'] =$arrival_date_stamp;
		$productData['gender'] =$gender_id;
		$productData['product_shipping_type'] =$product_type_id;
		
		
		try {	 
			$new_product_id = $api->create('simple','4',$simple_sku,$productData);
		echo "SKU: ".$simple_sku. "has been Saved. <br />";
			}
			catch (Exception $ex) {
				//Handle the error
				echo 'Caught exception: ',  $ex->getMessage(), "\n";

			} 
		//print_r($new_product_id);
		 
		$stockItem = Mage::getModel('cataloginventory/stock_item');
		$stockItem->loadByProduct( $new_product_id );
		 
		$stockItem->setData('use_config_manage_stock', 1);
		$stockItem->setData('qty', trim($data[4]));
		$stockItem->setData('min_qty', 0);
		$stockItem->setData('use_config_min_qty', 1);
		$stockItem->setData('min_sale_qty', 0);
		$stockItem->setData('use_config_max_sale_qty', 1);
		$stockItem->setData('max_sale_qty', 0);
		$stockItem->setData('use_config_max_sale_qty', 1);
		$stockItem->setData('is_qty_decimal', 0);
		$stockItem->setData('backorders', 0);
		$stockItem->setData('notify_stock_qty', 0);
		$stockItem->setData('is_in_stock', 1);
		$stockItem->setData('tax_class_id', 2);
		 
		$stockItem->save();
		
/*
************ NO NEED TO UPLOAD IMAGES FOR SIMPLE PRODUCTS *********

		$filename = utf8_encode($data[5]);
		$ext = strtolower(substr($filename,strlen($filename)-3,3));
		$filenamenew = substr($filename,0,strlen($filename)-3);
		$newfile = $filenamenew.$ext;
		
		$filepath = Mage::getBaseDir('media').'/import/'.$newfile;
		if ( file_exists($filepath) ) {
		$product = Mage::getModel('catalog/product')->load($new_product_id);
		$product->setMediaGallery (array('images'=>array (), 'values'=>array ()));
    	$product->addImageToMediaGallery ($filepath, array ('image','small_image','thumbnail'), false, false);
    	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
 
			try {
				$product->save();
				echo "SKU: ".trim($data[0]). " Images has been Saved. <br />";
			}catch (Exception $ex) {
					//Handle the error
				echo 'Caught exception: ',  $ex->getMessage(), "\n";
	
			}
		}else{
			echo trim($data[0])." Product does not have an image or the path is incorrect. Path was: {$filePath}<br/>";
		}
************************************************************		
	*/	
		
		/*****Associate simple product into Group product******/
		$products_links = Mage::getModel('catalog/product_link_api');
		$products_links->assign ("grouped",$grouped_product_id,$new_product_id); 
		/**************************************************/
		
		}//end if sky exist		
		
		
		
		//*************************************************
		if($brand_category_name == "OFF BRAND"){
			$closeout = trim($data[9]);
			if($closeout == "CLOSEOUT"){
				$closeout_cat_id = $obr_closecatid;
			}else{
				$closeout_cat_id = '';
			}
			
				//****Assign grouped products into category of this new product********
				try{
				$product2 = Mage::getModel('catalog/product')->load($grouped_product_id);
				$cats = $product2->getCategoryIds();
				$product2->setCategoryIds(array_merge($cats, array($topcatid,$brandcatid,$offbrandcatid,$new_cat_id,$closeout_cat_id,$obr_justarrcatid,$top_justarrcatid,$top_comingsooncatid,$top_closecatid,$top_main_cat_id,$second_brand_id,$main_brand_id)));
				
				$product2->save();
				}catch (Exception $ex) {
							//Handle the error
						echo 'Caught exception in Assign Category : ',  $ex->getMessage(), "\n";
			
				}
				//**********************************************
			
		}else{
			$closeout = trim($data[9]);
			if($closeout == "CLOSEOUT"){
				$closeout_cat_id = $brn_closecatid;
			}else{
				$closeout_cat_id = '';
			}
			
				//***Assign grouped products into category of this new product********
				try{
				$product2 = Mage::getModel('catalog/product')->load($grouped_product_id);
				$cats = $product2->getCategoryIds();
				$product2->setCategoryIds(array_merge($cats, array($topcatid,$brandcatid,$new_cat_id,$closeout_cat_id,$brn_justarrcatid,$top_justarrcatid,$top_comingsooncatid,$offer_cat,$top_closecatid,$top_main_cat_id,$second_brand_id,$main_brand_id)));
				$product2->save();
				}catch (Exception $ex) {
							//Handle the error
						echo 'Caught exception in Assign Category : ',  $ex->getMessage(), "\n";
			
				}
				//**********************************************
			
			
		}
			
		}//endif//skip header row	
    }//end while
    fclose($handle);
}else{
echo "error";
}

//******** Reindex DB ************/
/*for ($i = 1; $i <= 11; $i++) {
   $process = Mage::getModel('index/process')->load($i);
   $process->reindexAll();
   echo "Reindex done for Process :".$i." out of 11.<br>";
}*/
?>