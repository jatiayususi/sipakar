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

/*function refresh_table_data_gaji_karyawan(periode) {
    $.ajax({
        url: base_url+"DataGajiKaryawan/refresh_table_data_gaji_karyawan",
        type: "post",
        data: {
            periode: periode
        },
        //async: false,
        success: function(data) {
            var periode = $("#periode_gaji_hidden").val();
            getListDataGajiKaryawan(periode);
        }

    });
}*/

function button_filter_periode_gaji_bawah13(){
    $('#pemberitahuan_input_datagajikaryawan').show();
    var periode = $("#periode_gaji").val();
    var jenis_gaji  = $("#jenis_gaji").val();
    
    getListDataGajiKaryawanBawahXIII(periode, jenis_gaji);
}

function button_filter_periode_gaji_atas13(){
    $('#pemberitahuan_input_datagajikaryawan').show();
    var periode = $("#periode_gaji").val();
    var jenis_gaji  = $("#jenis_gaji").val();
    
    getListDataGajiKaryawanAtasXIII(periode, jenis_gaji);
}

function getListDataGajiKaryawanAtasXIII(periode, jenis_gaji){

    var periode = $("#periode_gaji").val();
    var jenis_gaji  = $("#jenis_gaji").val();
    var gol = 2;

       if (!periode && jenis_gaji) {
            swal({   
                title: "Gagal!",
                text: "Data anda gagal dicari, silahkan mengisi data dengan benar",
                timer: 1500,
                showConfirmButton: false,
                type: "error",
            });

        } else {

            var tabel_periode = '';
            var tabel_datagajikaryawan = '';

            $.ajax({
                url: base_url+"DataGajiKaryawan/getListDataGajiKaryawanAtasXIII",
                type: "post",
                data: {
                    'periode': periode,
                    'jenis_gaji': jenis_gaji
                },
                dataType: 'json',
                async:true,
                success: function(response) {
                    console.log(response);
                tanggal = "'"+periode+"'";

                if(jenis_gaji == 1){
                    var jenisgaji = 'Gaji';
                }else{
                    var jenisgaji = 'Non Gaji';
                }
                
                /*tabel_periode = '<input type="hidden" id="periode_gaji_hidden" value="'+periode+'">'+
                            '<div class="tabel_periode" style="text-align: right;">'+
                            '<button type="button" class="btn btn-round btn-success" id="modal_generate_gaji" onclick="modal_generate_gaji('+tanggal+','+gol+')"><i class="fa fa-check"></i><b> Generate Gaji</b></button></div>'+
                            '<hr>';*/

                tabel_periode = '<input type="hidden" id="periode_gaji_hidden" value="'+periode+'">'+
                            '<table id="tabel_periode" style="width:100%">'+
                            '<td style="font-size: 15px;"><b>Periode Bulan : '+ periode +' || Jenis Gaji : '+ jenisgaji +'</b></td>';

                            if(response != 'kosong'){
                                tabel_periode += '<td style="float:right;"><button type="button" class="btn btn-round btn-success" id="modal_generate_gaji" onclick="modal_generate_gaji('+tanggal+','+gol+','+jenis_gaji+')"><i class="fa fa-check"></i><b> Generate Gaji</b></button></td>';
                            }else{
                                tabel_periode += '<td style="float:right;"><button type="button" class="btn btn-round btn-success" id="modal_generate_gaji" disabled><i class="fa fa-check"></i><b> Generate Gaji</b></button></td>';
                            }
                            
                tabel_periode +='</table>'+
                                '<hr>';

                var nomor = 1;

                tabel_datagajikaryawan= '<table class="table table-bordered table-striped js-basic-example dataTable" id="mytabeldatagajikaryawan">'+
                                '<thead>'+
                                '<tr bgcolor="#4682B4">'+
                                    '<th><font color="#ffffff">NO</th>'+
                                    '<th><font color="#ffffff">NIK</th>'+
                                    '<th><font color="#ffffff">NAMA</th>'+
                                    '<th><font color="#ffffff">BAGIAN</th>'+
                                    '<th width="90px"><font color="#ffffff">GOLONGAN</th>'+
                                    //'<th width="90px"><font color="#ffffff">THP BULAT</th>'+
                                    //'<th width="90px"><font color="#ffffff">POTONGAN</th>'+
                                    '<th width="90px"><font color="#ffffff">JML TERIMA</th>'+
                                    '<th><font color="#ffffff">BACA</th>'+
                                    '<th><font color="#ffffff">GENERATE</th>'+
                                '</tr>'+
                                '</thead>'+
                                '<tbody id="tabel_datagajikaryawan">';

                    if(response != 'kosong'){

                        var baca = '';
                        $.each(response, function (index, karyawan){
                            if(karyawan.tglbaca){
                                baca = karyawan.tglbaca;
                            }

                            var v_nik = "'"+karyawan.v_nik+"'";
                            // if(karyawan.baca == 0){
                            //     //baca = '<i class="fa fa-close" style="color:crimson;"></i>';
                            //     baca = '-';
                            // }else if(karyawan.baca == 1){
                                
                            // }

                            tabel_datagajikaryawan=tabel_datagajikaryawan+'<tr>'+
                                '<td>' + nomor + '</td>' +
                                '<td>' + karyawan.v_nik + '</td>' +
                                '<td>' + karyawan.v_employee_name + '</td>' +
                                '<td>' + karyawan.v_unitrsnama + '</td>' +
                                '<td>' + karyawan.nama_golongan + '</td>' +
                                //'<td style="text-align: right"> Rp. ' + numeral(karyawan.thpbulat).format('0,0') + '</td>' +
                                //'<td style="text-align: right"> Rp. ' + numeral(karyawan.potongan).format('0,0') + '</td>' +
                                '<td style="text-align: right"> Rp. ' + numeral(karyawan.jumlah_terima).format('0,0') + '</td>' +
                                '<td style="text-align: center">' + baca + '</td>'+
                                '<td style="text-align: center"><button type="button" class="btn btn-warning" id="modal_generate_gaji_personal" onclick="modal_generate_gaji_personal('+tanggal+','+v_nik+','+jenis_gaji+')"><i class="fa fa-check-circle"></i></button><button type="button" class="btn btn-info" id="print_slip" onclick="print_slip_gaji('+tanggal+','+v_nik+','+jenis_gaji+','+gol+')"><i class="fa fa-print"></i></button></td>'+
                                '</tr>';
                            
                            nomor++;

                        });

                        tabel_datagajikaryawan += '</tbody></table>';

                        $("#tabel_periode").empty();
                        $("#tabel_datagajikaryawan").empty();
                        $("#tabel_periode").html(tabel_periode);
                        $("#tabel_datagajikaryawan").html(tabel_datagajikaryawan);
                        $("#mytabeldatagajikaryawan").DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            "stripeClasses": [ 'odd-row', 'even-row' ],
                            buttons: [
                            //'copy', 'csv', 'excel', 'pdf', 'print'
                                {
                                    extend: 'excel',
                                    title: 'Laporan Data Gaji Karyawan',
                                    className: 'btn btn-success btn-sm',
                                    text: '<i class="fa fa-file-excel-o" style="font-size: 15px;"></i> Excel'
                                },
                                {
                                    extend: 'pdf',
                                    title: 'Laporan Data Gaji Karyawan',
                                    className: 'btn btn-danger btn-sm',
                                    text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> PDF'
                                }
                            ]
                        });

                    } else{

                        tabel_datagajikaryawan += '</tbody></table>';

                        tabel_datagajikaryawan +='<center><h5><font color="red"> -------TIDAK ADA DATA -------- </font></h5></center>';

                        $("#tabel_periode").empty();
                        $("#tabel_datagajikaryawan").empty();
                        $("#tabel_periode").html(tabel_periode);
                        $("#tabel_datagajikaryawan").html(tabel_datagajikaryawan);

                    }

                $("#pemberitahuan_input_datagajikaryawan").hide();

                var desc = "Berhasil Melihat Data Gaji Karyawan Golongan XIII Ke Atas. Periode : "+periode;
                insert_log(desc);

                }
            });
        }
}

