<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="">
            <div class="x_panel">
                <div class="x_title">
                    <p style="font-family: Merriweather, serif; font-size: 25px; ">Laporan Gaji Perbagian (Golongan I-XII) </p>
                </div>


                <div class="x_content">
                    <div class="col-md-12">

                        <div class="col-md-5">
                            <div class="form-group" style="color: black;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="periodeXIIBawah" style="text-align: left;">Periode<span class="required" style="color: red;"> (*)</span>
                                </label>

                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <div class='input-group date' id='myDatepicker2'>
                                        <input type='text' id="periodeXIIBawah" name="periodeXIIBawah" class="form-control" />
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group" style="color: black;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisgajiXIIIBawah" style="text-align: left;">Jenis Gaji<span class="required" style="color: red;"> (*)</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control" data-live-search="true" id="jenisgajiXIIIBawah" name="jenisgajiXIIIBawah">
                                        <option value="1">Gaji</option>
                                        <option value="2">Non Gaji</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-1">
                            <button type='button' class='btn btn-primary' onclick="button_filter_lapGajiPerunitGolXIIBawah()"><i class="fa fa-search"></i></button>&emsp;
                        </div>
 
                    </div>

                </div>

            </div>



            <div class="x_panel">
                <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_content">
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <div id="tabel_periode">
                                        <div id="tb_coba"></div>
                                        <div id="tabel_detailXIIBawah">
                                        </div>
                                    </div>

                                    <div id="tabel_datagajikaryawan">
                                        <div id="pemberitahuan">
                                            <b>SILAHKAN PILIH BAGIAN DAN PERIODE GAJI</b>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>






