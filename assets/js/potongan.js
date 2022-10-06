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

//----------

getListMasterPotongan();

function getListMasterPotongan() {
    $.ajax({
        url: base_url+"MasterPotongan/getListMasterPotongan",
        type: "post",
        dataType: 'json',
        async: false,
        success: function(response) {
            //console.log(response);
            var tabel_master_awal =

                '<table class="table table-bordered table-striped tabel-apps" id="mytabelpotongan">'+
                '<thead>'+
                    '<tr bgcolor="#4682B4">'+
                        '<th><font color="#ffffff">No</th>'+ 
                        '<th><font color="#ffffff">Nama Potongan</th>'+
                        '<th width="150px;"><font color="#ffffff">Edit</th>'+ 
                    '</tr>'+
                '</thead>'+
                '<tbody>';
            var no = 1;
            var tabel_master_isi = "";
            $.each(response.list, function (index, data){

            tabel_master_isi+='<tr>'+                       
                            '<td>'+ no +'</td>'+   
                            '<td>'+ data.v_nama_potongan +'</td>'+   
                            '<td> <button type="button" class="btn btn-success" onclick="edit_modal_master_potongan('+data.n_potongan_id+')"><i class="fa fa-edit"></i> Edit</button></td>';                       
                            '</tr>';
            no++;
            });
                                
            var tabel_master_akhir='</tbody>'+
                '</table>';
            var hasil_tabel_master = tabel_master_awal+tabel_master_isi+tabel_master_akhir;

                $("#parent_tabel_master_potongan").empty();                         
                $("#parent_tabel_master_potongan").html(hasil_tabel_master);
                $("#mytabelpotongan").DataTable();

        }

    });
}

function tambah_modal_master_potongan(){ 
    $("#namapotongan_tambah").val('');
            
    $('#modal-tambah-master-potongan').modal('show');
          
}

function tambah_potongan() {
    $('#modal-tambah-master-potongan').modal('hide');
    var v_nama_potongan = $("#namapotongan_tambah").val();
    var v_group = $("#group_variable").val();

    var group_tambahan='-';
    var group_pengurang='-';

    var cek=v_group.substring(0, 1);

    if(cek=='t'){
        group_tambahan=v_group.substring(2);
    }else{
        group_pengurang=v_group.substring(2);
    }

    $.ajax({
        url: base_url+"MasterPotongan/insert",//controller
        type: "post",
        data: {
            'v_nama_potongan': v_nama_potongan,
            'group_tambahan':group_tambahan,
            'group_pengurang':group_pengurang
        },
        dataType: 'json',
        async: false,
        success: function(data) {
            console.log(data);
            if (data) {

                    swal({   
                        title: "Sukses!",
                        text: "Data anda berhasil ditambahkan",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "success",
                    });

                    var desc = "Berhasil Insert Master Potongan. nama potongan : "+v_nama_potongan;
                    insert_log(desc);
                    getListMasterPotongan();

            }else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal ditambahkan, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
                    var desc = "Gagal Insert Master Potongan. nama potongan : "+v_nama_potongan;
                    insert_log(desc);
                }
        }
    });
}

function edit_modal_master_potongan(n_potongan_id){
    $.ajax({
        url: base_url+'MasterPotongan/cari_potongan_by_id',
        method: 'post',
        data: {
            n_potongan_id: n_potongan_id
        },
        dataType: 'json',
        async: false,
        success: function(response){
            $("#namapotongan_edit").val('');

            $("#idpotongan_edit").val(n_potongan_id);
            $("#namapotongan_edit").val(response.response.v_nama_potongan);
        }
    });

    $('#modal-edit-master-potongan').modal('show');
}

function edit_master_potongan(){
    $('#modal-edit-master-potongan').modal('hide');

    var n_potongan_id   = $("#idpotongan_edit").val();
    var v_nama_potongan = $("#namapotongan_edit").val();

    $.ajax({
        url: base_url+"MasterPotongan/Update",
        type: "post",
        data: {
            'n_potongan_id': n_potongan_id,
            'v_nama_potongan': v_nama_potongan
        },

        success: function(data) {
            if (v_nama_potongan != "") {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                var desc = "Berhasil Update Master Potongan. n_potongan_id :"+n_potongan_id;
                insert_log(desc);
                getListMasterPotongan();
                } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
                    var desc = "Gagal Update Master Potongan. n_potongan_id : "+n_potongan_id;
                    insert_log(desc);
                }
        }
    });
}

//------------ XIII Atas

getListUploadFileAtasXIII();

function getListUploadFileAtasXIII() {
    $.ajax({
        url: base_url+"Upload/getListUploadFileAtasXIII",
        type: "post",
        dataType: 'json',
        async: false,
        success: function(response) {
            //console.log(response);
            var tabel_upload_awal =

                '<table class="table table-bordered table-striped tabel-apps" id="mytabelupload">'+
                '<thead>'+
                    '<tr bgcolor="#4682B4">'+
                        '<th><font color="#ffffff">No</th>'+ 
                        '<th><font color="#ffffff">Nama File</th>'+
                        //'<th><font color="#ffffff">Potongan</th>'+
                        '<th><font color="#ffffff">Jenis Gaji</th>'+
                        '<th><font color="#ffffff">Periode</th>'+
                        '<th width="200px;"><font color="#ffffff">#</th>'+ 
                    '</tr>'+
                '</thead>'+
                '<tbody>';
            var no = 1;
            var tabel_upload_isi = "";

            $.each(response.list_upload, function (index, data){

            var jenis_gaji = '';
            if(data.jenis == 1){
                jenis_gaji = 'Gaji';
            }else{
                jenis_gaji = 'Non Gaji';
            }

            tabel_upload_isi += '<tr>'+                       
                '<td>'+ no +'</td>'+   
                '<td>'+ data.v_nama_file +'</td>'+ 
                //'<td>'+ data.v_nama_potongan +'</td>'+
                '<td>'+ jenis_gaji +'</td>'+
                '<td>'+ data.n_bulan + '/' + data.n_tahun +'</td>'+
                '<td> <button type="button" class="btn btn-dark" onclick="modal_lihat_file('+data.n_upload_file_id+')"><i class="fa fa-external-link"></i> Lihat</button>'+
                '<button type="button" class="btn btn-danger" onclick="hapus_file('+data.n_upload_file_id+')"><i class="fa fa-trash-o"></i> Hapus</button>'+                     
                '</tr>';
                no++;
            });
                                
            var tabel_upload_akhir='</tbody></table>';

            var hasil_tabel_upload = tabel_upload_awal+tabel_upload_isi+tabel_upload_akhir;

                $("#parent_tabel_upload_atasxiii").empty();                         
                $("#parent_tabel_upload_atasxiii").html(hasil_tabel_upload);
                $("#mytabelupload").DataTable();

        }

    });
}


