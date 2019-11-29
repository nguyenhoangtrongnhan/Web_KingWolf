<?php
    session_start();
    ob_start();
    $page='register';
    include("giaodien/header.php");
    include("functions/index.php");
    include ('mail/PHPMailer-master/src/PHPMailer.php');
	include ('mail/PHPMailer-master/src/Exception.php');
	include ('mail/PHPMailer-master/src/OAuth.php');
	include ('mail/PHPMailer-master/src/POP3.php');
	include ('mail/PHPMailer-master/src/SMTP.php');
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
?>
<?php
    $thongbao=0;
    if(isset($_POST["dk_btn"]))
    {
        $ho=$_POST["dk_ho"];
        $ten=$_POST["dk_ten"];
        $pw=mysqli_real_escape_string($connect,$_POST["dk_pw"]);
        $email=$_POST["dk_email"];
        if($ho == null || $ten == null || $pw == null || $email == null )
        {
            $_SESSION["error_dk"]="Không được để trống !";
        }
        else
        {
            $query="SELECT * FROM accounts where Email='$email'";
            $kqquery= runquerynum($connect,$query);
            if($kqquery!=0)
            {
                $_SESSION["error_dk"]="Email đã có người sử dụng !";
            }
            else
            {
                $pw=mahoapassword($pw);
                $randomcode=substr(md5(rand()), 0, 20);
                $name=$ho." ".$ten;
                $query1="INSERT INTO accounts (HoTen,Email,PW,Active_token,Type_accounts) VALUES ('$name','$email','$pw','$randomcode','1')";
                $kqquery1=runquery($connect,$query1);
                if($kqquery1==1)
                {
                    $tieude='[Kích hoạt] tài khoản webstie';
					$noidung = 'Bạn bấm link để kích hoạt tài khoản: ';
					$webnewpass='http://'.$_SERVER["SERVER_NAME"].'/doan/active-accounts.php?tokenactives=';
					$noidung = $noidung.$webnewpass.$randomcode;
					$mail = new PHPMailer(true);
					$checkmail=guimail($mail,$email,$noidung,$tieude);
                    $_SESSION["success_dk"]="Đăng ký tài khoản thành công ! Vui lòng kiểm tra email để kích hoạt tài khoản";
                }
                else
                {
                    $_SESSION["error_dk"]="Lỗi cấu query1 ";
                }
            }
        }
    }
?>
<!--Giao Diện-->
<div class="row bg_row" style="margin-right: 0px;">
    <div class="col-md-6 offset-md-3">
        <br>
        <div class="card bg-dark text-light"style="margin-top:50px; margin-right:-10px;">
            <form action="" method="POST" class="">
                <div class="card-header bg_footer">
                    <!--Hiện thị thông báo (Lỗi/Thành Công)-->
                    <?php
                        if(isset($_SESSION["error_dk"]))
                        {
                            $thongbao=1;
                            ?>
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Error</span>
                                <?=$_SESSION["error_dk"]?>
                            </div>
                            <?php
                        }
                        if(isset($_SESSION["success_dk"]))
                        {
                            $thongbao=2;
                            ?>
                            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                <span class="badge badge-pill badge-success">Success</span>
                                <?=$_SESSION["success_dk"]?>
                            </div>
                            <?php
                        }
                    ?>
                    <!--Hiện thị thông báo (Lỗi/Thành Công)-->
                </div>
                <div class="card-body card-block ">
                    <div class="form-group">
                        <label for="nf-text" class=" form-control-label ">Họ <font color="red">(*)</font></label>
                        <input type="text" id="nf-text" name="dk_ho" placeholder="Nguyễn" class="form-control">
                        <span class="help-block">Nhập họ của bạn</span>
                    </div>
                    <div class="form-group">
                        <label for="nf-text" class=" form-control-label ">Tên <font color="red">(*)</font></label>
                        <input type="text" id="nf-text" name="dk_ten" placeholder="Nhân" class="form-control">
                        <span class="help-block">Nhập tên của bạn</span>
                    </div>
                    <div class="form-group">
                        <label for="nf-password" class=" form-control-label ">Mật Khẩu <font color="red">(*)</font></label>
                        <input type="password" id="nf-password" name="dk_pw" placeholder="************" class="form-control" minlength="7" maxlength="50">
                        <span class="help-block">Nhập mật khẩu của bạn</span>
                    </div>
                    <div class="form-group">
                        <label for="nf-email" class=" form-control-label">Địa chỉ Email <font color="red">(*)</font></label>
                        <input type="email" id="nf-email" name="dk_email" placeholder="jackscore1999@gmail.com" class="form-control">
                        <span class="help-block">Nhập email của bạn</span>
                    </div>
                    <p><font color="red">(*)</font> : Bắt buộc</p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="dk_btn">
                                        <i class="fa fa-user"></i> Đăng Ký
                                </button>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                                <button type="reset" class="btn btn-danger btn-lg btn-block">
                                        <i class="fa fa-ban"></i> Reset
                                </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg_footer">
                    <center><a href="login.php"><i class="fa fa-exclamation-circle"></i> Bạn đã có tài khoản ?</a></center>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Giao Diện-->
<?php
    if($thongbao==1)
    {
        unset($_SESSION["error_dk"]);
    }
    if($thongbao==2)
    {
        unset($_SESSION["success_dk"]);
    }
    include("giaodien/footer.php");
?>
