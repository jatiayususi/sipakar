<div class="x_title">
    <h2>Data Karyawan</h2>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

             <div class="">
              <div class="col-md-6 col-sm-6  ">
                <div class="x_panel">
                  <div class="x_content">

                    <div class="col-sm-10">

                    <select class="form-control" data-live-search="true" id="unit_by_user_filter" name="unit_by_user_filter">
                        <option selected disabled>-- Pilih --</option>
                        <?php if($list_unitrs):?>
                        <?php foreach($list_unitrs as $unit):?>
                        <option value="<?php echo $unit['n_unitrsid']; ?>"><?php echo $unit['v_unitrsnama']; ?></option>
                        <?php endforeach;?>
                        <?php endif;?>
                    </select>

                    </div>

                    <div class="col-sm-2">
                    
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
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="profil" role="tabpanel" aria-labelledby="profil-tab">

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