//------------------ I - XII

getListUploadFileBawahXIII();

function getListUploadFileBawahXIII() {
    $.ajax({
        url: base_url+"Upload/getListUploadFileBawahXIII",
        type: "post",
        dataType: 'json',
        async: false,
        success: function(response) {
            //console.log(response);
            var tabel_upload_awal =

                '<table class="table table-bordered table-striped tabel-apps" id="mytabelupload">'+
                '<thead>'+
                    '<tr bgcolor="#4682B4">'+
                        '<th><font color="#ffffff">No</th>'+ 
                        '<th><font color="#ffffff">Nama File</th>'+
                        //'<th><font color="#ffffff">Potongan</th>'+
                        '<th><font color="#ffffff">Jenis Gaji</th>'+
                        '<th><font color="#ffffff">Periode</th>'+
                        '<th width="200px;"><font color="#ffffff">#</th>'+ 
                    '</tr>'+
                '</thead>'+
                '<tbody>';
            var no = 1;
            var tabel_upload_isi = "";

            $.each(response.list_upload, function (index, data){

            var jenis_gaji = '';
            if(data.jenis == 1){
                jenis_gaji = 'Gaji';
            }else{
                jenis_gaji = 'Non Gaji';
            }

            var golongan = 1;

            tabel_upload_isi += '<tr>'+                       
                '<td>'+ no +'</td>'+   
                '<td>'+ data.v_nama_file +'</td>'+ 
                //'<td>'+ data.v_nama_potongan +'</td>'+
                '<td>'+ jenis_gaji +'</td>'+
                '<td>'+ data.n_bulan + '/' + data.n_tahun +'</td>'+
                '<td> <button type="button" class="btn btn-dark" onclick="modal_lihat_file('+data.n_upload_file_id+')"><i class="fa fa-external-link"></i> Lihat</button>'+
                '<button type="button" class="btn btn-danger" onclick="hapus_file('+data.n_upload_file_id+')"><i class="fa fa-trash-o"></i> Hapus</button>'+                     
                //'<button type="button" class="btn btn-round btn-danger" onclick="hapus_file('+data.n_upload_file_id+','+data.n_potongan_id+','+data.n_bulan+','+data.n_tahun+','+golongan+')"><i class="fa fa-trash-o"></i> Hapus</button>'+                     
                '</tr>';
                no++;
            });
                                
            var tabel_upload_akhir='</tbody></table>';

            var hasil_tabel_upload = tabel_upload_awal+tabel_upload_isi+tabel_upload_akhir;

                $("#parent_tabel_upload_bawahxiii").empty();                         
                $("#parent_tabel_upload_bawahxiii").html(hasil_tabel_upload);
                $("#mytabelupload").DataTable();

        }

    });
}


//---action

function modal_upload_file(){
    
    $('#modal-upload-file').modal('show');

}

function modal_lihat_file(n_upload_file_id){
    
    $('#modal-detail-upload').modal('show');

    var parent_tabel_detail = '';
                            
    $.ajax({
        url: base_url+'Upload/cari_detail',
        method: 'post',
        data: {
            n_upload_file_id: n_upload_file_id
        },
        dataType: 'json',
        async: false,
        success: function(response){
        
            parent_tabel_detail = '<table class="table table-bordered table-striped tabel-apps" id="mytabeldetail">'+
               '<thead>'+
               '<tr bgcolor="#3CB371">'+
                    '<th><font color="#ffffff">No</th>'+ 
                    '<th><font color="#ffffff">UNIT</th>'+
                    '<th><font color="#ffffff">NIK</th>'+
                    '<th><font color="#ffffff">NAMA</th>'+
                    '<th><font color="#ffffff">JML TERIMA</th>'+
                    '<th><font color="#ffffff">EDIT</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody id="parent_tabel_detail">';
            
            var no = 1;

            if(response){
                $.each(response, function (index, detail){

                    parent_tabel_detail += '<tr>' +
                                            '<td>'+ no +'</td>';

                    parent_tabel_detail += '<td>' + detail.v_unitrsnama + '</td>'+
                                           '<td>' + detail.v_nik + '</td>'+
                                           '<td>' + detail.v_employee_name + '</td>'+
                                           '<td align="right"> Rp. ' + numeral(detail.jumlah_terima).format('0,0') + '</td>'+
                                           '<td> <button type="button" class="btn btn-warning" onclick="modal_edit_isi_file('+detail.n_isi_file_id+')"><i class="fa fa-edit"></i></button> </td>';

                    parent_tabel_detail += '</tr>';
                    no++;
                });
            }
                                            
            parent_tabel_detail += '</tbody></table>';

            $('#parent_tabel_detail').html(parent_tabel_detail);
            $("#mytabeldetail").DataTable();

            var desc = "Berhasil Melihat File Upload. n_upload_file_id : "+n_upload_file_id;
            insert_log(desc);
        }
    });
}

