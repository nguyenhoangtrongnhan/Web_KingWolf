<?php
    session_start();// bắt đầu phiên session
    ob_start();//định hướng header 
    //$page dùng để active menu
    $page='index';
    include ("functions/index.php");
    include ("giaodien/header.php");
    
?>
<?php
    if (isset($_SESSION["email"])&& isset($_SESSION["check"])&& $_SESSION["check"]==1)
    {
        $email=$_SESSION["email"];
        $accountall="SELECT * From accounts WhERE Email='$email'";
        $taikhoan = runquerytable($connect,$accountall);
        if($taikhoan["Avatar"]== null)
        {
            header("location:canhan.php?edit=1");// di chuyển tới cập nhật profile
        }
    }
    else
    {
        header('location:dangnhap');// di chuyển tới dangnhap
    }
?>
<!--Giao diện index-->
<div class="row" style="margin-right: 0px;">
    <div class="col-md-6 offset-md-3">
        <br>
        <div class="card text-dark">
            <form action="" method="POST" class="">
                <div class="card-header">
                    <strong>Tạo bài viết</strong>
                </div>
                <div class="card-body">
                    <div class="row form-group">
                        <div class="col-3 col-sm-12 col-md-2">
                            </a href="index.php"><img class="align-self-center rounded-circle mr-3" style="width:150px; height:100px; margin: 0px;" alt="" src="https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1"></a>
                        </div>
                        <div class="col-9 col-sm-12 col-md-10">
                            <textarea  name="status" id="textarea-input" rows="5" placeholder="Bạn đang làm gì ?..." class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="upload-btn-wrapper_index">
                                        <button class="btn_index">Chọn Ảnh</button>
                                        <input type="file" name="photo" accept="image/x-png,image/gif,image/jpeg"/>
                                </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <button type="submit" class="btn btn-warning btn-lg btn-block" name="dn_btn">
                                        <i class="fa fa-edit"></i> Đăng
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <?php include ("giaodien/viewpost.php")?>
    </div>
</div>
<!--Giao diện index-->
<?php
    include("giaodien/footer.php");
?>
