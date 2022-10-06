<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <p style="font-family: Merriweather, serif; font-size: 25px; ">Hak Akses</p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button type="button" class="btn btn-round btn-info" id="tambah_hakakses" onclick="tambah_modal_hak_akses()"><i class="fa fa-plus-circle"></i><b> Hak Akses</b></button>
                <button type="button" class="btn btn-round btn-warning" id="edit_encrypt" onclick="edit_modal_encrypt()"><i class="fa fa-edit"></i><b> Encrypt</b></button>
                <br><br>
                <div id="parent_tabel_hak_akses"></div>
            </div>
        </div>
    </div>
</div>

<!-- tambah -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-tambah-hak-akses">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy;">Hak Akses</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal form-label-left" id="formManageApps" data-parsley-validate>
                <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="karyawan_tambah">Karyawan<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <!-- <select class="form-control" data-live-search="true" id="karyawan_tambah" name="karyawan_tambah">
                                <option selected disabled>-- Pilih --</option>
                                <?php if($list_karyawan):?>
                                <?php foreach($list_karyawan as $data):?>
                                <option value="<?php echo $data['n_employee_id']; ?>"><?php echo $data['v_nik']." - ".$data['v_employee_name']; ?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                            </select> -->
                            <select class="form-control" data-live-search="true" name="karyawan_tambah" id="karyawan_tambah" style="width:100%;" required></select>

                            <!-- <select id="country" data-live-search="true" style="width:300px;"></select> -->

                        </div>
                        <br><br><br>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hak_akses">Hak Akses<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="select2_group form-control" id="hak_akses">
                            <option value="1">Golongan Di Bawah XIII</option>
                            <option value="2">Golongan XIII Ke Atas</option>
                            </select>
                        </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="tambah_hak_akses()"><i class="fa fa-save"><b> Simpan</b></i></button>

            </div>
        </div>
    </div>
</div>
</div>

<!-- edit -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-edit-hak-akses">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy;">Hak Akses</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal form-label-left" id="formManageApps" data-parsley-validate>
                <div class="form-group" style="color: black;">
                        <input type="hidden" id="id_hak_akses_edit" required>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="karyawan_edit">Karyawan<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" data-live-search="true" id="karyawan_edit" name="karyawan_edit">
                                <option selected disabled>-- Pilih --</option>
                                <?php if($list_karyawan):?>
                                <?php foreach($list_karyawan as $data):?>
                                <option value="<?php echo $data['n_employee_id']; ?>"><?php echo $data['v_nik']." - ".$data['v_employee_name']; ?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                            </select>
                        </div>
                        <br><br>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hak_akses_edit">Hak Akses<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="select2_group form-control" id="hak_akses_edit">
                            <option value="1">Golongan Di Bawah XIII</option>
                            <option value="2">Golongan XIII Ke Atas</option>
                            </select>
                        </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="edit_hak_akses()"><i class="fa fa-save"><b> Simpan</b></i></button>

            </div>
        </div>
    </div>
</div>
</div>

<!-- encrypt -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-edit-encrypt">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy;">Ubah Kata Kunci</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal form-label-left" id="formManageApps" data-parsley-validate>

                <input type="hidden" id="id_encrypt_edit" required>

                <div class="form-group" style="color: black;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_lama1_edit">Kode Lama 1<span class="required" style="color: red;"> (*)</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="kode_lama1_edit" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group" style="color: black;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_lama2_edit">Kode Lama 2<span class="required" style="color: red;"> (*)</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="kode_lama2_edit" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group" style="color: black;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_baru1_edit">Kode Baru 1<span class="required" style="color: red;"> (*)</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="kode_baru1_edit" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group" style="color: black;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_baru2_edit">Kode Baru 2<span class="required" style="color: red;"> (*)</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="kode_baru2_edit" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
               
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="edit_encrypt()"><i class="fa fa-save"><b> Simpan</b></i></button>

            </div>
        </div>
    </div>
</div>
</div>