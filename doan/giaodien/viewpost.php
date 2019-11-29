
<div class="card text-dark ">
            <div class="card-header bg-dark text-light">
                    <div class="media">
                            <a href="#">
                            <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px; margin-top: 10px;" alt=""      src="https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1">
                            </a>
                        <div class="media-body">
                            <h4 class="display-6"><?=$post["HoTen"]?></h4>
                            <p>Thời gian đăng tải: <?php echo date('d-m-Y',strtotime($post["timepost"]));?></p>
                        </div>
                    </div>
            </div>
            <div class="card-body">
                <p><?=$post["bodypost"]?></p>
            </div>
        </div>
<br>


        