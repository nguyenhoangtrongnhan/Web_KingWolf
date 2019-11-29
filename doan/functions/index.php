<?php
    $connect = mysqli_connect('localhost','root','','db_mxh');
	mysqli_set_charset($connect, 'UTF8');
	if(!$connect)
	{
		echo 'Kết nối database thất bại';
		die();
    }
    //Mã hóa mật khẩu
    function mahoapassword($pass)
    {
        return $pass=strtoupper(sha1(strtoupper(md5($pass))));
    }
    //Kiếm tra câu query trả về 0 (chạy không được) và 1 (được)
    function runquery($con,$string)
	{
		if(mysqli_query($con,$string))
		{
			return 1;
		}
		else
		{
			return 0;
		}
    }
    //Kiếm tra câu query trả về 0 (chạy không được) và table có dữ liệu
	function runquerytable($con,$string)
	{
		if($result=mysqli_query($con,$string))
		{
			$tk=mysqli_fetch_array($result);
			return $tk;
		}
		else
		{
			return 0;
		}
    }
    //Kiếm tra câu query trả về 0 (chạy không được) và số dòng
	function runquerynum($con,$string)
	{
		if($result=mysqli_query($con,$string))
		{
			$num=mysqli_num_rows($result);
			return $num;
		}
		else
		{
			return 0;
		}
    }
    function guimail($mail,$email,$noidung,$tieude)
	{
		try
		{
					//Server setting
				    $mail->isSMTP();                                      // Set mailer to use SMTP
				    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
				    $mail->SMTPAuth = true;                               // Enable SMTP authentication
				    $mail->Username = 'jackscore1999@gmail.com';                 // SMTP username
				    $mail->Password = 'Jack12300';                           // SMTP password
				    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				    $mail->Port = 587;
				    $mail->CharSet='UTF-8';
				    $mail->setFrom('jackscore1999@gmail.com', 'Admin');
				    $mail->addAddress($email);
				    //Content
				    $mail->isHTML(true);                                  // Set email format to HTML
				    $mail->Subject = $tieude;
				    $mail->Body    = $noidung;
				    $mail->AltBody = '';
				    $mail->send();
				    return 1;
		}
		catch(Exception $e) 
		{
				   return 0;
		}	
	}
?>