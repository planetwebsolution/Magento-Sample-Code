<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Phoenix
 * @package     Phoenix_Moneybookers
 * @copyright   Copyright (c) 2013 Phoenix Medien GmbH & Co. KG (http://www.phoenix-medien.de)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Pws_Infiniteanalytics_Block_Recommendations extends Mage_Core_Block_Template
{
    
    protected $service_url;
    protected $ecompany_name;
    protected $mode;
    protected $client_ip;
    protected $rest_api_user_type;
    protected $rest_api_user_value;
    protected $orderby;
    public function _construct()
    {
       $this->service_url = $this->GetServiceUrl();
       $this->ecompany_name = $this->GetEcompanyName();
       $this->mode = $this->GetMode();
       $this->client_ip  = $_SERVER['REMOTE_ADDR'];
       $this->orderby = $this->GetOrderBy();
       
       if(Mage::getSingleton('customer/session')->isLoggedIn())
       {
	$customer_data=Mage::getSingleton('customer/session')->getCustomer();
	$userId = $customer_data->getId();
	$this->rest_api_user_type  = 'site_user';
	$this->rest_api_user_value  = $userId;
       }
       else
       {
	$this->rest_api_user_type  = 'session';
	$this->rest_api_user_value  = $_COOKIE['frontend'];        
       }
       
       if($this->IsRecommendationsEnable() == '0')
	{
	    return;
	}
       parent::_construct();
  
    }
    
    public function IsRecommendationsEnable()
    {
        return Mage::getStoreConfig('infiniteanalytics_options/general/enabled');
    }
	
	
    public function GetServiceUrl()
    {
        return Mage::getStoreConfig('infiniteanalytics_mainoptions/others/serviceurl');
    }
	
    public function GetEcompanyName()
    {
        return Mage::getStoreConfig('infiniteanalytics_mainoptions/others/ecompany');
    }
	
	
    public function GetOrderBy()
    {
        return Mage::getStoreConfig('infiniteanalytics_mainoptions/others/recommendationsorderby');
    }
	
    public function GetMode()
    {
	return Mage::getStoreConfig('infiniteanalytics_mainoptions/others/recommendationsmode');
    }
    
    public function GetNumberofProduct()
    {
	return Mage::getStoreConfig('infiniteanalytics_options/design_recommendations/numberofproduct');
    }
    
     public function GetRecommendationProductHtml()
    {
	return Mage::getStoreConfig('infiniteanalytics_options/design_recommendations/design_html');
    }
    
    public function GetRecommendationCss()
    {
	return Mage::getStoreConfig('infiniteanalytics_options/design_recommendations/design_css');
    }
    
   
    
     
    public function GetRecommendationfeed()
    {
	
	if($this->IsRecommendationsEnable() == '1')
	{
	    $service_url = $this->service_url;
	    $ecompany_name = $this->ecompany_name;
	    $mode = $this->mode;
	    $client_ip = $this->client_ip;
	    
	    $count = $this->GetNumberofProduct();
	    
	  
	
	    $curl_post_data = array(
		    'ecompany' => $ecompany_name,
		    'user_type' => $this->rest_api_user_type,
		    'user_id'  => $this->rest_api_user_value,
		    'client_ip' => $client_ip,
		    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'count' => $count,
		    'mode' =>$mode,
		    'order_by'=>$this->orderby
	    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		$result_html = '<ul class="recommendation-feed products-grid products-grid--max-4-col">';
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    $category = $recommedation_value['category'];
		    $price = $recommedation_value['price'];
		    $keyword = $recommedation_value['keywords'];
		    $image_url = $recommedation_value['image_url'];
		    $name = $recommedation_value['name'];
		    $discounted_price = $recommedation_value['discounted_price'];
		    $gender = $recommedation_value['gender'];
		    $brand = $recommedation_value['brand'];
                    $subbrand = $recommedation_value['subbrand'];      
                    $site_product_id   = $recommedation_value['site_product_id']; 
                    $sku =   $recommedation_value['sku'];
		    
		    //$url = $recommedation_value['url'];
		    
		    $product_array = array();
		    $product_array = Mage::getModel("catalog/product")->loadByAttribute('sku',$site_product_id);
		    
		    $url = 'http://dothejob.in/infiniteanalytics/'.$product_array->getUrlPath();

		   
                    
		    $producthtml = '';
		    $producthtml  = $this->GetRecommendationProductHtml();
		    $producthtml  = str_replace('{{image}}',$image_url,$producthtml);
		    $producthtml  = str_replace('{{name}}',$name,$producthtml);
		    $producthtml  = str_replace('{{price}}',$price,$producthtml);
		    $producthtml  = str_replace('{{discountedprice}}',$discounted_price,$producthtml);
		    $producthtml  = str_replace('{{category}}',$category,$producthtml);
		    $producthtml  = str_replace('{{keyword}}',$keyword,$producthtml);
		    $producthtml  = str_replace('{{gender}}',$gender,$producthtml);
		    $producthtml  = str_replace('{{brand}}',$brand,$producthtml);
		    $producthtml  = str_replace('{{subbrand}}',$subbrand,$producthtml);
		    $producthtml  = str_replace('{{siteproductid}}',$site_product_id,$producthtml);
		    $producthtml  = str_replace('{{sku}}',$sku,$producthtml);
		    $producthtml  = str_replace('{{url}}',$url,$producthtml);
		    
		    $result_html .= $producthtml;
		    
		}
		$result_html .='</ul>';
		
		return $result_html;
	    }
	    else
	    {
		return 'Data not found';
	    }

	}
	else
	{
	    return 'Please enable the Recommendations Feed from admin';
	}
    }
    
    public function GetCategoryPageRecommendationfeed($comingcategoryname)
    {
	
	$check_main_page_recommendation_enable = Mage::getStoreConfig('infiniteanalytics_categorypagesettings/general/enabled');
	$check_sub_recommendation_enable =  Mage::getStoreConfig('infiniteanalytics_categorypagesettings/nowtrending/nowtrending_enabled');
	if($check_main_page_recommendation_enable == '1' && $check_sub_recommendation_enable == '1')
	{
	    $custom_service_url_enable = Mage::getStoreConfig('infiniteanalytics_categorypagesettings/nowtrending/nowtrending_serviceurl_yesno');
	    if($custom_service_url_enable == 1)
	    {
	     $service_url = Mage::getStoreConfig('infiniteanalytics_categorypagesettings/nowtrending/nowtrending_serviceurl');
	    }
	    else
	    {
	    $service_url = $this->service_url;
	    }
	    
	    if(trim($service_url) != '' )
	    {
		 $ecompany_name = $this->ecompany_name;
		 $client_ip = $this->client_ip;
	         $count = Mage::getStoreConfig('infiniteanalytics_categorypagesettings/nowtrending/nowtrending_count');
		 $count = ($count != '')?$count:4; 
		 $mode =  Mage::getStoreConfig('infiniteanalytics_categorypagesettings/nowtrending/nowtrending_mode');
		 $custom_html = Mage::getStoreConfig('infiniteanalytics_categorypagesettings/nowtrending/nowtrending_html');
		 $custom_css = Mage::getStoreConfig('infiniteanalytics_categorypagesettings/nowtrending/nowtrending_css');
		 
		     $category_page_name = $comingcategoryname;
			$curl_post_data = array(
				'ecompany' => $ecompany_name,
				'user_type' => $this->rest_api_user_type,
				'user_id'  => $this->rest_api_user_value,
				'client_ip' => $client_ip,
				'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
				'count' => $count,
				'search_string'=>$category_page_name
			);
	   
	   $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">Now trending</h3><ul class="recommendation-feed products-grid products-grid--max-3-col">';
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    $category = $recommedation_value['category'];
		    $price = $recommedation_value['price'];
		    $keyword = $recommedation_value['keywords'];
		    $image_url = $recommedation_value['image_url'];
		    $name = $recommedation_value['name'];
		    $discounted_price = $recommedation_value['discounted_price'];
		    $gender = $recommedation_value['gender'];
		    $brand = $recommedation_value['brand'];
                    $subbrand = $recommedation_value['subbrand'];      
                    $site_product_id   = $recommedation_value['site_product_id']; 
                    $sku =   $recommedation_value['sku'];
		    //$url = $recommedation_value['url'];
		    
                    $product_array = array();
		    $product_array = Mage::getModel("catalog/product")->loadByAttribute('sku',$site_product_id);
		    
		    $url = 'http://dothejob.in/infiniteanalytics/'.$product_array->getUrlPath();
		    
		    $producthtml = '';
		    $producthtml  = $custom_html;
		    $producthtml  = str_replace('{{image}}',$image_url,$producthtml);
		    $producthtml  = str_replace('{{name}}',$name,$producthtml);
		    $producthtml  = str_replace('{{price}}',$price,$producthtml);
		    $producthtml  = str_replace('{{discountedprice}}',$discounted_price,$producthtml);
		    $producthtml  = str_replace('{{category}}',$category,$producthtml);
		    $producthtml  = str_replace('{{keyword}}',$keyword,$producthtml);
		    $producthtml  = str_replace('{{gender}}',$gender,$producthtml);
		    $producthtml  = str_replace('{{brand}}',$brand,$producthtml);
		    $producthtml  = str_replace('{{subbrand}}',$subbrand,$producthtml);
		    $producthtml  = str_replace('{{siteproductid}}',$site_product_id,$producthtml);
		    $producthtml  = str_replace('{{sku}}',$sku,$producthtml);
		    $producthtml  = str_replace('{{url}}',$url,$producthtml);
		    
		    $result_html .= $producthtml;
		    
		}
		$result_html .='</ul>';
		
		$result_html .= $custom_css;
		
		return $result_html;
	    }
	
	
	    }
	}
	
    }
    
    
    public function GetCategoryRecommendationCss()
    {
	$check_show_on_category_page = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/categorypage');
	if($check_show_on_category_page == 1)
	{
	    $use_default_design = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/use_same_default_html_category');
	    if($use_default_design == 1)
	    {
		$get_custom_value_html = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/category_page_css');
		$custom_css = ($get_custom_value_html != '')?$get_custom_value_html:$this->GetRecommendationCss();
	    }
	    else
	    {
		$custom_css = $this->GetRecommendationCss();
	    }
	    
	    return $custom_css;
	}
    }
    
    
     public function GetProductPageRecommendationfeed($currentproductsku)
    {
	$check_show_on_category_page = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/productviewpage');
	if($check_show_on_category_page == 1)
	{
	    $use_default_design = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/use_same_default_html_product');
	    if($use_default_design == 1)
	    {
		$get_custom_value_count = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/product_page_product_count');
		$get_custom_value_html = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/product_page_html');
		$custom_count = ($get_custom_value_count !='')?$get_custom_value_count:$this->GetNumberofProduct();
		$custom_html = ($get_custom_value_html !='')?$get_custom_value_html:$this->GetRecommendationProductHtml();
	    }
	    else
	    {
		$custom_count = $this->GetNumberofProduct();
		$custom_html = $this->GetRecommendationProductHtml();
	    }
	    
	    $service_url = $this->service_url;
	    $ecompany_name = $this->ecompany_name;
	    $mode = $this->mode;
	    
	    $client_ip = $this->client_ip;
	    
	    $count = $custom_count;
	    $number = 1;
	     $curl_post_data = array(
		    'ecompany' => $ecompany_name,
		    'user_type' => $this->rest_api_user_type,
		    'user_id'  => $this->rest_api_user_value,
		    'site_product_id' => $currentproductsku,
		    'client_ip' => $client_ip,
		    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'count' => $count,
		    'mode' =>$mode,
		    'order_by'=>$this->orderby
	    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">Recommended Products</h3><ul class="recommendation-feed products-grid products-grid--max-4-col">';
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    $category = $recommedation_value['category'];
		    $price = $recommedation_value['price'];
		    $keyword = $recommedation_value['keywords'];
		    $image_url = $recommedation_value['image_url'];
		    $name = $recommedation_value['name'];
		    $discounted_price = $recommedation_value['discounted_price'];
		    $gender = $recommedation_value['gender'];
		    $brand = $recommedation_value['brand'];
                    $subbrand = $recommedation_value['subbrand'];      
                    $site_product_id   = $recommedation_value['site_product_id']; 
                    $sku =   $recommedation_value['sku'];
		    //$url = $recommedation_value['url'];
		    
		    $product_array = array();
		    $product_array = Mage::getModel("catalog/product")->loadByAttribute('sku',$site_product_id);
		    
		    $url = 'http://dothejob.in/infiniteanalytics/'.$product_array->getUrlPath();
                    
		    $producthtml = '';
		    $producthtml  = $custom_html;
		    $producthtml  = str_replace('{{image}}',$image_url,$producthtml);
		    $producthtml  = str_replace('{{name}}',$name,$producthtml);
		    $producthtml  = str_replace('{{price}}',$price,$producthtml);
		    $producthtml  = str_replace('{{discountedprice}}',$discounted_price,$producthtml);
		    $producthtml  = str_replace('{{category}}',$category,$producthtml);
		    $producthtml  = str_replace('{{keyword}}',$keyword,$producthtml);
		    $producthtml  = str_replace('{{gender}}',$gender,$producthtml);
		    $producthtml  = str_replace('{{brand}}',$brand,$producthtml);
		    $producthtml  = str_replace('{{subbrand}}',$subbrand,$producthtml);
		    $producthtml  = str_replace('{{siteproductid}}',$site_product_id,$producthtml);
		    $producthtml  = str_replace('{{sku}}',$sku,$producthtml);
		    $producthtml  = str_replace('{{url}}',$url,$producthtml);
		    
		    $onlclick_event = 'onclick="return setrecommedationcookie(\''.$currentproductsku.'\',\''.$site_product_id.'\')"';
		    $producthtml  = str_replace('{{onclick-event}}',$onlclick_event,$producthtml);
		    
		    $result_html .= $producthtml;
		    
		}
		$result_html .='</ul>';
		return $result_html;
	    }
	    else
	    {
		echo 'no data found';
	    }
	}
    }
    
    
    public function GetProductPageRecommendationCss()
    {
	$check_show_on_category_page = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/productviewpage');
	if($check_show_on_category_page == 1)
	{
	    $use_default_design = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/use_same_default_html_product');
	    if($use_default_design == 1)
	    {
		$get_custom_value_html = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/product_page_css');
		$custom_css = ($get_custom_value_html != '')?$get_custom_value_html:$this->GetRecommendationCss();
	    }
	    else
	    {
		$custom_css = $this->GetRecommendationCss();
	    }
	    
	    return $custom_css;
	}
    }
    
    
     public function GetSearchRecommendationBycategoryandByBrandfeed($search_string)
    {
	
	$check_main_page_recommendation_enable = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/general/enabled');
	$check_sub_recommendation_enable =  Mage::getStoreConfig('infiniteanalytics_searchpagesettings/Searchresultsbybrandandcat/Searchresultsbybrandandcat_enabled');
	if($check_main_page_recommendation_enable == '1' && $check_sub_recommendation_enable == '1')
	{
	    $custom_service_url_enable = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/Searchresultsbybrandandcat/Searchresultsbybrandandcat_serviceurl_yesno');
	    if($custom_service_url_enable == 1)
	    {
	     $service_url = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/Searchresultsbybrandandcat/Searchresultsbybrandandcat_serviceurl');
	    }
	    else
	    {
	    $service_url = $this->service_url;
	    }
	    
	    if(trim($service_url) != '' )
	    {
		 $ecompany_name = $this->ecompany_name;
		 $client_ip = $this->client_ip;
	         $count = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/Searchresultsbybrandandcat/Searchresultsbybrandandcat_count');
		 $count = ($count != '')?$count:4; 
		 $mode =  Mage::getStoreConfig('infiniteanalytics_searchpagesettings/Searchresultsbybrandandcat/Searchresultsbybrandandcat_mode');
		 $custom_html = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/Searchresultsbybrandandcat/Searchresultsbybrandandcat_html');
		 $custom_css = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/Searchresultsbybrandandcat/Searchresultsbybrandandcat_css');
		 
	    $url_encodeed_string = urlencode($search_string);
	    $curl_post_data = array(
		    'ecompany' => $ecompany_name,
		    'user_type' => $this->rest_api_user_type,
		    'user_id'  => $this->rest_api_user_value,
		    'search_string' => $url_encodeed_string,
		    'client_ip' => $client_ip,
		    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'count' => $count
	    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">IA Search Results</h3><ul class="recommendation-feed products-grid products-grid--max-3-col">';
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    $category = $recommedation_value['category'];
		    $price = $recommedation_value['price'];
		    $keyword = $recommedation_value['keywords'];
		    $image_url = $recommedation_value['image_url'];
		    $name = $recommedation_value['name'];
		    $discounted_price = $recommedation_value['discounted_price'];
		    $gender = $recommedation_value['gender'];
		    $brand = $recommedation_value['brand'];
                    $subbrand = $recommedation_value['subbrand'];      
                    $site_product_id   = $recommedation_value['site_product_id']; 
                    $sku =   $recommedation_value['sku'];
		    //$url = $recommedation_value['url'];
		    
		    $product_array = array();
		    $product_array = Mage::getModel("catalog/product")->loadByAttribute('sku',$site_product_id);
		    
		    $url = 'http://dothejob.in/infiniteanalytics/'.$product_array->getUrlPath();
                    
		    $producthtml = '';
		    $producthtml  = $custom_html;
		    $producthtml  = str_replace('{{image}}',$image_url,$producthtml);
		    $producthtml  = str_replace('{{name}}',$name,$producthtml);
		    $producthtml  = str_replace('{{price}}',$price,$producthtml);
		    $producthtml  = str_replace('{{discountedprice}}',$discounted_price,$producthtml);
		    $producthtml  = str_replace('{{category}}',$category,$producthtml);
		    $producthtml  = str_replace('{{keyword}}',$keyword,$producthtml);
		    $producthtml  = str_replace('{{gender}}',$gender,$producthtml);
		    $producthtml  = str_replace('{{brand}}',$brand,$producthtml);
		    $producthtml  = str_replace('{{subbrand}}',$subbrand,$producthtml);
		    $producthtml  = str_replace('{{siteproductid}}',$site_product_id,$producthtml);
		    $producthtml  = str_replace('{{sku}}',$sku,$producthtml);
		    $producthtml  = str_replace('{{url}}',$url,$producthtml);
		    
		    $result_html .= $producthtml;
		    
		}
		$result_html .='</ul>';
		$result_html .= $custom_css;
		return $result_html;
	    } 
	
	
	    }
	}
    }
    
    
    public function GetSearchRecommendationCss()
    {
	$check_show_on_category_page = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/searchpage');
	if($check_show_on_category_page == 1)
	{
	    $use_default_design = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/use_same_default_html_search');
	    if($use_default_design == 1)
	    {
		$get_custom_value_html = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/search_page_css');
		$custom_css = ($get_custom_value_html != '')?$get_custom_value_html:$this->GetRecommendationCss();
	    }
	    else
	    {
		$custom_css = $this->GetRecommendationCss();
	    }
	    
	    return $custom_css;
	}
    }
    
    
    
         public function GetCartRecommendationfeed()
    {
	$check_show_on_category_page = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/cartpage');
	if($check_show_on_category_page == 1)
	{
	    $use_default_design = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/use_same_default_html_cart');
	    if($use_default_design == 1)
	    {
		$get_custom_value_count = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/cart_page_product_count');
		$get_custom_value_html = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/cart_page_html');
		$custom_count = ($get_custom_value_count !='')?$get_custom_value_count:$this->GetNumberofProduct();
		$custom_html = ($get_custom_value_html !='')?$get_custom_value_html:$this->GetRecommendationProductHtml();
	    }
	    else
	    {
		$custom_count = $this->GetNumberofProduct();
		$custom_html = $this->GetRecommendationProductHtml();
	    }
	    
	    $service_url = $this->service_url;
	    $ecompany_name = $this->ecompany_name;
	    $mode = $this->mode;
	    $client_ip = $this->client_ip;
	    
	    $count = $custom_count;
	    
	    $curl_post_data = array(
		    'ecompany' => $ecompany_name,
		    'user_type' => $this->rest_api_user_type,
		    'user_id'  => $this->rest_api_user_value,
		    'client_ip' => $client_ip,
		    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'count' => $count,
		    'mode' =>$mode,
		    'order_by'=>$this->orderby
	    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">Recommended Products</h3><ul class="recommendation-feed products-grid products-grid--max-4-col">';
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    $category = $recommedation_value['category'];
		    $price = $recommedation_value['price'];
		    $keyword = $recommedation_value['keywords'];
		    $image_url = $recommedation_value['image_url'];
		    $name = $recommedation_value['name'];
		    $discounted_price = $recommedation_value['discounted_price'];
		    $gender = $recommedation_value['gender'];
		    $brand = $recommedation_value['brand'];
                    $subbrand = $recommedation_value['subbrand'];      
                    $site_product_id   = $recommedation_value['site_product_id']; 
                    $sku =   $recommedation_value['sku'];
		    //$url = $recommedation_value['url'];
		    
		    $product_array = array();
		    $product_array = Mage::getModel("catalog/product")->loadByAttribute('sku',$site_product_id);
		    
		    $url = 'http://dothejob.in/infiniteanalytics/'.$product_array->getUrlPath();
                    
		    $producthtml = '';
		    $producthtml  = $custom_html;
		    $producthtml  = str_replace('{{image}}',$image_url,$producthtml);
		    $producthtml  = str_replace('{{name}}',$name,$producthtml);
		    $producthtml  = str_replace('{{price}}',$price,$producthtml);
		    $producthtml  = str_replace('{{discountedprice}}',$discounted_price,$producthtml);
		    $producthtml  = str_replace('{{category}}',$category,$producthtml);
		    $producthtml  = str_replace('{{keyword}}',$keyword,$producthtml);
		    $producthtml  = str_replace('{{gender}}',$gender,$producthtml);
		    $producthtml  = str_replace('{{brand}}',$brand,$producthtml);
		    $producthtml  = str_replace('{{subbrand}}',$subbrand,$producthtml);
		    $producthtml  = str_replace('{{siteproductid}}',$site_product_id,$producthtml);
		    $producthtml  = str_replace('{{sku}}',$sku,$producthtml);
		    $producthtml  = str_replace('{{url}}',$url,$producthtml);
		    
		    $result_html .= $producthtml;
		    
		}
		$result_html .='</ul>';
		return $result_html;
	    }  
	}
    }
    
    
    public function GetCartRecommendationCss()
    {
	$check_show_on_category_page = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/cartpage');
	if($check_show_on_category_page == 1)
	{
	    $use_default_design = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/use_same_default_html_cart');
	    if($use_default_design == 1)
	    {
		$get_custom_value_html = Mage::getStoreConfig('infiniteanalytics_options/show_recommendations_on/cart_page_css');
		$custom_css = ($get_custom_value_html != '')?$get_custom_value_html:$this->GetRecommendationCss();
	    }
	    else
	    {
		$custom_css = $this->GetRecommendationCss();
	    }
	    
	    return $custom_css;
	}
    }
    
    
    public function GetHomePageCategoryPersonalizationFeed()
    {
	$check_main_page_recommendation_enable = Mage::getStoreConfig('infiniteanalytics_homepagesettings/general/enabled');
	$check_sub_recommendation_enable =  Mage::getStoreConfig('infiniteanalytics_homepagesettings/categorypersonalization/categorypersonalization_enabled');
	if($check_main_page_recommendation_enable == '1' && $check_sub_recommendation_enable == '1')
	{
	    $custom_service_url_enable = Mage::getStoreConfig('infiniteanalytics_homepagesettings/categorypersonalization/categorypersonalization_serviceurl_yesno');
	    if($custom_service_url_enable == 1)
	    {
	     $service_url = Mage::getStoreConfig('infiniteanalytics_homepagesettings/categorypersonalization/categorypersonalization_serviceurl');
	    }
	    else
	    {
	    $service_url = $this->service_url;
	    }
	    
	    if(trim($service_url) != '' )
	    {
		
	    $ecompany_name = $this->ecompany_name;
	    $mode = Mage::getStoreConfig('infiniteanalytics_homepagesettings/categorypersonalization/categorypersonalization_mode');
	    $client_ip = $this->client_ip;
	    $count =  Mage::getStoreConfig('infiniteanalytics_homepagesettings/categorypersonalization/categorypersonalization_count');
	    
	  
	
	    $curl_post_data = array(
		    'ecompany' => $ecompany_name,
		    'user_type' => $this->rest_api_user_type,
		    'user_id'  => $this->rest_api_user_value,
		    'client_ip' => $client_ip,
		    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'categories_instead_of_products'=>'1'
	    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	   $html = Mage::getStoreConfig('infiniteanalytics_homepagesettings/categorypersonalization/categorypersonalization_html');
	   
	   $finalcategoryarray = array();
	   
	    if(!empty($result_data))
	    {
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">Home page category personalization</h3><ul class="recommendation-feed products-grid products-grid--max-5-col">';
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    $category = $recommedation_value['category'];
		    
		    if(!in_Array($category,$finalcategoryarray))
		    {
			$finalcategoryarray[]  = $category;
		    }
	    
		}
		
		$check_increment = 0;
		$final_count = (trim($count) !='')?$count:4;
		foreach($finalcategoryarray as $categoryname)
		{
		    if($check_increment < $final_count)
		    {
		    $producthtml = '';
		    $producthtml  = $html;
		    $producthtml  = str_replace('{{category}}',$categoryname,$producthtml);
		    $result_html .= $producthtml;
		    }
		$check_increment++;
		}
		
		$result_html .='</ul>';
		$result_html .= Mage::getStoreConfig('infiniteanalytics_homepagesettings/categorypersonalization/categorypersonalization_css');
		return $result_html;
	    }
	
	
	    }
	}
	
    }
    
     public function GetHomePageProductsYouCareAboutFeed()
    {
	
	$check_main_page_recommendation_enable = Mage::getStoreConfig('infiniteanalytics_homepagesettings/general/enabled');
	$check_sub_recommendation_enable =  Mage::getStoreConfig('infiniteanalytics_homepagesettings/productsyoucareabout/productsyoucareabout_enabled');
	if($check_main_page_recommendation_enable == '1' && $check_sub_recommendation_enable == '1')
	{
	    $custom_service_url_enable = Mage::getStoreConfig('infiniteanalytics_homepagesettings/productsyoucareabout/productsyoucareabout_serviceurl_yesno');
	    if($custom_service_url_enable == 1)
	    {
	     $service_url = Mage::getStoreConfig('infiniteanalytics_homepagesettings/productsyoucareabout/productsyoucareabout_serviceurl');
	    }
	    else
	    {
	    $service_url = $this->service_url;
	    }
	    
	    if(trim($service_url) != '' )
	    {
		 $ecompany_name = $this->ecompany_name;
		 $mode = $this->mode;
		 $client_ip = $this->client_ip;
	         $count = Mage::getStoreConfig('infiniteanalytics_homepagesettings/productsyoucareabout/productsyoucareabout_count');
		 $count = ($count != '')?$count:4; 
		 $mode =  Mage::getStoreConfig('infiniteanalytics_homepagesettings/productsyoucareabout/productsyoucareabout_mode');
		
		    $curl_post_data = array(
			    'ecompany' => $ecompany_name,
			    'user_type' => $this->rest_api_user_type,
			    'user_id'  => $this->rest_api_user_value,
			    'client_ip' => $client_ip,
			    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
			    'count' => $count,
			    'mode'=>$mode
		    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">The products you care about</h3><ul class="recommendation-feed products-grid products-grid--max-4-col">';
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    $category = $recommedation_value['category'];
		    $price = $recommedation_value['price'];
		    $keyword = $recommedation_value['keywords'];
		    $image_url = $recommedation_value['image_url'];
		    $name = $recommedation_value['name'];
		    $discounted_price = $recommedation_value['discounted_price'];
		    $gender = $recommedation_value['gender'];
		    $brand = $recommedation_value['brand'];
                    $subbrand = $recommedation_value['subbrand'];      
                    $site_product_id   = $recommedation_value['site_product_id']; 
                    $sku =   $recommedation_value['sku'];
		    
		    //$url = $recommedation_value['url'];
		    
		    $product_array = array();
		    $product_array = Mage::getModel("catalog/product")->loadByAttribute('sku',$site_product_id);
		    
		    $url = 'http://dothejob.in/infiniteanalytics/'.$product_array->getUrlPath();
		    
		    $producthtml = '';
		    $producthtml  = Mage::getStoreConfig('infiniteanalytics_homepagesettings/productsyoucareabout/productsyoucareabout_html');
		    $producthtml  = str_replace('{{image}}',$image_url,$producthtml);
		    $producthtml  = str_replace('{{name}}',$name,$producthtml);
		    $producthtml  = str_replace('{{price}}',$price,$producthtml);
		    $producthtml  = str_replace('{{discountedprice}}',$discounted_price,$producthtml);
		    $producthtml  = str_replace('{{category}}',$category,$producthtml);
		    $producthtml  = str_replace('{{keyword}}',$keyword,$producthtml);
		    $producthtml  = str_replace('{{gender}}',$gender,$producthtml);
		    $producthtml  = str_replace('{{brand}}',$brand,$producthtml);
		    $producthtml  = str_replace('{{subbrand}}',$subbrand,$producthtml);
		    $producthtml  = str_replace('{{siteproductid}}',$site_product_id,$producthtml);
		    $producthtml  = str_replace('{{sku}}',$sku,$producthtml);
		    $producthtml  = str_replace('{{url}}',$url,$producthtml);
		    
		    $result_html .= $producthtml;
		    
		}
		$result_html .='</ul>';
		$result_html .= Mage::getStoreConfig('infiniteanalytics_homepagesettings/productsyoucareabout/productsyoucareabout_css');;
		return $result_html;
	    }
	
	
	    }
	}
    }
    
    public function GetFrequentlysearcheddepartmentsfeed($string)
    {
	
	$check_main_page_recommendation_enable = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/general/enabled');
	$check_sub_recommendation_enable =  Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearcheddepartments/frequentlysearcheddepartments_enabled');
	if($check_main_page_recommendation_enable == '1' && $check_sub_recommendation_enable == '1')
	{
	    $custom_service_url_enable = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearcheddepartments/frequentlysearcheddepartments_serviceurl_yesno');
	    if($custom_service_url_enable == 1)
	    {
	     $service_url = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearcheddepartments/frequentlysearcheddepartments_serviceurl');
	    }
	    else
	    {
	    $service_url = $this->service_url;
	    }
	    
	    if(trim($service_url) != '' )
	    {
		 $ecompany_name = $this->ecompany_name;
		 $client_ip = $this->client_ip;
	         $count = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearcheddepartments/frequentlysearcheddepartments_count');
		 $count = ($count != '')?$count:4; 
		 $mode =  Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearcheddepartments/frequentlysearcheddepartments_mode');
		 $custom_html = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearcheddepartments/frequentlysearcheddepartments_html');
		 $custom_css = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearcheddepartments/frequentlysearcheddepartments_css');
		 
	    $url_encodeed_string = urlencode($search_string);
	    $curl_post_data = array(
		    'ecompany' => $ecompany_name,
		    'user_type' => $this->rest_api_user_type,
		    'user_id'  => $this->rest_api_user_value,
		    'client_ip' => $client_ip,
		    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'count' => $count,
		    'return_type'=>'product_category'
	    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		//die();
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">Frequently searched departments</h3><ul class="recommendation-feed products-grid products-grid--max-3-col">';
		$increment = 0;
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    if($increment < $count)
		    {
		    $category = $recommedation_value['category'];
		    $producthtml = '';
		    $producthtml  = $custom_html;
		    $producthtml  = str_replace('{{category}}',$category,$producthtml);
		    $result_html .= $producthtml;
		    }
		 $increment++;   
		}
		$result_html .='</ul>';
		 $result_html .= $custom_css;
		return $result_html;
	    }  
	
	
	    }
	}
	
    }
    
    
    public function GetFrequentlysearchedbrandsfeed($string)
    {
	
	
	
	$check_main_page_recommendation_enable = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/general/enabled');
	$check_sub_recommendation_enable =  Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearchedbrands/frequentlysearchedbrands_enabled');
	if($check_main_page_recommendation_enable == '1' && $check_sub_recommendation_enable == '1')
	{
	    $custom_service_url_enable = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearchedbrands/frequentlysearchedbrands_serviceurl_yesno');
	    if($custom_service_url_enable == 1)
	    {
	     $service_url = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearchedbrands/frequentlysearchedbrands_serviceurl');
	    }
	    else
	    {
	    $service_url = $this->service_url;
	    }
	    
	    if(trim($service_url) != '' )
	    {
		 $ecompany_name = $this->ecompany_name;
		 $client_ip = $this->client_ip;
	         $count = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearchedbrands/frequentlysearchedbrands_count');
		 $count = ($count != '')?$count:4; 
		 $mode =  Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearchedbrands/frequentlysearchedbrands_mode');
		 $custom_html = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearchedbrands/frequentlysearchedbrands_html');
		 $custom_css = Mage::getStoreConfig('infiniteanalytics_searchpagesettings/frequentlysearchedbrands/frequentlysearchedbrands_css');
		 
	    $url_encodeed_string = urlencode($search_string);
	     $curl_post_data = array(
		    'ecompany' => $ecompany_name,
		    'user_type' => $this->rest_api_user_type,
		    'user_id'  => $this->rest_api_user_value,
		    'client_ip' => $client_ip,
		    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'count' => $count,
		    'return_type'=>'brand'
	    );
	    
	    $service_url .= '?' . http_build_query($curl_post_data);
	    $curl = curl_init($service_url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    $curl_response = curl_exec($curl);
	    curl_close($curl);
	    
	   $result_data = json_decode($curl_response, true);
	    if(!empty($result_data))
	    {
		//echo '<pre>';
		//print_r($result_data);
		//die();
		$result_html = '<h3 style="border-bottom: 1px solid #ccc;">Frequently searched brands</h3><ul class="recommendation-feed products-grid products-grid--max-3-col">';
		$increment = 0;
		foreach($result_data['data']['recommendations'] as $recommedation_key=>$recommedation_value)
		{
		    if($increment < $count)
		    {
		    $brand = $recommedation_value['brand'];
		    $producthtml = '';
		    $producthtml  = $custom_html;
		    $producthtml  = str_replace('{{brand}}',$brand,$producthtml);
		    $result_html .= $producthtml;
		    }
		 $increment++;   
		}
		$result_html .='</ul>';
		 $result_html .= $custom_css;
		return $result_html;
	    }  
	
	
	    }
	}
    }


}
