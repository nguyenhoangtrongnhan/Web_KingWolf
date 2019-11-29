<?php
	include("functions/index.php");
	if(isset($_GET['id']))
	{
		$id=$_GET['id']; // lấy id mới trên ở link : viewimage.php?id=ID 
		$query="SELECT * FROM accounts WHERE ID='$id'"; // ta select ID tìm user 
		$tk=runquerytable($connect,$query);//function gọi hàm ra cái bảng 
		$img=$tk["Avatar"];// ta lấy dữ liệu ảnh trong cái bảng đó 
		header("content-type: image/jpeg");// ta chọn file này hiện thị hình ảnh
		echo $img;// show hình ảnh ra 
	}
	else
	{
		echo 'Lỗi';
		die();
	}
	
	
?>