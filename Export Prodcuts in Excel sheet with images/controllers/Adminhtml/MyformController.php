<?php

class Mage_Sintax_Adminhtml_MyformController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }
    
    public function postAction()
    {
      $post = $this->getRequest()->getPost();
		if($post['file_type']=='csv') {
			$dir = $post['filetype'].'_'.date('Y-m-d');
			mkdir('image/'.$dir, 0777);
			$name = $dir.'.csv';
			header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename=csv/'.$name);
            header('Pragma: no-cache');
            header("Expires: 0");
			touch('/csv');
            chmod('/csv', 0777);
			
			define('SAVE_FEED_LOCATION','csv/'.$name);
			
			set_time_limit(1800);
		try{
			$handle = fopen(SAVE_FEED_LOCATION, 'w');
		
			$heading = array('STYLE NUMBER','STYLE NAME','LONG DESCRIPTION','GENDER','IMAGES PROVIDED','IMAGE FILENAME','COMPOSITION: STONES','COMPOSITION: SETTING','COMPOSITION: OTHER','SECONDARY COLOR','STONE CUT','CLARITY','COLOUR','SETTING TYPE','RING SIZE 6','RING SIZE 7','RING SIZE 7.5','RING SIZE 8','RING SIZE 8.5','RING SIZE 9','RING SIZE 9.5','RING SIZE 10','RING SIZE 10.5','RING SIZE 11','RING SIZE 11.5','RING SIZE 12','RING SIZE 12.5','RING SIZE 13','LENGTH','HEIGHT','WIDTH','SPECIAL CARE','MADE IN "COUNTRY"','WHOLESALE','RETAIL','SPECIAL PRICE','INVENTORY');
			$feed_line=implode(",", $heading)."\r\n";
			fwrite($handle, $feed_line);
		
			$products = Mage::getModel('catalog/product')->getCollection();
			$products->addAttributeToSelect('*');
			$prodIds=$products->getAllIds();
		
			$product = Mage::getModel('catalog/product');
		
			$counter_test = 0;
		
			foreach($post['id'] as $productId) {
		
				if (++$counter_test < 30000){
		
					$product->load($productId);
		
					$product_data = array();
					$product_data['style_number'] = str_replace('"','""',$product->getSku());
					$product_data['style_name'] = $product->getName();		
					$product_data['description'] = htmlspecialchars(iconv("UTF-8","UTF-8//IGNORE",$product->getDescription()));
					$product_data['gender'] = $product->getResource()->getAttribute('filter_for')->getFrontend()->getValue($product);
					if($product->getImage()){
					if($product->getImage()=='no_selection'){
					$product_data['image_provided'] = 'No';
					}
					else
					{
					$product_data['image_provided'] = 'Yes';
					}
					} else {
					$product_data['image_provided'] = 'No';	
					}
					if($product->getImage()=='no_selection'){
					$product_data['image_link']='';
					}
					else
					{
					$product_data['image_link'] = $product->getImage();
					}
					$image_break = explode("/",$product->getImage());
					$imagename = end($image_break);
					$file = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'catalog/product'.$product->getImage();
					$newfile = 'image/'.$dir.'/'.$imagename;
					if (!copy($file, $newfile)) {
    					echo "failed to copy $file...\n";
						
					}
					$product_data['stone'] = $product->getAttributeText('product_stones');
					$product_data['setting'] = '';
					$product_data['other'] = '';
					$product_data['s_color'] = '';
					$product_data['stone_cut'] = '';
					$product_data['clarity'] = '';
					$product_data['color'] = $product->getAttributeText('product_color');
					$product_data['setting_type'] = '';
					$product_data['ring_size6'] = '';
					$product_data['ring_size7'] = '';
					$product_data['ring_size75'] = '';
					$product_data['ring_size8'] = '';
					$product_data['ring_size85'] = '';
					$product_data['ring_size9'] = '';
					$product_data['ring_size95'] = '';
					$product_data['ring_size10'] = '';
					$product_data['ring_size105'] = '';
					$product_data['ring_size11'] = '';
					$product_data['ring_size115'] = '';
					$product_data['ring_size12'] = '';
					$product_data['ring_size125'] = '';
					$product_data['ring_size13'] = '';
					$product_data['length'] = str_replace('"','""',$product->getLengthDimensions());
					$product_data['height'] = str_replace('"','""',$product->getHeightDimensions());
					$product_data['width'] = str_replace('"','""',$product->getWidthDimensions());
					
					$product_data['special_care'] = '';
					$product_data['made_in'] = '';
					$product->setCustomerGroupId(2);
					if(number_format($product->getPriceModel()->getFinalPrice(1, $product),2)==number_format($product->getPrice(),2)){
					$product_data['wholesale'] = '';
					} else {
						$product_data['wholesale'] = number_format($product->getPriceModel()->getFinalPrice(1, $product),2);
					}
					
		
					$price_temp = round($product->getPrice(),2);
					$product_data['price'] = round($product->getPrice(),2);
					if($product->getSpecialPrice()==''){
					$product_data['special_price'] = '';
					} else { 
					$product_data['special_price'] = number_format($product->getSpecialPrice(),2);
					}
					$product_data['qty'] = $product->getStockItem()->getQty();
					
		
					foreach($product_data as $k=>$val){
						
						$product_data[$k] = '"'.$val.'"';
					}		
				   	
					$feed_line = implode(",", $product_data)."\r\n";
					fwrite($handle, $feed_line);
					fflush($handle);
		
				}
		
			}
		
			fclose($handle);
			
			$dir12 = 'image/'.$dir;
			
			$archive = 'csv/'.$dir.'.zip';
			
			$zip = new ZipArchive;
			$zip->open($archive, ZipArchive::CREATE);
			
			$files = scandir($dir12);
			unset($files[0], $files[1]);
			foreach ($files as $file) {
			$zip->addFile($dir12.'/'.$file);
			}
			$zip->close();
			
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$archive);
			header('Content-Length: '.filesize($archive));
		
			$dirPath = 'image/'.$dir;
		if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
			}
			if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
				$dirPath .= '/';
			}
			$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					self::deleteDir($file);
				} else {
					unlink($file);
				}
			}
			rmdir($dirPath);
		}
		catch(Exception $e){
			die($e->getMessage());
		}
		}
		
		if($post['file_type']=='xls') {
		
		
		error_reporting(E_ALL);

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';


// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** Include PHPExcel_IOFactory */
require_once 'Classes/PHPExcel/IOFactory.php';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//********* CUSTOM CODE ****************************

// Create a first sheet, representing sales data
//echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("500 Sauve West\nMontreal, Quebec\nCanada\nH3L 1Z8");
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("info@italgemjewellers.com\nTel   (514) 388-5777\nFax  (514) 384-5777");
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);

