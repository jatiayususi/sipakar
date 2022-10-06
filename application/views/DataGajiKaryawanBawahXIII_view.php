<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="">
            <div class="x_panel">

                <div class="x_title">
                    <p style="font-family: Merriweather, serif; font-size: 25px; ">Data Gaji Karyawan</p>
                <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <div class="col-md-12">

                        <div class="col-md-5">
                            <div class="form-group" style="color: black;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="periode_gaji" style="text-align: left;">Periode <span class="required" style="color: red;">(*)</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class='input-group date' id='myDatepicker2'>
                                        <input type='text' id="periode_gaji" name="periode_gaji" class="form-control" />
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group" style="color: black;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_gaji" style="text-align: left;">Jenis Gaji<span class="required" style="color: red;"> (*)</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control" data-live-search="true" id="jenis_gaji" name="jenis_gaji">
                                        <option value="1">Gaji</option>
                                        <option value="2">Non Gaji</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type='button' class='btn btn-primary' onclick="button_filter_periode_gaji_bawah13()"><i class="fa fa-search"></i></button>&emsp;
                        </div>
                
                    </div>

                </div>
            </div>

            <div class="x_panel">
                <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="tabel_periode">
                            <div id="pemberitahuan_input_datagajikaryawan">
                            </div>
                        </div>

                        <div id="tabel_datagajikaryawan">
                            <div id="pemberitahuan_input_datagajikaryawan">
                                <b>SILAHKAN PILIH PERIODE GAJI</b>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- tambah -->
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-generate-gaji">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">

            <h4 style="text-align: center;" style="color: navy;">Apakah Anda Akan Generate Gaji ?</h4>

            <input type="hidden" name="tanggal" id="tanggal" required>
            <input type="hidden" name="gol" id="gol" required>
            <input type="hidden" name="jenis_gaji" id="jenis_gaji" required>

            <input type="hidden" name="periode" id="periode" required>
            <!-- <input type="hidden" name="thp_bulat" id="thp_bulat" required>
            <input type="hidden" name="potongan" id="potongan" required>
            <input type="hidden" name="transfer_bank" id="transfer_bank" required> -->

            <input type="hidden" name="gapok" id="gapok" required>
            <input type="hidden" name="tunjangan_khusus" id="tunjangan_khusus" required>
            <input type="hidden" name="tunjangan_struktural" id="tunjangan_struktural" required>
            <input type="hidden" name="penyesuaian" id="penyesuaian" required>
            <input type="hidden" name="tas" id="tas" required>
            <input type="hidden" name="maxgross" id="maxgross" required>
            <input type="hidden" name="dinas_malam" id="dinas_malam" required>
            <input type="hidden" name="lembur" id="lembur" required>
            <input type="hidden" name="rapel" id="rapel" required>
            <input type="hidden" name="insentif" id="insentif" required>
            <input type="hidden" name="gross" id="gross" required>
            <input type="hidden" name="potongan_jht" id="potongan_jht" required>
            <input type="hidden" name="jaminan_pensiun" id="jaminan_pensiun" required>
            <input type="hidden" name="bpjs_kesehatan" id="bpjs_kesehatan" required>
            <input type="hidden" name="sta" id="sta" required>
            <input type="hidden" name="pajak" id="pajak" required>
            <input type="hidden" name="thp_bulat" id="thp_bulat" required>
            <input type="hidden" name="potongan_kopkar" id="potongan_kopkar" required>
            <input type="hidden" name="nominal_rek" id="nominal_rek" required>
            <input type="hidden" name="nominal_lain" id="nominal_lain" required>
            <input type="hidden" name="nominal_prr_btn" id="nominal_prr_btn" required>
            <input type="hidden" name="nominal_btnsolo" id="nominal_btnsolo" required>
            <input type="hidden" name="nominal_koperasi" id="nominal_koperasi" required>
            <input type="hidden" name="ket_rek_rs" id="ket_rek_rs" required>
            <input type="hidden" name="ket_lain" id="ket_lain" required>
            <input type="hidden" name="ket_prr_btn" id="ket_prr_btn" required>
            <input type="hidden" name="ket_btn_solo" id="ket_btn_solo" required>
            <input type="hidden" name="ket_koperasi" id="ket_koperasi" required>
            <input type="hidden" name="jumlah_terima" id="jumlah_terima" required>
            <input type="hidden" name="titik_perubahan" id="titik_perubahan" required>

            <input type="hidden" name="nominal_ekstra" id="nominal_ekstra" required>
            <input type="hidden" name="ket_ekstra" id="ket_ekstra" required>
            <input type="hidden" name="jenis_ekstra" id="jenis_ekstra" required>

            <input type="hidden" name="nik" id="nik" required>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="generate_gaji()"><i class="fa fa-check"><b> Generate</b></i></button>

            </div>
        </div>
    </div>
