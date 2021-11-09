<?php

include_once (__DIR__ . '/libs/ConfigData.php');

//header( "Content-Type: application/octet-stream" );



//read upload file
if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else
{
    $fileName = $_FILES["file"]["name"];
    $type = $_FILES["file"]["type"];
    $size = ($_FILES["file"]["size"] / 1024)." kb" ;
    $tmp_name =  $_FILES["file"]["tmp_name"] ;
//    echo "Upload: " .$fileName . "<br />";
//    echo "Type: " . $tyep . "<br />";
//    echo "Size: " . $size. " Kb<br />";
//    echo "Stored in: " . $tmp_name."<br />";
//    move_uploaded_file($tmp_name,"upload/" .$fileName);
//    echo "success";


    $file_path = $tmp_name;
//    if(file_exists($file_path)){
//        $str = file_get_contents($file_path);//将整个文件内容读入到一个字符串中
//        $str = str_replace("\r\n","<br />",$str);
//        echo $str;
//    }else{
//        echo  'file not exist!';
//    }



    $map = (ConfigData::getInstance())->getDataArr($file_path,'sheet1');

    $typeArr = $map['type'];
    $arrMap = $map['data'];




    $keys = array_keys($arrMap[0]);

    for($i=0;$i<count($arrMap);$i++){
        for($ii=0;$ii<count($keys);$ii++){
            //一维数组
            if($typeArr[$ii] == 1){
                if($arrMap[$i][$keys[$ii]]!==""&&$arrMap[$i][$keys[$ii]]!==null){
                    $arrMap[$i][$keys[$ii]] = explode("#",$arrMap[$i][$keys[$ii]]);
                }
            //二维数组,第一位做字段索引
            }else if($typeArr[$ii] == 201){
                if($arrMap[$i][$keys[$ii]]!==""&&$arrMap[$i][$keys[$ii]]!==null){
                    $data = [];
                    $temp = explode("|",$arrMap[$i][$keys[$ii]]);
                    for($iii=0;$iii<count($temp);$iii++){
                        $temp2 = explode("#",$temp[$iii]);
                        $temp2_key_value = [];
                        for($i4=0;$i4<count($temp2);$i4=$i4+2){
                            $temp2_key_value[$temp2[$i4]] = is_numeric($temp2[$i4+1])?intval($temp2[$i4+1]):$temp2[$i4+1];
                        }
                        $data[$iii] = $temp2_key_value;
                    }
                    $arrMap[$i][$keys[$ii]] = $data;
                }else{
                    $arrMap[$i][$keys[$ii]] = [];
                }
            //二维数组,第一位做为整体索引，第一位做字段索引
            }else if($typeArr[$ii] == 211){
                if($arrMap[$i][$keys[$ii]]!==""&&$arrMap[$i][$keys[$ii]]!==null){
                    $data = [];
                    $temp = explode("|",$arrMap[$i][$keys[$ii]]);
                    for($iii=0;$iii<count($temp);$iii++){
                        $temp2 = explode("#",$temp[$iii]);
                        $temp2_key_value = [];
                        for($i4=0;$i4<count($temp2);$i4=$i4+2){
                            $temp2_key_value[$temp2[$i4]] = is_numeric($temp2[$i4+1])?intval($temp2[$i4+1]):$temp2[$i4+1];
                        }
                        $data[$temp2[1]] = $temp2_key_value;
                    }
                    $arrMap[$i][$keys[$ii]] = $data;
                }else{
                    $arrMap[$i][$keys[$ii]] = [];
                }
            }else if($typeArr[$ii] == 3){
                $arrMap[$i][$keys[$ii]] = $arrMap[$i][$keys[$ii]]===""?false:$arrMap[$i][$keys[$ii]];
            }
        }

    }








    $filename  =  explode(".",$fileName)[0].".ts";
    $encoded_filename  = urlencode( $filename );
    $encoded_filename  =  str_replace ( "+" ,  "%20" ,  $encoded_filename );

    if  (preg_match( "/MSIE/" ,  $_SERVER [ 'HTTP_USER_AGENT' ]) ) {
        header( 'Content-Disposition:  attachment; filename="'  .  $encoded_filename  .  '"' );
    }  elseif  (preg_match( "/Firefox/" ,  $_SERVER [ 'HTTP_USER_AGENT' ])) {
        // header('Content-Disposition: attachment; filename*="utf8' .  $filename . '"');
        header( 'Content-Disposition: attachment; filename*="'  .   $filename  .  '"' );
    }  else  {
        header( 'Content-Disposition: attachment; filename="'  .   $filename  .  '"' );
    }



    //echo   json_encode($arrMap,JSON_UNESCAPED_UNICODE) ;

    //JSON_UNESCAPED_UNICODE 取消unicode编码
    //JSON_UNESCAPED_SLASHES 取消斜杠转义

    echo   'let data = '.json_encode($arrMap,JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES)."\r\n".'export default data' ;
    //echo   'export default'.json_encode($arrMap,JSON_FORCE_OBJECT+JSON_UNESCAPED_UNICODE);


}















