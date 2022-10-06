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


function button_filter_lapGajiPerunitGolXIIBawah(){
	$('#pemberitahuan').hide();
	var periode_gaji = $("#periodeXIIBawah").val();
	var jenis_gaji = $("#jenisgajiXIIIBawah").val();
	var respon = '';

	$.ajax({
	    url: base_url+'LapGajiperunit/getUnitGolXIIBawah',
	    type: 'post',
	    dataType: 'json',
	    async: true,
	    data:
	    {
	    	'periode_gaji' : periode_gaji,
	    	'jenis_gaji' : jenis_gaji

	    },
	    success: function(response) {
	    	console.log(response);

	    	var periode_bulan = periode_gaji.split('/');
            var bulan_angka = periode_bulan[0];
            var tahun = periode_bulan[1];

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

          
            //jika di tb_isi_file tidak ada isinya
            if(response.detail == null){
	    		tabel_detailXIIBawah= '<h4 align="center"><b>=============    Tidak ada data =============</b></h4>';
	    		$("#tabel_detailXIIBawah").html(tabel_detailXIIBawah);

	    	}else{ //jika di tb_isi_file ada isinya

	    		//cek di total_perunit
            	$.ajax({
			        url: base_url+"LapGajiperunit/cekData",
			        type: "post",
			        data: {
			            'periode_gaji' : periode_gaji,
	    				'jenis_gaji' : jenis_gaji
			        },
			        dataType: 'json',
			        async: false,
			        success: function(response) {
			        	console.log(response);
			        	if(response == null){
			        		respon = "data belum ada";
			        	}else{
			        		respon = "data sudah ada";
			        	}
			        	
			        }
			    });

			    console.log(respon);

	
	            $.each(response.detail, function (index, data){
	             	var n_unitrsid = data.n_unitrsid;
	             	console.log(n_unitrsid);
	     			$.ajax({
				        url: base_url+"LapGajiperunit/getDataGajiGolXIIBawah",
				        type: "post",
				        data: {
				            'periode_gaji' : periode_gaji,
				            'n_unitrsid' : n_unitrsid,
		    				'jenis_gaji' : jenis_gaji
				           
				        },
				        dataType: 'json',
				        async: false,
				        success: function(response) {
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

							if(respon == "data belum ada"){
								var cek = "insertdata";
								console.log(cek);

								$.ajax({
							        url: base_url+"LapGajiperunit/insertdata",
							        type: "post",
							        data: {
							            'periode_gaji' : periode_gaji,
							            'n_unitrsid' : n_unitrsid,
					    				'jenis_gaji' : jenis_gaji,
					    				't_gapok' : t_gapok,
					    				't_penyesuaian' : t_penyesuaian,
					    				't_gross' : t_gross,
					    				't_TAS' : t_TAS,
					    				't_maxgross' : t_maxgross,
					    				't_rapellain' : t_rapellain,
					    				't_dinasmalam' : t_dinasmalam,
					    				't_lembur' : t_lembur,
					    				't_potJHT' : t_potJHT,
					    				't_jaminanpensiun' : t_jaminanpensiun,
					    				't_PotJKN' : t_PotJKN,
					    				't_ThpBulat' : t_ThpBulat,
					    				't_pph21' : t_pph21,
					    				't_tunjKhusus' : t_tunjKhusus,
					    				't_tunjStruktural' : t_tunjStruktural,
					    				't_insentif' : t_insentif,
					    				't_GajiBersih' : t_GajiBersih,
							           
							        },
							        dataType: 'json',
							        async: false,
							        success: function(response) {
							        	console.log(response.code);
							        	
							        }
							    });
							}else if(respon == "data sudah ada"){
								var cek = "update data";
								console.log(cek);

								$.ajax({
							        url: base_url+"LapGajiperunit/updatedata",
							        type: "post",
							        data: {
							            'periode_gaji' 		: periode_gaji,
							            'n_unitrsid' 		: n_unitrsid,
					    				'jenis_gaji' 		: jenis_gaji,
					    				't_gapok' 			: t_gapok,
					    				't_penyesuaian' 	: t_penyesuaian,
					    				't_gross' 			: t_gross,
					    				't_TAS' 			: t_TAS,
					    				't_maxgross' 		: t_maxgross,
					    				't_rapellain' 		: t_rapellain,
					    				't_dinasmalam' 		: t_dinasmalam,
					    				't_lembur' 			: t_lembur,
					    				't_potJHT' 			: t_potJHT,
					    				't_jaminanpensiun' 	: t_jaminanpensiun,
					    				't_PotJKN' 			: t_PotJKN,
					    				't_ThpBulat' 		: t_ThpBulat,
					    				't_pph21' 			: t_pph21,
					    				't_tunjKhusus' 		: t_tunjKhusus,
					    				't_tunjStruktural' 	: t_tunjStruktural,
					    				't_insentif' 		: t_insentif,
					    				't_GajiBersih' 		: t_GajiBersih,
							           
							        },
							        dataType: 'json',
							        async: false,
							        success: function(response) {
							        	console.log(response.code);
							        	
							        }
							    });
							}
				        }
				    });                   		

	            });

				$.ajax({
			        url: base_url+"LapGajiperunit/gettotalPerunitXIIBawah",
			        type: "post",
			        data: {
			            'periode_gaji' 	: periode_gaji,			          
	    				'jenis_gaji' 	: jenis_gaji					   
	    			},
			        dataType: 'json',
			        async: false,
			        success: function(response) {
			        	console.log(response);
			        	tabel_detailXIIBawah = 
			    			'<h4 align="center"><b>LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN I-XII BULAN '+bulan_nama+' '+tahun+'</b></h4><br>'+
								'<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="tb_detailXIIBawah">'+
			                    '<thead>'+
			                    '<tr bgcolor="#424242">'+
			                        '<th rowspan="2" style="vertical-align : middle;text-align:center;"><font color="#ffffff">BAGIAN</th>'+
									'<th colspan="18" style="text-align:center;"><font color="#ffffff">JUMLAH</th>'+
									
			              
			                    '</tr><tr bgcolor="#424242">'+
			                    	'<th align="center"><font color="#ffffff">KARY.</th>'+
			                        '<th><font color="#ffffff">GAJI POKOK</th>'+
			                        '<th><font color="#ffffff">TUNJ. STRUKTURAL</th>'+
			                        '<th><font color="#ffffff">TUNJ. KHUSUS</th>'+
			                        '<th><font color="#ffffff">TUNJ. ALIH SISTEM</th>'+
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
			                    '<tbody id="tabel_detailXIIBawah">';

			                    $.each(response, function (index, data){
			                    	var t_gapok = data.t_gapok;
			                    	var	number_string = t_gapok.toString(),
										split	= number_string.split('.'),
										sisa 	= split[0].length % 3,
										rupiah 	= split[0].substr(0, sisa),
										ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
											
									if (ribuan) {
										separator = sisa ? '.' : '';
										rupiah += separator + ribuan.join('.');
									}
									gapokperunit = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

									console.log();
			                     	
			                     	tabel_detailXIIBawah= tabel_detailXIIBawah+'<tr>'+
		                     			'<td>'+data.v_unitrsnama+'</td>'+
		                     			'<td></td>'+
		                     			'<td align="center">'+data.t_gapok+'</td>'+
		                     			'<td align="center">'+data.t_tunjstruktural+'</td>'+
		                     			'<td align="center">'+data.t_tunjkhusus+'</td>'+
		                     			'<td align="center">'+data.t_tas+'</td>'+
		                     			'<td align="center">'+data.t_penyesuaian+'</td>'+
		                     			'<td align="center">'+data.t_maxgross+'</td>'+
		                     			'<td align="center">'+data.t_dinasmalam+'</td>'+
		                     			'<td align="center">'+data.t_lembur+'</td>'+
		                     			'<td align="center">'+data.t_rapellain+'</td>'+
		                     			'<td align="center">'+data.t_insentif+'</td>'+
		                     			'<td align="center">'+data.t_gross+'</td>'+
		                     			'<td align="center">'+data.t_potjht+'</td>'+
		                     			'<td align="center">'+data.t_jaminanpensiun+'</td>'+
		                     			'<td align="center">'+data.t_pph21+'</td>'+
		                     			'<td align="center">'+data.t_potjkn+'</td>'+
		                     			'<td align="center">'+data.t_thpbulat+'</td>'+
		                     			'<td align="center">'+data.t_gajibersih+'</td>';
		                     			
								});

								$.ajax({
							        url: base_url+"LapGajiperunit/gettotalAllGajiPerunitXIIKebawah",
							        type: "post",
							        data: {
							            'periode_gaji' 	: periode_gaji,        
					    				'jenis_gaji' 	: jenis_gaji					   
					    			},
							        dataType: 'json',
							        async: false,
							        success: function(response) {
							        	console.log(response);
							        	var highlights = response;

							        	//total gapok
										total_gapoks = highlights.reduce( function(tot, record) {
										    return tot + record.t_gapok;
										},0);

										//tunj. struktural
										total_tunjstruktural = highlights.reduce( function(tot, record) {
										    return tot + record.t_tunjstruktural;
										},0);

										//tunj. khusus
										total_tunjkhusus = highlights.reduce( function(tot, record) {
										    return tot + record.t_tunjkhusus;
										},0);

										//tunj. alih sistem
										total_tas = highlights.reduce( function(tot, record) {
										    return tot + record.t_tas;
										},0);

										//total penyesuaian
										total_penyesuaian = highlights.reduce( function(tot, record) {
										    return tot + record.t_penyesuaian;
										},0);

										//gross
										total_gross = highlights.reduce( function(tot, record) {
										    return tot + record.t_gross;
										},0);

										//dinas malam
										total_dinasmalam = highlights.reduce( function(tot, record) {
										    return tot + record.t_dinasmalam;
										},0);

										//lembur
										total_lembur = highlights.reduce( function(tot, record) {
										    return tot + record.t_lembur;
										},0);

										//lain2 dan rapel
										total_rapel = highlights.reduce( function(tot, record) {
										    return tot + record.t_rapellain;
										},0);
										//insentif
										total_insentif = highlights.reduce( function(tot, record) {
										    return tot + record.t_insentif;
										},0);
										//total.gross
										total_gross = highlights.reduce( function(tot, record) {
										    return tot + record.t_gross;
										},0);
										//potongan jht
										total_jht = highlights.reduce( function(tot, record) {
										    return tot + record.t_potjht;
										},0);
										//potongan jp
										total_jp = highlights.reduce( function(tot, record) {
										    return tot + record.t_jaminanpensiun;
										},0);
										//pph21
										total_pph21 = highlights.reduce( function(tot, record) {
										    return tot + record.t_pph21;
										},0);
										//potongan jkn
										total_potjkn = highlights.reduce( function(tot, record) {
										    return tot + record.t_potjkn;
										},0);
										//thp bulat
										total_thpbulat = highlights.reduce( function(tot, record) {
										    return tot + record.t_thpbulat;
										},0);
										//gaji bersih
										total_gajibersih = highlights.reduce( function(tot, record) {
										    return tot + record.t_gajibersih;
										},0);



										//GAPOK
										var	number_string = total_gapoks.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										Gapok = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//TUNJ.STRUKTURAL
										var	number_string = total_tunjstruktural.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										tunjanganStruktural = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//TUNJ KHUSUS
										var	number_string = total_tunjkhusus.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										tunjanganKhusus = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//TUNJ ALIH SISTEM
										var	number_string = total_tas.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										tas = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//TOTAL PENYESUAIAN
										var	number_string = total_penyesuaian.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										penyesuaian = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//GROSS
										var	number_string = total_gross.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										gross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//DINAS MALAM
										var	number_string = total_dinasmalam.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										dinasmalam = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//LEMBUR
										var	number_string = total_lembur.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										lembur = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//RAPEL DAN LAIN2
										var	number_string = total_rapel.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										rapel = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//INSENTIF
										var	number_string = total_insentif.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										insentif = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//TOTAL GROSS
										var	number_string = total_gross.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										totalgross = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//POTONGAN JHT
										var	number_string = total_jht.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										jht = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//POTONGAN JP
										var	number_string = total_jp.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										jp = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//PPH21
										var	number_string = total_pph21.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										pph = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//POTONGAN JKN
										var	number_string = total_potjkn.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										jkn = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//THP BULAT
										var	number_string = total_thpbulat.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										thpbulatt = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										//GAJI BERSIH
										var	number_string = total_gajibersih.toString(),
											split	= number_string.split('.'),
											sisa 	= split[0].length % 3,
											rupiah 	= split[0].substr(0, sisa),
											ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
												
										if (ribuan) {
											separator = sisa ? '.' : '';
											rupiah += separator + ribuan.join('.');
										}
										gajibersih = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

										// console.log(xxxx);


							        }
							    });



								tabel_detailXIIBawah= tabel_detailXIIBawah+'</tr></tbody><tfoot>'+
		                    		'<tr>'+
		                    			'<td><b>TOTAL</b></td>'+
		                    			'<td align="center"></td>'+
		                    			'<td align="center">Rp.'+Gapok+'</td>'+
		                    			'<td align="center">Rp.'+tunjanganStruktural+'</td>'+
		                    			'<td align="center">Rp.'+tunjanganKhusus+'</td>'+
		                    			'<td align="center">Rp.'+tas+'</td>'+
		                    			'<td align="center">Rp.'+penyesuaian+'</td>'+
		                    			'<td align="center">Rp.'+gross+'</td>'+
		                    			'<td align="center">Rp.'+dinasmalam+'</td>'+
		                    			'<td align="center">Rp.'+lembur+'</td>'+
		                    			'<td align="center">Rp.'+rapel+'</td>'+
		                    			'<td align="center">Rp.'+insentif+'</td>'+
		                    			'<td align="center">Rp.'+totalgross+'</td>'+
		                    			'<td align="center">Rp.'+jht+'</td>'+
		                    			'<td align="center">Rp.'+jp+'</td>'+
		                    			'<td align="center">Rp.'+pph+'</td>'+
		                    			'<td align="center">Rp.'+jkn+'</td>' +
		                    			'<td align="center">Rp.'+thpbulatt+'</td>'+
		                    			'<td align="center">Rp.'+gajibersih+'</td>'+
		                    		'</tr>'+
		                    	'</tfoot></table>';
			        }
			    });			

				

            $("#tabel_detailXIIBawah").html(tabel_detailXIIBawah);
            $("#tb_detailXIIBawah").DataTable({
            	iDisplayLength: 100,
				lengthChange: false,
            	dom: 'Bfrtip',
                responsive: true,
                spans:true,	
                html:true,
                "stripeClasses": [ 'odd-row', 'even-row' ],

                buttons: [
                
                    {
                        extend: 'excel',
                        footer: true,
                        exportOptions: {
		                    columns: [ ':visible' ]
		                },
		                filename: 'LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN I-XII BULAN '+bulan_nama+' '+tahun+'',
                        title: 'LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN I-XII BULAN '+bulan_nama+' '+tahun+' \n RUMAH SAKIT Dr.OEN KANDANG SAPI SOLO',
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
                        title: 'LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN I-XII BULAN '+bulan_nama+' '+tahun+' \n RUMAH SAKIT Dr.OEN KANDANG SAPI SOLO',
                        className: 'btn btn-danger btn-sm',
                        filename: 'LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN I-XII BULAN '+bulan_nama+' '+tahun+'',
                        text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> PDF'

                    }//,
					// {
					//     extend:'colvis',
					//     className: 'btn btn-warning btn-sm',
					//     text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> Pilih'

					// }
                ]
        });
        	}
	    }
	});

}