function modal_lihat_fileXIIIAtas(n_upload_file_id){
    
    $('#modal-detail-upload-xiii-keatas').modal('show');

    var parent_tabel_detail = '';
                            
    $.ajax({
        url: base_url+'Upload/cari_detail',
        method: 'post',
        data: {
            n_upload_file_id: n_upload_file_id
        },
        dataType: 'json',
        async: false,
        success: function(response){
        
            parent_tabel_detail = '<table class="table table-bordered table-striped tabel-apps" id="mytabeldetail">'+
               '<thead>'+
               '<tr bgcolor="#3CB371">'+
                    '<th><font color="#ffffff">No</th>'+ 
                    '<th><font color="#ffffff">UNIT</th>'+
                    '<th><font color="#ffffff">NIK</th>'+
                    '<th><font color="#ffffff">NAMA</th>'+
                    '<th><font color="#ffffff">JML TERIMA</th>'+
                    '<th><font color="#ffffff">EDIT</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody id="parent_tabel_detail">';
            
            var no = 1;

            if(response){
                $.each(response, function (index, detail){

                    parent_tabel_detail += '<tr>' +
                                            '<td>'+ no +'</td>';

                    parent_tabel_detail += '<td>' + detail.v_unitrsnama + '</td>'+
                                           '<td>' + detail.v_nik + '</td>'+
                                           '<td>' + detail.v_employee_name + '</td>'+
                                           '<td align="right"> Rp. ' + numeral(detail.jumlah_terima).format('0,0') + '</td>'+
                                           '<td> <button type="button" class="btn btn-warning" onclick="modal_edit_isi_fileXIIIAtas('+detail.n_isi_file_id+')"><i class="fa fa-edit"></i></button> </td>';

                    parent_tabel_detail += '</tr>';
                    no++;
                });
            }
                                            
            parent_tabel_detail += '</tbody></table>';

            $('#parent_tabel_detail').html(parent_tabel_detail);
            $("#mytabeldetail").DataTable();

            var desc = "Berhasil Melihat File Upload. n_upload_file_id : "+n_upload_file_id;
            insert_log(desc);
        }
    });
}

function hapus_file(n_upload_file_id) {

    $.ajax({
        url: base_url+"Upload/getCekGenerateFile",
        type: "post",
        data: {
            'n_upload_file_id': n_upload_file_id
        },
        //async: false,
        success: function(data) {

            if(data == "kosong"){
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
                        url: base_url+"Upload/hapusFile",
                        type: "post",
                        data: {
                            'n_upload_file_id': n_upload_file_id
                        },
                        //async: false,
                        success: function(data) {
                            //console.log(data);
                            swal({   
                                title: "Sukses!",
                                text: "Data anda berhasil dihapus",
                                timer: 1500,
                                showConfirmButton: false,
                                type: "success",
                            });

                            var desc = "Berhasil Menghapus File Upload. n_upload_file_id : "+n_upload_file_id;
                            insert_log(desc);
                            //getListUploadFile();
                            window.location.reload();
                        }
                    });
                });
            }else{
                swal({
                    title: "Perhatian!",
                    text: "Data Sudah Di Generate ! Tidak Bisa Di Hapus!",
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#3085d6',
                    type: "warning",
                });
            }
        }
    });
}

