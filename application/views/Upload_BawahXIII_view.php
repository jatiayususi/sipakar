<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <p style="font-family: Merriweather, serif; font-size: 25px; ">Upload File</p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table width="100%">
                    <td width="50%">
                        <button type="button" class="btn btn-round btn-info" id="upload_file" onclick="modal_upload_file()"><i class="fa fa-cloud-upload"></i><b> Upload File</b></button>
                    </td>
                    <td width="50%" style="text-align: right;">
                        <a href="<?php echo base_url();?>file/template_ sipakar.xlsx">
                        <!-- <img src="<?php echo base_url();?>assets/images/Excel.png" width="40" height="40" title="Template" target="_blank"> -->
                        <button type="button" class="btn btn-round btn-success"><i class="fa fa-cloud-download"></i><b> Download Template</b></button></a>
                    </td>
                </table>
            </div>
        
        </div>

        <div class="x_panel">
            <div class="x_title">
                <p style="font-family: Merriweather, serif; font-size: 23px; ">Tabel Upload</p>
                <div class="clearfix"></div>
            </div>
            <div id="parent_tabel_upload_bawahxiii"></div>
        </div>
    </div>
</div>

<!-- modal upload -->

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-upload-file">
<div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy;"><b>Upload</b></h4>
        </div>

        <div class="modal-body">
            
            <div class="col-md-12 col-sm-12 col-xs-12">

                <input type="hidden" name="grup_golongan" id="grup_golongan" required>

                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_tambah" style="color: black;">Jenis Gaji
                    <span class="required" style="color: red;"> (*)</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">

                        <select class="form-control" data-live-search="true" id="jenis_tambah" name="jenis_tambah">
                            <option selected disabled>-- Pilih --</option>
                            <option value="1">Gaji</option>
                            <option value="2">Non Gaji</option>
                        </select>

                </div>
            </div>

            <br><br><br>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulantahun_tambah" style="color: black;">Periode <span class="required" style="color: red;"> (*)</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="form-group">
                        <div class='input-group date' id='myDatepicker2'>
                            <input type='text' id="bulantahun_tambah" name="bulantahun_tambah" class="form-control" />
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <br><br><br>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="upload" style="color: black;">Upload File <span class="required" style="color: red;"> (*)</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="dropzone" id="mydropzone">
                        <div class="dz-message" style="margin-top: -1%;">
                            <div class="drag-icon-cph">
                                <i class="fa fa-upload fa-lg"></i>
                            </div>
                            <h2>Drop files here or click to upload.</h2>
                        </div>
                    </div>
                </div>
            </div>

            <br><br><br><br><br>

            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-left: 24%;">
                <label class="control-label col-md-8 col-sm-8 col-xs-12" style="color: red;">Silahkan upload file max. 2 Mb dengan tipe .xlsx
                </label>
            </div>

            <br><br>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                <button type="button" class="btn btn-primary" id="button_upload_file"><i class="fa fa-cloud-upload"><b> Upload</b></i></button>
            </div>

        </div>
    </div>

</div>
</div>

<!-- ----- -->

<!-- modal detail -->

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-detail-upload">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy;">Detail</h4>
        </div>
        <div class="modal-body">

            <div id="parent_tabel_detail"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
</div>

