<?php


include_once (__DIR__ . '/loadExcelConfigData.php');

class ConfigData{
    public static $instance;
    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }



    public function __construct() {

    }


    public function getDataArr($filename,$sheetName){
        $type = loadConfig($filename,$sheetName,1,2,[]);
        $data = loadConfig($filename,$sheetName,2,3,[]);
        $index_name_arr = $data[0];//字段名字
        $Arr = loadConfig($filename,$sheetName,3,null,$index_name_arr);
        //$Map = $this->getArrIndexIsId($Arr);
        return ["type"=>$type[0],"data"=>$Arr];
    }



    private function getArrIndexIsId($arr){
        $newArr = [];
        for($i=0;$i<count($arr);$i++){
            $newArr[$arr[$i]['id']] = $arr[$i];
        }
        return $newArr;
    }
}