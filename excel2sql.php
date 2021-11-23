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



    $map = (ConfigData::getInstance())->getDataArr($file_path,'Sheet1');

    $typeArr = $map['type'];
    $arrMap = $map['data'];





    $filename  =  explode(".",$fileName)[0].".sql";
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





    $table_name = $_POST['table_name'];
    $fieldArr = $_POST['fieldArr'];
    $fieldString = implode(',',$fieldArr);
    $sql = '';
    for($i=0;$i<count($arrMap);$i++){
        $temp = [];
        foreach ($arrMap[$i] as $value ){
            $value =htmlspecialchars($value,ENT_QUOTES);
            $temp[] = "'{$value}'";
        }
        $fieldValueString = implode(',',$temp);
        $sql .=  "INSERT INTO {$table_name} ( {$fieldString} )VALUES({$fieldValueString});";
    }
    echo $sql;
}















