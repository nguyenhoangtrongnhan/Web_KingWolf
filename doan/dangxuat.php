<?php
    session_start();
    session_destroy();
    header('location:dangnhap');// di chuyển tới login
?>