$('#mytabelpotongan').DataTable();
$('#mytabeldetail').DataTable();

$(document).ajaxStart(function(){
  $('#loading').show();
});

$(document).ajaxComplete(function(){
  $('#loading').hide();
});

$('#myDatepicker2').datetimepicker({
    format: 'MM/YYYY'
});
$('#myDatepickerYear').datetimepicker({
    format: 'YYYY'
});

//----------

getListMasterPotongan();



//------------

getListUploadFileGapok();

function getListUploadFileGapok() {
    $.ajax({
        url: base_url+"UploadGapok/getListUploadFile",
        type: "post",
        dataType: 'json',
        async: false,
        success: function(response) {
            //console.log(response);
            var tabel_upload_awal =

                '<table class="table table-bordered table-striped tabel-apps" id="mytabeluploadGapok">'+
                '<thead>'+
                    '<tr bgcolor="#4682B4">'+
                        '<th><font color="#ffffff">No</th>'+ 
                        '<th><font color="#ffffff">Tahun Berlaku</th>'+
                        '<th><font color="#ffffff">Keterangan</th>'+
                        '<th><font color="#ffffff">Creator</th>'+
                        '<th><font color="#ffffff">Editor</th>'+
                        '<th width="200px;"><font color="#ffffff">#</th>'+ 
                    '</tr>'+
                '</thead>'+
                '<tbody>';
            var no = 1;
            var tabel_upload_isi = "";

            //var excel = base_url+"Upload/lihatExcel";

            $.each(response.list_upload, function (index, data){

            tabel_upload_isi += '<tr>'+                       
                '<td>'+ no +'</td>'+   
                '<td>'+ data.th_berlaku +'</td>'+ 
                '<td>'+ data.v_keterangan+'</td>'+
                '<td>'+ data.dibuat_oleh +'</td>'+
                '<td>'+ data.last_editor  +'</td>'+
                '<td> <button type="button" class="btn btn-round btn-dark" onclick="modal_lihat_gapok('+data.n_gapok_header_id+')"><i class="fa fa-external-link"></i> Lihat</button>'+
                '<button type="button" class="btn btn-round btn-danger" onclick="hapus_fileGapok('+data.n_gapok_header_id+')"><i class="fa fa-trash-o"></i> Hapus</button>'+
                //'<a href="'+ excel +'" target="_blank"> <button type="button" class="btn btn-round btn-success"><i class="fa fa-external-link"></i> Excel</button></a></td>';                       
                '</tr>';
                no++;
            });
                                
            var tabel_upload_akhir='</tbody></table>';

            var hasil_tabel_upload = tabel_upload_awal+tabel_upload_isi+tabel_upload_akhir;

                $("#parent_tabel_uploadGapok").empty();                         
                $("#parent_tabel_uploadGapok").html(hasil_tabel_upload);
                $("#mytabeluploadGapok").DataTable();

        }

    });
}

function getListUploadGapok() {
    $.ajax({
        url: base_url+"UploadGapok/getListUploadFile",
        type: "post",
        dataType: 'json',
        async: false,
        success: function(response) {
            //console.log(response);
            var tabel_upload_awal =

                '<table class="table table-bordered table-striped tabel-apps" id="mytabeluploadGapok">'+
                '<thead>'+
                    '<tr bgcolor="#4682B4">'+
                        '<th><font color="#ffffff">No</th>'+ 
                        '<th><font color="#ffffff">Tahun Berlaku</th>'+
                        '<th><font color="#ffffff">Keterangan</th>'+
                        '<th><font color="#ffffff">Creator</th>'+
                        '<th><font color="#ffffff">Editor</th>'+
                        '<th width="200px;"><font color="#ffffff">#</th>'+ 
                    '</tr>'+
                '</thead>'+
                '<tbody>';
            var no = 1;
            var tabel_upload_isi = "";

            //var excel = base_url+"Upload/lihatExcel";

            $.each(response.list_upload, function (index, data){

            tabel_upload_isi += '<tr>'+                       
                '<td>'+ no +'</td>'+   
                '<td>'+ data.th_berlaku +'</td>'+ 
                '<td>'+ data.v_keterangan+'</td>'+
                '<td>'+ data.dibuat_oleh +'</td>'+
                '<td>'+ data.last_editor +'</td>'+
                '<td> <button type="button" class="btn btn-round btn-dark" onclick="modal_lihat_gapok('+data.n_upload_file_id+')"><i class="fa fa-external-link"></i> Lihat</button>'+
                '<button type="button" class="btn btn-round btn-danger" onclick="hapus_fileGapok('+data.n_upload_file_id+')"><i class="fa fa-trash-o"></i> Hapus</button>'+
                //'<a href="'+ excel +'" target="_blank"> <button type="button" class="btn btn-round btn-success"><i class="fa fa-external-link"></i> Excel</button></a></td>';                       
                '</tr>';
                no++;
            });
                                
            var tabel_upload_akhir='</tbody></table>';

            var hasil_tabel_upload = tabel_upload_awal+tabel_upload_isi+tabel_upload_akhir;

                $("#parent_tabel_uploadGapok").empty();                         
                $("#parent_tabel_uploadGapok").html(hasil_tabel_upload);
                $("#mytabeluploadGapok").DataTable();

        }

    });
}

 function modal_upload_file_gapok(){
    
     $('#modal-upload-file-Gapok').modal('show');

 }

