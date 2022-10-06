<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <p style="font-family: Merriweather, serif; font-size: 25px; ">Master Variabel Gaji</p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <button type="button" class="btn btn-round btn-info" id="tambah_hakakses" onclick="tambah_modal_master_potongan()"><b><i class="fa fa-plus-circle"></i> Master Variabel Gaji</b></button>   
                <br><br>
                <div id="parent_tabel_master_potongan">
                </div>

            </div>
        </div>
    </div>
</div>

<!-- tambah -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-tambah-master-potongan">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy;">Master Variable Gaji</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal form-label-left" id="formManageApps" data-parsley-validate>
                <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="namapotongan_tambah">Nama Variable<span class="required" style="color: red;"> (*)</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="namapotongan_tambah" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <br><br>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="namapotongan_tambah">Group Variable<span class="required" style="color: red;"> (*)</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="select2_group form-control" id="group_variable">
                            <optgroup label="Variable Penambahan">
                            <option value="thp_bulat">THP Bulat</option>
                            <option value="trf_bank">Transfer Bank</option>
                            <!-- <option value="t_tunjangan_struktural">Tunjangan Struktural</option>
                            <option value="tunjangan_khusus">Tunjangan Khusus</option>
                            <option value="t_penyesuaian">Penyesuaian</option>
                            <option value="t_tas">Tunjangan Alih Sistem</option>
                            <option value="t_rapel">Rapel</option>
                            <option value="t_incentive">Incentive</option> -->
                            </optgroup>
                            <optgroup label="Variable Pengurangan">
                            <option value="total_potongan">Potongan</option>
                            <!-- <option value="k_jkn">Potongan JKN</option>
                            <option value="k_koperasi">Potongan Koperasi</option>
                            <option value="k_obat">Potongan Obat</option>
                            <option value="k_lain">Potongan Lain-Lain</option> -->
                            </optgroup>
                            </select>
                        </div>
                    </div>
                   
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="tambah_potongan()"><i class="fa fa-save"><b> Simpan</b></i></button>

            </div>
        </div>
    </div>
</div>
</div>

<!-- edit -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-edit-master-potongan">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy;">Master Potongan</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal form-label-left" id="formManageApps" data-parsley-validate>

                <input type="hidden" id="idpotongan_edit" required>

                <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="namapotongan_edit">Nama Potongan<span class="required" style="color: red;"> (*)</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="namapotongan_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                </div>
               
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="edit_master_potongan()"><i class="fa fa-save"><b> Simpan</b></i></button>

            </div>
        </div>
    </div>
</div>
</div>