function modal_edit_isi_file(n_isi_file_id){

    $.ajax({
        url: base_url+'Upload/cari_gaji_generate_by_id',
        method: 'post',
        data: {
            n_isi_file_id: n_isi_file_id
        },
        dataType: 'json',
        async: false,
        success: function(response){

            if(response){
                swal({
                    title: "Data Sudah Ada Pada Slip Gaji Karyawan. Yakin akan Mengubah?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#AF1000',
                    cancelButtonColor: '#212F3C',
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal'
                },
                function(){
                    $.ajax({
                        url: base_url+'Upload/cari_isi_file_by_id',
                        method: 'post',
                        data: {
                            n_isi_file_id: n_isi_file_id
                        },
                        dataType: 'json',
                        async: false,
                        success: function(response){

                            $("#nik_edit").val('');
                            //$("#nominal_edit").val('');
                            $("#gapok_edit").val('');
                            $("#tunj_khusus_edit").val('');
                            $("#tunj_struktural_edit").val('');
                            $("#penyesuaian_edit").val('');
                            $("#tas_edit").val('');
                            $("#max_gross_edit").val('');
                            $("#dinas_malam_edit").val('');
                            $("#lembur_edit").val('');
                            $("#rapel_edit").val('');
                            $("#insentif_edit").val('');
                            $("#gross_edit").val('');
                            $("#potongan_jht_edit").val('');
                            $("#jaminan_pensiun_edit").val('');
                            $("#bpjs_kesehatan_edit").val('');
                            $("#sta_edit").val('');
                            $("#pajak_edit").val('');
                            $("#thp_bulat_edit").val('');
                            $("#pot_kopkar_edit").val('');
                            $("#nom_rek_edit").val('');
                            $("#nom_lain_edit").val('');
                            $("#nom_prr_btn_edit").val('');
                            $("#nom_btn_solo_edit").val('');
                            $("#nom_koperasi_edit").val('');
                            $("#ket_rek_rs_edit").val('');
                            $("#ket_lain_edit").val('');
                            $("#ket_prr_btn_edit").val('');
                            $("#ket_btn_solo_edit").val('');
                            $("#ket_koperasi_edit").val('');
                            $("#jml_terima_edit").val('');
                            $("#titik_perubahan_edit").val('');
                            $("#nom_ekstra_edit").val('');
                            $("#ket_ekstra_edit").val('');
                            $("#jenis_ekstra_edit").val('');

                            $("#id_isi_file_edit").val(n_isi_file_id);
                            $("#nama_edit").val(response.response.v_employee_name);
                            //$("#potongan_edit").val(response.response.v_nama_potongan);
                            $("#id_upload_file_edit").val(response.response.n_upload_file_id);
                            $("#nik_edit").val(response.response.v_nik);
                            //$("#nominal_edit").val(response.response.v_nominal);
                            $("#gapok_edit").val(response.response.gapok);
                            $("#tunj_khusus_edit").val(response.response.tunjangan_khusus);
                            $("#tunj_struktural_edit").val(response.response.tunjangan_struktural);
                            $("#penyesuaian_edit").val(response.response.penyesuaian);
                            $("#tas_edit").val(response.response.tas);
                            $("#max_gross_edit").val(response.response.maxgross);
                            $("#dinas_malam_edit").val(response.response.dinas_malam);
                            $("#lembur_edit").val(response.response.lembur);
                            $("#rapel_edit").val(response.response.rapel);
                            $("#insentif_edit").val(response.response.insentif);
                            $("#gross_edit").val(response.response.gross);
                            $("#potongan_jht_edit").val(response.response.potongan_jht);
                            $("#jaminan_pensiun_edit").val(response.response.jaminan_pensiun);
                            $("#bpjs_kesehatan_edit").val(response.response.bpjs_kesehatan);
                            $("#sta_edit").val(response.response.sta);
                            $("#pajak_edit").val(response.response.pajak);
                            $("#thp_bulat_edit").val(response.response.thp_bulat);
                            $("#pot_kopkar_edit").val(response.response.potongan_kopkar);
                            $("#nom_rek_edit").val(response.response.nominal_rek);
                            $("#nom_lain_edit").val(response.response.nominal_lain);
                            $("#nom_prr_btn_edit").val(response.response.nominal_prr_btn);
                            $("#nom_btn_solo_edit").val(response.response.nominal_btnsolo);
                            $("#nom_koperasi_edit").val(response.response.nominal_koperasi);
                            $("#ket_rek_rs_edit").val(response.response.ket_rek_rs);
                            $("#ket_lain_edit").val(response.response.ket_lain);
                            $("#ket_prr_btn_edit").val(response.response.ket_prr_btn);
                            $("#ket_btn_solo_edit").val(response.response.ket_btn_solo);
                            $("#ket_koperasi_edit").val(response.response.ket_koperasi);
                            $("#jml_terima_edit").val(response.response.jumlah_terima);
                            $("#titik_perubahan_edit").val(response.response.titik_perubahan);
                            $("#nom_ekstra_edit").val(response.response.nominal_ekstra);
                            $("#ket_ekstra_edit").val(response.response.ket_ekstra);
                            $("#jenis_ekstra_edit").val(response.response.jenis_ekstra);
                        }
                    });

                    $('#modal-detail-upload').modal('hide');
                    $('#modal-edit-data-upload').modal('show');
                });

            }else{

                $.ajax({
                    url: base_url+'Upload/cari_isi_file_by_id',
                    method: 'post',
                    data: {
                        n_isi_file_id: n_isi_file_id
                    },
                    dataType: 'json',
                    async: false,
                    success: function(response){

                        console.log(response);

                            $("#nik_edit").val('');
                            //$("#nominal_edit").val('');
                            $("#gapok_edit").val('');
                            $("#tunj_khusus_edit").val('');
                            $("#tunj_struktural_edit").val('');
                            $("#penyesuaian_edit").val('');
                            $("#tas_edit").val('');
                            $("#max_gross_edit").val('');
                            $("#dinas_malam_edit").val('');
                            $("#lembur_edit").val('');
                            $("#rapel_edit").val('');
                            $("#insentif_edit").val('');
                            $("#gross_edit").val('');
                            $("#potongan_jht_edit").val('');
                            $("#jaminan_pensiun_edit").val('');
                            $("#bpjs_kesehatan_edit").val('');
                            $("#sta_edit").val('');
                            $("#pajak_edit").val('');
                            $("#thp_bulat_edit").val('');
                            $("#pot_kopkar_edit").val('');
                            $("#nom_rek_edit").val('');
                            $("#nom_lain_edit").val('');
                            $("#nom_prr_btn_edit").val('');
                            $("#nom_btn_solo_edit").val('');
                            $("#nom_koperasi_edit").val('');
                            $("#ket_rek_rs_edit").val('');
                            $("#ket_lain_edit").val('');
                            $("#ket_prr_btn_edit").val('');
                            $("#ket_btn_solo_edit").val('');
                            $("#ket_koperasi_edit").val('');
                            $("#jml_terima_edit").val('');
                            $("#titik_perubahan_edit").val('');
                            $("#nom_ekstra_edit").val('');
                            $("#ket_ekstra_edit").val('');
                            $("#jenis_ekstra_edit").val('');

                            $("#id_isi_file_edit").val(n_isi_file_id);
                            $("#nama_edit").val(response.response.v_employee_name);
                            //$("#potongan_edit").val(response.response.v_nama_potongan);
                            $("#id_upload_file_edit").val(response.response.n_upload_file_id);
                            $("#nik_edit").val(response.response.v_nik);
                            //$("#nominal_edit").val(response.response.v_nominal);
                            $("#gapok_edit").val(response.response.gapok);
                            $("#tunj_khusus_edit").val(response.response.tunjangan_khusus);
                            $("#tunj_struktural_edit").val(response.response.tunjangan_struktural);
                            $("#penyesuaian_edit").val(response.response.penyesuaian);
                            $("#tas_edit").val(response.response.tas);
                            $("#max_gross_edit").val(response.response.maxgross);
                            $("#dinas_malam_edit").val(response.response.dinas_malam);
                            $("#lembur_edit").val(response.response.lembur);
                            $("#rapel_edit").val(response.response.rapel);
                            $("#insentif_edit").val(response.response.insentif);
                            $("#gross_edit").val(response.response.gross);
                            $("#potongan_jht_edit").val(response.response.potongan_jht);
                            $("#jaminan_pensiun_edit").val(response.response.jaminan_pensiun);
                            $("#bpjs_kesehatan_edit").val(response.response.bpjs_kesehatan);
                            $("#sta_edit").val(response.response.sta);
                            $("#pajak_edit").val(response.response.pajak);
                            $("#thp_bulat_edit").val(response.response.thp_bulat);
                            $("#pot_kopkar_edit").val(response.response.potongan_kopkar);
                            $("#nom_rek_edit").val(response.response.nominal_rek);
                            $("#nom_lain_edit").val(response.response.nominal_lain);
                            $("#nom_prr_btn_edit").val(response.response.nominal_prr_btn);
                            $("#nom_btn_solo_edit").val(response.response.nominal_btnsolo);
                            $("#nom_koperasi_edit").val(response.response.nominal_koperasi);
                            $("#ket_rek_rs_edit").val(response.response.ket_rek_rs);
                            $("#ket_lain_edit").val(response.response.ket_lain);
                            $("#ket_prr_btn_edit").val(response.response.ket_prr_btn);
                            $("#ket_btn_solo_edit").val(response.response.ket_btn_solo);
                            $("#ket_koperasi_edit").val(response.response.ket_koperasi);
                            $("#jml_terima_edit").val(response.response.jumlah_terima);
                            $("#titik_perubahan_edit").val(response.response.titik_perubahan);
                            $("#nom_ekstra_edit").val(response.response.nominal_ekstra);
                            $("#ket_ekstra_edit").val(response.response.ket_ekstra);
                            $("#jenis_ekstra_edit").val(response.response.jenis_ekstra);
                    }
                });

                $('#modal-detail-upload').modal('hide');
                $('#modal-edit-data-upload').modal('show');
            }
        }
    });

}

