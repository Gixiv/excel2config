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

    /**
     * excel表第一行（类型）不需要时可以随意填写
     * excel表第二行（数据的字段索引）必须填写，且不要重，否者数据会覆盖。
     * excel表第三行及以下都是正常的数据
     */
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