</div>
</div>


<!-- generate personal -->

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-generate-gaji-personal">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: powderblue;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">

            <h4 style="text-align: center;" style="color: navy;">Apakah Anda Akan Generate Gaji ?</h4>

            <input type="hidden" name="tanggal" id="tanggal" required>
            <input type="hidden" name="nik" id="nik" required>
            <input type="hidden" name="jenis_gaji" id="jenis_gaji" required>

            <input type="hidden" name="periode" id="periode" required>
            <!-- <input type="hidden" name="thp_bulat" id="thp_bulat" required>
            <input type="hidden" name="potongan" id="potongan" required>
            <input type="hidden" name="transfer_bank" id="transfer_bank" required> -->

            <input type="hidden" name="gapok" id="gapok" required>
            <input type="hidden" name="tunjangan_khusus" id="tunjangan_khusus" required>
            <input type="hidden" name="tunjangan_struktural" id="tunjangan_struktural" required>
            <input type="hidden" name="penyesuaian" id="penyesuaian" required>
            <input type="hidden" name="tas" id="tas" required>
            <input type="hidden" name="maxgross" id="maxgross" required>
            <input type="hidden" name="dinas_malam" id="dinas_malam" required>
            <input type="hidden" name="lembur" id="lembur" required>
            <input type="hidden" name="rapel" id="rapel" required>
            <input type="hidden" name="insentif" id="insentif" required>
            <input type="hidden" name="gross" id="gross" required>
            <input type="hidden" name="potongan_jht" id="potongan_jht" required>
            <input type="hidden" name="jaminan_pensiun" id="jaminan_pensiun" required>
            <input type="hidden" name="bpjs_kesehatan" id="bpjs_kesehatan" required>
            <input type="hidden" name="sta" id="sta" required>
            <input type="hidden" name="pajak" id="pajak" required>
            <input type="hidden" name="thp_bulat" id="thp_bulat" required>
            <input type="hidden" name="potongan_kopkar" id="potongan_kopkar" required>
            <input type="hidden" name="nominal_rek" id="nominal_rek" required>
            <input type="hidden" name="nominal_lain" id="nominal_lain" required>
            <input type="hidden" name="nominal_prr_btn" id="nominal_prr_btn" required>
            <input type="hidden" name="nominal_btnsolo" id="nominal_btnsolo" required>
            <input type="hidden" name="nominal_koperasi" id="nominal_koperasi" required>
            <input type="hidden" name="ket_rek_rs" id="ket_rek_rs" required>
            <input type="hidden" name="ket_lain" id="ket_lain" required>
            <input type="hidden" name="ket_prr_btn" id="ket_prr_btn" required>
            <input type="hidden" name="ket_btn_solo" id="ket_btn_solo" required>
            <input type="hidden" name="ket_koperasi" id="ket_koperasi" required>
            <input type="hidden" name="jumlah_terima" id="jumlah_terima" required>
            <input type="hidden" name="titik_perubahan" id="titik_perubahan" required>

            <input type="hidden" name="nominal_ekstra" id="nominal_ekstra" required>
            <input type="hidden" name="ket_ekstra" id="ket_ekstra" required>
            <input type="hidden" name="jenis_ekstra" id="jenis_ekstra" required>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="generate_gaji_personal()"><i class="fa fa-check"><b> Generate</b></i></button>

            </div>
        </div>
    </div>
</div>
</div>


<!-- sudah digenerate -->

<!-- <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-sudah-generate-gaji">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">

            <h4 style="text-align: center; color: red;">Data Sudah Di Generate</h4>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
</div> -->