//XIII keatas
function modal_edit_isi_fileXIIIAtas(n_isi_file_id){

    $.ajax({
        url: base_url+'Upload/cari_gaji_generate_by_id',
        method: 'post',
        data: {
            n_isi_file_id: n_isi_file_id
        },
        dataType: 'json',
        async: false,
        success: function(response){

            if(response){
                swal({
                    title: "Data Sudah Ada Pada Slip Gaji Karyawan. Yakin akan Mengubah?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#AF1000',
                    cancelButtonColor: '#212F3C',
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal'
                },
                function(){
                    $.ajax({
                        url: base_url+'Upload/cari_isi_file_by_id',
                        method: 'post',
                        data: {
                            n_isi_file_id: n_isi_file_id
                        },
                        dataType: 'json',
                        async: false,
                        success: function(response){

                            $("#nik_edit").val('');
                            //$("#nominal_edit").val('');
                            $("#gapok_edit").val('');
                            $("#rapel_edit").val('');
                            $("#pot_rs_edit").val('');
                            $("#tunj_khusus_edit").val('');
                            $("#insentif_edit").val('');
                            $("#pot_koperasi_edit").val('');
                            $("#tunj_struktural_edit").val('');
                            $("#potongan_jht_edit").val('');
                            $("#pot_btn_edit").val('');
                            $("#tas_edit").val('');
                            $("#jaminan_pensiun_edit").val('');
                            $("#tunai_edit").val('');
                            $("#penyesuaian_edit").val('');
                            $("#pot_jkn_edit").val('');
                            $("#jml_potongan_edit").val('');
                            $("#gross_edit").val('');
                            $("#status_edit").val('');
                            $("#max_gross_edit").val('');
                            $("#pajak_edit").val('');
                            $("#jml_terima_edit").val('');
                            $("#honor_edit").val('');
                            $("#thr_edit").val('');
                            $("#lembur_edit").val('');
                            $("#thp_bulat_edit").val('');
                            $("#pot_jkn_kelg_edit").val('');
                            
                            
                        

                            $("#id_isi_file_edit").val(n_isi_file_id);
                            $("#nama_edit").val(response.response.v_employee_name);
                            //$("#potongan_edit").val(response.response.v_nama_potongan);
                            $("#id_upload_file_edit").val(response.response.n_upload_file_id);
                            $("#nik_edit").val(response.response.v_nik);
                            //$("#nominal_edit").val(response.response.v_nominal);
                            $("#gapok_edit").val(response.response.gapok);
                            $("#rapel_edit").val(response.response.rapel);
                            $("#pot_rs_edit").val(response.response.potongan_rs);
                            $("#tunj_khusus_edit").val(response.response.tunjangan_khusus);
                            $("#insentif_edit").val(response.response.insentif);
                            $("#pot_koperasi_edit").val(response.response.pot_koperasi);
                            $("#tunj_struktural_edit").val(response.response.tunjangan_struktural);
                            $("#potongan_jht_edit").val(response.response.potongan_jht);
                            $("#pot_btn_edit").val(response.response.pot_btn);
                            $("#tas_edit").val(response.response.tas);
                            $("#jaminan_pensiun_edit").val(response.response.jaminan_pensiun);
                            $("#tunai_edit").val(response.response.tunai);
                            $("#penyesuaian_edit").val(response.response.penyesuaian);
                            $("#pot_jkn_edit").val(response.response.bpjs_kesehatan);
                            $("#jml_potongan_edit").val(response.response.jml_potongan);
                            $("#gross_edit").val(response.response.gross);
                            $("#status_edit").val(response.response.status);
                            $("#max_gross_edit").val(response.response.maxgross);
                            $("#pajak_edit").val(response.response.pajak);
                            $("#jml_terima_edit").val(response.response.jumlah_terima);
                            $("#honor_edit").val(response.response.honor);
                            $("#thr_edit").val(response.response.thr);
                            $("#lembur_edit").val(response.response.lembur);
                            $("#thp_bulat_edit").val(response.response.thp_bulat);
                            $("#pot_jkn_kelg_edit").val(response.response.pot_jkn_kelg);
                            
                        }
                    });

                    $('#modal-detail-upload-xiii-keatas').modal('hide');
                    $('#modal-edit-data-upload-xiii-keatas').modal('show');
                });

            }else{

                $.ajax({
                    url: base_url+'Upload/cari_isi_file_by_id',
                    method: 'post',
                    data: {
                        n_isi_file_id: n_isi_file_id
                    },
                    dataType: 'json',
                    async: false,
                    success: function(response){

                        console.log(response);

                             $("#nik_edit").val('');
                            //$("#nominal_edit").val('');
                            $("#gapok_edit").val('');
                            $("#rapel_edit").val('');
                            $("#pot_rs_edit").val('');
                            $("#tunj_khusus_edit").val('');
                            $("#insentif_edit").val('');
                            $("#pot_koperasi_edit").val('');
                            $("#tunj_struktural_edit").val('');
                            $("#potongan_jht_edit").val('');
                            $("#pot_btn_edit").val('');
                            $("#tas_edit").val('');
                            $("#jaminan_pensiun_edit").val('');
                            $("#tunai_edit").val('');
                            $("#penyesuaian_edit").val('');
                            $("#pot_jkn_edit").val('');
                            $("#jml_potongan_edit").val('');
                            $("#gross_edit").val('');
                            $("#status_edit").val('');
                            $("#max_gross_edit").val('');
                            $("#pajak_edit").val('');
                            $("#jml_terima_edit").val('');
                            $("#honor_edit").val('');
                            $("#thr_edit").val('');
                            $("#lembur_edit").val('');
                            $("#thp_bulat_edit").val('');
                            $("#pot_jkn_kelg_edit").val('');                            
                            
                        

                            $("#id_isi_file_edit").val(n_isi_file_id);
                            $("#nama_edit").val(response.response.v_employee_name);
                            //$("#potongan_edit").val(response.response.v_nama_potongan);
                            $("#id_upload_file_edit").val(response.response.n_upload_file_id);
                            $("#nik_edit").val(response.response.v_nik);
                            //$("#nominal_edit").val(response.response.v_nominal);
                            $("#gapok_edit").val(response.response.gapok);
                            $("#rapel_edit").val(response.response.rapel);
                            $("#pot_rs_edit").val(response.response.potongan_rs);
                            $("#tunj_khusus_edit").val(response.response.tunjangan_khusus);
                            $("#insentif_edit").val(response.response.insentif);
                            $("#pot_koperasi_edit").val(response.response.pot_koperasi);
                            $("#tunj_struktural_edit").val(response.response.tunjangan_struktural);
                            $("#potongan_jht_edit").val(response.response.potongan_jht);
                            $("#pot_btn_edit").val(response.response.pot_btn);
                            $("#tas_edit").val(response.response.tas);
                            $("#jaminan_pensiun_edit").val(response.response.jaminan_pensiun);
                            $("#tunai_edit").val(response.response.tunai);
                            $("#penyesuaian_edit").val(response.response.penyesuaian);
                            $("#pot_jkn_edit").val(response.response.bpjs_kesehatan);
                            $("#jml_potongan_edit").val(response.response.jml_potongan);
                            $("#gross_edit").val(response.response.gross);
                            $("#status_edit").val(response.response.status);
                            $("#max_gross_edit").val(response.response.maxgross);
                            $("#pajak_edit").val(response.response.pajak);
                            $("#jml_terima_edit").val(response.response.jumlah_terima);
                            $("#honor_edit").val(response.response.honor);
                            $("#thr_edit").val(response.response.thr);
                            $("#lembur_edit").val(response.response.lembur);
                            $("#thp_bulat_edit").val(response.response.thp_bulat);
                            $("#pot_jkn_kelg_edit").val(response.response.pot_jkn_kelg);
                    }
                });

                $('#modal-detail-upload-xiii-keatas').modal('hide');
                $('#modal-edit-data-upload-xiii-keatas').modal('show');
            }
        }
    });

}

