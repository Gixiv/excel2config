<?php
require_once dirname(__FILE__) . '/libs/PHPExcel/Classes_/PHPExcel.php';

//$filename = "./jsonfile/2016-08-17.json";
//$json_string = file_get_contents($filename);



$filename = $_POST['filename'];
$json_string = $_POST['json_string'];






//echo print_r($json_string,true);            //打印文件的内容
//echo "<br>";

$array = json_decode($json_string,true);
if (!is_array($array)){
    var_dump($json_string);
    die('no successful');
}







// echo "<pre>";
// print_r($array);
// echo "</pre>";


$keys = array_keys($array[0]);



for($i=0;$i<count($array);$i++){
    for($ii=0;$ii<count($keys);$ii++){
        if(is_array($array[$i][$keys[$ii]])){
            $array[$i][$keys[$ii]] = "!array!";
        }
    }
}
















$sortFlightsArray = array();
$sortFlightsArray[] = $keys;
for ($i=0; $i < count($array); $i++) {
    # code...
    $tempArray = array();
    for ($ii=0; $ii < count($keys); $ii++) {
        $tempArray[] = $array[$i][$keys[$ii]];
    }
    $sortFlightsArray[] = $tempArray;
}





// echo "<pre>";
// print_r($sortFlightsArray);
// echo "</pre>";

//********************************************************************************

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Fill worksheet from values in array
$objPHPExcel->getActiveSheet()->fromArray($sortFlightsArray, null, 'A1',true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('sheet1');

// Set AutoSize for name and email fields
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);





//var_dump($sortFlightsArray);exit;




// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
//$filename = date("YmdHis",time());
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0






// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save("./2016-08-17.xlsx");
$objWriter->save('php://output');
