<?php
if(!isset($_FILES["file"])){
?>
<form action="" method="POST" enctype="multipart/form-data">
	<label>选择文件</label>
	<input type="file" id="file" name="file" />
	<button type="submit">提交</button>
</form>
<?php 
}else{
	if($_FILES["file"]["error"] > 0){
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}else{
		$fileName = $_FILES["file"]["name"];
		$type = $_FILES["file"]["type"];
		$size = ($_FILES["file"]["size"] / 1024)." kb" ;
		$tmp_name =  $_FILES["file"]["tmp_name"] ;
		$data = file_get_contents($tmp_name);
		
		echo json_encode(['txt'=>$data]);
	}
}
?>