function edit_isi_file(){
    $('#modal-edit-data-upload').modal('hide');

    var n_isi_file_id       = $("#id_isi_file_edit").val();
    var n_upload_file_id    = $("#id_upload_file_edit").val();
    var v_nik               = $("#nik_edit").val();
    //var v_nominal           = $("#nominal_edit").val();
    var gapok               = $("#gapok_edit").val();
    var tunjangan_khusus    = $("#tunj_khusus_edit").val();
    var tunjangan_struktural= $("#tunj_struktural_edit").val();
    var penyesuaian         = $("#penyesuaian_edit").val();
    var tas                 = $("#tas_edit").val();
    var maxgross            = $("#max_gross_edit").val();
    var dinas_malam         = $("#dinas_malam_edit").val();
    var lembur              = $("#lembur_edit").val();
    var rapel               = $("#rapel_edit").val();
    var insentif            = $("#insentif_edit").val();
    var gross               = $("#gross_edit").val();
    var potongan_jht        = $("#potongan_jht_edit").val();
    var jaminan_pensiun     = $("#jaminan_pensiun_edit").val();
    var bpjs_kesehatan      = $("#bpjs_kesehatan_edit").val();
    var sta                 = $("#sta_edit").val();
    var pajak               = $("#pajak_edit").val();
    var thp_bulat           = $("#thp_bulat_edit").val();
    var potongan_kopkar     = $("#pot_kopkar_edit").val();
    var nominal_rek         = $("#nom_rek_edit").val();
    var nominal_lain        = $("#nom_lain_edit").val();
    var nominal_prr_btn     = $("#nom_prr_btn_edit").val();
    var nominal_btnsolo     = $("#nom_btn_solo_edit").val();
    var nominal_koperasi    = $("#nom_koperasi_edit").val();
    var ket_rek_rs          = $("#ket_rek_rs_edit").val();
    var ket_lain            = $("#ket_lain_edit").val();
    var ket_prr_btn         = $("#ket_prr_btn_edit").val();
    var ket_btn_solo        = $("#ket_btn_solo_edit").val();
    var ket_koperasi        = $("#ket_koperasi_edit").val();
    var jumlah_terima       = $("#jml_terima_edit").val();
    var titik_perubahan     = $("#titik_perubahan_edit").val();
    var nominal_ekstra      = $("#nom_ekstra_edit").val();
    var ket_ekstra          = $("#ket_ekstra_edit").val();
    var jenis_ekstra        = $("#jenis_ekstra_edit").val();

    $.ajax({
        url: base_url+"Upload/UpdateIsiFile",
        type: "post",
        data: {
            'n_isi_file_id': n_isi_file_id,
            'n_upload_file_id': n_upload_file_id,
            'v_nik': v_nik,
            //'v_nominal': v_nominal,
            'gapok': gapok,
            'tunjangan_khusus': tunjangan_khusus,
            'tunjangan_struktural': tunjangan_struktural,
            'penyesuaian': penyesuaian,
            'tas': tas,
            'maxgross': maxgross,
            'dinas_malam': dinas_malam,
            'lembur': lembur,
            'rapel': rapel,
            'insentif': insentif,
            'gross': gross,
            'potongan_jht': potongan_jht,
            'jaminan_pensiun': jaminan_pensiun,
            'bpjs_kesehatan': bpjs_kesehatan,
            'sta': sta,
            'pajak': pajak,
            'thp_bulat': thp_bulat,
            'potongan_kopkar': potongan_kopkar,
            'nominal_rek': nominal_rek,
            'nominal_lain': nominal_lain,
            'nominal_prr_btn': nominal_prr_btn,
            'nominal_btnsolo': nominal_btnsolo,
            'nominal_koperasi': nominal_koperasi,
            'ket_rek_rs': ket_rek_rs,
            'ket_lain': ket_lain,
            'ket_prr_btn': ket_prr_btn,
            'ket_btn_solo': ket_btn_solo,
            'ket_koperasi': ket_koperasi,
            'jumlah_terima': jumlah_terima,
            'titik_perubahan': titik_perubahan,
            'nominal_ekstra': nominal_ekstra,
            'ket_ekstra': ket_ekstra,
            'jenis_ekstra': jenis_ekstra
        },

        success: function(data) {

            if (v_nik != "") {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                var desc = "Berhasil Mengubah Isi File. n_isi_file_id : "+n_isi_file_id;
                insert_log(desc);
                modal_lihat_file(n_upload_file_id);
                } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });

                    var desc = "Gagal Mengubah Isi File. n_isi_file_id : "+n_isi_file_id;
                    insert_log(desc);
                }
        }
    });
}

