$('#mytabelkaryawan').DataTable();

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

function refresh_table_karyawan(n_unitrsid) {
    $.ajax({
        url: base_url+"Karyawan/refresh_table_karyawan",
        type: "post",
        data: {
            n_unitrsid: n_unitrsid
        },
        //async: false,
        success: function(data) {
            var n_unitrsid = $("#unit_by_user_filter_hidden").val();
            getListKaryawan(n_unitrsid);
        }

    });
}

function button_filter_unit(){
    $('#pemberitahuan_input_unit').show();
    $('#parent_tabel_profil').hide();
    var n_unitrsid = $("#unit_by_user_filter").val();
    
    getListKaryawan(n_unitrsid);
}

function getListKaryawan(n_unitrsid){

    //console.log(n_unitrsid);

    var n_unitrsid = $("#unit_by_user_filter").val();

       if (n_unitrsid == null) {
            swal({   
                title: "Gagal!",
                text: "Data anda gagal dicari, silahkan mengisi data dengan benar",
                timer: 1500,
                showConfirmButton: false,
                type: "error",
            });

        } else {

            var tabel_unit = '';
            var tabel_karyawan = '';

            $.ajax({
                url: base_url+"Karyawan/getListKaryawan",
                type: "post",
                data: {
                    'n_unitrsid': n_unitrsid
                },
                dataType: 'json',
                success: function(data) {

                //data_parse = JSON.parse(data);
                
                tabel_unit = '<input type="hidden" id="unit_by_user_filter_hidden" value="'+n_unitrsid+'">'+
                             '<br>'+
                             '<hr>';

    //----------------------------------------------batas kelompok-------------------------------------

                //var nomor = 1;

                tabel_karyawan=  '<div class="header" align="center"><h3><b>" '+data.list_unitrs.v_unitrsnama+' "</b></h3><br></div>'+
                                '<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="mytabelkaryawan">'+
                                '<thead>'+
                                '<tr bgcolor="#4682B4">'+
                                    //'<th>NO</th>'+
                                    '<th><font color="#ffffff">NIK</th>'+
                                    '<th><font color="#ffffff">NAMA</th>'+
                                '</tr>'+
                                '</thead>'+
                                '<tbody id="tabel_karyawan">';

                    if(data.list_karyawan){
                    $.each(data.list_karyawan, function (index, karyawan){

                        tabel_karyawan=tabel_karyawan+'<tr class="row_karyawan" karyawanPilih="'+karyawan.n_employee_id+'">'+
                            //'<td>' + nomor + '</td>' +
                            '<td>' + karyawan.v_nik + '</td>' +
                            '<td>' + karyawan.v_employee_name + '</td>' +
                            '</tr>';
                        
                        //nomor++;

                    });

                        tabel_karyawan += '</tbody></table>';

                        $("#tabel_unit").empty();
                        $("#tabel_karyawan").empty();
                        $("#tabel_unit").html(tabel_unit);
                        $("#tabel_karyawan").html(tabel_karyawan);
                        $("#mytabelkaryawan").DataTable();

                    } else{

                        tabel_karyawan +='<tr><center><h5><font color="red"> -------TIDAK ADA DATA -------- </font></h5></center></tr>';

                        tabel_karyawan += '</tbody></table>';

                        $("#tabel_unit").empty();
                        $("#tabel_karyawan").empty();
                        $("#tabel_unit").html(tabel_unit);
                        $("#tabel_karyawan").html(tabel_karyawan);

                    }

                $("#pemberitahuan_input_unit").hide();

                }
            });
        }
    }

    $(document).on("click", ".row_karyawan", function () {
        var tampil_data_karyawan = $(this).attr('karyawanPilih');
        var n_employee_id = tampil_data_karyawan;
        var bulanTahunGaji=$("#bulantahun_gaji").val();

        cari_detail_karyawan2(n_employee_id,bulanTahunGaji);

        $(this).addClass('pilihrow').siblings().removeClass('pilihrow');
    });

    $('#parent_tabel_profil').hide();

    function cari_detail_karyawan(n_employee_id) {

    $.ajax({
        url: base_url+"GajiKaryawan/cari_detail_karyawan",
        type: "post",
        data: {
            n_employee_id: n_employee_id
        },
        dataType: 'json',
        async: false,
        success: function(response) {
            if (response != null) {
                $('#parent_tabel_profil').show();
            } else {
                $('#parent_tabel_profil').show();
            }
            //$('#parent_tabel_profil').empty();

            var tabel_detail_karyawan =
                '<table class="table table-bordered table-striped dataTable" id="tabel_detail_karyawan">'+
                    '<tbody>';

                $.each(response, function (index, detailkaryawan){

                tabel_detail_karyawan+=   '<tr><th width="200px;"> NIK</th><td colspan="2">'+ detailkaryawan.v_nik +'</td></tr>'+
                        '<tr><th> NAMA</th><td colspan="2">'+ detailkaryawan.v_employee_name +'</td></tr>'+
                        '<tr><th> Tahun Gapok</th><td colspan="2">'+bulanGapok.y+'</td></tr>'+
                        '<tr><th> GOLONGAN</th><td colspan="2">'+ detailkaryawan.nama_golongan +'</td></tr>';

                });

                tabel_detail_karyawan+='</table>';
               
                tabel_detail_karyawan+='<table class="table table-bordered table-striped dataTable" id="tabel_detail_gaji">'+
                    '<tbody>';

                $.each(response, function (index, detailkaryawan){

                tabel_detail_karyawan+=   '<tr><th width="200px;"> Gapok</th><td colspan="2">'+gapok+'</td></tr>'+
                        '<tr><th> Tunjangan Khusus</th><td colspan="2"></td></tr>'+
                        '<tr><th> Tunjangan Struktural</th><td colspan="2"></td></tr>'+
                        '<tr><th> Penyesuaian</th><td colspan="2"></td></tr>'+
                        '<tr><th> Gross</th><td colspan="2"></td></tr>'+
                        '<tr><th> Tunjangan Alih Sistem</th><td colspan="2"></td></tr>'+
                        '<tr><th> Max Gross</th><td colspan="2"></td></tr>'+
                        '<tr><th> Tunjangan Khusus</th><td colspan="2"></td></tr>'+
                        '<tr><th> Rapel</th><td colspan="2"></td></tr>'+
                        '<tr><th> Dinas Malam</th><td colspan="2"></td></tr>'+
                        '<tr><th> Lembur</th><td colspan="2"></td></tr>'+
                        '<tr><th> Total Max Gross</th><td colspan="2"></td></tr>'+
                        '<tr><th> Premi Asuransi</th><td colspan="2"></td></tr>'+
                        '<tr><th> Total Gross + Premi</th><td colspan="2"></td></tr>'+
                        '<tr><th> Tunjangan Jabatan</th><td colspan="2"></td></tr>'+
                        '<tr><th> Potongan JHT</th><td colspan="2"></td></tr>'+
                        '<tr><th> Jaminan Pensiun</th><td colspan="2"></td></tr>'+
                        '<tr><th> BPJS Kesehatan</th><td colspan="2"></td></tr>'+
                        '<tr><th> Dasar Perhitungan Pajak</th><td colspan="2"></td></tr>'+
                        '<tr><th> PTKP</th><td colspan="2"></td></tr>'+
                        '<tr><th> Pendapatan Kena Pajak</th><td colspan="2"></td></tr>'+
                        '<tr><th> Pajak</th><td colspan="2"></td></tr>'+
                        '<tr><th> THP</th><td colspan="2"></td></tr>'+
                        '<tr><th> THP Pembulatan</th><td colspan="2"></td></tr>'+
                        '<tr><th> Total Potongan</th><td colspan="2"></td></tr>'+
                        '<tr><th> Terima Bersih</th><td colspan="2"></td></tr>';
                });

                tabel_detail_karyawan+= '</tbody>'+
                '</table>';

                //$('#parent_detail_tabel').empty();
                $('#parent_tabel_profil').html(tabel_detail_karyawan);
                $('#pemberitahuan_input_unit').hide();
                $('#pemberitahuan_input_karyawan').hide();
            
            }
        });
    }

    function cari_detail_karyawan2(n_employee_id, bulanTahunGaji) {

    $.ajax({
        url: base_url+"GajiKaryawan/cari_detail_karyawan",
        type: "post",
        data: {
            n_employee_id: n_employee_id,
            bulanTahunGajiHitung:bulanTahunGaji
        },
        dataType: 'json',
        async: false,
        success: function(response) {
            console.log(response.data_karyawan.v_nik);

                var dob=response.data_karyawan.d_employee_dob;
                var tunjangan_khusus=0;
                var tunjangan_struktural=0;
                var penyesuaian=0;
                var tas=0;
                var rapel=0;
                var dinas_malam=0;
                var lembur=0;
                var premi_asuransi=0;
                var premi_jkn=0;
                var tunjangan_jabatan=0;
                var potongan_pensiun=0;
                var bpjs_kesehatan=0;
                var ptkp=0;
                var pajak=0;
                var thp=0;
                var incentive=0;
                var thp_bulat=0;
                var terima_bersih=0;
                var potongan_jkn=0;
                var potongan_lain=0;
                var gross=0;
                var max_gross=0;
                var total_max_gross=0;
                var jkn=0;
                var total_gross_premi=0;
                var potongan_jht=0;
                var cek_plafon=0;
                var dasar_hitung_pajak=0;
                var pendapatan_kena_pajak=0;

            if (response != null) {
                $('#parent_tabel_profil').show();
            } else {
                $('#parent_tabel_profil').show();
            }
            // $('#parent_tabel_profil').empty();

            var tabel_detail_karyawan =
                '<table class="table table-bordered table-striped dataTable" id="tabel_detail_karyawan">'+
                    '<tbody>';

                tabel_detail_karyawan+=   '<tr><th width="200px;"> NIK</th><td colspan="2">'+ response.data_karyawan.v_nik +'</td></tr>'+
                        '<tr><th> NAMA</th><td colspan="2">'+ response.data_karyawan.v_employee_name +'</td></tr>'+
                        '<tr><th> Tahun Gapok</th><td colspan="2">'+ response.thGapok.th_gapok +'</td></tr>'+
                        '<tr><th> GOLONGAN</th><td colspan="2">'+ response.data_karyawan.nama_golongan +'</td></tr>';

                tabel_detail_karyawan+='</table>';
               
                tabel_detail_karyawan+='<table class="table table-bordered table-striped dataTable" id="tabel_detail_gaji">'+
                    '<tbody>';
                    
                $.each(response.potongan, function (index, potongan){
                    if(potongan.jenis_potongan=='jkn'){
                        potongan_jkn =parseInt(potongan_jkn) +parseInt(potongan.v_nominal);
                    }else{
                        potongan_lain=parseInt(potongan_lain) +parseInt(potongan.v_nominal);
                    }
                });
               
                 $.each(response.tambahan, function (index, tambahan){
                    if(tambahan.jenis_tambahan=='tunjangan_khusus'){
                        tunjangan_khusus =parseInt(tambahan.v_nominal);
                    }else if(tambahan.jenis_tambahan=='tunjangan_struktural'){
                        tunjangan_struktural =parseInt(tambahan.v_nominal);
                    }else if(tambahan.jenis_tambahan=='penyesuaian'){
                        penyesuaian =parseInt(tambahan.v_nominal);
                    }else if(tambahan.jenis_tambahan=='tas'){
                        tas =parseInt(tambahan.v_nominal);
                    }else if(tambahan.jenis_tambahan=='rapel'){
                        rapel =parseInt(tambahan.v_nominal);
                    }else if(tambahan.jenis_tambahan=='incentive'){
                        incentive =parseInt(tambahan.v_nominal);
                    }

                });

                if(response.gapok==''){
                    gapok=0;
                }else{
                    gapok=response.gapok;
                }
                console.log(gapok);
                console.log(tunjangan_struktural);
                console.log(penyesuaian);
                gross=parseInt(gapok)+parseInt(tunjangan_khusus)+parseInt(tunjangan_struktural)+parseInt(penyesuaian);
                max_gross=parseInt(gross)+parseInt(tas);
                
                total_max_gross=parseInt(max_gross)+parseInt(rapel)+parseInt(dinas_malam)+parseInt(lembur);

                premi_asuransi=max_gross*0.54/100;
                var cek_premi_jkn=max_gross*4/100;

                if(cek_premi_jkn<=320000){
                    premi_jkn=cek_premi_jkn;
                }else{
                    premi_jkn=320000;
                }
                
                jkn=potongan_jkn;
                total_gross_premi=parseInt(total_max_gross)+parseInt(premi_asuransi)+parseInt(jkn);
                
                var cek_tunjangan_jabatan=parseInt(max_gross)*5/100;

                if(cek_tunjangan_jabatan<=500000){
                    tunjangan_jabatan=cek_tunjangan_jabatan;
                }else{
                    tunjangan_jabatan=500000;
                }
            
                potongan_jht=parseInt(max_gross)*2/100;

                var cek_plafon=parseInt(max_gross)*1/100;

                var today = new Date();
                var umur=today.getFullYear()-parseInt(dob.substring(0,4));
                console.log(umur);

                if(umur < 56){
                    if(cek_plafon<=80940){
                        potongan_pensiun=cek_plafon;
                    }else{
                        potongan_pensiun=80940;
                    }
                }else{
                    potongan_pensiun=0;
                }

                if(cek_plafon<=80000){
                    bpjs_kesehatan=cek_plafon;
                }else{
                    bpjs_kesehatan=80000;
                }
                dasar_hitung_pajak=total_gross_premi+tunjangan_jabatan+potongan_jht+potongan_pensiun;            
                pendapatan_kena_pajak=dasar_hitung_pajak-ptkp;
                                                                                                           
                tabel_detail_karyawan+=   '<tr><th width="200px;"> Gapok</th><td colspan="2" align="right"> Rp. '+ numeral(gapok).format('0,0') +'</td></tr>'+
                        '<tr><th> Tunjangan Khusus</th><td colspan="2">Rp. '+ numeral(tunjangan_khusus).format('0,0') +'</td></tr>'+
                        '<tr><th> Tunjangan Struktural</th><td colspan="2">Rp. '+ numeral(tunjangan_struktural).format('0,0') +'</td></tr>'+
                        '<tr><th> Penyesuaian</th><td colspan="2">Rp. '+ numeral(penyesuaian).format('0,0') +'</td></tr>'+
                        '<tr><th> Gross</th><td colspan="2" align="right">Rp. '+ numeral(gross).format('0,0') +'</td></tr>'+
                        '<tr><th> Tunjangan Alih Sistem</th><td colspan="2">Rp. '+ numeral(tas).format('0,0') +'</td></tr>'+
                        '<tr><th> Max Gross</th><td colspan="2" align="right">Rp. '+ numeral(max_gross).format('0,0') +'</td></tr>'+
                        '<tr><th> Rapel</th><td colspan="2">Rp. '+ numeral(rapel).format('0,0') +'</td></tr>'+
                        '<tr><th> Dinas Malam</th><td colspan="2">Rp. '+ numeral(dinas_malam).format('0,0') +'</td></tr>'+
                        '<tr><th> Lembur</th><td colspan="2">Rp. '+ numeral(lembur).format('0,0') +'</td></tr>'+
                        '<tr><th> Total Max Gross</th><td colspan="2" align="right">Rp. '+ numeral(total_max_gross).format('0,0') +'</td></tr>'+
                        '<tr><th> Premi Asuransi</th><td colspan="2">Rp. '+ numeral(premi_asuransi).format('0,0') +'</td></tr>'+
                        '<tr><th> Premi JKN</th><td colspan="2">Rp. '+ numeral(premi_jkn).format('0,0') +'</td></tr>'+
                        '<tr><th> Total Gross + Premi</th><td colspan="2" align="right">Rp. '+ numeral(total_gross_premi).format('0,0') +'</td></tr>'+
                        '<tr><th> Tunjangan Jabatan</th><td colspan="2">Rp. '+ numeral(tunjangan_jabatan).format('0,0') +'</td></tr>'+
                        '<tr><th> Potongan JHT</th><td colspan="2">Rp. '+ numeral(potongan_jht).format('0,0') +'</td></tr>'+
                        '<tr><th> Jaminan Pensiun</th><td colspan="2">Rp. '+ numeral(potongan_pensiun).format('0,0') +'</td></tr>'+
                        '<tr><th> BPJS Kesehatan</th><td colspan="2">Rp. '+ numeral(jkn).format('0,0') +'</td></tr>'+
                        '<tr><th> Dasar Perhitungan Pajak</th><td colspan="2">Rp. '+ numeral(dasar_hitung_pajak).format('0,0') +'</td></tr>'+
                        '<tr><th> PTKP</th><td colspan="2">Rp. '+ numeral(ptkp).format('0,0') +'</td></tr>'+
                        '<tr><th> Pendapatan Kena Pajak</th><td colspan="2">Rp. '+ numeral(pendapatan_kena_pajak).format('0,0') +'</td></tr>'+
                        '<tr><th> Pajak</th><td colspan="2">Rp. '+ numeral(pajak).format('0,0') +'</td></tr>'+
                        '<tr><th> THP</th><td colspan="2">Rp. '+ numeral(thp).format('0,0') +'</td></tr>'+
                        '<tr><th> INCENTIVE</th><td colspan="2">Rp. '+ numeral(incentive).format('0,0') +'</td></tr>'+
                        '<tr><th> THP Pembulatan</th><td colspan="2">Rp. '+ numeral(thp_bulat).format('0,0') +'</td></tr>'+
                        '<tr><th> Total Potongan</th><td colspan="2">Rp. '+ numeral(potongan_lain).format('0,0') +'</td></tr>'+
                        '<tr><th> Terima Bersih</th><td colspan="2"align="right">Rp. '+ numeral(terima_bersih).format('0,0') +'</td></tr>';
                // });

                tabel_detail_karyawan+= '</tbody>'+
                '</table>';

                // $('#parent_detail_tabel').empty();
                $('#parent_tabel_profil').html(tabel_detail_karyawan);
                $('#pemberitahuan_input_unit').hide();
                $('#pemberitahuan_input_karyawan').hide();
            
            }
        });
    }
    function getGapok(golongan_id,th_gapok) {
    $.ajax({
        url: base_url+"GajiKaryawan/getGapok",
        type: "post",
        data: {
            golongan: golongan_id,
            thGapok:th_gapok
        },
        //async: false,
        success: function(data) {
            $("#no_mr").val(response.v_mr_code);
        }

    });
}

