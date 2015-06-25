<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));

if(isset($_REQUEST['query_text'])){
    $query_text = $_REQUEST['query_text'];
 }

 
 $query = Mage::helper('catalogSearch')->getQuery();
 $query->setStoreId(Mage::app()->getStore()->getId());
 //$query->setQueryText(Mage::helper('catalogsearch')->getQuery()->getQueryText());
$query->setQueryText($query_text);
 $collection = $query->getSearchCollection();
 $collection->addSearchFilter($query_text);
 $collection->addAttributeToSelect('*');
 $collection->addAttributeToFilter('smart_cart_visible', 4);
 $collection->addAttributeToFilter('status', 1);
 $cat_id = 9999;
 
 ?>
 
 <?php
    if($cat_id != ''):
    $myrowcount = 0;
    $total_product = count($collection);
    $total_page2 = $total_product/12;
    $total_page =  ceil($total_page2);
    $page_id = 1;
    $pagination_counter = 0;
    $pagination_id = 1;
        
    $cat_id_id = str_pad( "$cat_id", 4, "0", STR_PAD_RIGHT );
    ?>
    
    
    <div class="main-search">
    
     <span class="noofpro">
    <?php echo 'Search Result for <b>'.$query_text.'</b>- '.count($collection).' Product found'; ?>
    <br>Click <b><a href="javascript:void(0)" onclick="searchTextback()">here</a></b> for show all products by category</span>
    <div class="meneame" id="pagi_number"> 
    <?php if($total_page>1){ ?>
    
   
    <?php for($i=1;$i<=$total_page;$i++){ ?>
    <?php if($total_page>3 && $i == 1){ ?>
    <a onclick="paginationDec(<?php echo $pagination_id; ?>)" class="meneame_previous"> &lt; </a>
    <?php } ?>
    
    <?php if($pagination_counter%3==0){ ?>
    <span <?php if($pagination_id!=1){ ?>style="display: none" <?php } ?>  class="<?php echo $pagination_id; ?>" id="pagenitaion_<?php echo $cat_id_id.$pagination_id; ?>">
    <?php } ?>
    
    <a class="<?php if($i==1){echo 'activea';} ?> op-active" onclick="clickFunction(<?php echo $i; ?>,<?php echo $cat_id_id; ?><?php echo $i; ?>)" id="<?php echo $cat_id_id; ?><?php echo $i; ?>"><?php echo $i; ?></a>
    
    <?php $pagination_counter++;
    if($pagination_counter%3==0 || $total_page==$i){
    $pagination_id++; ?>
    </span>
    <?php } ?>
    <?php if($total_page>3 && $i == $total_page){ ?>
    <a onclick="paginationInc(<?php echo $page_id; ?>)" class="meneame_next"> &gt; </a>
     <?php } ?>
    <?php  } ?>
    
    
    <?php } ?>
    </div>
    <?php 
    echo '<div id="pagination" class="row">';
    foreach ($collection as $product) {
        $product = Mage::getModel('catalog/product')->load($product->getId());
        $product_id = $product->getId();
        $attVal = $product->getOptions();
        
        //cart fatch start
        $cart_qty = 0;
        $cartitems = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
        foreach($cartitems as $cartitem) {
            $cart_product_id = $cartitem->getProductId();
            if($product_id == $cart_product_id){
            $cart_qty = $cartitem->getQty();
            }else{
               // $cart_qty = 0;
            }
        }
        //cart fatch end
        
        if($myrowcount%12 == 0){ ?>
        <ul  id="page-<?php echo $page_id; ?>" page="<?php echo $page_id; ?>"  class="for-all-row" style="list-style:none;<?php if($page_id != 1){echo 'display:none';}; ?>">
        
        <?php }  ?>
        
        
        <li class="col-md-3">       
        
        <div class="hover panel">
        <div class="front">
            <div class="pad">
                <div class="product_section">
        <div data-toggle="modal" data-target="#myModal" ><a onclick="proFunction(<?php echo $product_id; ?>)" href="javascript:void(0)"><div class="product_view"><img src="<?php echo Mage::helper('catalog/image')->init($product, 'small_image')->resize(135); ?>" width="135" height="135" alt="" /></div>
        <h2><?php echo $product->getName(); ?></h2></a></div>
        <span class="smart_price"><?php
        $finalPrice = number_format($product->getFinalPrice(),2);
        echo '$'.$finalPrice; ?></span>
        
        <?php //Mage::app()->getLayout()->createBlock('yotpo/yotpo')->setTemplate('yotpo/bottomline.phtml')->toHtml();
        ?>
        
        
            <form action="<?php echo Mage::helper('checkout/cart')->getAddUrl($product); ?>" method="post" id="product_addtocart_form_<?php echo $product->getId()?>"<?php if($product->getOptions()): ?> enctype="multipart/form-data"<?php endif; ?>>
            
            <?php if(!$product->isGrouped()): ?>
           <div class="add-to-cart2">
            <div class="quanitybox">         
                       <div class="row no_margin"><div class="col-xs-6 rating_qua">Quantity:</div> <div class="col-xs-6">                       
                       <input readonly type="text" name="qty" id="qty-<?php echo $cat_id_id; ?><?php echo $product_id; ?>" value="<?php echo $cart_qty; ?>" title="<?php echo 'Qty'; ?>" class="input-text qty" />
                       <?php
                        if($attVal){ ?>
                          <div class="up-down">
                            <!--<input type="button" class="quantity_box_button_up" onclick="qtyUp(<?php echo $cat_id_id; ?><?php echo $product_id; ?>),addcartFunction(<?php echo $product_id; ?>,<?php echo $cat_id_id; ?><?php echo $product_id; ?>),topcartcall();" />-->
                            
                            <input data-toggle="modal" data-target="#myModal" type="button" class="quantity_box_button_up" onclick="optionFunction(<?php echo $product_id; ?>)" />
                            <input type="button" onclick="alertoptopnF()" class="quantity_box_button_down" />
                        </div>
                   
                       <?php }else{ ?>
                       
                       
                        <div class="up-down">
                            <input type="button" class="quantity_box_button_up" onclick="qtyUp(<?php echo $cat_id_id; ?><?php echo $product_id; ?>),addcartFunction(<?php echo $product_id; ?>,<?php echo $cat_id_id; ?><?php echo $product_id; ?>),topcartcall();" />
                            <input type="button" class="quantity_box_button_down" onclick="qtyDown(<?php echo $cat_id_id; ?><?php echo $product_id; ?>),topcartcall(),decreasecartFunction(<?php echo $product_id; ?>,<?php echo $cat_id_id; ?><?php echo $product_id; ?>);" /> 
                        </div>
                        
                        
                        <?php } ?>
                        
                        
                        </div></div>
                       <?php endif; ?>
            <input type="hidden" name="product" value="<?php echo $product->getId() ?>" />
            
            </div>
           </div>       
                   
            
           
        </form>
        
        <!--<div class="details_button" data-toggle="modal" data-target="#myModal"><a onclick="proFunction(<?php echo $product_id; ?>)" class="prduct_view" pro_view="<?php echo $product_id; ?>"  href="#">Product Details</a></div>-->
        
                </div>
            </div>
        </div>
        <div class="back">
            <div class="pad">
               <div class="details_button21">
        
        <div class="details_product21" >
            <!---Share button----------------->
            <span class="list-dis">Description</span>
        <div class="social-share">
        <a href="javascript:popWin('https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($product->getProductUrl()); ?>&t=<?php echo urlencode($product->getName()); ?>', 'facebook', 'width=640,height=480,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes');" title="<?php //echo $this->__('Share on Facebook') ?>"><img src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN); ?>/frontend/default/gvp/images/fbshare1.png" alt="facebook" ></a>

