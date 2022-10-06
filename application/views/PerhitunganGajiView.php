<section class="content">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h3 class="font-bold col-blue-grey" align="left"></i>Perhitungan Gaji</h3>
                </div>
                <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control selectpicker show-tick" data-live-search="true" name="unitrs_by_user_filter" id="unitrs_by_user_filter" required>
                                            <option selected disabled>-- Pilih Unit RS --</option>
                                                    <?php
                                               if ($list_unitrs_cari) {
                                                   foreach ($list_unitrs_cari as $unitrs) {
                                           ?>
                                            <option value="<?php echo $unitrs['n_unitrsid']; ?>"><?php echo $unitrs['v_unitrsnama']; ?></option>
                                           <?php
                                               }
                                           }
                                           ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <button type='button' class='btn btn-info btn-sm m-l-15 waves-effect' id="button_filter" onclick="getListEmployeeByUnit()"><i class="material-icons">search</i> Cari Data</button>&emsp;
                                
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="body">              
                    <div class="x_panel">
                        <div class="x_title">
                            <h4>Daftar Karyawan</h4>
                            <div class="clearfix"></div>
                        </div>
                        <div id="parent_tabel_list_employee"></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>


