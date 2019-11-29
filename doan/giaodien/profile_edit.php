<br>
        
        <div class="card text-dark border border-secondary ">
                <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="card-body ">
                                <div class="form-group">
                                        <div class="upload-btn-wrapper_index">
                                                <button class="btn_index">Chọn Ảnh</button>
                                                <input type="file" name="profile_image" accept="image/x-png,image/gif,image/jpeg"/>
                                        </div>
                                </div>
                                                
                                <div class="form-group">
                                        <label for="nf-text" class=" form-control-label ">Nick Name</font></label>
                                        <input type="text" id="nf-text" name="profile_nickname" placeholder="Jack Score" class="form-control" value="<?=$taikhoan["HoTen"]?>">
                                </div>
                                <div class="form-group">
                                        <label for="nf-text" class=" form-control-label ">Ngày Sinh</font></label>
                                        <input type="date" id="nf-date" name="profile_ngaysinh" class="form-control" value="<?=$taikhoan["NgaySinh"]?>">
                                </div>
                                <div class="form-group">
                                        <label for="nf-text" class=" form-control-label ">Số Điện Thoại</font></label>
                                        <input type="text" id="nf-text" name="profile_sdt" class="form-control" minlength="10" maxlength="11" value="<?=$taikhoan["SDT"]?>">
                                </div>
                                <div class="form-group">
                                        <label for="nf-text" class=" form-control-label ">Địa Chỉ</font></label>
                                        <input type="text" id="nf-text" name="profile_diachi" class="form-control" minlength="10" value="<?=$taikhoan["DiaChi"]?>">
                                </div>
                        </div>
                        <div class="card-footer ">
                                <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="profile_btn_update">
                                                        <i class="fa fa-user"></i> Cập Nhật
                                                </button>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                                <button type="reset" class="btn btn-danger btn-lg btn-block">
                                                        <i class="fa fa-ban"></i>Reset
                                                </button>
                                        </div>
                                </div>
                        </div>
                </form>
        </div>