function getListDataGajiKaryawanBawahXIII(periode, jenis_gaji){

    var periode = $("#periode_gaji").val();
    var jenis_gaji  = $("#jenis_gaji").val();
    var gol = 1;

       if (!periode && jenis_gaji) {
            swal({   
                title: "Gagal!",
                text: "Data anda gagal dicari, silahkan mengisi data dengan benar",
                timer: 1500,
                showConfirmButton: false,
                type: "error",
            });

        } else {

            var tabel_periode = '';
            var tabel_datagajikaryawan = '';
            var tanggal = '';

            $.ajax({
                url: base_url+"DataGajiKaryawan/getListDataGajiKaryawanBawahXIII",
                type: "post",
                data: {
                    'periode': periode,
                    'jenis_gaji': jenis_gaji
                },
                dataType: 'json',
                async:true,
                success: function(response) {

                tanggal = "'"+periode+"'";

                if(jenis_gaji == 1){
                    var jenisgaji = 'Gaji';
                }else{
                    var jenisgaji = 'Non Gaji';
                }
   
                /*tabel_periode = '<input type="hidden" id="periode_gaji_hidden" value="'+periode+'">'+
                            '<div class="tabel_periode" style="text-align: right;">'+
                            '<button type="button" class="btn btn-round btn-success" id="modal_generate_gaji" onclick="modal_generate_gaji('+tanggal+','+gol+')"><i class="fa fa-check"></i><b> Generate Gaji</b></button></div>'+
                            '<hr>';*/

                tabel_periode = '<input type="hidden" id="periode_gaji_hidden" value="'+periode+'">'+
                            '<table id="tabel_periode" style="width:100%">'+
                            '<td style="font-size: 15px;"><b>Periode Bulan : '+ periode +' || Jenis Gaji : '+ jenisgaji +'</b></td>';

                            if(response != 'kosong'){
                                tabel_periode += '<td style="float:right;"><button type="button" class="btn btn-round btn-success" id="modal_generate_gaji" onclick="modal_generate_gaji('+tanggal+','+gol+','+jenis_gaji+')"><i class="fa fa-check"></i><b> Generate Gaji</b></button></td>';
                            }else{
                                tabel_periode += '<td style="float:right;"><button type="button" class="btn btn-round btn-success" id="modal_generate_gaji" disabled><i class="fa fa-check"></i><b> Generate Gaji</b></button></td>';
                            }
                            
                tabel_periode +='</table>'+
                               '<hr>';

                var nomor = 1;

                tabel_datagajikaryawan= '<table class="table table-bordered table-striped js-basic-example dataTable" id="mytabeldatagajikaryawan">'+
                                '<thead>'+
                                '<tr bgcolor="#4682B4">'+
                                    '<th><font color="#ffffff">NO</th>'+
                                    '<th><font color="#ffffff">NIK</th>'+
                                    '<th><font color="#ffffff">NAMA</th>'+
                                    '<th><font color="#ffffff">BAGIAN</th>'+
                                    '<th width="90px"><font color="#ffffff">GOLONGAN</th>'+
                                    // '<th width="90px"><font color="#ffffff">THP BULAT</th>'+
                                    // '<th width="90px"><font color="#ffffff">POTONGAN</th>'+
                                    '<th width="90px"><font color="#ffffff">JML TERIMA</th>'+
                                    '<th><font color="#ffffff">BACA</th>'+
                                    '<th><font color="#ffffff">GENERATE</th>'+
                                '</tr>'+
                                '</thead>'+
                                '<tbody id="tabel_datagajikaryawan">';

                    if(response != "kosong"){

                        var baca = '';
                        $.each(response, function (index, karyawan){
                            if(karyawan.tglbaca){
                                baca=karyawan.tglbaca;
                            }

                            var v_nik = "'"+karyawan.v_nik+"'";
                            // if(karyawan.baca == 0){
                            //     //baca = '<i class="fa fa-close" style="color:crimson;"></i>';
                            //     baca = '-';
                            // }else if(karyawan.baca == 1){
                            //     baca = karyawan.tglbaca+' ('+ karyawan.jambaca +') ';
                            // }

                            tabel_datagajikaryawan=tabel_datagajikaryawan+'<tr>'+
                                '<td>' + nomor + '</td>' +
                                '<td>' + karyawan.v_nik + '</td>' +
                                '<td>' + karyawan.v_employee_name + '</td>' +
                                '<td>' + karyawan.v_unitrsnama + '</td>' +
                                '<td>' + karyawan.nama_golongan + '</td>' +
                                // '<td style="text-align: right"> Rp. ' + numeral(karyawan.thpbulat).format('0,0') + '</td>' +
                                // '<td style="text-align: right"> Rp. ' + numeral(karyawan.potongan).format('0,0') + '</td>' +
                                '<td style="text-align: right"> Rp. ' + numeral(karyawan.jumlah_terima).format('0,0') + '</td>' +
                                '<td style="text-align: center">' + baca + '</td>' +
                                '<td style="text-align: center"><button type="button" class="btn btn-warning" id="modal_generate_gaji_personal" onclick="modal_generate_gaji_personal('+tanggal+','+v_nik+','+jenis_gaji+')"><i class="fa fa-check-circle"></i></button><button type="button" class="btn btn-info" id="print_slip" onclick="print_slip_gaji('+tanggal+','+v_nik+','+jenis_gaji+','+gol+')"><i class="fa fa-print"></i></button></td>' +
                                '</tr>';
                            
                            nomor++;

                        });

                        tabel_datagajikaryawan += '</tbody></table>';

                        $("#tabel_periode").empty();
                        $("#tabel_datagajikaryawan").empty();
                        $("#tabel_periode").html(tabel_periode);
                        $("#tabel_datagajikaryawan").html(tabel_datagajikaryawan);
                        $("#mytabeldatagajikaryawan").DataTable({
                            dom: 'Bfrtip',
                            responsive: true,
                            "stripeClasses": [ 'odd-row', 'even-row' ],
                            buttons: [
                            //'copy', 'csv', 'excel', 'pdf', 'print'
                                {
                                    extend: 'excel',
                                    title: 'Laporan Data Gaji Karyawan',
                                    className: 'btn btn-success btn-sm',
                                    text: '<i class="fa fa-file-excel-o" style="font-size: 15px;"></i> Excel'
                                },
                                {
                                    extend: 'pdf',
                                    title: 'Laporan Data Gaji Karyawan',
                                    className: 'btn btn-danger btn-sm',
                                    text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> PDF'
                                }
                            ]
                        });

                    } else{

                        tabel_datagajikaryawan += '</tbody></table>';

                        tabel_datagajikaryawan +='<center><h5><font color="red"> -------TIDAK ADA DATA -------- </font></h5></center>';

                        $("#tabel_periode").empty();
                        $("#tabel_datagajikaryawan").empty();
                        $("#tabel_periode").html(tabel_periode);
                        $("#tabel_datagajikaryawan").html(tabel_datagajikaryawan);

                    }

                $("#pemberitahuan_input_datagajikaryawan").hide();

                var desc = "Berhasil Melihat Data Gaji Karyawan Golongan I-XII Ke Atas. Periode : "+periode;
                insert_log(desc);

                }
            });
        }
    }