<!-- modal edit upload -->

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-edit-data-upload">
<div class="modal-dialog" style="width: 1200px;">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue; height: 40px;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel" style="color: navy; margin-top: -10px;">Update Data</h4>
        </div>
        <div class="modal-body" style="font-size: 11px;">
            <form class="form-horizontal form-label-left" id="formManageApps" data-parsley-validate>

                <input type="hidden" id="id_isi_file_edit" required>

                <input type="hidden" id="id_upload_file_edit" required>

                <div class="col-md-12"> <!-- nama nik -->
                    <!-- <div class="form-group" style="color: black;">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="potongan_edit" style="text-align: left;">Potongan</label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <input type="text" id="potongan_edit" readonly="readonly" class="form-control col-md-7 col-xs-12">
                            </div>
                    </div> -->

                    <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="nik_edit" style="text-align: left;">NIK<span class="required" style="color: red;"> (*)</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="nik_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    </div>

                    <div class="col-md-9">
                    <div class="form-group" style="color: black;">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="nama_edit" style="text-align: left;">Nama Karyawan</label>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <input type="text" id="nama_edit" readonly="readonly" class="form-control col-md-7 col-xs-12">
                            </div>
                    </div>
                    </div>
                </div>

                <div class="col-md-12"> <!-- gapok, potongan JHT dan nom koperasi -->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="gapok_edit" style="text-align: left;">Gapok<span class="required" style="color: red;"> (*)</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="gapok_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="rapel_edit" style="text-align: left;">Rapel
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="rapel_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nom_rek_edit" style="text-align: left;">Rekening
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="ket_rek_rs_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="nom_rek_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- tnj khusus, jaminan pesiun, pot kopkar -->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="tunj_khusus_edit" style="text-align: left;">T.Khusus
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            <input type="text" id="tunj_khusus_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="insentif_edit" style="text-align: left;">Insentif
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="insentif_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nom_koperasi_edit" style="text-align: left;">Koperasi
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="ket_koperasi_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="nom_koperasi_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- tnj.struktural, jkn, ket koperasi -->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="tunj_struktural_edit" style="text-align: left;">T.Struktural
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="tunj_struktural_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="potongan_jht_edit" style="text-align: left;">POT. JHT
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="potongan_jht_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nom_btn_solo_edit" style="text-align: left;">BTN Solo
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="ket_btn_solo_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="nom_btn_solo_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- TAS, STA dan Nom BTN Solo -->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="tas_edit" style="text-align: left;">T.A.S
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="tas_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="jaminan_pensiun_edit" style="text-align: left;">POT. JP
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="jaminan_pensiun_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nom_prr_btn_edit" style="text-align: left;">PRR BTN Solo
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="ket_prr_btn_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="nom_prr_btn_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- penyesuaian, pajak dan ket btn solo -->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="penyesuaian_edit" style="text-align: left;">Penyesuaian
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="penyesuaian_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="bpjs_kesehatan_edit" style="text-align: left;">JKN
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="bpjs_kesehatan_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nom_lain_edit" style="text-align: left;">Lain
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="ket_lain_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="nom_lain_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- gross, thp bulat dan nom prr btn-->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="gross_edit" style="text-align: left;">Gross
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="gross_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="sta_edit" style="text-align: left;">STA
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="sta_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="titik_perubahan_edit" style="text-align: left;">Titik / Perub.
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="titik_perubahan_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- maks gross, nom rek dan ket prr btn -->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="max_gross_edit" style="text-align: left;">Maks Gross
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="max_gross_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="pajak_edit" style="text-align: left;">Pajak
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="pajak_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jml_terima_edit" style="text-align: left;">Jml Terima
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="jml_terima_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- dinas malam, nom lain, jml terima-->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="dinas_malam_edit" style="text-align: left;">Dinas Malam
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="dinas_malam_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="pot_kopkar_edit" style="text-align: left;">Pot. KopKar
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="pot_kopkar_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <hr>
                </div>
                
                </div>

                <div class="col-md-12"> <!-- lembur, ket lain, nom ekstra -->

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="lembur_edit" style="text-align: left;">Lembur
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="lembur_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="color: black;">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="thp_bulat_edit" style="text-align: left;">THP Bulat
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="thp_bulat_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="color: black;">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="ket_ekstra_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="text" id="nom_ekstra_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <input type="text" id="jenis_ekstra_edit" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                </div>
                
                </div>
               
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="edit_isi_file()"><i class="fa fa-save"><b> Simpan</b></i></button>
            </div>
        </div>
    </div>
</div>
</div>