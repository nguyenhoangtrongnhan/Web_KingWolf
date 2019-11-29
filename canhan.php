<?php
    session_start();// bắt đầu phiên session
    ob_start();//định hướng header 
    $page="canhan";
    include ("functions/index.php");
    include ("giaodien/header.php");
    $thongbao=0;
?>
<?php
    if (isset($_SESSION["email"])&& isset($_SESSION["check"])&& $_SESSION["check"]==1)
    {
        $email=$_SESSION["email"];
        $accountall="SELECT * From accounts WhERE Email='$email'";
        $taikhoan = runquerytable($connect,$accountall);
        $IDtk=$taikhoan["ID"];
        //xử lý update
                if(isset($_POST["profile_btn_update"]) && isset($_FILES["profile_image"]))
                {
                        $nickname=$_POST["profile_nickname"];
                        $ngaysinh=$_POST["profile_ngaysinh"];
                        $sdt=$_POST["profile_sdt"];
                        $diachi=$_POST["profile_diachi"];
                        if($nickname == null || $ngaysinh == null || $sdt == null || $diachi == null )
                        {
                                $_SESSION["error_profile_update"]="Không được để trống !";
                        }
                        else
                        {
                                if($_FILES["profile_image"]["name"]!="")
                                {
                                        if ($_FILES["profile_image"]["error"] > 0)
                                        {
                                                $_SESSION['error_profile_update']='Update Lỗi file';
                                        }
                                        else
                                        {
                                                $namefile=$_FILES["profile_image"]['tmp_name'];
						$fh = fopen($namefile, "rb");  
						$imgData = fread($fh, filesize($namefile));  
                                                fclose($fh);
                                                $idac=$taikhoan["ID"];
                                                $queryupdate="UPDATE accounts SET Avatar='".mysqli_real_escape_string($connect,$imgData)."', 
                                                HoTen='$nickname',NgaySinh='$ngaysinh',SDT='$sdt',DiaChi='$diachi'
                                                WHERE ID='$idac'";
                                                $kqqueryupdate=runquery($connect,$queryupdate);
                                                if($kqqueryupdate!=0)
                                                {
                                                        $_SESSION["success_profile_update"]="Thành công";
                                                }
                                                else
                                                {
                                                        $_SESSION['error_profile_update']="Thất Bại";
                                                }
                                        }
                                }
                                else
                                {
                                        $queryupdate="UPDATE accounts SET  HoTen='$nickname',NgaySinh='$ngaysinh',SDT='$sdt',DiaChi='$diachi' WHERE ID='$idac'";
                                        $kqqueryupdate=runquery($connect,$queryupdate);
                                        if($kqqueryupdate!=0)
                                        {
                                                $_SESSION["success_profile_update"]="Thành công";
                                        }
                                        else
                                        {
                                                $_SESSION['error_profile_update']="Thất Bại";
                                        }
                                }
                        }
                }
        //xử lý update
        ?>
        <br>
        <div class="row" style="margin-right: 0px;">
            <div class="col-xs-12 col-sm-12 col-md-4 " >
                <div class="card text-dark sticky-top">
                    <div class="card-header">
                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-8" >
                                <strong>Thông Tin Cá Nhân</strong>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-4" >
                                <form action="" method="GET">
                                    <button type="submit" class="btn btn-danger btn-lg btn-block" name="edit" value="1">
                                            Edit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="mx-auto d-block">
                            <img class="rounded-circle mx-auto d-block" style="width:256px; height:256px;" src="<?php 
                                                            if($taikhoan["Avatar"]==null)
                                                            {
                                                                echo 'https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1';
                                                            }
                                                            else
                                                            {
                                                                $idac=$taikhoan["ID"];
                                                                echo "viewimage.php?id=$idac";
                                                            }
                                                        ?>" alt="Card image cap" >
                            <h5 class="text-sm-center mt-2 mb-1"><?=$taikhoan["HoTen"]?></h5>
                            <div class="location text-sm-center">
                                <i class="fa fa-map-marker"></i> <?=$taikhoan["DiaChi"]?>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-top-campaign ">
                                <tbody>
                                    <tr>
                                        <td>Ngày Sinh </td>
                                        <td><?php echo date('d-m-Y',strtotime($taikhoan["NgaySinh"]));?></td>
                                    </tr>
                                    <tr>
                                        <td>Số Điện Thoại </td>
                                        <td><?=$taikhoan["SDT"]?></td>
                                    </tr>
                                    <tr>
                                        <td>Email </td>
                                        <td><?=$taikhoan["Email"]?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                    <?php
                        if(isset($_GET["edit"]))
                        {
                            $idget=$_GET["edit"];
                            if($idget==1)
                            {
                                if(isset($_SESSION["error_profile_update"]))// kiểm tra session có tồn tại ko ?
                                {
                                    $thongbao=1;// gắn thống báo = 1 . Để xóa khi load lại trang
                                    ?>
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Error</span>
                                        <?=$_SESSION["error_profile_update"]?>
                                    </div>
                                    <?php
                                }
                                if(isset($_SESSION["success_profile_update"]))// kiểm tra session có tồn tại ko ?
                                {
                                    $thongbao=2;// gắn thống báo = 2 . Để xóa khi load lại trang
                                    ?>
                                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                        <span class="badge badge-pill badge-success">Success</span>
                                        <?=$_SESSION["success_profile_update"]?>
                                    </div>
                                    <?php
                                }
                                include ("giaodien/profile_edit.php");
                                
                            }
                        }
                        else
                        {
                            $query="SELECT * FROM posts p, accounts tk where tk.ID=p.iduserpost order by p.IDpost DESC";
                            if($s=mysqli_query($connect,$query))
                            {
                                $num=mysqli_num_rows($s);
                                    if($num==1&&$num!=0)
                                    {
                                        $post=mysqli_fetch_array($s);
                                        include("giaodien/viewpost.php");
                                    }
                                    else
                                    {
                                        while($post=mysqli_fetch_array($s))
                                        {
                                            include("giaodien/viewpost.php");
                                        }
                                    }
                            }
                            else
                            {
                                echo 'sai cau query';
                            }
                        }
                    ?>
            </div>
		</div>
        <?php
    }
    else
    {
        header('location:dangnhap');// di chuyển tới dangnhap
    }
?>
<?php
    // Xóa các thông báo lỗi hoặc thành công
    if($thongbao==1)
    {
        unset($_SESSION["error_profile_update"]);
        header("location:canhan.php");
    }
    if($thongbao==2)
    {
        unset($_SESSION["success_profile_update"]);
        header("location:canhan.php");
    }
    include ("giaodien/footer.php");
?>
<script>
    $(document).ready(function(){
        var litmit=5;
        var start=0;
        var action='inactive';
        function load_country_data(litmit,start)
        {
            $.ajax({
                url:'giaodien/viewpost.php',
                method:"POST",
                date:{litmit:litmit,start:start},
                case:false,
                success:function(date)
                {
                    $('#load_data_post').append(data);
                    if(data=='')
                    {
                        $('#load_data_messenger').html(<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <span class="badge badge-pill badge-danger">Success</span>
                                        Hết bài viết
                                    </div>);
                        action='active';
                    }
                    else
                    {
                        $('#load_data_messenger').html(<div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                                        <span class="badge badge-pill badge-primary">Success</span>
                                        Vui lòng đợi tí
                                    </div>);
                        action='inactive';
                    }
                }
            })
        }
        if(action=='inactive')
        {
            action='active';
            load_country_data(litmit,start);
        }
    });
</script>
