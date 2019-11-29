<?php
    session_start();
    ob_start();
    $page='login';
    include("giaodien/header.php");
    include("functions/index.php");
?>
<?php
    $thongbao=0;
    if(isset($_POST["dn_btn"]))
    {
        $email=$_POST["dn_email"];
        $pw=mysqli_real_escape_string($connect,$_POST["dn_pw"]);
        if( $pw == null || $email == null )
        {
            $_SESSION["error_dn"]="Không được để trống !";
        }
        else
        {
            $query="SELECT * FROM accounts where Email='$email'";
            $kqquery= runquerynum($connect,$query);
            if($kqquery==0)
            {
                $_SESSION["error_dn"]="Email không có trên hệ thống";
            }
            else
            {
                $query1="SELECT * FROM accounts where Email='$email' and Type_accounts = 2 ";
                $kqquery1=runquerynum($connect,$query1);
                if($kqquery1==0)
                {
                    $_SESSION["error_dn"]="Vui lòng kiểm tra mail để kích hoạt tài khoản";
                }
                else
                {
                    $pw=mahoapassword($pw);
                    $query2="SELECT * FROM accounts where Email='$email' and Type_accounts = 2 and PW='$pw'";
                    $kqquery2= runquerynum($connect,$query2);
                    if($kqquery2==0)
                    {
                        $_SESSION["error_dn"]="Vui lòng kiểm tra mail để kích hoạt tài khoản";
                    }
                    else
                    {
                        $tk=runquerytable($connect,$query2);
                        $_SESSION["tk"]=$tk;
                        $_SESSION["check"]=1;
                        header('location:index.php');
                    }
                }
            }
        }
    }
?>
<!--Giao Diện-->
<div class="row bg_row" style="margin-right: 0px;">
    <div class="col-md-6 offset-md-3">
        <br>
        <div class="card bg-dark text-light"style="margin-top:80px;margin-right:-10px;">
            <form action="" method="post" class="">
                <div class="card-header bg_footer">
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
                    ?>
                </div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="nf-email" class=" form-control-label">Địa chỉ Email</label>
                        <input type="email" id="nf-email" name="dn_email" placeholder="jackscore1999@gmail.com" class="form-control">
                        <span class="help-block">Nhập email của bạn</span>
                    </div>
                    <div class="form-group">
                        <label for="nf-password" class=" form-control-label">Mật Khẩu</label>
                        <input type="password" id="nf-password" name="dn_pw" placeholder="************" class="form-control" minlength="7" maxlength="50">
                        <span class="help-block">Nhập mật khẩu của bạn</span>
                    </div>
                </div>
                <div class="card-footer">
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
                <div class="card-footer bg_footer">
                    <center><a href="#"><i class="fa fa-exclamation-circle"></i> Bạn quên mật khẩu ?</a></center>
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
    include("giaodien/footer.php");
?>