function edit_isi_fileXIIIKeatas(){
    $('#modal-edit-data-upload-xiii-keatas').modal('hide');

    var n_isi_file_id       = $("#id_isi_file_edit").val();
    var n_upload_file_id    = $("#id_upload_file_edit").val();
    var v_nik               = $("#nik_edit").val();
    //var v_nominal           = $("#nominal_edit").val();
    var gapok               = $("#gapok_edit").val();
    var rapel               = $("#rapel_edit").val();
    var potongan_rs         = $("#pot_rs_edit").val();
    var tunjangan_khusus    = $("#tunj_khusus_edit").val();
    var insentif            = $("#insentif_edit").val();
    var pot_koperasi        = $("#pot_koperasi_edit").val();
    var tunjangan_struktural= $("#tunj_struktural_edit").val();
    var potongan_jht        = $("#potongan_jht_edit").val();
    var pot_btn             = $("#pot_btn_edit").val();
    var tas                 = $("#tas_edit").val();
    var jaminan_pensiun     = $("#jaminan_pensiun_edit").val();
    var tunai               = $("#tunai_edit").val();
    var penyesuaian         = $("#penyesuaian_edit").val();
    var bpjs_kesehatan      = $("#pot_jkn_edit").val();
    var jml_potongan        = $("#jml_potongan_edit").val();
    var gross               = $("#gross_edit").val();
    var status              = $("#status_edit").val();
    var maxgross            = $("#max_gross_edit").val();
    var pajak               = $("#pajak_edit").val();
    var jumlah_terima       = $("#jml_terima_edit").val();
    var honor               = $("#honor_edit").val();
    var thr                 = $("#thr_edit").val();
    var lembur              = $("#lembur_edit").val();
    var thp_bulat           = $("#thp_bulat_edit").val();
    

    $.ajax({
        url: base_url+"Upload/UpdateIsiFileXIIIKeatas",
        type: "post",
        data: {
            'n_isi_file_id': n_isi_file_id,
            'n_upload_file_id': n_upload_file_id,
            'v_nik': v_nik,
            //'v_nominal': v_nominal,
            'gapok': gapok,
            'rapel': rapel,
            'potongan_rs': potongan_rs,
            'tunjangan_khusus': tunjangan_khusus,
            'insentif': insentif,
            'pot_koperasi': pot_koperasi,
            'tunjangan_struktural': tunjangan_struktural,
            'potongan_jht': potongan_jht,
            'pot_btn': pot_btn,
            'tas': tas,
            'jaminan_pensiun': jaminan_pensiun,
            'tunai': tunai,
            'penyesuaian': penyesuaian,
            'bpjs_kesehatan': bpjs_kesehatan,
            'jml_potongan': jml_potongan,
            'gross': gross,
            'status': status,
            'maxgross': maxgross,
            'pajak': pajak,
            'jumlah_terima': jumlah_terima,
            'honor': honor,
            'thr': thr,
            'lembur': lembur,
            'thp_bulat': thp_bulat
            
        },

        success: function(data) {

            if (v_nik != "") {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                var desc = "Berhasil Mengubah Isi File. n_isi_file_id : "+n_isi_file_id;
                insert_log(desc);
                modal_lihat_fileXIIIAtas(n_upload_file_id);
                } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });

                    var desc = "Gagal Mengubah Isi File. n_isi_file_id : "+n_isi_file_id;
                    insert_log(desc);
                }
        }
    });
}

