<!DOCTYPE html>
<html>
    <head>
        <!--Tiêu đề-->
        <title>#ten |</title>
        <meta charset="utf-8">
        <!--Chế độ xem mobi-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--Sử dụng bootstrap online-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!--Giao diện chính-->
        <link rel="stylesheet" type="text/css" href="public/css/theme.css">
        <!-- Fontfaces CSS-->
        <link href="public/css/font-face.css" rel="stylesheet" media="all">
        <link href="public/styles/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="public/styles/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="public/styles/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="public/styles/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="public/styles/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="public/styles/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="public/styles/wow/animate.css" rel="stylesheet" media="all">
        <link href="public/styles/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="public/styles/slick/slick.css" rel="stylesheet" media="all">
        <link href="public/styles/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="public/styles/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    </head>
    <!-- class="animsition"  style="animation-duration: 900ms; opacity: 1;" -->
    <body>
        <!--File header.php-->
        <div class="web_header">
            <div class="header bg-dark">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
                                <div class="container">
                                    <a class="navbar-brand" href="index.html">LOGO</a>
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="oi oi-menu"></span> Menu
                                    </button>
                                    <div class="collapse navbar-collapse" id="ftco-nav">
                                        <ul class="navbar-nav ml-auto">
                                            <?php
                                                if (isset($_SESSION["email"])&& isset($_SESSION["check"])&& $_SESSION["check"]==1)
                                                {
                                                    $email=$_SESSION["email"];
                                                    $accountall="SELECT * From accounts WhERE Email='$email'";
                                                    $taikhoan = runquerytable($connect,$accountall);
                                                ?>
                                                <li class="nav-item <?php if($page=='canhan'){ echo "active";}?>">
                                                    <a href="canhan.php" class="nav-link">
                                                        <img class="align-self-center rounded-circle mr-3" style="width:40px; height:40px; margin: 0px;" alt="" 
                                                        src="<?php 
                                                            if($taikhoan["Avatar"]==null)
                                                            {
                                                                echo 'https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1';
                                                            }
                                                            else
                                                            {
                                                                $idac=$taikhoan["ID"];
                                                                echo "viewimage.php?id=$idac";
                                                            }
                                                        ?>">
                                                    <?=$taikhoan["HoTen"]?></a>
                                                </li>
                                                    <li class="nav-item <?php if($page=='index'){ echo 'active';} ?>">
                                                        <a href="index.php" class="nav-link">Trang Chủ</a></li>
                                                    <li class="nav-item <?php if($page=='dangxuat'){ echo 'active';} ?>">
                                                        <a href="dangxuat.php" class="nav-link">Đăng Xuất</a></li>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <li class="nav-item <?php if($page=='dangnhap'){ echo 'active';} ?>">
                                                        <a href="dangnhap.php" class="nav-link">Đăng Nhập</a></li>
                                                    <li class="nav-item <?php if($page=='dangky'){ echo 'active';} ?>">
                                                        <a href="dangky.php" class="nav-link">Đăng Ký</a></li>
                                                    <?php
                                                }
                                            ?>
                                            <!-- <li class="nav-item"><a href="services.html" class="nav-link">services</a></li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                                <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Separated link</a>
                                                </div>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--File header.php-->
        <div class="web_body">
            <div class="page-content--bgf7">