
$(document).ajaxStart(function(){
  $('#loading').show();
});

$(document).ajaxComplete(function(){
  $('#loading').hide();
});

$('#myDatepicker2').datetimepicker({
    format: 'MM/YYYY'
});

$('#pemberitahuan').show();

function toDataURL(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.onload = function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      callback(reader.result);
    }
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
}

function button_filter_laporan_gaji_bawah13(){
	$('#pemberitahuan').hide();
	var periode_gaji = $("#periode_gaji").val();
	var jenis_gaji = $("#jenis_gaji").val();
	console.log(periode_gaji);
	// console.log(jenis_gaji);
	var total_gross;
	var total_THP;
	var total_karyawan;
	var total_Allgapok;
	var total_AllTunjStruktural;
	
	$.ajax({
	    url: base_url+'LapGajipergolongan/getJmlKaryawanXIIKeBawah',
	    type: 'post',
	    dataType: 'json',
	    async: true,
	    data:
	    {
	    	'periode_gaji' : periode_gaji,
	    	'jenis_gaji' : jenis_gaji

	    },
	    success: function(response) {
	    	// console.log(response.detail);
	    	var periode_bulan = periode_gaji.split('/');
            var bulan_angka = periode_bulan[0];
            var tahun = periode_bulan[1];
            // console.log(bulan_angka);
            if(bulan_angka == "01"){
            	var bulan_nama = "JAN";
            }else if(bulan_angka == "02"){
            	var bulan_nama = "FEB";
            }else if(bulan_angka == "03"){
            	var bulan_nama = "MAR";
            }else if(bulan_angka == "04"){
            	var bulan_nama = "APR";
            }else if(bulan_angka == "05"){
            	var bulan_nama = "MEI";
            }else if(bulan_angka == "06"){
            	var bulan_nama = "JUN";
            }else if(bulan_angka == "07"){
            	var bulan_nama = "JUL";
            }else if(bulan_angka == "08"){
            	var bulan_nama = "AGUST";
            }else if(bulan_angka == "09"){
            	var bulan_nama = "SEPT";
            }else if(bulan_angka == "10"){
            	var bulan_nama = "OKT";
            }else if(bulan_angka == "11"){
            	var bulan_nama = "NOV";
            }else{
            	var bulan_nama = "DES";
            }

	    	if(response.detail == null){
	    		tabel_LapGajiPerGolongan= '<h4 align="center"><b>=============    Tidak ada data =============</b></h4>';
	    		$("#tabel_LapGajiPerGolongan").html(tabel_LapGajiPerGolongan);

	    	}else{

	    	
	    	var url = base_url+'assets/images/payroll.png';
            var hasil_lihat_file = '<img src="'+url+'" type="application/jpg" style="width:10%;height:10%"></img>';
	    	
	    	tabel_LapGajiPerGolongan= '<h4 align="center"><b>LAPORAN GAJI (NON SARJANA) PER GOLONGAN I-XII BULAN '+bulan_nama+' '+tahun+'</b></h4><br>'+
	    						'<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="tb_LapGajiPerGolongan">'+
                                '<thead>'+
                                '<tr bgcolor="#424242">'+
                                    '<th rowspan="2" style="vertical-align : middle;text-align:center;"><font color="#ffffff">GOLONGAN</th>'+
									'<th colspan="20" style="text-align:center;"><font color="#ffffff">JUMLAH</th>'+
									
                          
                                '</tr><tr bgcolor="#424242">'+
                                	'<th align="center"><font color="#ffffff">KARY</th>'+
                                    '<th><font color="#ffffff">GAJI POKOK</th>'+
                                    '<th><font color="#ffffff">TUNJ.STRUKTURAL</th>'+
                                    '<th><font color="#ffffff">TUNJ.KHUSUS</th>'+
                                    '<th><font color="#ffffff">TUNJ.ALIH SISTEM</th>'+
                                    '<th><font color="#ffffff">PENYESUAIAN</th>'+
                                    '<th><font color="#ffffff">GROSS</th>'+
                                    '<th><font color="#ffffff">DINAS MALAM</th>'+
                                    '<th><font color="#ffffff">LEMBUR</th>'+
                                    '<th><font color="#ffffff">LAIN-LAIN/ RAPEL</th>'+
                                    '<th><font color="#ffffff">INSENTIF</th>'+
                                    '<th><font color="#ffffff">TOT.GROSS</th>'+
                                    '<th><font color="#ffffff">POTONGAN JHT</th>'+
                                    '<th><font color="#ffffff">POTONGAN JP</th>'+
                                    '<th><font color="#ffffff">PPH 21</th>'+
                                    '<th><font color="#ffffff">POTONGAN JKN</th>'+
                                    '<th><font color="#ffffff">THP BULAT</th>'+
                                    '<th><font color="#ffffff">GAJI BERSIH</th>'+
                      
                                '</tr>'+
                                '</thead>'+
                                '<tbody id="tabel_LapGajiPerGolongan">';

           
            $.each(response.detail, function (index, data){
            	var id_golongan = data.id_golongan;

            	//total gaji pokok
	    		$.ajax({
			        url: base_url+"LapGajipergolongan/getGapokXIIKeBawah",
			        type: "post",
			        data: {
			            'id_golongan': id_golongan,
			            'periode_gaji' : periode_gaji,
	    				'jenis_gaji' : jenis_gaji
			           
			        },
			        dataType: 'json',
			        async: false,
			        success: function(response) {
			        	// console.log(response);
			        	var highlights = response;
			        	//gapok
						t_gapok = highlights.reduce( function(tot, record) {
						    return tot + record.gapok;
						},0);

						//tunjangan struktural
						t_tunjStruktural = highlights.reduce( function(tot, record) {
						    return tot + record.tunjangan_struktural;
						},0);

						//tunjangan khusus
						t_tunjKhusus = highlights.reduce( function(tot, record) {
						    return tot + record.tunjangan_khusus;
						},0);

						//TAS
						t_TAS = highlights.reduce( function(tot, record) {
						    return tot + record.tas;
						},0);

						//penyesuaian
						t_penyesuaian = highlights.reduce( function(tot, record) {
						    return tot + record.penyesuaian;
						},0);

						//maxgross
						t_maxgross = highlights.reduce( function(tot, record) {
						    return tot + record.maxgross;
						},0);

						//dinas malam
						t_dinasmalam = highlights.reduce( function(tot, record) {
						    return tot + record.dinas_malam;
						},0);

						//lembur
						t_lembur = highlights.reduce( function(tot, record) {
						    return tot + record.lembur;
						},0);

						//rapel&lain-lain
						t_rapellain = highlights.reduce( function(tot, record) {
						    return tot + record.rapel;
						},0);

						// insentif
						t_insentif = highlights.reduce( function(tot, record) {
						    return tot + record.insentif;
						},0);

						//gross
						t_gross = highlights.reduce( function(tot, record) {
						    return tot + record.gross;
						},0);

						//potongan JHT
						t_potJHT = highlights.reduce( function(tot, record) {
						    return tot + record.potongan_jht;
						},0);

						//jaminan pensiun
						t_jaminanpensiun = highlights.reduce( function(tot, record) {
						    return tot + record.jaminan_pensiun;
						},0);

						//pph 21
						t_pph21 = highlights.reduce( function(tot, record) {
						    return tot + record.pajak;
						},0);

						//potongan JKN
						t_PotJKN = highlights.reduce( function(tot, record) {
						    return tot + record.bpjs_kesehatan;
						},0);

						//THP Bulat
						t_ThpBulat = highlights.reduce( function(tot, record) {
						    return tot + record.thp_bulat;
						},0);

						//gaji bersih
						t_GajiBersih = highlights.reduce( function(tot, record) {
						    return tot + record.jumlah_terima;
						},0);

			        }
			    });


	    		//gapok
			    var	number_string = t_gapok.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}

				var total_gapok = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			  
			   	//tunjangan sturktural
			    var	number_string = t_tunjStruktural.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_tunjStruktural = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//tunjangan khusus
			    var	number_string = t_tunjKhusus.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_tunjKhusus = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			  
				//TAS
			    var	number_string = t_TAS.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_TAS = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    
				//penyesuaian
			    var	number_string = t_penyesuaian.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_penyesuaian = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //gross - maxgross
			    var	number_string = t_maxgross.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_maxgross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total dinas malam
			    var	number_string = t_dinasmalam.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_dinasmalam = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


			    //total lembur
			    var	number_string = t_lembur.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_lembur = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total rapel/ lain-lain
			    var	number_string = t_rapellain.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_rapellain = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total insentif
			    var	number_string = t_insentif.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_insentif = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total gross
	    		var	number_string = t_gross.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_gross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    
			    //total potongan jht
			    var	number_string = t_potJHT.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_potJHT = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total Jaminan Pensiun
			   	var	number_string = t_jaminanpensiun.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_jaminanpensiun = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total pajak (PPH 21)
			    var	number_string = t_pph21.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_pph21 = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total potongan JKN
			    var	number_string = t_PotJKN.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_PotJKN = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total semua thp bulat
			   	var	number_string = t_ThpBulat.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_ThpBulat = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

			    //total semua gaji bersih
			  	var	number_string = t_GajiBersih.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var total_GajiBersih = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				// =========== footer (total semua) ==============
			    //total semua karyawan
			    $.ajax({
			        url: base_url+"LapGajipergolongan/getJumKaryawan",
			        type: "post",
			        data: {
			            'id_golongan': id_golongan,
			            'periode_gaji' : periode_gaji,
	    				'jenis_gaji' : jenis_gaji
			        },
			        dataType: 'json',
			        async: false,
			        success: function(response) {
			        	// console.log(response.total_karyawan);
			        	total_karyawan = response.total_karyawan;
			         
			        }
			    });

			    //total semua gapok
			    $.ajax({
			        url: base_url+"LapGajipergolongan/getAllGapokXIIKeBawah",
			        type: "post",
			        data: {
			            'periode_gaji' : periode_gaji,
	    				'jenis_gaji' : jenis_gaji
			           
			        },
			        dataType: 'json',
			        async: false,
			        success: function(response) {
			        	// console.log(response);
			        	var highlights = response;

			        	//total gapok
						total_Allgapok = highlights.reduce( function(tot, record) {
						    return tot + record.allgapok;
						},0);

						//total tunj. stukrtural
						total_AllTunjStruktural = highlights.reduce( function(tot, record) {
						    return tot + record.tunjangan_struktural;
						},0);

						//total tunjangan khusus
						total_AllTunjKhusus = highlights.reduce( function(tot, record) {
						    return tot + record.tunjangan_khusus;
						},0);

						//total TAS
						total_AllTAS = highlights.reduce( function(tot, record) {
						    return tot + record.tas;
						},0);

						//total penyesuaian
						total_AllPenyesuaian = highlights.reduce( function(tot, record) {
						    return tot + record.penyesuaian;
						},0);

						//total maxgross(total gross)
						total_AllMaxgross = highlights.reduce( function(tot, record) {
						    return tot + record.maxgross;
						},0);

						//total dinas malam
						total_AllDinasMalam = highlights.reduce( function(tot, record) {
						    return tot + record.dinas_malam;
						},0);

						//total lembur
						total_AllLembur = highlights.reduce( function(tot, record) {
						    return tot + record.lembur;
						},0);

						//total rapel
						total_AllRapel = highlights.reduce( function(tot, record) {
						    return tot + record.rapel;
						},0);

						//total insentif
						total_AllInsentif = highlights.reduce( function(tot, record) {
						    return tot + record.insentif;
						},0);

						//total gross
						total_AllTotGross = highlights.reduce( function(tot, record) {
						    return tot + record.gross;
						},0);

						//total potongan JHT
						total_AllPotJHT = highlights.reduce( function(tot, record) {
						    return tot + record.potongan_jht;
						},0);

						//total potongan jaminan pensium
						total_AllPotJP = highlights.reduce( function(tot, record) {
						    return tot + record.jaminan_pensiun;
						},0);

						//total pajak
						total_AllPPH21 = highlights.reduce( function(tot, record) {
						    return tot + record.pajak;
						},0);

						//total potongan JKN
			         	total_AllBPJSKes = highlights.reduce( function(tot, record) {
						    return tot + record.bpjs_kesehatan;
						},0);

						//total THP bulat
						total_AllThpBulat = highlights.reduce( function(tot, record) {
						    return tot + record.thp_bulat;
						},0);

						//total gaji bersih
						total_AllGajiBersih = highlights.reduce( function(tot, record) {
						    return tot + record.jumlah_terima;
						},0);

			        }
			    });

			    

                tabel_LapGajiPerGolongan=tabel_LapGajiPerGolongan+'<tr>'+
	                    '<td align="center">'+data.golongan +'</td>' +
	                    '<td align="center">'+data.jumlah_karyawan+'</td>' +
	                    '<td align="right">Rp.'+total_gapok+'</td>' +
	                    '<td align="right">Rp.'+total_tunjStruktural+'</td>' +
	                    '<td align="right">Rp.'+total_tunjKhusus+'</td>' +
	                    '<td align="right">Rp.'+total_TAS+'</td>' +
	                    '<td align="right">Rp.'+total_penyesuaian+'</td>' +
	                    '<td align="right">Rp.'+total_maxgross+'</td>' +
	                    '<td align="right">Rp.'+total_dinasmalam+'</td>' +
	                    '<td align="right">Rp.'+total_lembur+'</td>' +
	                    '<td align="right">Rp.'+total_rapellain+'</td>' +
	                    '<td align="right">Rp.'+total_insentif+'</td>' +
	                    '<td align="right">Rp.'+total_gross+'</td>' +
	                    '<td align="right">Rp.'+total_potJHT+'</td>' +
	                    '<td align="right">Rp.'+total_jaminanpensiun+'</td>' +
	                    '<td align="right">Rp.'+total_pph21+'</td>' +
	                    '<td align="right">Rp.'+total_PotJKN+'</td>' +
	                    '<td align="right">Rp.'+total_ThpBulat+'</td>' +
	                    '<td align="right">Rp.'+total_GajiBersih+'</td>' +
                    '</tr>';

            });
				
				//gaji pokok
				var	number_string = total_Allgapok.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var Gapok = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//tunjangan struktural
				var	number_string = total_AllTunjStruktural.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var TunjanganStruktural = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//tunjangan khusus
				var	number_string = total_AllTunjKhusus.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var TunjanganKhusus = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//TAS
				var	number_string = total_AllTAS.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var TAS = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//Penyesuaian
				var	number_string = total_AllPenyesuaian.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var Penyesuaian = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//Gross
				var	number_string = total_AllMaxgross.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var Gross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//Dinas Malam
				var	number_string = total_AllDinasMalam.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var DinasMalam = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//Lembur
				var	number_string = total_AllLembur.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var Lembur = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//Rapel/Lain-lain
				var	number_string = total_AllRapel.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var RapelLain2 = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//Insentif
				var	number_string = total_AllInsentif.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var Insentif = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//Total Gross
				var	number_string = total_AllTotGross.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var TotalGross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//Total Potongan JHT
				var	number_string = total_AllPotJHT.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var PotonganJHT = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//Potongan JP
				var	number_string = total_AllPotJP.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var PotonganJP = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//PPH 21
				var	number_string = total_AllPPH21.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var PPH = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

				//BPJS Kesehatan
				var	number_string = total_AllBPJSKes.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var BPJSKesehatan = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//THP Bulat
				var	number_string = total_AllThpBulat.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var Thpbulat = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


				//gaji bersih
				var	number_string = total_AllGajiBersih.toString(),
					split	= number_string.split('.'),
					sisa 	= split[0].length % 3,
					rupiah 	= split[0].substr(0, sisa),
					ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
						
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				var GajiBersih = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


                tabel_LapGajiPerGolongan += '</tbody><tfoot>'+
                		'<tr>'+
                    	'<td><b>TOTAL</b></td>' +
                    	'<td align="center">'+total_karyawan+'</td>' +
                    	'<td align="right">Rp.'+Gapok+'</td>' +
                    	'<td align="right">Rp.'+TunjanganStruktural+'</td>' +
                    	'<td align="right">Rp.'+TunjanganKhusus+'</td>' +
                    	'<td align="right">Rp.'+TAS+'</td>' +
                    	'<td align="right">Rp.'+Penyesuaian+'</td>' +
                    	'<td align="right">Rp.'+Gross+'</td>' +
                    	'<td align="right">Rp.'+DinasMalam+'</td>' +
                    	'<td align="right">Rp.'+Lembur+'</td>' +
                    	'<td align="right">Rp.'+RapelLain2+'</td>' +
                    	'<td align="right">Rp.'+Insentif+'</td>' +
                    	'<td align="right">Rp.'+TotalGross+'</td>' +
                    	'<td align="right">Rp.'+PotonganJHT+'</td>' +
                    	'<td align="right">Rp.'+PotonganJP+'</td>' +
                    	'<td align="right">Rp.'+PPH+'</td>' +
                    	'<td align="right">Rp.'+BPJSKesehatan+'</td>' +
                    	'<td align="right">Rp.'+Thpbulat+'</td>' +
                    	'<td align="right">Rp.'+GajiBersih+'</td>' +
                    '</tr>'+
                	'</table>';

                
                $("#tabel_LapGajiPerGolongan").empty();
                $("#tabel_LapGajiPerGolongan").html(tabel_LapGajiPerGolongan);
                // $("div.toolbar").html('<h3 align="center">RUMAH SAKIT Dr. OEN KANDANG SAPI SOLO <br> Jl. Brigjen Katamso No. 55 <br> Surakarta 57128</h3>');
               
                $("#tb_LapGajiPerGolongan").DataTable({
                	iDisplayLength: 100,
					lengthChange: false,
                	dom: 'Bfrtip',
                    responsive: true,
                    spans:true,	
                    "stripeClasses": [ 'odd-row', 'even-row' ],
                    buttons: [
                    
                        {
                            extend: 'excel',
                            footer: true,
                            exportOptions: {
			                    columns: [ ':visible' ]
			                },
                            title: 'Laporan Data Gaji Karyawan',
                            className: 'btn btn-success btn-sm',
                            text: '<i class="fa fa-file-excel-o" style="font-size: 15px;"></i> Excel',
                           
                        },
                        {
                           
                            extend: 'pdfHtml5',
			                orientation: 'landscape',
			                pageSize: 'LEGAL',
			                exportOptions: {
			                    columns: [ ':visible' ]
			                },
			                customize: function (doc) {
						        doc.pageMargins = [20,10,10,10];
						        doc.defaultStyle.fontSize = 7;
						        doc.styles.tableHeader.fontSize = 7;
						        doc.styles.tableHeader.fillColor = "#424242";
						        doc.styles.tableFooter.fillColor = "#828282";
						        doc.styles.tableFooter.fontSize = 7;
						        doc.styles.title.fontSize = 9;
						        doc.styles.title = {
							      fontSize: '10',
							      fontStyle: 'bold',
							      alignment: 'center'
							    }   
						  		//toDataURL('http://localhost/sipakar/assets/images/payroll.png', function(dataUrl) {
								//   console.log('RESULT:', dataUrl);
								// })
						        // doc.content.splice( 1, 0, {
						        // } ); 
						       
						        doc.content[0].text = doc.content[0].text.trim();


						        // Create a footer
						        doc['footer']=(function(page, pages) {
						            return {
						                columns: [
						                    '',
						                    {
						                        // This is the right column
						                        alignment: 'right',
						                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
						                    }
						                ],
						                margin: [10, 0]
						            }
						        });
						        // Styling the table: create style object
						        var objLayout = {};
						        // Horizontal line thickness
						        objLayout['hLineWidth'] = function(i) { return .5; };
						        // Vertikal line thickness
						        objLayout['vLineWidth'] = function(i) { return .5; };
						        // Horizontal line color
						        objLayout['hLineColor'] = function(i) { return '#aaa'; };
						        // Vertical line color
						        objLayout['vLineColor'] = function(i) { return '#aaa'; };
						        // Left padding of the cell
						        objLayout['paddingLeft'] = function(i) { return 4; };
						        // Right padding of the cell
						        objLayout['paddingRight'] = function(i) { return 4; };
						        // Inject the object in the document
						        doc.content[1].layout = objLayout;
						    },

                            footer: true,
                            title: 'LAPORAN GAJI (NON SARJANA) PER GOLONGAN BULAN '+bulan_nama+' '+tahun+' \n RUMAH SAKIT Dr.OEN KANDANG SAPI SOLO',
                            className: 'btn btn-danger btn-sm',
                            text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> PDF'

                        }//,
						// {
			   //      		extend:'colvis',
			   //      		className: 'btn btn-warning btn-sm',
			   //      		text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> Pilih'

			   //      	}
                    ]
                });
	    
	    
	    }}
	    
	});
}

