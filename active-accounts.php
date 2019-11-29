<?php
    $page='';
	include("giaodien/header.php");
	include("functions/index.php");
?>
<div class="row bg_row" style="margin-right: 0px;">
    <div class="col-md-6 offset-md-3">
            /* <?php
            $token=$_GET['tokenactives'];
            $query="SELECT * FROM accounts WHERE Active_token='$token'";
            $check = runquerynum($connect,$query);
            if($check==0)
            {
                ?>
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Error</span>
                                Token đã hết hạn . Vui lòng về trang đăng nhập <a href="login.php">tại đây</a>
                        </div>
                <?php
            }
            else
            {
                $query1="UPDATE accounts SET Type_accounts=2,Active_token ='null'WHERE Active_token='$token'";
                $check1=runquery($connect,$query1);
                if($check1!=0)
                {
                    ?>
                            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                    <span class="badge badge-pill badge-success">Success</span>
                                    Bạn đã kích hoạt thành công ! Đăng nhập bấm <a href="login.php">tại đây</a>
                            </div>
                    <?php
                }
            }
        ?> */
    </div>
</div>

<?php
	include("giaodien/footer.php");
?>