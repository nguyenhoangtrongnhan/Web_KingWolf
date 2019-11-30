<?php
    session_start();// bắt đầu phiên session
    ob_start();//định hướng header 
    //$page dùng để active menu
    $page='quenmatkhau';
    //lấy giao diện và các hàm 
    include ("giaodien/header.php");
    include ("functions/index.php");
    //lấy thư viện mail
    include ('mail/PHPMailer-master/src/PHPMailer.php');
	include ('mail/PHPMailer-master/src/Exception.php');
	include ('mail/PHPMailer-master/src/OAuth.php');
	include ('mail/PHPMailer-master/src/POP3.php');
	include ('mail/PHPMailer-master/src/SMTP.php');
	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $thongbao=0;//tạo biến thông báo
?>
<?php
    if(isset($_POST["quenpw_btn"]))
    {

        $email=$_POST["quenpw_email"];
        $query="SELECT * FROM accounts WHERE Email='$email'";
        $kqquery= runquerynum($connect,$query);
        if($kqquery!=0)
        {
            $randomcode=substr(md5(rand()), 0, 15);
            $query2="UPDATE accounts SET Foget_token='$randomcode' WHERE Email='$email'";
            $kqquery2=runquery($connect,$query2);
            if($kqquery2==1)
            {
                //trường hợp có thực thi
                $tieude='[Quên Mật Khẩu] tài khoản webstie';// tạo tiêu đề mail
                $noidung = 'Bạn bấm link để lấy lại mật khẩu tài khoản: '; // tạo nội dụng mail
                $webnewpass='http://'.$_SERVER["SERVER_NAME"].'/doan/forget-newpass.php?tokenforget=';// tạo nội dụng mail
                $noidung = $noidung.$webnewpass.$randomcode;// tạo nội dụng mail
                $mail = new PHPMailer(true);//tạo đối tượng mail
                $checkmail=guimail($mail,$email,$noidung,$tieude);//Lấy kết quả kết quả việc gửi mail thành công ko ?
                if($checkmail==1)//kiểm tra mail đã gửi chưa ?
                    {
                        //trường hợp đã gửi
                        $_SESSION["success_pwforget"]="Vui lòng kiểm tra email để lấy lại mật khẩu ";
                    }
                    else
                    {
                        //trường hợp chưa gửi
                        $_SESSION["error_pwforget"]="Gửi mail lấy lại mật khẩu bị lỗi";
                    }
            }
            
        }
    }
?>
<!--Giao diện đăng nhập-->
<div class="row" style="margin-right: 0px;">
    <div class="col-md-6 offset-md-3">
        <br>
        <div class="card text-dark border border-secondary ">
            <form action="" method="POST" class="">
                <div class="card-header">
                <?php
                    if(isset($_SESSION["error_pwforget"]))// kiểm tra session có tồn tại ko ?
                        {
                            $thongbao=1;// gắn thống báo = 1 . Để xóa khi load lại trang
                            ?>
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Error</span>
                                <?=$_SESSION["error_pwforget"]?>
                            </div>
                            <?php
                        }
                    if(isset($_SESSION["success_pwforget"]))// kiểm tra session có tồn tại ko ?
                        {
                            $thongbao=2;// gắn thống báo = 2 . Để xóa khi load lại trang
                            ?>
                            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                <span class="badge badge-pill badge-success">Success</span>
                                <?=$_SESSION["success_pwforget"]?>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="card-body ">
                        <div class="form-group">
                                <label for="nf-email" class=" form-control-label">Địa chỉ Email </label>
                                <input type="email" id="nf-email" name="quenpw_email" placeholder="jackscore1999@gmail.com" class="form-control">
                                <span class="help-block">Nhập email của bạn</span>
                        </div>
                </div>
                <div class="card-footer ">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="quenpw_btn">
                                            <i class="fa fa-lock"></i> Lấy lại mật khẩu
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                    <button type="reset" class="btn btn-danger btn-lg btn-block">
                                            <i class="fa fa-ban"></i> Reset
                                    </button>
                            </div>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Giao diện đăng nhập-->
<?php
    // Xóa các thông báo lỗi hoặc thành công
        if($thongbao==1)
        {
            unset($_SESSION["error_pwforget"]);
        }
        if($thongbao==2)
        {
            unset($_SESSION["success_pwforget"]);
        }
    include("giaodien/footer.php");
?>