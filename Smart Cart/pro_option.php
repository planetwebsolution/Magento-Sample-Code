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
    $_product = $obj->load($pro_id); ?>
   
    


<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body clearfix">
      
      <div role="tabpanel">

  <!--- For product option start--->
  <h4 class="modal-title_my">Product Options</h4>
            <div class="option-list">
            <?php
            $attVal = $_product->getOptions();
            $option_contstant =1;
 
            $optStr = "";
             
            // loop through the options
            foreach($attVal as $optionKey => $optionVal) {
             
            //$optStr .= "<br/>";
            $option_contstant_id = 'opid-'.$option_contstant.'-'.$pro_id;
            $optStr .= "<span class='option-title'><span>".$optionVal->getTitle()."</span></span>";
             
            $optStr .= "<select id='$option_contstant_id' style='display:block; clear:both;width: 100%' name='".$optionVal->getId()."'>";
             
            foreach($optionVal->getValues() as $valuesKey => $valuesVal) {
            $optStr .= "<option value='".$valuesVal->getId()."'>".$valuesVal->getTitle()."</option>";
            }
             
            $optStr .= "</select>";
            
            $option_contstant++;
            }
             
            echo($optStr ); 
            
            ?>
      
            <button class="option_pop_button" type="submit" data-dismiss="modal" onclick="addcartoptionFunction(<?php echo $pro_id; ?>,<?php echo $option_contstant-1; ?>)"><span>Submit Option</span>
            </div>   
            
            <!-- For product option end--> 


 </div>
 </div>
  </div>
    </div>