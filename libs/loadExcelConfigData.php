<?php

include_once __DIR__ . '/PHPExcel/Classes_/PHPExcel/IOFactory.php';


function loadConfig($filePath,$sheetName,$startRowIndex,$endRowIndex,$needIndexNameArr){

    //加载excel文件
    //$filename = dirname(__FILE__).'/config_excel/excel/equip.xls';
    //$filename = __DIR__.'/files/'.$filePath;
    $filename = $filePath;
    $objPHPExcelReader = PHPExcel_IOFactory::load($filename);

    $sheet = $objPHPExcelReader->getSheetByName($sheetName);
    if(!$sheet){
        exit($sheetName.'not exist!');
    }
    //读取表内容
    $content = $sheet->getRowIterator();
    //逐行处理
    $res_arr = array();
    foreach($content as $key => $items) {
        $rows = $items->getRowIndex();              //行
        $columns = $items->getCellIterator();       //列


        $row_arr = array();
        //确定从哪一行开始读取
        if($rows < $startRowIndex){
            continue;
        }


        if($endRowIndex&&$rows >= $endRowIndex){
            break;
        }




        //逐列读取
        $index = 0;
        foreach($columns as $head => $cell) {
            if(!empty($needIndexNameArr)&&isset($needIndexNameArr[$index])){
                //获取cell中数据
                $data = $cell->getValue();

                $row_arr[$needIndexNameArr[$index]] = $data===null?"":$data;




//                if(is_object($data)){
//                    var_dump($data);
//                    echo $data;
//                }



//                if($data !== ''){
//                    $row_arr[$needIndexNameArr[$index]] = $data;
//                }else{
//                    break;//遇到空数据即为结束了
//                }
                //$row_arr[$needIndexNameArr[$index]] = mb_convert_encoding($data,'UTF-8','auto');
            }else{
                //获取cell中数据
                $data = $cell->getValue();

                $row_arr[] = $data===null?"":$data;




//                if($data !== ''){
//                    $row_arr[] = $data;
//                }else{
//                    break;//遇到空数据即为结束了
//                }

                //$row_arr[] = mb_convert_encoding($data,'UTF-8','auto');
            }
            $index++;

        }
        if(!empty($row_arr)){
            $res_arr[] = $row_arr;
        }
    }
    return $res_arr;
}





