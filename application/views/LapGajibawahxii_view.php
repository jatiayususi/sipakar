<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="">
            <div class="x_panel">
                <div class="x_title">
                    <p style="font-family: Merriweather, serif; font-size: 25px; ">Laporan Gaji Pergolongan</p>
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
                            <button type='button' class='btn btn-primary' onclick="button_filter_laporan_gaji_bawah13()"><i class="fa fa-search"></i></button>&emsp;
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
                                        <div id="tabel_LapGajiPerGolongan">
                                        </div>
                                    </div>

                                    <div id="tabel_datagajikaryawan">
                                        <div id="pemberitahuan">
                                            <b>SILAHKAN PILIH PERIODE GAJI</b>
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