<a href="javascript:popWin('http://twitter.com/home/?status=<?php echo urlencode($product->getName() . ' (' . $product->getProductUrl() . ')'); ?>', 'twitter', 'width=640,height=480,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes');" title="<?php //echo $this->__('Tweet') ?>"><img src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN); ?>frontend/default/gvp/images/twshare.png" alt="twitter" ></a>

<a href="javascript:popWin('https://pinterest.com/pin/create/button/?url=<?php echo urlencode($product->getProductUrl()); ?>&media=<?php echo urlencode(Mage::helper('catalog/image')->init($product, 'small_image')); ?>&description=<?php echo urlencode($product->getName()); ?>', 'pinterest', 'width=640,height=480,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes');" title="<?php //echo $this->__('Pin it') ?>"><img src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN); ?>frontend/default/gvp/images/prshare1.png" alt="Pin it" ></a>

<a href="javascript:popWin('<?php echo Mage::helper('catalog/product')->getEmailToFriendUrl($product) ?>', 'google', 'width=640,height=480,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes');" title="<?php echo 'Share on Google Plus'; ?>"><img src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN); ?>frontend/default/gvp/images/eshare1.png" alt="Google" ></a>
  
        
        </div>
        <!---Share button----------------->
          
        
        <div class="details_product_text"><?php echo $product->getSmartCartDescription(); ?></div>
        
        <!-- Add to cart Button---->
        <?php if(!$product->isGrouped()): ?>
        <div class="add-to-cart2">
            <div class="quanitybox">         
                       <div class="row no_margin"><div class="col-xs-6 rating_qua">Quantity:</div> <div class="col-xs-6">                       
                       <input readonly type="text" name="qty" id="qty-second-<?php echo $cat_id_id; ?><?php echo $product_id; ?>" value="<?php echo $cart_qty; ?>" title="<?php echo 'Qty'; ?>" class="input-text qty" />
                       <?php
                        if($attVal){ ?>
                          <div class="up-down">
                            
                            
                            <input data-toggle="modal" data-target="#myModal" type="button" class="quantity_box_button_up" onclick="optionFunction(<?php echo $product_id; ?>)" />
                            <input type="button" onclick="alertoptopnF()" class="quantity_box_button_down" />
                        </div>
                   
                       <?php }else{ ?>
                       
                       
                        <div class="up-down">
                            <input type="button" class="quantity_box_button_up" onclick="qtysecondUp(<?php echo $cat_id_id; ?><?php echo $product_id; ?>),addcartFunction(<?php echo $product_id; ?>,<?php echo $cat_id_id; ?><?php echo $product_id; ?>),topcartcall();" />
                            <input type="button" class="quantity_box_button_down" onclick="qtysecondDown(<?php echo $cat_id_id; ?><?php echo $product_id; ?>),topcartcall(),decreasecartFunction(<?php echo $product_id; ?>,<?php echo $cat_id_id; ?><?php echo $product_id; ?>);" /> 
                        </div>
                        
                        
                        <?php } ?>
                        
                        
                        </div></div>
                       
            <input type="hidden" name="product" value="<?php echo $product->getId() ?>" />
            
            </div>
           </div>
        <?php endif; ?>
        <!-- Add to cart end--->
        
        
        
       <!--<div class="overview_button" data-toggle="modal" data-target="#myModal" ><a onclick="proFunction(<?php echo $product_id; ?>)" href="javascript:void(0)">Product Overview</a></div>-->
        </div>
        
            </div>
        </div>
        </div>
        <div onclick="flipFunction(<?php echo $product_id; ?>)" class=" details_button click flip_<?php echo $product_id; ?>"><a  href="javascript:void(0)">Product Details</a></div>
    </div>

        </li>
        
       
        
<?php
$myrowcount++;





if($myrowcount%12 == 0 && $myrowcount != 0){
    $page_id++;
        echo '</ul>'; 
}
if($total_product == $myrowcount){
        echo '</ul>'; 
}


}

echo '</div>';

endif;
?>
</div>

<style>
.panel,
.details_product,
.product_section{min-height: 337px;}
.click{margin-top: 331px;}
</style> 