function modal_generate_gaji(tanggal, gol, jenis_gaji){

    $.ajax({
        url: base_url+'DataGajiKaryawan/cek_generate',
        method: 'post',
        data: {
            periode: tanggal,
            gol: gol,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(data){

            if(data != "kosong"){

                swal({   
                    title: "Perhatian!",
                    text: "Data Sudah Di Generate !",
                    //timer: 2500,
                    //showConfirmButton: false,
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#3085d6',
                    type: "warning",
                });

            }else{

                $('#modal-generate-gaji').modal('show');

                $("#tanggal").val(tanggal);
                $("#gol").val(gol);
                $("#jenis_gaji").val(jenis_gaji);
            }
        }
    });
}
function modal_generate_gajiXIIIKeatas(tanggal, gol, jenis_gaji){
    // console.log(tanggal);
    // console.log(gol);
    // console.log(jenis_gaji);

    $.ajax({
        url: base_url+'DataGajiKaryawan/cek_generate',
        method: 'post',
        data: {
            periode: tanggal,
            gol: gol,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(data){
            console.log(data);
            if(data != "kosong"){

                swal({   
                    title: "Perhatian!",
                    text: "Data Sudah Di Generate !",
                    //timer: 2500,
                    //showConfirmButton: false,
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#3085d6',
                    type: "warning",
                });

            }else{

                $('#modal-generate-gaji-xiii-keatas').modal('show');

                $("#tanggal").val(tanggal);
                $("#gol").val(gol);
                $("#jenis_gaji").val(jenis_gaji);
            }
        }
    });
}

function generate_gajiXIIIKeatas(){

    $('#modal-generate-gaji-xiii-keatas').modal('hide');

    var tanggal   = $("#tanggal").val();
    var gol       = $("#gol").val();
    var jenis_gaji= $("#jenis_gaji").val();

    // console.log(jenis_gaji);

    /*var tgl = tanggal.split('"');
    var bulantahun = tgl[0];*/

    $.ajax({
        url: base_url+'DataGajiKaryawan/getListGajiToGenerateXIIIKeatas',
        method: 'post',
        data: {
            periode: tanggal,
            gol: gol,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(response){
            console.log(response);
            if(response != "kosong"){
                $.each(response, function (index, data){

                    // console.log(data.v_nik);
                    // console.log(jenis_gaji);

                    $("#periode").val(tanggal);
                    /*$("#thp_bulat").val(data.thpbulat);
                    $("#potongan").val(data.potongan);
                    $("#transfer_bank").val(data.totaltransfer);*/

                    $("#gapok").val(data.gapok);
                    $("#rapel").val(data.rapel);
                    $("#pot_rs").val(data.potongan_rs);
                    $("#tunj_khusus").val(data.tunjangan_khusus);
                    $("#insentif").val(data.insentif);
                    $("#pot_koperasi").val(data.pot_koperasi);
                    $("#tunj_struktural").val(data.tunjangan_struktural);
                    $("#potongan_jht").val(data.potongan_jht);
                    $("#pot_btn").val(data.pot_btn);
                    $("#tas").val(data.tas);
                    $("#jaminan_pensiun").val(data.jaminan_pensiun);
                    $("#tunai").val(data.tunai);
                    $("#penyesuaian").val(data.penyesuaian);
                    $("#pot_jkn").val(data.bpjs_kesehatan);
                    $("#jml_potongan").val(data.jml_potongan);
                    $("#gross").val(data.gross);
                    $("#status").val(data.status);
                    $("#max_gross").val(data.maxgross);
                    $("#pajak").val(data.pajak);
                    $("#jml_terima").val(data.jumlah_terima);
                    $("#honor").val(data.honor);
                    $("#thr").val(data.thr);
                    $("#lembur").val(data.lembur);
                    $("#thp_bulat").val(data.thp_bulat);
                    $("#pot_jkn_kelg").val(data.pot_jkn_kelg);
                    $("#potongan_rs").val(data.potongan_rs);
                    $("#pot_btn").val(data.pot_btn);
                    $("#pot_jkn_kelg").val(data.pot_jkn_kelg);

                    $("#tf_cimb_niaga").val(data.tf_cimb_niaga);
                    $("#tf_bca").val(data.tf_bca);
                    

                    $("#nik").val(data.v_nik);
                    $("#jenis_gaji").val(jenis_gaji);

                    generateXIIIKeatas();


                });
            }else{
                swal({   
                    title: "Gagal!",
                    text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "error",
                });
            }
        }
    });
}

function generate_gaji(){

    $('#modal-generate-gaji').modal('hide');

    var tanggal   = $("#tanggal").val();
    var gol       = $("#gol").val();
    var jenis_gaji= $("#jenis_gaji").val();

    /*var tgl = tanggal.split('"');
    var bulantahun = tgl[0];*/

    $.ajax({
        url: base_url+'DataGajiKaryawan/getListGajiToGenerate',
        method: 'post',
        data: {
            periode: tanggal,
            gol: gol,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(response){
            console.log(response);
            if(response != "kosong"){
                $.each(response, function (index, data){

                    $("#periode").val(tanggal);
                    /*$("#thp_bulat").val(data.thpbulat);
                    $("#potongan").val(data.potongan);
                    $("#transfer_bank").val(data.totaltransfer);*/

                    $("#gapok").val(data.gapok);
                    $("#tunjangan_khusus").val(data.tunjangan_khusus);
                    $("#tunjangan_struktural").val(data.tunjangan_struktural);
                    $("#penyesuaian").val(data.penyesuaian);
                    $("#tas").val(data.tas);
                    $("#maxgross").val(data.maxgross);
                    $("#dinas_malam").val(data.dinas_malam);
                    $("#lembur").val(data.lembur);
                    $("#rapel").val(data.rapel);
                    $("#insentif").val(data.insentif);
                    $("#gross").val(data.gross);
                    $("#potongan_jht").val(data.potongan_jht);
                    $("#jaminan_pensiun").val(data.jaminan_pensiun);
                    $("#bpjs_kesehatan").val(data.bpjs_kesehatan);
                    $("#sta").val(data.sta);
                    $("#pajak").val(data.pajak);
                    $("#thp_bulat").val(data.thp_bulat);
                    $("#potongan_kopkar").val(data.potongan_kopkar);
                    $("#nominal_rek").val(data.nominal_rek);
                    $("#nominal_lain").val(data.nominal_lain);
                    $("#nominal_prr_btn").val(data.nominal_prr_btn);
                    $("#nominal_btnsolo").val(data.nominal_btnsolo);
                    $("#nominal_koperasi").val(data.nominal_koperasi);
                    $("#ket_rek_rs").val(data.ket_rek_rs);
                    $("#ket_lain").val(data.ket_lain);
                    $("#ket_prr_btn").val(data.ket_prr_btn);
                    $("#ket_btn_solo").val(data.ket_btn_solo);
                    $("#ket_koperasi").val(data.ket_koperasi);
                    $("#jumlah_terima").val(data.jumlah_terima);
                    $("#titik_perubahan").val(data.titik_perubahan);
                    $("#jml_potongan").val(data.jml_potongan);
                    $("#nominal_ekstra").val(data.nominal_ekstra);
                    $("#ket_ekstra").val(data.ket_ekstra);
                    $("#jenis_ekstra").val(data.jenis_ekstra);
                    $("#nik").val(data.v_nik);
                    $("#jenis_gaji").val(jenis_gaji);
                    $("#tf_cimb_niaga").val(data.tf_cimb_niaga);
                    $("#tf_bca").val(data.tf_bca);
                    $("#pot_jkn_kelg").val(data.pot_jkn_kelg);
                    $("#potongan_rs").val(data.potongan_rs);
                    $("#pot_btn").val(data.pot_btn);
                    $("#pot_jkn_kelg").val(data.pot_jkn_kelg);
                    $("#tunai").val(data.tunai);
                    $("#pot_koperasi").val(data.pot_koperasi);
                    generate();
                });
            }else{
                swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
            }
        }
    });
}

function generateXIIIKeatas(){

    $('#modal-generate-gaji-xiii-keatas').modal('hide');

    var periode         = $("#periode").val();
    /*var thp_bulat       = $("#thp_bulat").val();
    var potongan        = $("#potongan").val();
    var totaltransfer   = $("#transfer_bank").val();*/

    var gapok                   = $("#gapok").val();
    var rapel                   = $("#rapel").val();
    var potongan_rs             = $("#pot_rs").val();
    var tunjangan_khusus        = $("#tunj_khusus").val();
    var insentif                = $("#insentif").val();
    var pot_koperasi            = $("#pot_koperasi").val();
    var tunjangan_struktural    = $("#tunj_struktural").val();
    var potongan_jht            = $("#potongan_jht").val();
    var pot_btn                 = $("#pot_btn").val();
    var tas                     = $("#tas").val();
    var jaminan_pensiun         = $("#jaminan_pensiun").val();
    var tunai                   = $("#tunai").val();
    var penyesuaian             = $("#penyesuaian").val();
    var bpjs_kesehatan          = $("#pot_jkn").val();
    var jml_potongan            = $("#jml_potongan").val();
    var gross                   = $("#gross").val();
    var status_gaji             = $("#status").val();
    var maxgross                = $("#max_gross").val();
    var pajak                   = $("#pajak").val();
    var jumlah_terima           = $("#jml_terima").val();
    var honor                   = $("#honor").val();
    var thr                     = $("#thr").val();
    var lembur                  = $("#lembur").val();
    var thp_bulat               = $("#thp_bulat").val();
    var pot_jkn_kelg            = $("#pot_jkn_kelg").val();
    var potongan_rs             = $("#potongan_rs").val();
    var v_nik                   = $("#nik").val();
    var jenis_gaji              = $("#jenis_gaji").val();
    var pot_jkn_kelg            = $("#pot_jkn_kelg").val();

    $.ajax({
        url: base_url+"DataGajiKaryawan/tambahDataGajiKaryawanXIIIKeatas",
        type: "post",
        data: {
            'periode': periode,
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
            'status_gaji': status_gaji,
            'maxgross': maxgross,
            'pajak': pajak,
            'jumlah_terima': jumlah_terima,
            'honor': honor,
            'thr': thr,
            'lembur': lembur,
            'thp_bulat': thp_bulat,
            'v_nik': v_nik,
            'jenis_gaji': jenis_gaji,
            'pot_jkn_kelg': pot_jkn_kelg,
            'ket_lain': ket_lain
        },

        success: function(data) {
            if (data) {
                // console.log(data);
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                var desc = "Berhasil Generate Gaji. Periode : "+periode;
                insert_log(desc);
                // setTimeout(function(){ 
                //      window.location = base_url+"DataGajiKaryawan/daftarAtasXIII";

                // }, 2000);
                // getListDataGajiKaryawanAtasXIII(periode, jenis_gaji);
            } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
                    var desc = "Gagal Generate Gaji. Periode : "+periode;
                    insert_log(desc);
                }
        }
    });

}

function generate(){

    $('#modal-generate-gaji').modal('hide');

    var periode         = $("#periode").val();
    /*var thp_bulat       = $("#thp_bulat").val();
    var potongan        = $("#potongan").val();
    var totaltransfer   = $("#transfer_bank").val();*/

    var gapok               = $("#gapok").val();
    var tunjangan_khusus    = $("#tunjangan_khusus").val();
    var tunjangan_struktural= $("#tunjangan_struktural").val();
    var penyesuaian         = $("#penyesuaian").val();
    var tas                 = $("#tas").val();
    var maxgross            = $("#maxgross").val();
    var dinas_malam         = $("#dinas_malam").val();
    var lembur              = $("#lembur").val();
    var rapel               = $("#rapel").val();
    var insentif            = $("#insentif").val();
    var gross               = $("#gross").val();
    var potongan_jht        = $("#potongan_jht").val();
    var jaminan_pensiun     = $("#jaminan_pensiun").val();
    var bpjs_kesehatan      = $("#bpjs_kesehatan").val();
    var sta                 = $("#sta").val();
    var pajak               = $("#pajak").val();
    var thp_bulat           = $("#thp_bulat").val();
    var potongan_kopkar     = $("#potongan_kopkar").val();
    var nominal_rek         = $("#nominal_rek").val();
    var nominal_lain        = $("#nominal_lain").val();
    var nominal_prr_btn     = $("#nominal_prr_btn").val();
    var nominal_btnsolo     = $("#nominal_btnsolo").val();
    var nominal_koperasi    = $("#nominal_koperasi").val();
    var ket_rek_rs          = $("#ket_rek_rs").val();
    var ket_lain            = $("#ket_lain").val();
    var ket_prr_btn         = $("#ket_prr_btn").val();
    var ket_btn_solo        = $("#ket_btn_solo").val();
    var ket_koperasi        = $("#ket_koperasi").val();
    var jumlah_terima       = $("#jumlah_terima").val();
    var titik_perubahan     = $("#titik_perubahan").val();

    var nominal_ekstra      = $("#nominal_ekstra").val();
    var ket_ekstra          = $("#ket_ekstra").val();
    var jenis_ekstra        = $("#jenis_ekstra").val();
    var jml_potongan        = $("#jml_potongan").val();
    var v_nik               = $("#nik").val();
    var jenis_gaji          = $("#jenis_gaji").val();
    var tf_cimb_niaga       = $("#tf_cimb_niaga").val();
    var tf_bca              = $("#tf_bca").val();

    var potongan_rs         = $("#potongan_rs").val();
    var pot_koperasi        = $("#pot_koperasi").val();
    var pot_btn             = $("#pot_btn").val();
    var tunai               = $("#tunai").val();
    var pot_jkn_kelg        = $("#pot_jkn_kelg").val();
    var ket_lain            = $("#ket_lain").val();

    $.ajax({
        url: base_url+"DataGajiKaryawan/tambahDataGajiKaryawan",
        type: "post",
        data: {
            'periode': periode,
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
            'jml_potongan': jml_potongan,
            'jumlah_terima': jumlah_terima,
            'titik_perubahan': titik_perubahan,
            'v_nik': v_nik,
            'jenis_gaji': jenis_gaji,
            'nominal_ekstra': nominal_ekstra,
            'ket_ekstra': ket_ekstra,
            'jenis_ekstra': jenis_ekstra,
            'tf_cimb_niaga':tf_cimb_niaga,
            'tf_bca':tf_bca,
            'potongan_rs':potongan_rs,
            'pot_koperasi':pot_koperasi,
            'pot_btn':pot_btn,
            'tunai':tunai,
            'pot_jkn_kelg':pot_jkn_kelg,
            'ket_lain':ket_lain

        },

        success: function(data) {
            if (data) {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                var desc = "Berhasil Generate Gaji. Periode : "+periode;
                insert_log(desc);
            } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
                    var desc = "Gagal Generate Gaji. Periode : "+periode;
                    insert_log(desc);
                }
        }
    });

}

//--generate personal
//kelas xii kebawah
function modal_generate_gaji_personal(tanggal, nik, jenis_gaji){

    $.ajax({
        url: base_url+'DataGajiKaryawan/cek_generate_personal',
        method: 'post',
        data: {
            periode: tanggal,
            nik: nik,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(data){

            if(data != "kosong"){

                swal({   
                    title: "Perhatian!",
                    text: "Data Sudah Di Generate !",
                    //timer: 2500,
                    //showConfirmButton: false,
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#3085d6',
                    type: "warning",
                });

            }else{

                $('#modal-generate-gaji-personal').modal('show');

                $("#tanggal").val(tanggal);
                $("#nik").val(nik);
                $("#jenis_gaji").val(jenis_gaji);
            }
        }
    });
}


function modal_generate_gaji_personalXIIIKeatas(tanggal, nik, jenis_gaji){

    $.ajax({
        url: base_url+'DataGajiKaryawan/cek_generate_personal',
        method: 'post',
        data: {
            periode: tanggal,
            nik: nik,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(data){

            if(data != "kosong"){

                swal({   
                    title: "Perhatian!",
                    text: "Data Sudah Di Generate !",
                    //timer: 2500,
                    //showConfirmButton: false,
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#3085d6',
                    type: "warning",
                });

            }else{

                $('#modal-generate-gaji-personal-xiii-keatas').modal('show');

                $("#tanggal").val(tanggal);
                $("#nik").val(nik);
                $("#jenis_gaji").val(jenis_gaji);
            }
        }
    });
}

//button tambah digolongan XII kebawah
function generate_gaji_personal(){

    $('#modal-generate-gaji-personal').modal('hide');

    var tanggal   = $("#tanggal").val();
    var nik       = $("#nik").val();
    var jenis_gaji= $("#jenis_gaji").val();

    /*var tgl = tanggal.split('"');
    var bulantahun = tgl[0];*/

    $.ajax({
        url: base_url+'DataGajiKaryawan/getPersonalGajiToGenerate',
        method: 'post',
        data: {
            periode: tanggal,
            nik: nik,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(response){

            console.log(response);
            
            if(response != "kosong"){

                $("#periode").val(tanggal);

                /*$("#thp_bulat").val(data.thpbulat);
                $("#potongan").val(data.potongan);
                $("#transfer_bank").val(data.totaltransfer);*/

                $("#gapok").val(response.gapok);
                $("#tunjangan_khusus").val(response.tunjangan_khusus);
                $("#tunjangan_struktural").val(response.tunjangan_struktural);
                $("#penyesuaian").val(response.penyesuaian);
                $("#tas").val(response.tas);
                $("#maxgross").val(response.maxgross);
                $("#dinas_malam").val(response.dinas_malam);
                $("#lembur").val(response.lembur);
                $("#rapel").val(response.rapel);
                $("#insentif").val(response.insentif);
                $("#gross").val(response.gross);
                $("#potongan_jht").val(response.potongan_jht);
                $("#jaminan_pensiun").val(response.jaminan_pensiun);
                $("#bpjs_kesehatan").val(response.bpjs_kesehatan);
                $("#sta").val(response.sta);
                $("#pajak").val(response.pajak);
                $("#thp_bulat").val(response.thp_bulat);
                $("#potongan_kopkar").val(response.potongan_kopkar);
                $("#nominal_rek").val(response.nominal_rek);
                $("#nominal_lain").val(response.nominal_lain);
                $("#nominal_prr_btn").val(response.nominal_prr_btn);
                $("#nominal_btnsolo").val(response.nominal_btnsolo);
                $("#nominal_koperasi").val(response.nominal_koperasi);
                $("#ket_rek_rs").val(response.ket_rek_rs);
                $("#ket_lain").val(response.ket_lain);
                $("#ket_prr_btn").val(response.ket_prr_btn);
                $("#ket_btn_solo").val(response.ket_btn_solo);
                $("#ket_koperasi").val(response.ket_koperasi);
                $("#jumlah_terima").val(response.jumlah_terima);
                $("#titik_perubahan").val(response.titik_perubahan);
                $("#nominal_ekstra").val(response.nominal_ekstra);
                $("#ket_ekstra").val(response.ket_ekstra);
                $("#jenis_ekstra").val(response.jenis_ekstra);
                $("#nik").val(nik);
                $("#jenis_gaji").val(jenis_gaji);
                $("#jml_potongan").val(response.jml_potongan);
                $("#tf_cimb_niaga").val(response.tf_cimb_niaga);
                $("#tf_bca").val(response.tf_bca);
                $("#pot_jkn_kelg").val(response.pot_jkn_kelg);
                $("#potongan_rs").val(response.potongan_rs);
                $("#pot_btn").val(response.pot_btn);
                $("#pot_jkn_kelg").val(response.pot_jkn_kelg);
                $("#tunai").val(response.tunai);
                $("#pot_koperasi").val(response.pot_koperasi);
                $("#thr").val(response.thr);
                //console.log(nik);

                generate_personal();

            }else{
                swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
            }
        }
    });
}

//button tambah digolongan XIII keatas
function generate_gaji_personal_XIIKeatas(){

    $('#modal-generate-gaji-personal-xiii-keatas').modal('hide');

    var tanggal   = $("#tanggal").val();
    var nik       = $("#nik").val();
    var jenis_gaji= $("#jenis_gaji").val();

    /*var tgl = tanggal.split('"');
    var bulantahun = tgl[0];*/

    $.ajax({
        url: base_url+'DataGajiKaryawan/getPersonalGajiToGenerateXIIKeatas',
        method: 'post',
        data: {
            periode: tanggal,
            nik: nik,
            jenis_gaji: jenis_gaji
        },
        dataType: 'json',
        async: false,
        success: function(response){

            console.log(response);
            
            if(response != "kosong"){

                $("#periode").val(tanggal);
                /*$("#thp_bulat").val(data.thpbulat);
                $("#potongan").val(data.potongan);
                $("#transfer_bank").val(data.totaltransfer);*/

                $("#gapok").val(response.gapok);
                $("#rapel").val(response.rapel);
                $("#pot_rs").val(response.potongan_rs);
                $("#tunj_khusus").val(response.tunjangan_khusus);
                $("#insentif").val(response.insentif);
                $("#pot_koperasi").val(response.pot_koperasi);
                $("#tunj_struktural").val(response.tunjangan_struktural);
                $("#potongan_jht").val(response.potongan_jht);
                $("#pot_btn").val(response.pot_btn);
                $("#tas").val(response.tas);
                $("#jaminan_pensiun").val(response.jaminan_pensiun);tunai
                $("#tunai").val(response.tunai);
                $("#penyesuaian").val(response.penyesuaian);
                $("#pot_jkn").val(response.bpjs_kesehatan);
                $("#jml_potongan").val(response.jml_potongan);
                $("#gross").val(response.gross);
                $("#status").val(response.status_gaji);
                $("#max_gross").val(response.maxgross);
                $("#pajak").val(response.pajak);
                $("#jml_terima").val(response.jumlah_terima);
                $("#honor").val(response.honor);
                $("#thr").val(response.thr);
                $("#lembur").val(response.lembur);
                $("#thp_bulat").val(response.thp_bulat);
                $("#pot_jkn_kelg").val(response.pot_jkn_kelg);
                $("#nik").val(nik);
                $("#jenis_gaji").val(jenis_gaji);
                $("#tf_cimb_niaga").val(tf_cimb_niaga);
                $("#tf_bca").val(tf_bca);
                $("#thr").val(response.thr);
                //console.log(nik);

                generate_personal_XIIKeatas();

            }else{
                swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
            }
        }
    });
}

function generate_personal_XIIKeatas(){

    $('#modal-generate-gaji-personal-xiii-keatas').modal('hide');

    var periode         = $("#periode").val();
    /*var thp_bulat       = $("#thp_bulat").val();
    var potongan        = $("#potongan").val();
    var totaltransfer   = $("#transfer_bank").val();*/

    var gapok                   = $("#gapok").val();
    var rapel                   = $("#rapel").val();
    var potongan_rs             = $("#pot_rs").val();
    var tunjangan_khusus        = $("#tunj_khusus").val();
    var insentif                = $("#insentif").val();
    var pot_koperasi            = $("#pot_koperasi").val();
    var tunjangan_struktural    = $("#tunj_struktural").val();
    var potongan_jht            = $("#potongan_jht").val();
    var pot_btn                 = $("#pot_btn").val();
    var tas                     = $("#tas").val();
    var jaminan_pensiun         = $("#jaminan_pensiun").val();
    var tunai                   = $("#tunai").val();
    var penyesuaian             = $("#penyesuaian").val();
    var bpjs_kesehatan          = $("#pot_jkn").val();
    var jml_potongan            = $("#jml_potongan").val();
    var gross                   = $("#gross").val();
    var status_gaji             = $("#status").val();
    var maxgross                = $("#max_gross").val();
    var pajak                   = $("#pajak").val();
    var jumlah_terima           = $("#jml_terima").val();
    var honor                   = $("#honor").val();
    var thr                     = $("#thr").val();
    var lembur                  = $("#lembur").val();
    var thp_bulat               = $("#thp_bulat").val();
    var pot_jkn_kelg            = $("#pot_jkn_kelg").val();

    var v_nik           = $("#nik").val();
    var jenis_gaji      = $("#jenis_gaji").val();
    var tf_cimb_niaga   =$("#tf_cimb_niaga").val();
    var tf_bca          = $("#tf_bca").val();

    var potongan_rs         = $("#potongan_rs").val();
    var pot_koperasi        = $("#pot_koperasi").val();
    var pot_btn             = $("#pot_btn").val();
    var tunai               = $("#tunai").val();
    var pot_jkn_kelg        = $("#pot_jkn_kelg").val();
    var ket_lain            = $("#ket_lain").val();


    //console.log(gapok);

    $.ajax({
        url: base_url+"DataGajiKaryawan/tambahDataGajiKaryawanXIIIKeatas",
        type: "post",
        data: {
            'periode': periode,
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
            'status_gaji': status_gaji,
            'maxgross': maxgross,
            'pajak': pajak,
            'jumlah_terima': jumlah_terima,
            'honor': honor,
            'thr': thr,
            'lembur': lembur,
            'thp_bulat': thp_bulat,
            'v_nik': v_nik,
            'jenis_gaji': jenis_gaji,
            'pot_jkn_kelg': pot_jkn_kelg,
            'tf_cimb_niaga':tf_cimb_niaga,
            'tf_bca':tf_bca,
            'potongan_rs':potongan_rs,
            'pot_koperasi':pot_koperasi,
            'pot_btn':pot_btn,
            'tunai':tunai,
            'pot_jkn_kelg':pot_jkn_kelg,
            'ket_lain':ket_lain
        },

        success: function(data) {

            if (data) {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil digenerate",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                var desc = "Berhasil Generate Gaji. Periode : "+periode;
                insert_log(desc);
            } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
                    var desc = "Gagal Generate Gaji. Periode : "+periode;
                    insert_log(desc);
                }
        }
    });

}

function generate_personal(){

    $('#modal-generate-gaji-personal').modal('hide');

    var periode         = $("#periode").val();
    /*var thp_bulat       = $("#thp_bulat").val();
    var potongan        = $("#potongan").val();
    var totaltransfer   = $("#transfer_bank").val();*/

    var gapok               = $("#gapok").val();
    var tunjangan_khusus    = $("#tunjangan_khusus").val();
    var tunjangan_struktural= $("#tunjangan_struktural").val();
    var penyesuaian         = $("#penyesuaian").val();
    var tas                 = $("#tas").val();
    var maxgross            = $("#maxgross").val();
    var dinas_malam         = $("#dinas_malam").val();
    var lembur              = $("#lembur").val();
    var rapel               = $("#rapel").val();
    var thr                 = $("#thr").val();
    var insentif            = $("#insentif").val();
    var gross               = $("#gross").val();
    var potongan_jht        = $("#potongan_jht").val();
    var jaminan_pensiun     = $("#jaminan_pensiun").val();
    var bpjs_kesehatan      = $("#bpjs_kesehatan").val();
    var sta                 = $("#sta").val();
    var pajak               = $("#pajak").val();
    var thp_bulat           = $("#thp_bulat").val();
    var potongan_kopkar     = $("#potongan_kopkar").val();
    var jml_potongan        = $("#jml_potongan").val();
    var nominal_rek         = $("#nominal_rek").val();
    var nominal_lain        = $("#nominal_lain").val();
    var nominal_prr_btn     = $("#nominal_prr_btn").val();
    var nominal_btnsolo     = $("#nominal_btnsolo").val();
    var nominal_koperasi    = $("#nominal_koperasi").val();
    var ket_rek_rs          = $("#ket_rek_rs").val();
    var ket_lain            = $("#ket_lain").val();
    var ket_prr_btn         = $("#ket_prr_btn").val();
    var ket_btn_solo        = $("#ket_btn_solo").val();
    var ket_koperasi        = $("#ket_koperasi").val();
    var jumlah_terima       = $("#jumlah_terima").val();
    var titik_perubahan     = $("#titik_perubahan").val();

    var nominal_ekstra      = $("#nominal_ekstra").val();
    var ket_ekstra          = $("#ket_ekstra").val();
    var jenis_ekstra        = $("#jenis_ekstra").val();

    var v_nik           = $("#nik").val();
    var jenis_gaji      = $("#jenis_gaji").val();
    var tf_cimb_niaga   = $("#tf_cimb_niaga").val();
    var tf_bca          = $("#tf_bca").val();


    var potongan_rs         = $("#potongan_rs").val();
    var pot_koperasi        = $("#pot_koperasi").val();
    var pot_btn             = $("#pot_btn").val();
    var tunai               = $("#tunai").val();
    var pot_jkn_kelg        = $("#pot_jkn_kelg").val();
    var ket_lain            = $("#ket_lain").val();
       //console.log(gapok);

    $.ajax({
        url: base_url+"DataGajiKaryawan/tambahDataGajiKaryawan",
        type: "post",
        data: {
            'periode': periode,
            'gapok': gapok,
            'tunjangan_khusus': tunjangan_khusus,
            'tunjangan_struktural': tunjangan_struktural,
            'penyesuaian': penyesuaian,
            'tas': tas,
            'maxgross': maxgross,
            'dinas_malam': dinas_malam,
            'lembur': lembur,
            'rapel': rapel,
            'thr': thr,
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
            'v_nik': v_nik,
            'jenis_gaji': jenis_gaji,
            'jml_potongan': jml_potongan,
            'nominal_ekstra': nominal_ekstra,
            'ket_ekstra': ket_ekstra,
            'jenis_ekstra': jenis_ekstra,
            'tf_cimb_niaga':tf_cimb_niaga,
            'tf_bca':tf_bca,
            'potongan_rs':potongan_rs,
            'pot_koperasi':pot_koperasi,
            'pot_btn':pot_btn,
            'tunai':tunai,
            'pot_jkn_kelg':pot_jkn_kelg,
            'ket_lain':ket_lain
        },

        success: function(data) {

            if (data) {
                swal({   
                    title: "Sukses!",
                    text: "Data anda berhasil diubah",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "success",
                });
                var desc = "Berhasil Generate Gaji. Periode : "+periode;
                insert_log(desc);
            } else {
                    swal({   
                        title: "Gagal!",
                        text: "Data anda gagal diubah, silahkan mengisi data dengan lengkap",
                        timer: 1500,
                        showConfirmButton: false,
                        type: "error",
                    });
                    var desc = "Gagal Generate Gaji. Periode : "+periode;
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

function print_slip_gaji(tanggal,v_nik,jenis_gaji,gol){
    // console.log(tanggal);
    // console.log(v_nik);
    // console.log(jenis_gaji);

    $.ajax({
        url: base_url+'DataGajiKaryawan/cetak_slip',
        method: 'POST',
        dataType: 'JSON',
        async: false,
        data: 
        {
          gol           : gol,
          tanggal       : tanggal,
          v_nik         : v_nik,
          jenis_gaji    : jenis_gaji
        },
        success: function (response) {
            console.log(response);
            if(response == 0){
                swal({   
                    title: "Peringatan!",
                    text: "Mohon gaji digenerate dahulu!",
                    timer: 1500,
                    showConfirmButton: false,
                    type: "warning",
                });
            }else{
                // console.log("print slip");
                printJS(response.response);
            }
              // printJS(response.response);
              //filterTable();
        }
    });
}