function modal_lihat_gapok(n_header_id){
    
    $('#modal-detail-upload').modal('show');

    var parent_tabel_detail = '';
                            
    $.ajax({
        url: base_url+'UploadGapok/cari_detail',
        method: 'post',
        data: {
            n_header_id: n_header_id
        },
        dataType: 'json',
        async: false,
        success: function(response){
        console.log(response);
            parent_tabel_detail = '<table class="table table-bordered table-striped tabel-apps" id="mytabeldetail">'+
               '<thead>'+
               '<tr bgcolor="#3CB371">'+
                    '<th><font color="#ffffff">No</th>'+ 
                    '<th><font color="#ffffff">Golongan</th>'+
                    '<th><font color="#ffffff">Bulan Gaji</th>'+
                    '<th><font color="#ffffff">Gapok</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody id="parent_tabel_detail">';
            
            var no = 1;

            if(response){
                $.each(response, function (index, detail){

                    parent_tabel_detail += '<tr>' +
                                            '<td>'+ no +'</td>';

                    parent_tabel_detail += '<td>' + detail.golongan + '</td>'+
                                           '<td>' + detail.bulan_gapok + '</td>'+
                                           '<td align="right"> Rp. ' + numeral(detail.gapok).format('0,0') + '</td>';

                    parent_tabel_detail += '</tr>';
                    no++;
                });
            }
                                            
            parent_tabel_detail += '</tbody></table>';
            $('#parent_tabel_detailGapok').empty();
            $('#parent_tabel_detailGapok').html(parent_tabel_detail);
            $("#mytabeldetail").DataTable();
        }
    });
}

function hapus_fileGapok(n_header_id) {
    swal({
        title: "Apakah anda yakin ingin menghapus file ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#AF1000',
        cancelButtonColor: '#212F3C',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    },
    function(){
        $.ajax({
            url: base_url+"UploadGapok/hapusFile",
            type: "post",
            data: {
                'n_header_id': n_header_id
            },
            //async: false,
            success: function(data) {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil dihapus",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                getListUploadFileGapok();
            }
        });
    });
}
function getListEmployeeByUnit() {
    var id_unitrs=$('#unitrs_by_user_filter').val();
    $.ajax({
        url: base_url+"ProsesHitungGaji/getListEmployeeByUnitRs",
        method: 'post',
        data: {
            unitrs_id: id_unitrs
        },
        dataType: 'json',
        async: false,
        success: function(response) {
            //console.log(response);
            var tabel_upload_awal =

                '<table class="table table-bordered table-striped tabel-apps" id="mytabeluploadGapok">'+
                '<thead>'+
                    '<tr bgcolor="#4682B4">'+
                        '<th><font color="#ffffff">No</th>'+ 
                        '<th><font color="#ffffff">NIK</th>'+
                        '<th><font color="#ffffff">Nama</th>'+
                        '<th><font color="#ffffff">Golongan</th>'+
                        '<th><font color="#ffffff">Th Gapok</th>'+
                        '<th width="200px;"><font color="#ffffff">#</th>'+ 
                    '</tr>'+
                '</thead>'+
                '<tbody>';
            var no = 1;
            var tabel_upload_isi = "";

            //var excel = base_url+"Upload/lihatExcel";

            $.each(response.list_upload, function (index, data){

            tabel_upload_isi += '<tr>'+                       
                '<td>'+ no +'</td>'+   
                '<td>'+ data.v_nik +'</td>'+ 
                '<td>'+ data.v_employee_name+'</td>'+
                '<td>'+ data.nama_golongan +'</td>'+
                '<td>'+ data.d_tglditerima +'</td>'+
                '<td> <button type="button" class="btn btn-round btn-dark" onclick="modal_lihat_gapok('+data.n_upload_file_id+')"><i class="fa fa-external-link"></i> Lihat</button>'+
                '<button type="button" class="btn btn-round btn-danger" onclick="hapus_fileGapok('+data.n_upload_file_id+')"><i class="fa fa-trash-o"></i> Hapus</button>'+
                //'<a href="'+ excel +'" target="_blank"> <button type="button" class="btn btn-round btn-success"><i class="fa fa-external-link"></i> Excel</button></a></td>';                       
                '</tr>';
                no++;
            });
                                
            var tabel_upload_akhir='</tbody></table>';

            var hasil_tabel_upload = tabel_upload_awal+tabel_upload_isi+tabel_upload_akhir;

                $("#parent_tabel_list_employee").empty();                         
                $("#parent_tabel_list_employee").html(hasil_tabel_upload);
                $("#mytabellist_employee").DataTable();

        }

    });
}