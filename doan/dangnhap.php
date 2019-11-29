<?php
    session_start();// bắt đầu phiên session
    ob_start();//định hướng header 
    //$page dùng để active menu
    $page='dangnhap';
    //lấy giao diện và các hàm 
    include ("giaodien/header.php");
    include ("functions/index.php");
    $thongbao=0;//tạo biến thông báo
?>
<?php
    //Xử lý đăng nhập
    if(isset($_POST["dn_btn"]))//Kiểm tra nút button đăng nhập click chưa ?
    {
        $email=$_POST["dn_email"];//lấy mail từ input 
        $pw=mysqli_real_escape_string($connect,$_POST["dn_pw"]);//ép kiểu string pw từ input
        if( $pw == null || $email == null )// kiểm tra các input có trống không ?
        {
            //trường hợp có input để trống
            $_SESSION["error_dn"]="Không được để trống !";
        }
        else
        {
            //trường hợp không input nào để trống
            $query="SELECT * FROM accounts where Email='$email'";// câu query kiểm tra có trùng mail ko ?
            $kqquery= runquerynum($connect,$query);// lấy kết quả số dòng (row)
            if($kqquery==0) //Số dòng = 0 thì không có trùng mail
            {
                //trường hợp không trùng
                $_SESSION["error_dn"]="Email không có trên hệ thống";
            }
            else
            {
                //trường hợp trùng
                $query1="SELECT * FROM accounts where Email='$email' and Type_accounts = 2 ";// kiểm tra mail và loại account có kích hoạt chưa ?
                $kqquery1=runquerynum($connect,$query1);//lấy kết quả số dòng (row)
                if($kqquery1==0)//Số dòng = 0 thì trùng mail và loại account = 1 ( Chưa kích hoạt ) 
                {
                    $_SESSION["error_dn"]="Vui lòng kiểm tra mail để kích hoạt tài khoản";
                }
                else // Số dòng # 0 thì trùng mail và loại account = 2 ( đã được kích hoạt ) 
                {
                    $pw=mahoapassword($pw);//mã hóa pw từ input để kiểm tra pw từ dữ liệu
                    $query2="SELECT * FROM accounts where Email='$email' and Type_accounts = 2 and PW='$pw'";// câu query kiểm trùng mail và loại account =2 và pw = PW(dữ liệu)
                    $kqquery2= runquerynum($connect,$query2);//lấy kết quả số dòng
                    if($kqquery2==0)//số dòng == 0 thì không có trùng
                    {
                        $_SESSION["error_dn"]="Vui lòng kiểm tra mail để kích hoạt tài khoản";
                    }
                    else//số dòng # 0 thì trùng sẽ đến giao diện index.
                    {
                        
                        $_SESSION["email"]=$email;//gắn vào session email
                        $_SESSION["check"]=1;//hàm check tăng tính bảo mật thôi :))
                        header('location:index.php');// di chuyển qua trang index
                    }
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
                    if(isset($_SESSION["error_dn"]))// kiểm tra session có tồn tại ko ?
                        {
                            $thongbao=1;// gắn thống báo = 1 . Để xóa khi load lại trang
                            ?>
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Error</span>
                                <?=$_SESSION["error_dn"]?>
                            </div>
                            <?php
                        }
                    if(isset($_SESSION["success_dn"]))// kiểm tra session có tồn tại ko ?
                        {
                            $thongbao=2;// gắn thống báo = 2 . Để xóa khi load lại trang
                            ?>
                            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                <span class="badge badge-pill badge-success">Success</span>
                                <?=$_SESSION["success_dn"]?>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="card-body ">
                        <div class="form-group">
                                <label for="nf-email" class=" form-control-label">Địa chỉ Email </label>
                                <input type="email" id="nf-email" name="dn_email" placeholder="jackscore1999@gmail.com" class="form-control">
                                <span class="help-block">Nhập email của bạn</span>
                        </div>
                        <div class="form-group">
                                <label for="nf-password" class=" form-control-label ">Mật Khẩu </label>
                                <input type="password" id="nf-password" name="dn_pw" placeholder="************" class="form-control" minlength="7" maxlength="50">
                                <span class="help-block">Nhập mật khẩu của bạn</span>
                        </div>
                </div>
                <div class="card-footer ">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="dn_btn">
                                            <i class="fa fa-lock"></i> Đăng Nhập
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
<!--Giao diện đăng nhập-->
<?php
    // Xóa các thông báo lỗi hoặc thành công
        if($thongbao==1)
        {
            unset($_SESSION["error_dn"]);
        }
        if($thongbao==2)
        {
            unset($_SESSION["success_dn"]);
        }
    include("giaodien/footer.php");
?>