function button_filter_lapGajiPerunitGolXIIIAtas(){
	$('#pemberitahuan').hide();
	var periode_gaji = $("#periodeXIIAtas").val();
	var jenis_gaji = $("#jenisgajiXIIIAtas").val();

	$.ajax({
	    url: base_url+'LapGajiperunit/getUnitGolXIIIAtas',
	    type: 'post',
	    dataType: 'json',
	    async: true,
	    data:
	    {
	    	'periode_gaji' : periode_gaji,
	    	'jenis_gaji' : jenis_gaji

	    },
	    success: function(response) {
	    	console.log(response);

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
	    		tabel_detailXIIIAtas= '<h4 align="center"><b>=============    Tidak ada data =============</b></h4>';
	    		$("#tabel_detailXIIIAtas").html(tabel_detailXIIIAtas);

	    	}else{

	    		tabel_detailXIIIAtas= '<h4 align="center"><b>LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN XII KE ATAS BULAN '+bulan_nama+' '+tahun+'</b></h4><br>'+
					'<table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="tb_detailXIIIAtas">'+
                    '<thead>'+
                    '<tr bgcolor="#424242">'+
                        '<th rowspan="2" style="vertical-align : middle;text-align:center;"><font color="#ffffff">BAGIAN</th>'+
						'<th colspan="20" style="text-align:center;"><font color="#ffffff">JUMLAH</th>'+
						
                    '</tr><tr bgcolor="#424242">'+
                    	'<th align="center"><font color="#ffffff">KARY.</th>'+
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
                    '<tbody id="tabel_detailXIIIAtas">';

                    $.each(response.detail, function (index, data){
                    	var n_unitrsid = data.n_unitrsid;

                    	$.ajax({
					        url: base_url+"LapGajiperunit/getDataGajiGolXIIIAtas",
					        type: "post",
					        data: {
					            'periode_gaji' : periode_gaji,
					            'n_unitrsid' : n_unitrsid,
			    				'jenis_gaji' : jenis_gaji
					           
					        },
					        dataType: 'json',
					        async: false,
					        success: function(response) {
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


						//=============== footer (total semua) =================
						//total semua karyawan
						$.ajax({
					        url: base_url+"LapGajiperunit/getJumKaryawanXIIIAtas",
					        type: "post",
					        data: {
					            'periode_gaji' : periode_gaji,
								'jenis_gaji' : jenis_gaji
					        },
					        dataType: 'json',
					        async: false,
					        success: function(response) {
					        	
					        	// console.log(response);
					        	total_karyawan = response.total_karyawan;
					         
					        }
					    });

					    //totak semua gapok, semua thp bulat dll
					    $.ajax({
					        url: base_url+"LapGajiperunit/getTotalDetailXIIIAtas",
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


                    	tabel_detailXIIIAtas= tabel_detailXIIIAtas+'<tr>'+
                     			'<td>'+data.v_unitrsnama+'</td>'+
                     			'<td align="center">'+data.total+'</td>'+
                     			'<td align="right">Rp.'+total_gapok+'</td>'+
                     			'<td align="right">Rp.'+total_tunjStruktural+'</td>'+
                     			'<td align="right">Rp.'+total_tunjKhusus+'</td>'+
                     			'<td align="right">Rp.'+total_TAS+'</td>'+
                     			'<td align="right">Rp.'+total_penyesuaian+'</td>'+
                     			'<td align="right">Rp.'+total_maxgross+'</td>'+
                     			'<td align="right">Rp.'+total_dinasmalam+'</td>'+
                     			'<td align="right">Rp.'+total_lembur+'</td>'+
                     			'<td align="right">Rp.'+total_rapellain+'</td>'+
                     			'<td align="right">Rp.'+total_insentif+'</td>'+
                     			'<td align="right">Rp.'+total_gross+'</td>'+
                     			'<td align="right">Rp.'+total_potJHT+'</td>'+
                     			'<td align="right">Rp.'+total_jaminanpensiun+'</td>'+
                     			'<td align="right">Rp.'+total_pph21+'</td>'+
                     			'<td align="right">Rp.'+total_PotJKN+'</td>'+
                     			'<td align="right">Rp.'+total_ThpBulat+'</td>'+
                     			'<td align="right">Rp.'+total_GajiBersih+'</td>';

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


						tabel_detailXIIIAtas= tabel_detailXIIIAtas+'</tr></tbody><tfoot>'+
								'<tr>'+
                    			'<td><b>TOTAL</b></td>'+
                    			'<td align="center">'+total_karyawan+'</td>'+
                    			'<td align="right">Rp.'+Gapok+'</td>'+
                    			'<td align="right">Rp.'+TunjanganStruktural+'</td>'+
                    			'<td align="right">Rp.'+TunjanganKhusus+'</td>'+
                    			'<td align="right">Rp.'+TAS+'</td>'+
                    			'<td align="right">Rp.'+Penyesuaian+'</td>'+
                    			'<td align="right">Rp.'+Gross+'</td>'+
                    			'<td align="right">Rp.'+DinasMalam+'</td>'+
                    			'<td align="right">Rp.'+Lembur+'</td>'+
                    			'<td align="right">Rp.'+RapelLain2+'</td>'+
                    			'<td align="right">Rp.'+Insentif+'</td>'+
                    			'<td align="right">Rp.'+TotalGross+'</td>'+
                    			'<td align="right">Rp.'+PotonganJHT+'</td>'+
                    			'<td align="right">Rp.'+PotonganJP+'</td>'+
                    			'<td align="right">Rp.'+PPH+'</td>'+
                    			'<td align="right">Rp.'+BPJSKesehatan+'</td>' +
                    			'<td align="right">Rp.'+Thpbulat+'</td>'+
                    			'<td align="right">Rp.'+GajiBersih+'</td>'+
                    		'</tr>'+
							'</tfoot></table>';

	    		$("#tabel_detailXIIIAtas").html(tabel_detailXIIIAtas);
	    		// $('#tb_detailXIIIAtas').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');
	    		$("#tb_detailXIIIAtas").DataTable({
                	iDisplayLength: 100,
					lengthChange: false,
                	dom: 'Bfrtip',
                    responsive: true,
                    spans:true,	
                    "stripeClasses": [ 'odd-row', 'even-row' ],

                    buttons: [
                    
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            messageTop: 'Report',
                            exportOptions: {
			                    
			                },
                            title: 'LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN XII KE ATAS BULAN '+bulan_nama+' '+tahun+' \n RUMAH SAKIT Dr.OEN KANDANG SAPI SOLO',
                            className: 'btn btn-success btn-sm',
                            messageTop: 'This print was produced using the Print button for DataTables',
                            text: '<i class="fa fa-file-excel-o" style="font-size: 15px;"></i> Excel',
                            customize: function ( xlsx ){
				                var sheet = xlsx.xl.worksheets['sheet1.xml'];
				 
				                // jQuery selector to add a border
				                // $('row c[r*="1"]', sheet).attr( 's', '25' );
				                // $('row c[r^="C"]', sheet).attr( 's', '25' );
				                $('row c[r*="1"]', sheet).attr( 's', '2' );
				                // $('row c[r*="1"]', sheet).attr( 's', '25' );
				            }
                        },

			            // {
			            //     extend: 'print',
			            //     messageTop: 'This print was produced using the Print button for DataTables'
			            // },
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
                            title: 'LAPORAN GAJI (NON SARJANA) PER BAGIAN GOLONGAN XII KE ATAS BULAN '+bulan_nama+' '+tahun+' \n RUMAH SAKIT Dr.OEN KANDANG SAPI SOLO',
                            className: 'btn btn-danger btn-sm',
                            text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> PDF'

                        }//,
						// {
						//     extend:'colvis',
						//     className: 'btn btn-warning btn-sm',
						//     text: '<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i> Pilih'

						// }
                    ]
                });
	    	}
	    }
	});

}