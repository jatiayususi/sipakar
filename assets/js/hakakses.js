$('#mytabelhakakses').DataTable();
$('#mytabelencrip').DataTable();

$(document).ajaxStart(function(){
  $('#loading').show();
});

$(document).ajaxComplete(function(){
  $('#loading').hide();
});

$('#myDatepicker2').datetimepicker({
    format: 'MM/YYYY'
});

$('#karyawan_tambah').select2({
        dropdownParent: $('#modal-tambah-hak-akses'),
        minimumInputLength: 3,
        placeholder: '-- Pilih Karyawan --',
        ajax: {
            url: base_url+'HakAkses/cari_karyawan',
            dataType: 'json',
            type: "GET",
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                var res = data.map(function (item) {
                    return {id: item.n_employee_id, text: item.v_nik +' - '+ item.v_employee_name};
                });
                return {
                    results: res
                };
            },
        },
    }); 

//----------

getListHakAkses();

function getListHakAkses() {
    $.ajax({
        url: base_url+"HakAkses/getListHakAkses",
        type: "post",
        dataType: 'json',
        async: false,
        success: function(response) {
            //console.log(response);
            var tabel_hak_akses_awal =

                '<table class="table table-bordered table-striped tabel-apps" id="mytabelhakakses">'+
                '<thead>'+
                    '<tr bgcolor="#4682B4">'+
                        '<th><font color="#ffffff">No</th>'+ 
                        '<th><font color="#ffffff">NIK</th>'+
                        '<th><font color="#ffffff">Nama</th>'+
                        '<th><font color="#ffffff">Hak Akses</th>'+
                        '<th width="150px;"><font color="#ffffff">#</th>'+ 
                    '</tr>'+
                '</thead>'+
                '<tbody>';
            var no = 1;
            var tabel_hak_akses_isi = "";
            $.each(response.list, function (index, data){

                var hak = '';
                if(data.n_hak_akses == 1){
                    hak = 'Golongan di bawah XIII';
                }else{
                    hak = 'Golongan di atas XIII';
                }

            tabel_hak_akses_isi+='<tr>'+                       
                            '<td>'+ no +'</td>'+   
                            '<td>'+ data.v_nik +'</td>'+
                            '<td>'+ data.v_employee_name +'</td>'+
                            '<td>'+ hak +'</td>'+
                            '<td> <button type="button" class="btn btn-success" onclick="edit_modal_hak_akses('+data.id+')"><i class="fa fa-edit"></i> Edit</button>'+
                            '<button type="button" class="btn btn-danger" onclick="hapus_hak_akses('+data.id+')"><i class="fa fa-trash"></i> Hapus</button></td>';                       
                            '</tr>';
            no++;
            });
                                
            var tabel_hak_akses_akhir='</tbody>'+
                '</table>';
            var hasil_tabel_hak_akses = tabel_hak_akses_awal+tabel_hak_akses_isi+tabel_hak_akses_akhir;

                $("#parent_tabel_hak_akses").empty();                         
                $("#parent_tabel_hak_akses").html(hasil_tabel_hak_akses);
                $("#mytabelhakakses").DataTable();

        }

    });
}

function tambah_modal_hak_akses(){ 
            
    $('#modal-tambah-hak-akses').modal('show');
          
}

function tambah_hak_akses() {
    $('#modal-tambah-hak-akses').modal('hide');
    var n_employee_id = $("#karyawan_tambah").val();
    var n_hak_akses   = $("#hak_akses").val();

    $.ajax({
        url: base_url+"HakAkses/insert",//controller
        type: "post",
        data: {
            'n_employee_id': n_employee_id,
            'n_hak_akses':n_hak_akses
        },
        dataType: 'json',
        async: false,
        success: function(data) {

            if (data) {
                    swal({   
                        title: "Sukses!",
                        text: "Data anda berhasil ditambahkan",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "success",
                    });

                    var desc = "Berhasil Menambahkan Hak Akses. n_employee_id : "+n_employee_id;
                    insert_log(desc);

                    getListHakAkses();
            }else{
                swal({   
                    title: "Gagal!",
                    text: "Data anda gagal ditambahkan, silahkan mengisi data dengan lengkap",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "error",
                });

                var desc = "Gagal Menambahkan Hak Akses. n_employee_id : "+n_employee_id;
                insert_log(desc);
            }
        }
    });
}