// Merge cells
//echo date('H:i:s') , " Merge cells" , EOL;
$objPHPExcel->getActiveSheet()->mergeCells('F1:G1');
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("Quotation preparred for \nClientABCD");
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->setCellValue('A3', 'STYLE CODE #');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'PICTURE');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'DESCRIPTION');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'RETAIL');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'WHOLE SALE PRICE');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'YOUR PRICE');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Quanity ');


// Set column widths
//echo date('H:i:s') , " Set column widths" , EOL;
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(98);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

// Set fonts
//echo date('H:i:s') , " Set fonts" , EOL;
$objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setName('Times New Roman')->setSize(15)->getColor()->setRGB('000000');
$objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setName('Times New Roman')->setSize(15)->getColor()->setRGB('000000');
$objPHPExcel->getActiveSheet()->getStyle("F1")->getFont()->setBold(true)->setName('Times New Roman')->setSize(18)->getColor()->setRGB('000000');

$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Set thin black border outline around column
//echo date('H:i:s') , " Set thin black border outline around column" , EOL;
$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($styleThinBlackBorderOutline);

$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleThinBlackBorderOutline);


// Set fills
//echo date('H:i:s') , " Set fills" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('FFFFFF');
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFill()->getStartColor()->setARGB('FFFFFF');

// Set style for header row using alternative method
//echo date('H:i:s') , " Set style for header row using alternative method" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true
			),			
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),			
		)
);


