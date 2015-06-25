<?php
class Pws_Managebrands_Block_Adminhtml_Managebrands_Renderer_Viewimage extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$value =  $row->getData($this->getColumn()->getIndex());
		$path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). 'star.png';
		$value_count = 0;
		$Comment = '';
		if($value == 'poor')
		{
			$value_count = 1;
			$Comment = '<span style="font-size:10px;">( Poor )</span>';
		}
		elseif($value == 'average')
		{
			$value_count = 2;
			$Comment = '<span style="font-size:10px;">( Average )</span>';
		}
		elseif($value == 'good')
		{
			$value_count = 3;
			$Comment = '<span style="font-size:10px;">( Good )</span>';
		}
		elseif($value == 'verygood')
		{
			$value_count = 4;
			$Comment = '<span style="font-size:10px;">( Very Good )</span>';
		}
		elseif($value == 'Exs')
		{
			$value_count = 5;
			$Comment = '<span style="font-size:10px;">( Extremely Satisfied )</span>';
		}
		
		$output = '';
		for($counting=0;$counting<$value_count;$counting++)
		{
			$output .= '<img src="'.$path.'"/>';
		}
		$output .= $Comment;
		return $output;
		
	}
}
?>