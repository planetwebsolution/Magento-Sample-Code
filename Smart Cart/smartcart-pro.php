<?php
require_once('app/Mage.php');

umask (0);
Mage::app('default');
Mage::getSingleton('core/session', array('name' => 'frontend'));

    $pro_id = '';
    
    if(isset($_REQUEST['pro_id'])){
    $pro_id = $_REQUEST['pro_id'];
    }
    $obj = Mage::getModel('catalog/product');
    $_product = $obj->load($pro_id);
    

?>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body clearfix">
      
      <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#Description" aria-controls="Description" role="tab" data-toggle="tab">Description</a></li>
    <li role="presentation"><a href="#Related" aria-controls="Related" role="tab" data-toggle="tab">Related Products</a></li>
    <li role="presentation"><a href="#Videos" aria-controls="Videos" role="tab" data-toggle="tab">Product Videos</a></li>
    <li role="presentation"><a href="#Warranty" aria-controls="Warranty" role="tab" data-toggle="tab">Warranty</a></li>
    <li role="presentation"><a href="#Viewed" aria-controls="Viewed" role="tab" data-toggle="tab">Also Viewed</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Description">
    <div class="product_headding_text"><?php echo $_product->getName();
    //echo $pro_id; ?></div>
    <div class="row" style="margin-left: 0px;">
    <?php //echo $_product->getDescription();
    //echo $_product['description'];
    //echo Mage::getModel('catalog/product')->$_product->getDescription();
     
      ?>
      <?php echo Mage::helper('catalog/output')->productAttribute($_product, nl2br($_product->getDescription()), 'description') ?>
    </div>
    
    </div>
    <div role="tabpanel" class="tab-pane" id="Related">
    <ul>
    <?php
   //echo $_product->getId();
    $relatedProductsId=$_product->getRelatedProductIds();
    $relatedProducts=array();
     $j=1;      
    foreach($relatedProductsId as $relatedProductId)
    {
        echo '<li class="col-md-3">';
        
	$relatedProducts_condition = 'Yes';

        $relatedProducts =  Mage::getModel('catalog/product')->load($relatedProductId);
	?>
        <div class="product_section">
        <div class="product_view"><img src="<?php echo Mage::helper('catalog/image')->init($relatedProducts, 'image')->resize(135); ?>" width="135" height="135" alt="" /></div>
        <h2 class="heightclass"><a href="<?php echo $relatedProducts->getProductUrl(); ?>"><?php echo $relatedProducts->getName(); ?></a></h2>
        <h2><?php echo Mage::helper('core')->currency($relatedProducts->getPrice(),true,false); ?></h2>
        
        <?php
		

    echo '</li>';
    $j++;
    }
    if($j<2){
        echo 'No related Item find...';
    }
    ?>
    </ul>
    </div>
    
    
    <div role="tabpanel" class="tab-pane" id="Videos"> <?php echo $_product->getProductVideos(); ?></div>
    <div role="tabpanel" class="tab-pane" id="Warranty"><?php echo $_product->getWarranty (); ?></div>
    <div role="tabpanel" class="tab-pane" id="Viewed">No Viewed product found..<?php //$this->helper('yotpo')->showBottomline($this, $_product); ?></div>
  </div>

</div>
 </div>
 </div>
  </div>