// Add a drawing to the worksheet
//echo date('H:i:s') , " Add a drawing to the worksheet" , EOL;
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('./images/logo.png');
$objDrawing->setHeight(133);
$objDrawing->setWidth(281);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//$post['id'] = array("1","2","3","4","5");
$products = Mage::getModel('catalog/product')->getCollection();
			$products->addAttributeToSelect('*');
			$prodIds=$products->getAllIds();
		
			$product = Mage::getModel('catalog/product');
		
			$counter_test = 0;
		    $i = 4;
			foreach($post['id'] as $productId) {
		
				if (++$counter_test < 30000){
		
					$product->load($productId);
					$style_number = str_replace('"','',$product->getSku());
					$image_link = $product->getImage();
					$description = htmlspecialchars(iconv("UTF-8","UTF-8//IGNORE",$product->getDescription()));					
					$product->setCustomerGroupId(2);
					$wholesale = number_format($product->getPriceModel()->getFinalPrice(1, $product),2);		
					$price_temp = round($product->getPrice(),2);
					$price = round($product->getPrice(),2);					
					$special_price = number_format($product->getSpecialPrice(),2);					
					$qty = $product->getStockItem()->getQty();
					
					$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(190);			
					//Infromation 1
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $style_number);	
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setIndent(9);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('Arial')->setSize(10)->getColor()->setRGB('000000');
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->getStartColor()->setARGB('FFFFFF');
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($styleThinBlackBorderOutline);
					
					//Extra Block
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($styleThinBlackBorderOutline);
					
					//2
					$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleThinBlackBorderOutline);	
								
					$objDrawing = new PHPExcel_Worksheet_Drawing();
					if (file_exists('./media/catalog/product'.$image_link)) {
					if($product->getImage()=='no_selection'){
					$objDrawing->setPath('./images/logo.png');
					$objDrawing->setOffsetX(5);
     				$objDrawing->setOffsetY(50);
					} else {
					$objDrawing->setPath('./media/catalog/product'.$image_link);
					$objDrawing->setOffsetX(5);
     				$objDrawing->setOffsetY(5);
					}
					} else {
					$objDrawing->setPath('./images/logo.png');
					$objDrawing->setOffsetX(5);
     				$objDrawing->setOffsetY(50);
					}
					$objDrawing->setCoordinates('B'.$i);
					//$objDrawing->setHeight(190);
     				//$objDrawing->setWidth(340);
					$objDrawing->setResizeProportional(true);
					$objDrawing->setWidthAndHeight(340,210);
    				
					$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
					
					
					
					//3 Cell
					$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $description);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
					$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('Arial')->setSize(10)->getColor()->setRGB('000000');
					$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
					
					//4 Cell
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($styleThinBlackBorderOutline);
					if($price_temp == '0'){
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, '');
					} else {
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->applyFromArray(
	 				array(
	 				'code' => PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
	 				));
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $price_temp);
					}
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setIndent(9);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setName('Arial')->setSize(10)->getColor()->setRGB('000000');
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(true);
					
					//5 Cell
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleThinBlackBorderOutline);
					if($wholesale == $price_temp){
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, '');
					} else {
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->applyFromArray(
	 				array(
	 				'code' => PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
	 				));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $wholesale);
					}
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setIndent(9);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getFont()->setName('Arial')->setSize(10)->getColor()->setRGB('000000');
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getFont()->setBold(true);
					
					//6 Cell
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($styleThinBlackBorderOutline);
					if($special_price=='0'){
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '');
					} else {
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->applyFromArray(
	 				array(
	 				'code' => PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
	 				));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $special_price);
					}
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setIndent(9);	
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getFont()->setName('Arial')->setSize(10)->getColor()->setRGB('000000');
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getFont()->setBold(true);
					
					//7 Cell
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($styleThinBlackBorderOutline);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $qty);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);	
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setIndent(9);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('Arial')->setSize(10)->getColor()->setRGB('FF0000');
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);
				            }
		
			$i++;}
			//echo "come";
		//die();
$name = $post['filetype'].'_'.date('Y-m-d').'.xlsx';			
$changeFilename=$name;
$allvalues_array = explode('/',$changeFilename);

$lastvalues = count($allvalues_array)-1;
$finalname_array = array();
$finalname = '';
for($pl=0;$pl<count($allvalues_array);$pl++)
{
	if($pl == $lastvalues)
	{
	$finalname_array[] = 'xls';
	$finalname_array[] = $allvalues_array[$pl];

	}
	else
	{
	$finalname_array[] = $allvalues_array[$pl];
	}
}
$finalname =implode('/',$finalname_array);
//********* CUSTOM CODE ****************************
$objWriter->save($finalname);
		
		
		
		
		
		}
		
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            
            /* here's your form processing */
			if($post['file_type']=='csv') {
            $message = $this->__('Your CSV successfully exported.');
			}
            if($post['file_type']=='xls') {
            $message = $this->__('Your XLSX successfully exported.');
			}
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
    }
public function downloadcsvAction() {
		$post = $this->getRequest()->getPost();
		//echo "<pre>";
		//print_r($post);
		//die();
		
		$url = str_replace("index.php/","",Mage::getUrl());
		echo $filepath = $url.'csv/'.$post['filetype_csv'];
		
		header("location:".$filepath);
		die();
		
    
        $this->_redirect('*/*');
}
public function downloadxlsAction() {
		$post = $this->getRequest()->getPost();
		//echo "<pre>";
		//print_r($post);
		//die();
		
		$url = str_replace("index.php/","",Mage::getUrl());
		echo $filepath = $url.'xls/'.$post['filetype_xls'];
		
		header("location:".$filepath);
		die();
		
    
        $this->_redirect('*/*');
}
public function downloadimageAction() {
		$post = $this->getRequest()->getPost();
		//echo "<pre>";
		//print_r($post);
		//die();
		$url = str_replace("index.php/","",Mage::getUrl());
		echo $filepath = $url.'csv/'.$post['filetype_image'];
		
		header("location:".$filepath);
		die();
		
    
        $this->_redirect('*/*');
}
}