function button_filter_laporan_gaji_atas13(){
	$('#pemberitahuan').hide();
	var periode_gaji = $("#periode_gajiXIIIkeatas").val();
	var jenis_gaji = $("#jenis_gajiXIIIkeatas").val();

	var periode_bulan = periode_gaji.split('/');
    var bulan_angka = periode_bulan[0];
    var tahun = periode_bulan[1];
    // console.log(bulan_angka);
    if(bulan_angka == "01"){
    	var bulan_nama = "JAN";
    }else if(bulan_angka == "02"){
    	var bulan_nama = "FEB";
    }else if(bulan_angka == "03"){
    	var bulan_nama = "MAR";
    }else if(bulan_angka == "04"){
    	var bulan_nama = "APR";
    }else if(bulan_angka == "05"){
    	var bulan_nama = "MEI";
    }else if(bulan_angka == "06"){
    	var bulan_nama = "JUN";
    }else if(bulan_angka == "07"){
    	var bulan_nama = "JUL";
    }else if(bulan_angka == "08"){
    	var bulan_nama = "AGUST";
    }else if(bulan_angka == "09"){
    	var bulan_nama = "SEPT";
    }else if(bulan_angka == "10"){
    	var bulan_nama = "OKT";
    }else if(bulan_angka == "11"){
    	var bulan_nama = "NOV";
    }else{
    	var bulan_nama = "DES";
    }


	console.log(periode_gaji);
	console.log(jenis_gaji);
	$.ajax({
	    url: base_url+'LapGajipergolongan/getJmlKaryawanXIIIKeAtas',
	    type: 'post',
	    dataType: 'json',
	    async: true,
	    data:
	    {
	    	'periode_gaji' : periode_gaji,
	    	'jenis_gaji' : jenis_gaji

	    },
	    success: function(response) {
	    	if(response.detail == null){
	    		tabel_LapGajiPerGolonganAtasXII= '<h4 align="center"><b>=============    Tidak ada data =============</b></h4>';
	    		$("#tabel_LapGajiPerGolonganAtasXII").html(tabel_LapGajiPerGolonganAtasXII);

	    	}else{

	    		tabel_LapGajiPerGolonganAtasXII= '<h4 align="center"><b>LAPORAN GAJI PER GOLONGAN XIII KEATAS BULAN '+bulan_nama+' '+tahun+'</b></h4><br>'+
	    						'<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="tb_LapGajiPerGolonganAtasXII">'+
                                '<thead>'+
                                '<tr bgcolor="#424242">'+
                                    '<th rowspan="2" style="vertical-align : middle;text-align:center;"><font color="#ffffff">GOLONGAN</th>'+
									'<th colspan="20" style="text-align: center;"><font color="#ffffff">JUMLAH</th>'+
									
                          
                                '</tr><tr bgcolor="#424242">'+
                                	'<th align="center"><font color="#ffffff">KARY</th>'+
                                    '<th><font color="#ffffff">GAJI POKOK</th>'+
                                    '<th><font color="#ffffff">TUNJ.STRUKTURAL</th>'+
                                    '<th><font color="#ffffff">TUNJ.KHUSUS</th>'+
                                    '<th><font color="#ffffff">TUNJ.ALIH SISTEM</th>'+
                                    '<th><font color="#ffffff">PENYESUAIAN</th>'+
                                    '<th><font color="#ffffff">GROSS</th>'+
                                    '<th><font color="#ffffff">DINAS MALAM</th>'+
                                    '<th><font color="#ffffff">LEMBUR</th>'+
                                    '<th><font color="#ffffff">LAIN-LAIN/ RAPEL</th>'+
                                    '<th><font color="#ffffff">INSENTIF</th>'+
                                    '<th><font color="#ffffff">TOT.GROSS</th>'+
                                    '<th><font color="#ffffff">POTONGAN JHT</th>'+
                                    '<th><font color="#ffffff">POTONGAN JP</th>'+
                                    '<th><font color="#ffffff">PPH 21</th>'+
                                    '<th><font color="#ffffff">POTONGAN JKN</th>'+
                                    '<th><font color="#ffffff">THP BULAT</th>'+
                                    '<th><font color="#ffffff">GAJI BERSIH</th>'+
                      
                                '</tr>'+
                                '</thead>'+
                                '<tbody id="tabel_LapGajiPerGolonganAtasXII">';
		            $.each(response.detail, function (index, data){
		            	var id_golongan = data.id_golongan;

		            	//total gaji pergolongan detail
		            	$.ajax({
					        url: base_url+"LapGajipergolongan/getGapokXIIIKeAtas",
					        type: "post",
					        data: {
					            'id_golongan': id_golongan,
					            'periode_gaji' : periode_gaji,
			    				'jenis_gaji' : jenis_gaji
					           
					        },
					        dataType: 'json',
					        async: false,
					        success: function(response) {
					        	// console.log(response);
					        	var highlights = response;
					        	//gapok
								t_gapok = highlights.reduce( function(tot, record) {
								    return tot + record.gapok;
								},0);

								//tunjangan struktural
								t_tunjStruktural = highlights.reduce( function(tot, record) {
								    return tot + record.tunjangan_struktural;
								},0);

								//tunjangan khusus
								t_tunjKhusus = highlights.reduce( function(tot, record) {
								    return tot + record.tunjangan_khusus;
								},0);

								//TAS
								t_TAS = highlights.reduce( function(tot, record) {
								    return tot + record.tas;
								},0);

								//penyesuaian
								t_penyesuaian = highlights.reduce( function(tot, record) {
								    return tot + record.penyesuaian;
								},0);

								//maxgross
								t_maxgross = highlights.reduce( function(tot, record) {
								    return tot + record.maxgross;
								},0);

								//dinas malam
								t_dinasmalam = highlights.reduce( function(tot, record) {
								    return tot + record.dinas_malam;
								},0);

								//lembur
								t_lembur = highlights.reduce( function(tot, record) {
								    return tot + record.lembur;
								},0);

								//rapel&lain-lain
								t_rapellain = highlights.reduce( function(tot, record) {
								    return tot + record.rapel;
								},0);

								// insentif
								t_insentif = highlights.reduce( function(tot, record) {
								    return tot + record.insentif;
								},0);

								//gross
								t_gross = highlights.reduce( function(tot, record) {
								    return tot + record.gross;
								},0);

								//potongan JHT
								t_potJHT = highlights.reduce( function(tot, record) {
								    return tot + record.potongan_jht;
								},0);

								//jaminan pensiun
								t_jaminanpensiun = highlights.reduce( function(tot, record) {
								    return tot + record.jaminan_pensiun;
								},0);

								//pph 21
								t_pph21 = highlights.reduce( function(tot, record) {
								    return tot + record.pajak;
								},0);

								//potongan JKN
								t_PotJKN = highlights.reduce( function(tot, record) {
								    return tot + record.bpjs_kesehatan;
								},0);

								//THP Bulat
								t_ThpBulat = highlights.reduce( function(tot, record) {
								    return tot + record.thp_bulat;
								},0);

								//gaji bersih
								t_GajiBersih = highlights.reduce( function(tot, record) {
								    return tot + record.jumlah_terima;
								},0);

					        }
					    });

					    //gapok
					    var	number_string = t_gapok.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}

						var total_gapok = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

						//tunjangan sturktural
					    var	number_string = t_tunjStruktural.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_tunjStruktural = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

						//tunjangan khusus
					    var	number_string = t_tunjKhusus.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_tunjKhusus = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					  
						//TAS
					    var	number_string = t_TAS.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_TAS = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    
						//penyesuaian
					    var	number_string = t_penyesuaian.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_penyesuaian = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //gross - maxgross
					    var	number_string = t_maxgross.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_maxgross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total dinas malam
					    var	number_string = t_dinasmalam.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_dinasmalam = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					    //total lembur
					    var	number_string = t_lembur.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_lembur = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total rapel/ lain-lain
					    var	number_string = t_rapellain.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_rapellain = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total insentif
					    var	number_string = t_insentif.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_insentif = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total gross
			    		var	number_string = t_gross.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_gross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    
					    //total potongan jht
					    var	number_string = t_potJHT.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_potJHT = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total Jaminan Pensiun
					   	var	number_string = t_jaminanpensiun.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_jaminanpensiun = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total pajak (PPH 21)
					    var	number_string = t_pph21.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_pph21 = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total potongan JKN
					    var	number_string = t_PotJKN.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_PotJKN = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total semua thp bulat
					   	var	number_string = t_ThpBulat.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_ThpBulat = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					    //total semua gaji bersih
					  	var	number_string = t_GajiBersih.toString(),
							split	= number_string.split('.'),
							sisa 	= split[0].length % 3,
							rupiah 	= split[0].substr(0, sisa),
							ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						var total_GajiBersih = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


						// =========== footer (total semua) ==============
					    //total semua karyawan
					    $.ajax({
					        url: base_url+"LapGajipergolongan/getJumKaryawanXIIIkeAtas",
					        type: "post",
					        data: {
					            'id_golongan': id_golongan,
					            'periode_gaji' : periode_gaji,
			    				'jenis_gaji' : jenis_gaji
					        },
					        dataType: 'json',
					        async: false,
					        success: function(response) {
					        	// console.log(response.total_karyawan);
					        	total_karyawan = response.total_karyawan;
					         
					        }
					    });

					    //total semua gapok
					    $.ajax({
					        url: base_url+"LapGajipergolongan/getAllGapokXIIIKeAtas",
					        type: "post",
					        data: {
					            'periode_gaji' : periode_gaji,
			    				'jenis_gaji' : jenis_gaji
					           
					        },
					        dataType: 'json',
					        async: false,
					        success: function(response) {
					        	// console.log(response);
					        	var highlights = response;

					        	//total gapok
								total_Allgapok = highlights.reduce( function(tot, record) {
								    return tot + record.allgapok;
								},0);

								//total tunj. stukrtural
								total_AllTunjStruktural = highlights.reduce( function(tot, record) {
								    return tot + record.tunjangan_struktural;
								},0);

								//total tunjangan khusus
								total_AllTunjKhusus = highlights.reduce( function(tot, record) {
								    return tot + record.tunjangan_khusus;
								},0);

								//total TAS
								total_AllTAS = highlights.reduce( function(tot, record) {
								    return tot + record.tas;
								},0);

								//total penyesuaian
								total_AllPenyesuaian = highlights.reduce( function(tot, record) {
								    return tot + record.penyesuaian;
								},0);

								//total maxgross(total gross)
								total_AllMaxgross = highlights.reduce( function(tot, record) {
								    return tot + record.maxgross;
								},0);

								//total dinas malam
								total_AllDinasMalam = highlights.reduce( function(tot, record) {
								    return tot + record.dinas_malam;
								},0);

								//total lembur
								total_AllLembur = highlights.reduce( function(tot, record) {
								    return tot + record.lembur;
								},0);

								//total rapel
								total_AllRapel = highlights.reduce( function(tot, record) {
								    return tot + record.rapel;
								},0);

								//total insentif
								total_AllInsentif = highlights.reduce( function(tot, record) {
								    return tot + record.insentif;
								},0);

								//total gross
								total_AllTotGross = highlights.reduce( function(tot, record) {
								    return tot + record.gross;
								},0);

								//total potongan JHT
								total_AllPotJHT = highlights.reduce( function(tot, record) {
								    return tot + record.potongan_jht;
								},0);

								//total potongan jaminan pensium
								total_AllPotJP = highlights.reduce( function(tot, record) {
								    return tot + record.jaminan_pensiun;
								},0);

								//total pajak
								total_AllPPH21 = highlights.reduce( function(tot, record) {
								    return tot + record.pajak;
								},0);

								//total potongan JKN
					         	total_AllBPJSKes = highlights.reduce( function(tot, record) {
								    return tot + record.bpjs_kesehatan;
								},0);

								//total THP bulat
								total_AllThpBulat = highlights.reduce( function(tot, record) {
								    return tot + record.thp_bulat;
								},0);

								//total gaji bersih
								total_AllGajiBersih = highlights.reduce( function(tot, record) {
								    return tot + record.jumlah_terima;
								},0);

					        }
					    });



		                tabel_LapGajiPerGolonganAtasXII=tabel_LapGajiPerGolonganAtasXII+'<tr>'+
			                    '<td align="center">'+data.golongan+'</td>' +
			                    '<td align="center">'+data.jumlah_karyawan+'</td>' +
			                    '<td align="right">Rp.'+total_gapok+'</td>' +
			                    '<td align="right">Rp.'+total_tunjStruktural+'</td>' +
			                    '<td align="right">Rp.'+total_tunjKhusus+'</td>' +
			                    '<td align="right">Rp.'+total_TAS+'</td>' +
			                    '<td align="right">Rp.'+total_penyesuaian+'</td>' +
			                    '<td align="right">Rp.'+total_maxgross+'</td>' +
			                    '<td align="right">Rp'+total_dinasmalam+'</td>' +
			                    '<td align="right">Rp.'+total_lembur+'</td>' +
			                    '<td align="right">Rp.'+total_rapellain+'</td>' +
			                    '<td align="right">Rp.'+total_insentif+'</td>' +
			                    '<td align="right">Rp.'+total_gross+'</td>' +
			                    '<td align="right">Rp.'+total_potJHT+'</td>' +
			                    '<td align="right">Rp.'+total_jaminanpensiun+'</td>' +
			                    '<td align="right">Rp.'+total_pph21+'</td>' +
			                    '<td align="right">Rp.'+total_PotJKN+'</td>' +
			                    '<td align="right">Rp.'+total_ThpBulat+'</td>' +
			                    '<td align="right">Rp.'+total_GajiBersih+'</td>' +
		                    '</tr>';

		            });

					//gaji pokok
					var	number_string = total_Allgapok.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var Gapok = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//tunjangan struktural
					var	number_string = total_AllTunjStruktural.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var TunjanganStruktural = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//tunjangan khusus
					var	number_string = total_AllTunjKhusus.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var TunjanganKhusus = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//TAS
					var	number_string = total_AllTAS.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var TAS = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					//Penyesuaian
					var	number_string = total_AllPenyesuaian.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var Penyesuaian = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//Gross
					var	number_string = total_AllMaxgross.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var Gross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					//Dinas Malam
					var	number_string = total_AllDinasMalam.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var DinasMalam = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					//Lembur
					var	number_string = total_AllLembur.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var Lembur = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//Rapel/Lain-lain
					var	number_string = total_AllRapel.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var RapelLain2 = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					//Insentif
					var	number_string = total_AllInsentif.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var Insentif = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//Total Gross
					var	number_string = total_AllTotGross.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var TotalGross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					//Total Potongan JHT
					var	number_string = total_AllPotJHT.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var PotonganJHT = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					//Potongan JP
					var	number_string = total_AllPotJP.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var PotonganJP = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//PPH 21
					var	number_string = total_AllPPH21.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var PPH = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

					//BPJS Kesehatan
					var	number_string = total_AllBPJSKes.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var BPJSKesehatan = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//THP Bulat
					var	number_string = total_AllThpBulat.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var Thpbulat = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


					//gaji bersih
					var	number_string = total_AllGajiBersih.toString(),
						split	= number_string.split('.'),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
							
					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}
					var GajiBersih = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;


	                tabel_LapGajiPerGolonganAtasXII += '</tbody><tfoot>'+
	                		'<tr>'+
	                    	'<td><b>TOTAL</b></td>' +
	                    	'<td align="center">'+total_karyawan+'</td>' +
	                    	'<td align="right">Rp.'+Gapok+'</td>' +
	                    	'<td align="right">Rp.'+TunjanganStruktural+'</td>' +
	                    	'<td align="right">Rp.'+TunjanganKhusus+'</td>' +
	                    	'<td align="right">Rp.'+TAS+'</td>' +
	                    	'<td align="right">Rp.'+Penyesuaian+'</td>' +
	                    	'<td align="right">Rp.'+Gross+'</td>' +
	                    	'<td align="right">Rp.'+DinasMalam+'</td>' +
	                    	'<td align="right">Rp.'+Lembur+'</td>' +
	                    	'<td align="right">Rp.'+RapelLain2+'</td>' +
	                    	'<td align="right">Rp.'+Insentif+'</td>' +
	                    	'<td align="right">Rp.'+TotalGross+'</td>' +
	                    	'<td align="right">Rp.'+PotonganJHT+'</td>' +
	                    	'<td align="right">Rp.'+PotonganJP+'</td>' +
	                    	'<td align="right">Rp.'+PPH+'</td>' +
	                    	'<td align="right">Rp.'+BPJSKesehatan+'</td>' +
	                    	'<td align="right">Rp.'+Thpbulat+'</td>' +
	                    	'<td align="right">Rp.'+GajiBersih+'</td>' +
	                    '</tr>'+
	                	'</table>';


                $("#tabel_LapGajiPerGolonganAtasXII").html(tabel_LapGajiPerGolonganAtasXII);
                $("#tb_LapGajiPerGolonganAtasXII").DataTable({
                	iDisplayLength: 100,
					lengthChange: false,
                	dom: 'Bfrtip',
                    responsive: true,
                    spans:true,	
                    "stripeClasses": [ 'odd-row', 'even-row' ],
                    buttons: [
                    
                        {
                            extend: 'excel',
                            footer: true,
                            exportOptions: {
			                    columns: [ ':visible' ]
			                },
                            title: 'Laporan Data Gaji Karyawan',
                            className: 'btn btn-success btn-sm',
                            text: '<i class="fa fa-file-excel-o" style="font-size: 15px;"></i> Excel',
                           
                        },
                        {
                           
                            extend: 'pdfHtml5',
			                orientation: 'landscape',
			                pageSize: 'LEGAL',
			                exportOptions: {
			                    columns: [ ':visible' ]
			                },
			                customize: function (doc) {
						        doc.pageMargins = [20,10,10,10];
						        doc.defaultStyle.fontSize = 7;
						        doc.styles.tableHeader.fontSize = 7;
						        doc.styles.tableHeader.fillColor = "#424242";
						        doc.styles.tableFooter.fillColor = "#828282";
						        doc.styles.tableFooter.fontSize = 7;
						        doc.styles.title.fontSize = 9;
						        doc.styles.title = {
							      fontSize: '10',
							      fontStyle: 'bold',
							      alignment: 'center'
							    }   
							    

						  		//toDataURL('http://localhost/sipakar/assets/images/payroll.png', function(dataUrl) {
								//   console.log('RESULT:', dataUrl);
								// })
						        // doc.content.splice( 1, 0, {
						        // } ); 
						       
						        doc.content[0].text = doc.content[0].text.trim();


						        // Create a footer
						        doc['footer']=(function(page, pages) {
						            return {
						                columns: [
						                    '',
						                    {
						                        // This is the right column
						                        alignment: 'right',
						                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
						                    }
						                ],
						                margin: [10, 0]
						            }
						        });
						        // Styling the table: create style object
						        var objLayout = {};
						        // Horizontal line thickness
						        objLayout['hLineWidth'] = function(i) { return .5; };
						        // Vertikal line thickness
						        objLayout['vLineWidth'] = function(i) { return .5; };
						        // Horizontal line color
						        objLayout['hLineColor'] = function(i) { return '#aaa'; };
						        // Vertical line color
						        objLayout['vLineColor'] = function(i) { return '#aaa'; };
						        // Left padding of the cell
						        objLayout['paddingLeft'] = function(i) { return 4; };
						        // Right padding of the cell
						        objLayout['paddingRight'] = function(i) { return 4; };
						        // Inject the object in the document
						        doc.content[1].layout = objLayout;
						    },

                            footer: true,
                            title: 'LAPORAN GAJI PER GOLONGAN BULAN '+bulan_nama+' '+tahun+' \n RUMAH SAKIT Dr.OEN KANDANG SAPI SOLO',
                            className: 'btn btn-danger btn-sm',
                            text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> PDF'

                        }//,
						// {
			   //      		extend:'colvis',
			   //      		className: 'btn btn-warning btn-sm',
			   //      		text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> Pilih'

			   //      	}
                    ]
                });



	    	}
	    }
	});

}