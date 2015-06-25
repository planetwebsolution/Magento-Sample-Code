<?php

class Magestore_Instantsearch_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getSearchProduct($keyword)
	{
		$result = array();
		
		$limit = Mage::getStoreConfig('instantsearch/general/more_product_num');
		//search by name
		if(Mage::getStoreConfig('instantsearch/general/search_in_name'))
			$products = $this->searchProductByAttribute($keyword,"name");		
		else $products = array();		
		$product_count = count($products);
		
		if($product_count)
		{
			foreach($products as $productId)
			{
				$result[] = $productId;
			}
		}
		
		
		//search by tag
		if($product_count < $limit)
		{
			$product_list2 = $this->searchProductByTag($keyword);
			
			if(count($product_list2))
			{
				
				foreach($product_list2 as $productId)
				{
					$result[] = $productId;
					$product_count++;	
					if($product_count >= $limit)
					{
						break;
					}
				}
			}
		}
		//search by description
		if($product_count < $limit)
		{
			if(Mage::getStoreConfig('instantsearch/general/search_in_description')) {
				$description_type = Mage::getStoreConfig('instantsearch/general/search_description_type');
				switch($description_type) {
				case 1:
					$product_list3 = $this->searchProductByAttribute($keyword,"short_description");
					break;
				case 2:
					$product_list3 = $this->searchProductByAttribute($keyword,"description");
					break;
				case 3:
					$product_list3_1 = $this->searchProductByAttribute($keyword,"short_description");
					$product_list3_2 = $this->searchProductByAttribute($keyword,"description");
					$array_merge = array_merge($product_list3_1,$product_list3_2);
					$product_list3 = array();
					if(count($array_merge)) {
						foreach($array_merge as $item) {
							$product_list3[$item] = $item;
						}
					}
				}
			
			} else $product_list3 = array();
			
			if(count($product_list3))
			{
				
				foreach($product_list3 as $productId)
				{
					$result[] = $productId;
					$product_count++;	
					if($product_count >= $limit)
					{
						break;
					}
				}
			}
		}
		
		
		
		
		//************* search by code *************
		if($product_count < $limit)
		{
			
			$products_again = $this->searchProductByAttribute($keyword,"search_terms_custom");	
			$product_count_again = count($products_again);
			if(count($product_count_again))
				{
					
					foreach($products_again as $productId)
					{
						$result[] = $productId;
						$product_count++;	
						if($product_count >= $limit)
						{
							break;
						}
					}
				}
		}
		//************* search by code *************
		
		
		$result_final = array();
		if(count($result)) {
			foreach($result as $item)
				$result_final[$item] = $item;
		}
		
		return $result_final;
	}
	
        public function getInfinitescrollSearchProduct($keyword,$currentpage)
        {
            $result = array();
		
		$limit = Mage::getStoreConfig('instantsearch/general/more_product_num');
		//search by name
		if(Mage::getStoreConfig('instantsearch/general/search_in_name'))
			$products = $this->searchProductByAttributeNew($keyword,"name");		
		else $products = array();		
		$product_count = count($products);
		
		if($product_count)
		{
			foreach($products as $productId)
			{
				$result[] = $productId;
			}
		}
                //search by tag
                $product_list2 = $this->searchProductByTag($keyword);
			
			if(count($product_list2))
			{
				
				foreach($product_list2 as $productId)
				{
					$result[] = $productId;
					
				}
			}
                //search by description
                if(Mage::getStoreConfig('instantsearch/general/search_in_description')) {
				$description_type = Mage::getStoreConfig('instantsearch/general/search_description_type');
				switch($description_type) {
				case 1:
					$product_list3 = $this->searchProductByAttributeNew($keyword,"short_description");
					break;
				case 2:
					$product_list3 = $this->searchProductByAttributeNew($keyword,"description");
					break;
				case 3:
					$product_list3_1 = $this->searchProductByAttributeNew($keyword,"short_description");
					$product_list3_2 = $this->searchProductByAttributeNew($keyword,"description");
					$array_merge = array_merge($product_list3_1,$product_list3_2);
					$product_list3 = array();
					if(count($array_merge)) {
						foreach($array_merge as $item) {
							$product_list3[$item] = $item;
						}
					}
				}
			
			} else $product_list3 = array();
			
			if(count($product_list3))
			{
				
				foreach($product_list3 as $productId)
				{
					$result[] = $productId;
					
				}
			}
		//************* search by code *************	
		$products_again = $this->searchProductByAttributeNew($keyword,"search_terms_custom");	
		$product_count_again = count($products_again);
		if(count($product_count_again))
			{
				
				foreach($products_again as $productId)
				{
					$result[] = $productId;
					
				}
			}
		//************* search by code *************
		
                $output = array();
               
                if(!empty($result))
                {
			$result123 = array_unique($result);
                   $all_products_id = implode(',',$result123);
                    $output['all_product_ids'] = $all_products_id;
                    $output['outputresults'] = $result123;
                }
                
                return $output;
        }
        
	public function getRelatedkeyword($keyword)
	{
		$result = '';
		if(trim($keyword) != '')
		{
		$coreResource = Mage::getSingleton('core/resource');
		$connection = $coreResource->getConnection('core_read');
		$select  = "Select query_text from catalogsearch_query where query_text LIKE '".$keyword."%' ORDER BY popularity DESC LIMIT 1";
		$row = $connection->fetchOne($select);
		$result = '';
		if(!empty($row))
		{
			$result = $row;
		}
		}
		else
		{
		$result = '';	
		}
		return $result;
		
	}
	
        public function searchProductByAttributeNew($keyword,$att)
	{
		$result = array();
		$visibility = '';
		$visibility = array(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
				    Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG);
			$limit = Mage::getStoreConfig('instantsearch/general/more_product_num');
			$all_coll_array = array();
			$all_coll_array  = explode(' ',$keyword);
			$filter_a = array('like'=>'%'.$all_coll_array[0].'%');
			$storeId    = Mage::app()->getStore()->getId();
			$products = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect('*')
			->addAttributeToFilter('status',1)
			->setStoreId($storeId)
			->addStoreFilter($storeId)
			->addFieldToFilter($att,array($filter_a))
			->addFieldToFilter('visibility',$visibility)
			->setOrder('entity_id','DESC');
			
			if(count($all_coll_array) > 1)
			{
				$kk=0;
				foreach($all_coll_array as $outputA=>$outputB)
				{
				if($kk != 0)
				{
					$outputB = trim($outputB);
					if($outputB != '')
					{
					$outputB_value = array('like'=>'%'.$outputB.'%');
					$products = $products->addFieldToFilter($att,array($outputB_value));
					}
				}
				$kk++;
				}
			}
			
			
			//Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($products);
			//Mage::getSingleton('catalog/product_visibility')->addVisibleInSiteFilterToCollection($products);
			$products->load();
			
			if(count($products))
			{
				foreach($products as $product)
				{
					$result[] = $product->getId();
				}
			}
		return $result;
	}
        
	public function searchProductByAttribute($keyword,$att)
	{
		$result = array();
		$visibility = '';
		$visibility = array(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
				    Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG);
			$limit = Mage::getStoreConfig('instantsearch/general/more_product_num');
			$all_coll_array = array();
			$all_coll_array  = explode(' ',$keyword);
			$filter_a = array('like'=>'%'.$all_coll_array[0].'%');
			$storeId    = Mage::app()->getStore()->getId();
			$products = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect('*')
			->addAttributeToFilter('status',1)
			->setStoreId($storeId)
			->addStoreFilter($storeId)
			->addFieldToFilter($att,array($filter_a))
			->setPageSize($limit)
			->setCurPage(1)
			->addFieldToFilter('visibility',$visibility)
			->setOrder('entity_id','DESC');
			
			if(count($all_coll_array) > 1)
			{
				$kk=0;
				foreach($all_coll_array as $outputA=>$outputB)
				{
				if($kk != 0)
				{
					$outputB = trim($outputB);
					if($outputB != '')
					{
					$outputB_value = array('like'=>'%'.$outputB.'%');
					$products = $products->addFieldToFilter($att,array($outputB_value));
					}
				}
				$kk++;
				}
			}
			
			
			//Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($products);
			//Mage::getSingleton('catalog/product_visibility')->addVisibleInSiteFilterToCollection($products);
			$products->load();
			
			if(count($products))
			{
				foreach($products as $product)
				{
					$result[] = $product->getId();
				}
			}
		return $result;
	}
	
	public function searchProductByTag($keyword)
	{
		$result = array();
		
		if(Mage::getStoreConfig('instantsearch/general/search_in_tag'))
		{
			$model = Mage::getModel('tag/tag');
	            $tag_collections = $model->getResourceCollection()
	                ->addPopularity()
	                ->addStatusFilter($model->getApprovedStatus())
					->addFieldToFilter("name",array('like'=>'%'. $keyword.'%'))	
	                ->addStoreFilter(Mage::app()->getStore()->getId())
	                ->setActiveFilter()
	                ->load();
			if(count($tag_collections))
			{
				foreach($tag_collections as $tag)
				{
					$products = $this->getProductListByTagId($tag->getId());
					if(count($products))
					{
						foreach($products as $product)
						{
							$result[] = $product->getId();
						}
					}				
				}
			}
		}	
		return $result;	
	}
	
	public function getProductListByTagId($tagId)
	{
		
		$tagModel = Mage::getModel('tag/tag');
		$collections = $tagModel->getEntityCollection()
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addTagFilter($tagId)
			->addStoreFilter()
			->addMinimalPrice()
			->addUrlRewrite()
			->setActiveFilter();
		Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($collections);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInSiteFilterToCollection($collections);
		
		return $collections;		
			
	}

   
}