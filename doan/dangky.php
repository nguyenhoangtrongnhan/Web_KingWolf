<?php
    session_start();// bắt đầu phiên session
    ob_start();//định hướng header 
    //$page dùng để active menu
    $page='dangky';
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
    //Xử lý đăng ký tài khoản
    if(isset($_POST["dk_btn"]))//kiểm tra nút button đăng ký đc click chưa ?
    {
        $ho=$_POST["dk_ho"];//lấy họ từ input
        $ten=$_POST["dk_ten"]; // Lấy tên từ input
        $pw=mysqli_real_escape_string($connect,$_POST["dk_pw"]);//ép kiểu string pw từ input
        $email=$_POST["dk_email"];// lấy email từ input
        if($ho == null || $ten == null || $pw == null || $email == null ) // kiểm tra các input có trống không ?
        {
            //trường hợp có input để trống
            $_SESSION["error_dk"]="Không được để trống !";
        }
        else
        {
            //trường hợp không input nào để trống
            $query="SELECT * FROM accounts where Email='$email'";// câu query kiểm tra có trùng mail ko ?
            $kqquery= runquerynum($connect,$query);// lấy kết quả số dòng (row)
            if($kqquery!=0) //Số dòng # 0 thì trùng mail
            {
                //trường hợp trùng
                $_SESSION["error_dk"]="Email đã có người sử dụng !";
            }
            else
            {
                //trường hợp không trùng
                $pw=mahoapassword($pw);// mã hóa mật khẩu đã dùng hàm để mã hóa
                $randomcode=substr(md5(rand()), 0, 20);// tạo token lấy 20 ký tự
                $name=strtoupper($ho." ".$ten);// INHOA họ tên
                $query1="INSERT INTO accounts (HoTen,Email,PW,Active_token,Type_accounts) VALUES ('$name','$email','$pw','$randomcode','1')";//câu query thêm account
                $kqquery1=runquery($connect,$query1);//lấy kết quả câu query có thực thi ko ?
                if($kqquery1==1)
                {
                    //trường hợp có thực thi
                    $tieude='[Kích hoạt] tài khoản webstie';// tạo tiêu đề mail
					$noidung = 'Bạn bấm link để kích hoạt tài khoản: '; // tạo nội dụng mail
					$webnewpass='http://'.$_SERVER["SERVER_NAME"].'/doan/active-accounts.php?tokenactives=';// tạo nội dụng mail
					$noidung = $noidung.$webnewpass.$randomcode;// tạo nội dụng mail
					$mail = new PHPMailer(true);//tạo đối tượng mail
                    $checkmail=guimail($mail,$email,$noidung,$tieude);//Lấy kết quả kết quả việc gửi mail thành công ko ?
                    if($checkmail==1)//kiểm tra mail đã gửi chưa ?
                    {
                        //trường hợp đã gửi
                        $_SESSION["success_dk"]="Đăng ký tài khoản thành công ! Vui lòng kiểm tra email để kích hoạt tài khoản";
                    }
                    else
                    {
                        //trường hợp chưa gửi
                        $_SESSION["error_dk"]="Gửi mail kích hoạt tài khoản bị lỗi";
                    }
                    
                }
                else
                {
                    //trường hợp không thực thi
                    $_SESSION["error_dk"]="Lỗi cấu query1 ";
                }
            }
        }
    }
?>
<!--Giao diện đăng ký-->
<div class="row " style="margin-right: 0px;">
    <div class="col-md-6 offset-md-3">
        <br>
        <div class="card text-dark border border-secondary ">
            <form action="" method="POST" class="">
                <div class="card-header">
                <?php
                    if(isset($_SESSION["error_dk"]))// kiểm tra session có tồn tại ko ?
                        {
                            $thongbao=1;// gắn thống báo = 1 . Để xóa khi load lại trang
                            ?>
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Error</span>
                                <?=$_SESSION["error_dk"]?>
                            </div>
                            <?php
                        }
                    if(isset($_SESSION["success_dk"]))// kiểm tra session có tồn tại ko ?
                        {
                            $thongbao=2;// gắn thống báo = 2 . Để xóa khi load lại trang
                            ?>
                            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                <span class="badge badge-pill badge-success">Success</span>
                                <?=$_SESSION["success_dk"]?>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="card-body ">
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
                <div class="card-footer ">
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
            </form>
        </div>
    </div>
</div>
<!--Giao diện đăng ký-->
<?php
    // Xóa các thông báo lỗi hoặc thành công
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