if (window.location.pathname.split("/")[3] == "uploadAtasXIII") {
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#mydropzone", {
        url: base_url+"Upload/uploadFileAtasXIII",
        autoProcessQueue: false,
        paramName: "file_upload",
        clickable: true,
        maxFilesize: 20, //in mb
        addRemoveLinks: false,
        acceptedFiles: '.xlsx',
        maxFiles:1,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
            this.on("sending", function(file, xhr, formData) {
                //console.log("sending file");
                //formData.append('potongan_tambah', $('#potongan_tambah').val());
                formData.append('bulantahun_tambah', $('#bulantahun_tambah').val());
                formData.append('jenis_tambah', $('#jenis_tambah').val());
            });
            this.on("success", function(file, responseText) {
                //console.log('great success');
                //console.log(file);
                //console.log(responseText);
                if(responseText == 0){
                    swal({   
                        title: "Sukses!",
                        text: "Data anda berhasil diupload",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "success",
                    });
                    getListUploadFileAtasXIII();
                }else{
                    swal({   
                        title: "Berhasil Upload ! Ada Data Yang Salah !!",
                        text: "NIK yang salah : "+responseText,
                        /*timer: 1500,
                        showConfirmButton: false,*/
                        type: "warning",
                    });
                    getListUploadFileAtasXIII();
                }
                
            });
            this.on("addedfile", function(file){
                //console.log('file added');
            });
            var submitButton = document.querySelector("#button_upload_file");
            myDropzone = this;
            submitButton.addEventListener("click", function() {
                //var potongan_tambah = $('#potongan_tambah').val();
                var bulantahun_tambah = $('#bulantahun_tambah').val();
                var jenis_tambah = $('#jenis_tambah').val();
                if (myDropzone.files.length && bulantahun_tambah && jenis_tambah) {

                    myDropzone.processQueue();
                    //$('#potongan_tambah').val($('#potongan_tambah option:first').val()).trigger('change');
                    $('#bulantahun_tambah').val(moment().format('MM/YYYY'));
                    $('#jenis_tambah').val();

                    $('#modal-upload-file').modal('hide');
                    myDropzone.removeAllFiles();
                    /*swal({   
                        title: "Sukses!",
                        text: "Data anda berhasil diupload",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "success",
                    });*/

                    //window.location = base_url+"Upload/uploadAtasXIII";
                    //getListUploadFileAtasXIII();
                } else {
                    swal({   
                        title: "Gagal!",
                        text: "Silahkan menginput data dengan benar",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "warning",
                    });

                    var desc = "Gagal Mengupload File. Periode : "+bulantahun_tambah;
                    insert_log(desc);
                }
            });
        }
    });
    
}else if(window.location.pathname.split("/")[3] == "uploadBawahXIII"){
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#mydropzone", {
        url: base_url+"Upload/uploadFileBawahXIII",
        autoProcessQueue: false,
        paramName: "file_upload",
        clickable: true,
        maxFilesize: 20, //in mb
        addRemoveLinks: false,
        acceptedFiles: '.xlsx',
        maxFiles:1,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
            this.on("sending", function(file, xhr, formData) {
                //formData.append('potongan_tambah', $('#potongan_tambah').val());
                formData.append('bulantahun_tambah', $('#bulantahun_tambah').val());
                formData.append('jenis_tambah', $('#jenis_tambah').val());
            });
            this.on("success", function(file, responseText) {
                //console.log('great success');
                //console.log(file);
                //console.log(responseText);
                if(responseText == 0){
                    swal({   
                        title: "Sukses!",
                        text: "Data anda berhasil diupload",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "success",
                    });
                    getListUploadFileBawahXIII();
                }else{
                    swal({   
                        title: "Berhasil Upload ! Ada Data Yang Salah !!",
                        text: "NIK yang salah : "+responseText,
                        /*timer: 1500,
                        showConfirmButton: false,*/
                        type: "warning",
                    });
                    getListUploadFileBawahXIII();
                }
            });
            this.on("addedfile", function(file){
                //console.log('file added');
            });
            var submitButton = document.querySelector("#button_upload_file");
            myDropzone = this;
            submitButton.addEventListener("click", function() {
                //var potongan_tambah = $('#potongan_tambah').val();
                var bulantahun_tambah = $('#bulantahun_tambah').val();
                var jenis_tambah = $('#jenis_tambah').val();

                if (myDropzone.files.length && bulantahun_tambah && jenis_tambah) {
                    myDropzone.processQueue();
                    //$('#potongan_tambah').val($('#potongan_tambah option:first').val()).trigger('change');
                    $('#bulantahun_tambah').val(moment().format('MM/YYYY'));
                    $('#jenis_tambah').val();

                    $('#modal-upload-file').modal('hide');
                    myDropzone.removeAllFiles();
                    /*swal({   
                        title: "Sukses!",
                        text: "Data anda berhasil diupload",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "success",
                    });*/
                    //getListUploadFileBawahXIII();
                } else {
                    swal({   
                        title: "Gagal!",
                        text: "Silahkan menginput data dengan benar",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "warning",
                    });

                    var desc = "Gagal Mengupload File. Periode : "+bulantahun_tambah;
                    insert_log(desc);
                }
            });
        }
    });
}

function insert_log(desc){
    $.ajax({
        url: base_url+'MasterPotongan/insert_log',
        method: 'post',
        data: {
            desc: desc
        },
        dataType: 'json',
        async: false,
        success: function(response){

        }
    });
}