<div class="x_title">
    <h2>Pengolahan Gaji Karyawan</h2>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

             <div class="">
              <div class="col-md-6 col-sm-6  ">
                <div class="x_panel">
                  <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulantahun_tambah" style="color: black;">Unit <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                    <select class="form-control " data-live-search="true" id="unit_by_user_filter" name="unit_by_user_filter">
                        <option selected disabled>-- Pilih --</option>
                        <?php if($list_unitrs):?>
                        <?php foreach($list_unitrs as $unit):?>
                        <option value="<?php echo $unit['n_unitrsid']; ?>"><?php echo $unit['v_unitrsnama']; ?></option>
                        <?php endforeach;?>
                        <?php endif;?>
                    </select>
                    
                    </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulantahun_tambah" style="color: black;">Periode Gaji <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                    <!-- <input type="text" id="bulantahun_tambah" required="required" class="form-control col-md-7 col-xs-12"> -->
                      <div class="form-group">
                        <div class='input-group date' id='myDatepicker2'>
                            <input type='text' id="bulantahun_gaji" name="bulantahun_gaji" class="form-control" />
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <button type='button' class='btn btn-primary' onclick="button_filter_unit()"><i class="fa fa-search"></i></button>&emsp;
                    </div>
                    <div>
                        <div id="tabel_unit">
                            <div id="pemberitahuan_input_unit">
                            </div>
                        </div>

                        <div id="tabel_karyawan">
                            <div id="pemberitahuan_input_unit" ></div>
                        </div>
                    </div>

                  </div>
                </div>
              </div>


              <div class="col-md-6 col-sm-6  ">
                <div class="x_panel">

                  <div class="x_content">

                    <ul class="nav nav-tabs justify-content-end bar_tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="profil-tab" data-toggle="tab" href="#profil" role="tab" aria-controls="profil" aria-selected="true">Profil</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" id="riwayat-tab" data-toggle="tab" href="#profil" role="tab" aria-controls="profil" aria-selected="true">Riwayat Gaji</a>
                      </li>
                    </ul>
                    
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="profil" role="tabpanel" aria-labelledby="profil-tab">

                        <div id="pemberitahuan_input_karyawan" align="center">
                            <span><b>--- SILAHKAN KLIK BARIS YANG DI PILIH ---</b></span>
                        </div>
                            
                        <div id="parent_tabel_profil"></div>

                      </div>
                    </div>

                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">

                        <div id="pemberitahuan_input_karyawan" align="center">
                            <span><b>--- SILAHKAN KLIK BARIS YANG DI PILIH ---</b></span>
                        </div>
                            
                        <div id="parent_tabel_profil"></div>

                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>

    </div>
</div>