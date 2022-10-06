<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Upload Master Gapok</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table width="100%">
                    <td width="50%">
                        <button type="button" class="btn btn-round btn-info" id="upload_file" onclick="modal_upload_file_gapok()"><i class="fa fa-cloud-upload"></i> Upload Gapok</button>
                    </td>
                    <td width="50%" style="text-align: right;">
                        <a href="<?php echo base_url();?>file/TemplateGapok.xlsx">
                        <!-- <img src="<?php echo base_url();?>assets/images/Excel.png" width="40" height="40" title="Template" target="_blank"> -->
                        <button type="button" class="btn btn-round btn-success"><i class="fa fa-cloud-download"></i> Download Template</button></a>
                    </td>
                </table>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h4>Master Gapok</h4>
                <div class="clearfix"></div>
            </div>
            <div id="parent_tabel_uploadGapok"></div>
        </div>
    </div>
</div>

<!-- modal upload -->

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-upload-file-Gapok">
<div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Upload Master Gaji Pokok</h4>
        </div>
            <br>
            <!-- form mulai -->
            <form action="<?php echo base_url();?>UploadGapok/uploadMasterGapok/" method="post" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulantahun_tambah" style="color: black;">Periode <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <!-- <input type="text" id="bulantahun_tambah" required="required" class="form-control col-md-7 col-xs-12"> -->
                    <div class="form-group">
                        <div class='input-group date' id='myDatepickerYear'>
                            <input type='text' id="tahun_berlaku" name="tahun_berlaku" class="form-control" />
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bulantahun_tambah" style="color: black;">Keterangan
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <!-- <input type="text" id="bulantahun_tambah" required="required" class="form-control col-md-7 col-xs-12"> -->
                    <div class="form-group">
                        <textarea id="text_keterangan" name="text_keterangan" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <br><br><br>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="upload" style="color: black;">Upload File <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="file" name="file">
                </div>
            </div>

            <br><br><br>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="control-label col-md-8 col-sm-8 col-xs-12" style="color: red;">Silahkan upload file max. 2 Mb dengan tipe .xlsx
                </label>
            </div>

            <br><br>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload"> Upload</i></button>
            </div>
                    </form> <!-- tutup form -->
        </div>
    </div>

</div>
</div>

<!-- ----- -->

<!-- modal detail -->

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-detail-upload">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Detail</h4>
        </div>
        <div class="modal-body">

            <div id="parent_tabel_detailGapok"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
</div>