function edit_modal_hak_akses(id){
    $.ajax({
        url: base_url+'HakAkses/cari_hak_akses_by_id',
        method: 'post',
        data: {
            id: id
        },
        dataType: 'json',
        async: false,
        success: function(response){
            $("#id_hak_akses_edit").val(id);
            $("#karyawan_edit").val(response.response.n_employee_id);
            $("#hak_akses_edit").val(response.response.n_hak_akses);
        }
    });

    $('#modal-edit-hak-akses').modal('show');
}

function edit_hak_akses(){
    $('#modal-edit-hak-akses').modal('hide');

    var id              = $("#id_hak_akses_edit").val();
    var n_employee_id   = $("#karyawan_edit").val();
    var n_hak_akses     = $("#hak_akses_edit").val();

    $.ajax({
        url: base_url+"HakAkses/Update",
        type: "post",
        data: {
            'id': id,
            'n_employee_id': n_employee_id,
            'n_hak_akses': n_hak_akses
        },

        success: function(data) {
            if (n_employee_id != "") {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });

                var desc = "Berhasil Mengupdate Hak Akses. id hak akses :"+id;
                insert_log(desc);
                getListHakAkses();

                } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });

                    var desc = "Gagal Mengupdate Hak Akses. id hak akses : "+id;
                    insert_log(desc);
                }
        }
    });
}

function hapus_hak_akses(id) {
    swal({
        title: "Apakah anda yakin ingin menghapus data ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#AF1000',
        cancelButtonColor: '#212F3C',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    },
    function(){
        $.ajax({
            url: base_url+"HakAkses/Delete",
            type: "post",
            data: {
                'id': id
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
                var desc = "Berhasil Menghapus Hak Akses. id hak akses : "+id;
                insert_log(desc);
                getListHakAkses();
            }
        });
    });
}

//---------- ENCRYPT

function edit_modal_encrypt(){

    var id = 1;

    $.ajax({
        url: base_url+'HakAkses/cari_encrypt_by_id',
        method: 'post',
        data: {
            id: id
        },
        dataType: 'json',
        async: false,
        success: function(response){

            $("#kode_lama1_edit").val('');
            $("#kode_lama2_edit").val('');
            $("#kode_baru1_edit").val('');
            $("#kode_baru2_edit").val('');

            $("#id_encrypt_edit").val(id);
        }
    });

    $('#modal-edit-encrypt').modal('show');
}

function edit_encrypt(){
    $('#modal-edit-encrypt').modal('hide');

    var id              = $("#id_encrypt_edit").val();
    var kode_lama_iv    = $("#kode_lama1_edit").val();
    var kode_lama_key   = $("#kode_lama2_edit").val();
    var kode_baru_iv    = $("#kode_baru1_edit").val();
    var kode_baru_key   = $("#kode_baru2_edit").val();

    $.ajax({
        url: base_url+"HakAkses/UpdateChiper",
        type: "post",
        data: {
            'id': id,
            'kode_lama_iv': kode_lama_iv,
            'kode_lama_key': kode_lama_key,
            'kode_baru_iv': kode_baru_iv,
            'kode_baru_key': kode_baru_key
        },
        success: function(data) {

            if (data == "BENAR") {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });

                var desc = "Berhasil Mengupdate Encryption. id encr : "+id;
                insert_log(desc);
                getListHakAkses();

            } else {
                swal({   
                    title: "Gagal!",
                    text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "error",
                });

                var desc = "Gagal Mengupdate Encryption. id encr : "+id;
                insert_log(desc);
            }
        }
    });
}

function insert_log(desc){  //numpang fungsi di Master Potongan
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