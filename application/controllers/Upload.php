<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Upload extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
        $this->load->model(array('Upload_model'));
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory','cipher'));
	}

    //---------------- I - XII

    public function uploadBawahXIII(){

        $data['list_potongan'] = $this->Upload_model->get_list_master_potongan();
        $data['content']       = 'Upload_BawahXIII_view';

        $this->load->view('template', $data);
    }

   

    public function getListUploadFileBawahXIII(){

        $v_grup_golongan = 1;

        $list_upload = $this->Upload_model->get_list_all_by_grup_golongan($v_grup_golongan);

        //$cek_generate = $this->Upload_model->cek_upload_to_generate($bulan, $tahun, $jenis_potongan, $v_grup_golongan);

        $data = array(
            'list_upload' => $list_upload            
        );
        echo json_encode($data);
    }

    public function uploadFileBawahXIII(){

        if ($_FILES['file_upload']['error'] != 4){

            $fileName = $_FILES['file_upload']['name'];
             
            $config['upload_path']   = 'file/upload_excel';
            $config['file_name']     = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size']      = 10000;
            $config['overwrite']     = TRUE;
             
            $this->load->library('upload', $config);

            $n_potongan_id = $this->input->post('potongan_tambah');
            $bulan_tahun = $this->input->post('bulantahun_tambah');
            $jenis_gaji = $this->input->post('jenis_tambah');

            $bulan = substr($bulan_tahun,0,2);
            $tahun = substr($bulan_tahun,3,4);


            if($this->upload->do_upload("file_upload")){
                $media = $this->upload->data();

                $inputFileName = 'file/upload_excel/'.$media['file_name'];
                 
                $data = array(
                    'v_nama_file'=>$fileName,
                    'v_lokasi_file'=>$inputFileName,
                    'n_potongan_id'=>$n_potongan_id,
                    'n_bulan'=>$bulan,
                    'n_tahun'=>$tahun,
                    'jenis'=>$jenis_gaji,
                    'v_who_upload'=>$this->session->userdata('nik_payroll'),
                    'v_grup_golongan'=>1
                 );
                
                $this->Upload_model->insert_upload($data);

                $n_upload_file_id=$this->db->insert_id();
                $response = $this->upload_detail_bawahxiii($n_upload_file_id,$inputFileName);
                if (file_exists('file/upload_excel/'.$media['file_name'])) {
                    unlink('file/upload_excel/'.$media['file_name']);
                }
                
                echo json_encode($response);
            }else{

                echo $this->upload->display_errors();
            }

            echo $this->upload->display_errors();

        } else {

            echo $this->upload->display_errors();
        }
    }

    public function upload_detail_bawahxiii($n_upload_file_id,$inputFileName){

        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);

        } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $encr_key=$this->Upload_model->get_encr();
            $iv=$encr_key['encryption_iv'];
            $key=$encr_key['encryption_key'];
            
            $cek = 0;
            //$cekgroup = 0;
            $nik_salah = '';
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                
                $nominalEncr=$this->cipher->encrypt($rowData[0][2]); 
                //$nominalEncr=$this->cipher->encrypt_db($rowData[0][2], $iv, $key);

                //Sesuaikan sama nama kolom tabel di database                                
                $data = array(
                    //"n_isi_file_id"=> $rowData[0][0],
                    "n_upload_file_id"=> $n_upload_file_id,
                    "v_nik"=> $rowData[0][1],
                    "gapok"=>$this->cipher->encrypt($rowData[0][2]),
                    "tunjangan_khusus"=>$this->cipher->encrypt($rowData[0][3]),
                    "tunjangan_struktural"=>$this->cipher->encrypt($rowData[0][4]),
                    "penyesuaian"=>$this->cipher->encrypt($rowData[0][5]),
                    "tas"=>$this->cipher->encrypt($rowData[0][6]),
                    "maxgross"=>$this->cipher->encrypt($rowData[0][7]),
                    "dinas_malam"=>$this->cipher->encrypt($rowData[0][8]),
                    "lembur"=>$this->cipher->encrypt($rowData[0][9]),
                    "rapel"=>$this->cipher->encrypt($rowData[0][10]),
                    "insentif"=>$this->cipher->encrypt($rowData[0][11]),
                    "gross"=>$this->cipher->encrypt($rowData[0][12]),
                    "potongan_jht"=>$this->cipher->encrypt($rowData[0][13]),
                    "jaminan_pensiun"=>$this->cipher->encrypt($rowData[0][14]),
                    "bpjs_kesehatan"=>$this->cipher->encrypt($rowData[0][15]),
                    "sta"=>$this->cipher->encrypt($rowData[0][16]),
                    "pajak"=>$this->cipher->encrypt($rowData[0][17]),
                    "thp_bulat"=>$this->cipher->encrypt($rowData[0][18]),
                    "potongan_kopkar"=>$this->cipher->encrypt($rowData[0][19]),
                    "nominal_rek"=>$this->cipher->encrypt($rowData[0][20]),
                    "nominal_lain"=>$this->cipher->encrypt($rowData[0][21]),
                    "nominal_prr_btn"=>$this->cipher->encrypt($rowData[0][22]),
                    "nominal_btnsolo"=>$this->cipher->encrypt($rowData[0][23]),
                    "nominal_koperasi"=>$this->cipher->encrypt($rowData[0][24]),
                    "ket_rek_rs"=>$rowData[0][25],
                    "ket_lain"=>$rowData[0][26],
                    "ket_prr_btn"=>$rowData[0][27],
                    "ket_btn_solo"=>$rowData[0][28],
                    "ket_koperasi"=>$rowData[0][29],
                    "jumlah_terima"=>$this->cipher->encrypt($rowData[0][30]),
                    "titik_perubahan"=>$rowData[0][31],
                    "nominal_ekstra"=>$this->cipher->encrypt($rowData[0][32]),
                    "ket_ekstra"=>$rowData[0][33],
                    "jenis_ekstra"=>$rowData[0][34]
                );
                 
                //sesuaikan nama dengan nama tabel

                $ceknik = $this->Upload_model->get_cek_nik($rowData[0][1], 1);
                //$cekgroup = $this->Upload_model->get_cek_group($rowData[0][1], 1);

                if($ceknik){
                    $insert = $this->db->insert("payroll.tb_isi_file",$data);
                }else{
                    $nik_salah .= $rowData[0][1].", ";
                    $cek++;
                }
                     
            }
            if ($cek > 0) {
                $nik_salah = trim($nik_salah, ", ");
                //$this->session->set_flashdata('data_salah', 'NIK yang salah : '.$nik_salah);
                return $nik_salah;
            }else{
                return 0;
            }
    }

    public function getCekGenerateFile(){

        $n_upload_file_id   = $this->input->post('n_upload_file_id');

        $cek_file_upload = $this->Upload_model->get_upload($n_upload_file_id);
        //$jenis_potongan  = $cek_file_upload['n_potongan_id'];
        $bulan           = $cek_file_upload['n_bulan'];
        $tahun           = $cek_file_upload['n_tahun'];
        $v_grup_golongan = $cek_file_upload['v_grup_golongan'];

        $hasil_nik = $this->get_nik_detail_upload($n_upload_file_id);

        $cek_generate = $this->Upload_model->cek_upload_to_generate($bulan, $tahun,$v_grup_golongan, $hasil_nik);

        if($cek_generate){
            echo json_encode($cek_generate);
        }else{
            print_r("kosong");
        }
        
    }

    public function get_nik_detail_upload($n_upload_file_id){
        $v_nik = "";
        $cek_detail_file = $this->Upload_model->get_detail($n_upload_file_id);
        if(is_array($cek_detail_file)) {
            foreach ($cek_detail_file as $value) {
                $v_nik .= "'".$value['v_nik']."'".",";
            }
            $result_nik = rtrim($v_nik, ",");
        }else{
            $result_nik = "0";
        }
        return $result_nik;
    }

    //---------------- XIII Ke Atas

    public function uploadAtasXIII(){

        $data['list_potongan'] = $this->Upload_model->get_list_master_potongan();
        $data['content']       = 'Upload_AtasXIII_view';

        $this->load->view('template', $data);
    }

	public function getListUploadFileAtasXIII(){

        $v_grup_golongan = 2;

        $list_upload = $this->Upload_model->get_list_all_by_grup_golongan($v_grup_golongan);

		$data = array(
            'list_upload' => $list_upload            
        );
        echo json_encode($data);
	}

	public function uploadFileAtasXIII(){

        if ($_FILES['file_upload']['error'] != 4){

            $fileName = $_FILES['file_upload']['name'];
             
            $config['upload_path']   = 'file/upload_excel';
            $config['file_name']     = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size']      = 10000;
            $config['overwrite']     = TRUE;
             
            $this->load->library('upload', $config);

            $n_potongan_id = $this->input->post('potongan_tambah');
            $bulan_tahun = $this->input->post('bulantahun_tambah');
            $jenis_gaji = $this->input->post('jenis_tambah');

            $bulan = substr($bulan_tahun,0,2);
            $tahun = substr($bulan_tahun,3,4);


            if($this->upload->do_upload("file_upload")){
                $media = $this->upload->data();

                $inputFileName = 'file/upload_excel/'.$media['file_name'];
                 
                $data = array(
                    'v_nama_file'=>$fileName,
                    'v_lokasi_file'=>$inputFileName,
                    'n_potongan_id'=>$n_potongan_id,
                    'n_bulan'=>$bulan,
                    'n_tahun'=>$tahun,
                    'jenis'=>$jenis_gaji,
                    'v_who_upload'=>$this->session->userdata('nik_payroll'),
                    'v_grup_golongan'=>2
                 );
                
                $this->Upload_model->insert_upload($data);

                $n_upload_file_id=$this->db->insert_id();
                $response = $this->upload_detail_atasxiii($n_upload_file_id,$inputFileName);
                
                // $this->load->library('ftp');
                // $ftp_config['hostname'] = 'localhost';
                // $ftp_config['username'] = 'administrator';
                // $ftp_config['password'] = '643139';
                // $ftp_config['debug']    = FALSE;
                // $this->ftp->connect($ftp_config);

                // $destination = '/var/www/html/sipakar/file/upload_excel'.$media['file_name'];
                // $this->ftp->delete_file($destination);
                // $this->ftp->close();

                if (file_exists('file/upload_excel/'.$media['file_name'])) {
                    unlink('file/upload_excel/'.$media['file_name']);
                }
               

                echo json_encode($response);
            }else{

                echo $this->upload->display_errors();
            }

            echo $this->upload->display_errors();

        } else {

            echo $this->upload->display_errors();
        }
    }

    public function upload_detail_atasxiii($n_upload_file_id,$inputFileName){

        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);

        } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $encr_key   = $this->Upload_model->get_encr();
            $iv         = $encr_key['encryption_iv'];
            $key        = $encr_key['encryption_key'];
            
            $cek = 0;
            //$cekgroup = 0;
            $nik_salah = '';
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);

                $nominalEncr=$this->cipher->encrypt($rowData[0][2]); 
                //$nominalEncr=$this->cipher->encrypt_db($rowData[0][2], $iv, $key);
                                                 
                //Sesuaikan sama nama kolom tabel di database                                
                $data = array(
                    //"n_isi_file_id"=> $rowData[0][0],
                    "n_upload_file_id"=> $n_upload_file_id,
                    "v_nik"=> $rowData[0][1],
                    "gapok"=>$this->cipher->encrypt($rowData[0][2]),
                    "tunjangan_khusus"=>$this->cipher->encrypt($rowData[0][3]),
                    "tunjangan_struktural"=>$this->cipher->encrypt($rowData[0][4]),
                    "penyesuaian"=>$this->cipher->encrypt($rowData[0][5]),
                    "tas"=>$this->cipher->encrypt($rowData[0][6]),
                    "maxgross"=>$this->cipher->encrypt($rowData[0][7]),
                    "honor"=>$this->cipher->encrypt($rowData[0][8]),
                    "lembur"=>$this->cipher->encrypt($rowData[0][9]),
                    "rapel"=>$this->cipher->encrypt($rowData[0][10]),
                    "insentif"=>$this->cipher->encrypt($rowData[0][11]),
                    "thr"=>$this->cipher->encrypt($rowData[0][12]),
                    "gross"=>$this->cipher->encrypt($rowData[0][13]),
                    "potongan_jht"=>$this->cipher->encrypt($rowData[0][14]),
                    "jaminan_pensiun"=>$this->cipher->encrypt($rowData[0][15]),
                    "bpjs_kesehatan"=>$this->cipher->encrypt($rowData[0][16]),
                    "status"=>$this->cipher->encrypt($rowData[0][17]),
                    "pajak"=>$this->cipher->encrypt($rowData[0][18]),
                    "thp_bulat"=>$this->cipher->encrypt($rowData[0][19]),
                    "potongan_rs"=>$this->cipher->encrypt($rowData[0][20]),
                    "pot_jkn_kelg"=>$this->cipher->encrypt($rowData[0][21]),
                    "pot_btn"=>$this->cipher->encrypt($rowData[0][22]),
                    "tunai"=>$this->cipher->encrypt($rowData[0][23]),
                    "pot_koperasi"=>$this->cipher->encrypt($rowData[0][24]),
                    "jml_potongan"=>$this->cipher->encrypt($rowData[0][25]),
                    "jumlah_terima"=>$this->cipher->encrypt($rowData[0][26]),
                    "tf_cimb_niaga"=>$this->cipher->encrypt($rowData[0][27]),
                    "tf_bca"=>$this->cipher->encrypt($rowData[0][28])
                );
                 
                //sesuaikan nama dengan nama tabel

                $ceknik = $this->Upload_model->get_cek_nik($rowData[0][1], 2);
                //$cekgroup = $this->Upload_model->get_cek_group($rowData[0][1], 2);

                if($ceknik){

                    $insert = $this->db->insert("payroll.tb_isi_file",$data);

                }else{

                    $nik_salah .= $rowData[0][1].", ";
                    $cek++;
                }
                     
            }

            if ($cek > 0) {
                $nik_salah = trim($nik_salah, ", ");
                //$this->session->set_flashdata('data_salah', 'NIK yang salah : '.$nik_salah);

                return $nik_salah;
            }else{
                return 0;
            }
    }

    //---- action

    public function cari_detail(){
        $n_upload_file_id    = $this->input->post('n_upload_file_id');
            
        // $data['list_detail'] = $this->Upload_model->get_detail($n_upload_file_id);
        $dataEnc= $this->Upload_model->get_detail($n_upload_file_id);

        $encr_key=$this->Upload_model->get_encr();
        $iv=$encr_key['encryption_iv'];
        $key=$encr_key['encryption_key'];

        $dataDec = array();
        foreach ($dataEnc as $detail) {
            $dataDec[]=array(
                'n_isi_file_id' => $detail['n_isi_file_id'],
                'v_unitrsnama' => $detail['v_unitrsnama'],
                'v_nik' => $detail['v_nik'],
                'v_employee_name'=>$detail['v_employee_name'],
                'jumlah_terima'=>$this->cipher->decrypt($detail['jumlah_terima'])
            );
        }

        echo json_encode($dataDec);
    }

    public function hapusFile(){
        $n_upload_file_id = $this->input->post('n_upload_file_id');

        $this->Upload_model->delete_isi_file($n_upload_file_id);
        $this->Upload_model->delete($n_upload_file_id);
    }

    public function cari_isi_file_by_id(){
        $n_isi_file_id  = $this->input->post('n_isi_file_id');
        $data_edit      = $this->Upload_model->get_isi_file_by_id($n_isi_file_id);

        $encr_key=$this->Upload_model->get_encr();
        $iv=$encr_key['encryption_iv'];
        $key=$encr_key['encryption_key'];

        $response = array(
            'v_nik'=>$data_edit['v_nik'],
            'n_upload_file_id'=>$data_edit['n_upload_file_id'],
            'v_employee_name'=>$data_edit['v_employee_name'],
            //'v_nama_potongan'=>$data_edit['v_nama_potongan'],
            'v_nominal'=>$this->cipher->decrypt($data_edit['v_nominal']),
            'gapok'=>$this->cipher->decrypt($data_edit['gapok']),
            'tunjangan_khusus'=>$this->cipher->decrypt($data_edit['tunjangan_khusus']),
            'tunjangan_struktural'=>$this->cipher->decrypt($data_edit['tunjangan_struktural']),
            'penyesuaian'=>$this->cipher->decrypt($data_edit['penyesuaian']),
            'tas'=>$this->cipher->decrypt($data_edit['tas']),
            'maxgross'=>$this->cipher->decrypt($data_edit['maxgross']),
            'dinas_malam'=>$this->cipher->decrypt($data_edit['dinas_malam']),
            'lembur'=>$this->cipher->decrypt($data_edit['lembur']),
            'rapel'=>$this->cipher->decrypt($data_edit['rapel']),
            'insentif'=>$this->cipher->decrypt($data_edit['insentif']),
            'gross'=>$this->cipher->decrypt($data_edit['gross']),
            'potongan_jht'=>$this->cipher->decrypt($data_edit['potongan_jht']),
            'jaminan_pensiun'=>$this->cipher->decrypt($data_edit['jaminan_pensiun']),
            'bpjs_kesehatan'=>$this->cipher->decrypt($data_edit['bpjs_kesehatan']),
            'sta'=>$this->cipher->decrypt($data_edit['sta']),
            'pajak'=>$this->cipher->decrypt($data_edit['pajak']),
            'thp_bulat'=>$this->cipher->decrypt($data_edit['thp_bulat']),
            'potongan_kopkar'=>$this->cipher->decrypt($data_edit['potongan_kopkar']),
            'nominal_rek'=>$this->cipher->decrypt($data_edit['nominal_rek']),
            'nominal_lain'=>$this->cipher->decrypt($data_edit['nominal_lain']),
            'nominal_prr_btn'=>$this->cipher->decrypt($data_edit['nominal_prr_btn']),
            'nominal_btnsolo'=>$this->cipher->decrypt($data_edit['nominal_btnsolo']),
            'nominal_koperasi'=>$this->cipher->decrypt($data_edit['nominal_koperasi']),
            'ket_rek_rs'=>$data_edit['ket_rek_rs'],
            'ket_lain'=>$data_edit['ket_lain'],
            'ket_prr_btn'=>$data_edit['ket_prr_btn'],
            'ket_btn_solo'=>$data_edit['ket_btn_solo'],
            'ket_koperasi'=>$data_edit['ket_koperasi'],
            'jumlah_terima'=>$this->cipher->decrypt($data_edit['jumlah_terima']),
            'titik_perubahan'=>$data_edit['titik_perubahan'],
            'nominal_ekstra'=>$this->cipher->decrypt($data_edit['nominal_ekstra']),
            'ket_ekstra'=>$data_edit['ket_ekstra'],
            'jenis_ekstra'=>$data_edit['jenis_ekstra'],
            'honor'=>$this->cipher->decrypt($data_edit['honor']),
            'thr'=>$this->cipher->decrypt($data_edit['thr']),
            'status'=>$this->cipher->decrypt($data_edit['status']),
            'potongan_rs'=>$this->cipher->decrypt($data_edit['potongan_rs']),
            'pot_btn'=>$this->cipher->decrypt($data_edit['pot_btn']),
            'tunai'=>$this->cipher->decrypt($data_edit['tunai']),
            'pot_koperasi'=>$this->cipher->decrypt($data_edit['pot_koperasi']),
            'pot_jkn_kelg'=>$this->cipher->decrypt($data_edit['pot_jkn_kelg']),
            'jml_potongan'=>$this->cipher->decrypt($data_edit['jml_potongan'])
        );

        echo json_encode(array("code" => 200, "response" => $response));
    }

    public function cari_gaji_generate_by_id(){
        $n_isi_file_id  = $this->input->post('n_isi_file_id');
        $data_upload    = $this->Upload_model->get_isi_file_by_id($n_isi_file_id);

        $nik    = $data_upload['v_nik'];
        $bulan  = $data_upload['n_bulan'];
        $tahun  = $data_upload['n_tahun'];
        $jenis  = $data_upload['jenis'];

        $data   = $this->Upload_model->get_gaji_generate($nik, $bulan, $tahun, $jenis);

        echo json_encode($data);
    }

    public function UpdateIsiFile(){

        $n_isi_file_id          = $this->input->post('n_isi_file_id');
        $v_nik                  = $this->input->post('v_nik');
        $v_nominal              = $this->input->post('v_nominal');
        $gapok                  = $this->input->post('gapok');
        $tunjangan_khusus       = $this->input->post('tunjangan_khusus');
        $tunjangan_struktural   = $this->input->post('tunjangan_struktural');
        $penyesuaian            = $this->input->post('penyesuaian');
        $tas                    = $this->input->post('tas');
        $maxgross               = $this->input->post('maxgross');
        $dinas_malam            = $this->input->post('dinas_malam');
        $lembur                 = $this->input->post('lembur');
        $rapel                  = $this->input->post('rapel');
        $insentif               = $this->input->post('insentif');
        $gross                  = $this->input->post('gross');
        $potongan_jht           = $this->input->post('potongan_jht');
        $jaminan_pensiun        = $this->input->post('jaminan_pensiun');
        $bpjs_kesehatan         = $this->input->post('bpjs_kesehatan');
        $sta                    = $this->input->post('sta');
        $pajak                  = $this->input->post('pajak');
        $thp_bulat              = $this->input->post('thp_bulat');
        $potongan_kopkar        = $this->input->post('potongan_kopkar');
        $nominal_rek            = $this->input->post('nominal_rek');
        $nominal_lain           = $this->input->post('nominal_lain');
        $nominal_prr_btn        = $this->input->post('nominal_prr_btn');
        $nominal_btnsolo        = $this->input->post('nominal_btnsolo');
        $nominal_koperasi       = $this->input->post('nominal_koperasi');
        $ket_rek_rs             = $this->input->post('ket_rek_rs');
        $ket_lain               = $this->input->post('ket_lain');
        $ket_prr_btn            = $this->input->post('ket_prr_btn');
        $ket_btn_solo           = $this->input->post('ket_btn_solo');
        $ket_koperasi           = $this->input->post('ket_koperasi');
        $jumlah_terima          = $this->input->post('jumlah_terima');
        $titik_perubahan        = $this->input->post('titik_perubahan');
        $nominal_ekstra         = $this->input->post('nominal_ekstra');
        $ket_ekstra             = $this->input->post('ket_ekstra');
        $jenis_ekstra           = $this->input->post('jenis_ekstra');

        $data_upload    = $this->Upload_model->get_isi_file_by_id($n_isi_file_id);
        $bulan          = $data_upload['n_bulan'];
        $tahun          = $data_upload['n_tahun'];
        $nik            = $data_upload['v_nik'];

        $potongan_gaji  = $this->Upload_model->get_potongan_gaji_by_id($nik, $bulan, $tahun);
        $n_gaji_id      = $potongan_gaji['n_gaji_id'];
        // $potongan       = $potongan_gaji['potongan'];
        // $thp_bulat      = $potongan_gaji['thp_bulat'];
        // $transfer_bank  = $potongan_gaji['transfer_bank'];

        $cekdata   = $this->Upload_model->get_gaji_generate($nik, $bulan, $tahun);

        if($cekdata){

            $data = array(
                'v_nik'=>$v_nik,
                //'v_nominal'=>$this->cipher->encrypt($v_nominal),
                'gapok'=>$this->cipher->encrypt($gapok),
                'tunjangan_khusus'=>$this->cipher->encrypt($tunjangan_khusus),
                'tunjangan_struktural'=>$this->cipher->encrypt($tunjangan_struktural),
                'penyesuaian'=>$this->cipher->encrypt($penyesuaian),
                'tas'=>$this->cipher->encrypt($tas),
                'maxgross'=>$this->cipher->encrypt($maxgross),
                'dinas_malam'=>$this->cipher->encrypt($dinas_malam),
                'lembur'=>$this->cipher->encrypt($lembur),
                'rapel'=>$this->cipher->encrypt($rapel),
                'insentif'=>$this->cipher->encrypt($insentif),
                'gross'=>$this->cipher->encrypt($gross),
                'potongan_jht'=>$this->cipher->encrypt($potongan_jht),
                'jaminan_pensiun'=>$this->cipher->encrypt($jaminan_pensiun),
                'bpjs_kesehatan'=>$this->cipher->encrypt($bpjs_kesehatan),
                'sta'=>$this->cipher->encrypt($sta),
                'pajak'=>$this->cipher->encrypt($pajak),
                'thp_bulat'=>$this->cipher->encrypt($thp_bulat),
                'potongan_kopkar'=>$this->cipher->encrypt($potongan_kopkar),
                'nominal_rek'=>$this->cipher->encrypt($nominal_rek),
                'nominal_lain'=>$this->cipher->encrypt($nominal_lain),
                'nominal_prr_btn'=>$this->cipher->encrypt($nominal_prr_btn),
                'nominal_btnsolo'=>$this->cipher->encrypt($nominal_btnsolo),
                'nominal_koperasi'=>$this->cipher->encrypt($nominal_koperasi),
                'ket_rek_rs'=>$ket_rek_rs,
                'ket_lain'=>$ket_lain,
                'ket_prr_btn'=>$ket_prr_btn,
                'ket_btn_solo'=>$ket_btn_solo,
                'ket_koperasi'=>$ket_koperasi,
                'jumlah_terima'=>$this->cipher->encrypt($jumlah_terima),
                'titik_perubahan'=>$titik_perubahan,
                'nominal_ekstra'=>$this->cipher->encrypt($nominal_ekstra),
                'ket_ekstra'=>$ket_ekstra,
                'jenis_ekstra'=>$jenis_ekstra
            );

            $this->Upload_model->update_isi_file($n_isi_file_id, $data);

            $data_gaji = array(
                'nik'=>$v_nik,
                //'v_nominal'=>$this->cipher->encrypt($v_nominal),
                'gapok'=>$this->cipher->encrypt($gapok),
                'tunjangan_khusus'=>$this->cipher->encrypt($tunjangan_khusus),
                'tunjangan_struktural'=>$this->cipher->encrypt($tunjangan_struktural),
                'penyesuaian'=>$this->cipher->encrypt($penyesuaian),
                'tas'=>$this->cipher->encrypt($tas),
                'maxgross'=>$this->cipher->encrypt($maxgross),
                'dinas_malam'=>$this->cipher->encrypt($dinas_malam),
                'lembur'=>$this->cipher->encrypt($lembur),
                'rapel'=>$this->cipher->encrypt($rapel),
                'insentif'=>$this->cipher->encrypt($insentif),
                'gross'=>$this->cipher->encrypt($gross),
                'potongan_jht'=>$this->cipher->encrypt($potongan_jht),
                'jaminan_pensiun'=>$this->cipher->encrypt($jaminan_pensiun),
                'bpjs_kesehatan'=>$this->cipher->encrypt($bpjs_kesehatan),
                'sta'=>$this->cipher->encrypt($sta),
                'pajak'=>$this->cipher->encrypt($pajak),
                'thp_bulat'=>$this->cipher->encrypt($thp_bulat),
                'potongan_kopkar'=>$this->cipher->encrypt($potongan_kopkar),
                'nominal_rek'=>$this->cipher->encrypt($nominal_rek),
                'nominal_lain'=>$this->cipher->encrypt($nominal_lain),
                'nominal_prr_btn'=>$this->cipher->encrypt($nominal_prr_btn),
                'nominal_btnsolo'=>$this->cipher->encrypt($nominal_btnsolo),
                'nominal_koperasi'=>$this->cipher->encrypt($nominal_koperasi),
                'ket_rek_rs'=>$ket_rek_rs,
                'ket_lain'=>$ket_lain,
                'ket_prr_btn'=>$ket_prr_btn,
                'ket_btn_solo'=>$ket_btn_solo,
                'ket_koperasi'=>$ket_koperasi,
                'jumlah_terima'=>$this->cipher->encrypt($jumlah_terima),
                'titik_perubahan'=>$titik_perubahan,
                'nominal_ekstra'=>$this->cipher->encrypt($nominal_ekstra),
                'ket_ekstra'=>$ket_ekstra,
                'jenis_ekstra'=>$jenis_ekstra
            );

            $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            /*if($potongan != "" OR $potongan != null){
                $data_gaji = array(
                    'nik'=>$nik,
                    'potongan'=>$this->cipher->encrypt($v_nominal)
                );

                $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            }else if($thp_bulat != "" OR $thp_bulat != null){

                $data_gaji = array(
                    'nik'=>$nik,
                    'thp_bulat'=>$this->cipher->encrypt($v_nominal)
                );

                $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            }else if($transfer_bank != "" OR $transfer_bank != null){

                $data_gaji = array(
                    'nik'=>$nik,
                    'transfer_bank'=>$this->cipher->encrypt($v_nominal)
                );

                $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            }*/

        }else{

            $data = array(
                'v_nik'=>$v_nik,
                //'v_nominal'=>$this->cipher->encrypt($v_nominal),
                'gapok'=>$this->cipher->encrypt($gapok),
                'tunjangan_khusus'=>$this->cipher->encrypt($tunjangan_khusus),
                'tunjangan_struktural'=>$this->cipher->encrypt($tunjangan_struktural),
                'penyesuaian'=>$this->cipher->encrypt($penyesuaian),
                'tas'=>$this->cipher->encrypt($tas),
                'maxgross'=>$this->cipher->encrypt($maxgross),
                'dinas_malam'=>$this->cipher->encrypt($dinas_malam),
                'lembur'=>$this->cipher->encrypt($lembur),
                'rapel'=>$this->cipher->encrypt($rapel),
                'insentif'=>$this->cipher->encrypt($insentif),
                'gross'=>$this->cipher->encrypt($gross),
                'potongan_jht'=>$this->cipher->encrypt($potongan_jht),
                'jaminan_pensiun'=>$this->cipher->encrypt($jaminan_pensiun),
                'bpjs_kesehatan'=>$this->cipher->encrypt($bpjs_kesehatan),
                'sta'=>$this->cipher->encrypt($sta),
                'pajak'=>$this->cipher->encrypt($pajak),
                'thp_bulat'=>$this->cipher->encrypt($thp_bulat),
                'potongan_kopkar'=>$this->cipher->encrypt($potongan_kopkar),
                'nominal_rek'=>$this->cipher->encrypt($nominal_rek),
                'nominal_lain'=>$this->cipher->encrypt($nominal_lain),
                'nominal_prr_btn'=>$this->cipher->encrypt($nominal_prr_btn),
                'nominal_btnsolo'=>$this->cipher->encrypt($nominal_btnsolo),
                'nominal_koperasi'=>$this->cipher->encrypt($nominal_koperasi),
                'ket_rek_rs'=>$ket_rek_rs,
                'ket_lain'=>$ket_lain,
                'ket_prr_btn'=>$ket_prr_btn,
                'ket_btn_solo'=>$ket_btn_solo,
                'ket_koperasi'=>$ket_koperasi,
                'jumlah_terima'=>$this->cipher->encrypt($jumlah_terima),
                'titik_perubahan'=>$titik_perubahan,
                'nominal_ekstra'=>$this->cipher->encrypt($nominal_ekstra),
                'ket_ekstra'=>$ket_ekstra,
                'jenis_ekstra'=>$jenis_ekstra
            );

            $this->Upload_model->update_isi_file($n_isi_file_id, $data);
        }
        
    }

     public function UpdateIsiFileXIIIKeatas(){

        $n_isi_file_id          = $this->input->post('n_isi_file_id');
        $v_nik                  = $this->input->post('v_nik');
        $v_nominal              = $this->input->post('v_nominal');
        $gapok                  = $this->input->post('gapok');
        $potongan_rs            = $this->input->post('potongan_rs');
        $tunjangan_khusus       = $this->input->post('tunjangan_khusus');
        $insentif               = $this->input->post('insentif');
        $pot_koperasi           = $this->input->post('pot_koperasi');
        $tunjangan_struktural   = $this->input->post('tunjangan_struktural');
        $potongan_jht           = $this->input->post('potongan_jht');
        $pot_btn                = $this->input->post('pot_btn');
        $tas                    = $this->input->post('tas');
        $jaminan_pensiun        = $this->input->post('jaminan_pensiun');
        $tunai                  = $this->input->post('tunai');
        $penyesuaian            = $this->input->post('penyesuaian');
        $bpjs_kesehatan         = $this->input->post('bpjs_kesehatan');
        $jml_potongan           = $this->input->post('jml_potongan');
        $gross                  = $this->input->post('gross');
        $status                 = $this->input->post('status');
        $maxgross               = $this->input->post('maxgross');
        $pajak                  = $this->input->post('pajak');
        $jumlah_terima          = $this->input->post('jumlah_terima');
        $honor                  = $this->input->post('honor');
        $thr                    = $this->input->post('thr');
        $lembur                 = $this->input->post('lembur');
        $thp_bulat              = $this->input->post('thp_bulat');
     
       

        $data_upload    = $this->Upload_model->get_isi_file_by_id($n_isi_file_id);
        $bulan          = $data_upload['n_bulan'];
        $tahun          = $data_upload['n_tahun'];
        $nik            = $data_upload['v_nik'];

        $potongan_gaji  = $this->Upload_model->get_potongan_gaji_by_id($nik, $bulan, $tahun);
        $n_gaji_id      = $potongan_gaji['n_gaji_id'];
        // $potongan       = $potongan_gaji['potongan'];
        // $thp_bulat      = $potongan_gaji['thp_bulat'];
        // $transfer_bank  = $potongan_gaji['transfer_bank'];

        $cekdata   = $this->Upload_model->get_gaji_generateXIIIAtas($nik, $bulan, $tahun);

        if($cekdata){

            $data = array(
                'v_nik'=>$v_nik,
                //'v_nominal'=>$this->cipher->encrypt($v_nominal),
                'gapok'=>$this->cipher->encrypt($gapok),
                'rapel'=>$this->cipher->encrypt($rapel),
                'potongan_rs'=>$this->cipher->encrypt($potongan_rs),
                'tunjangan_khusus'=>$this->cipher->encrypt($tunjangan_khusus),
                'insentif'=>$this->cipher->encrypt($insentif),
                'pot_koperasi'=>$this->cipher->encrypt($pot_koperasi),
                'tunjangan_struktural'=>$this->cipher->encrypt($tunjangan_struktural),
                'potongan_jht'=>$this->cipher->encrypt($potongan_jht),
                'pot_btn'=>$this->cipher->encrypt($pot_btn),
                'tas'=>$this->cipher->encrypt($tas),
                'jaminan_pensiun'=>$this->cipher->encrypt($jaminan_pensiun),
                'tunai'=>$this->cipher->encrypt($tunai),
                'penyesuaian'=>$this->cipher->encrypt($penyesuaian),
                'bpjs_kesehatan'=>$this->cipher->encrypt($bpjs_kesehatan),
                'jml_potongan'=>$this->cipher->encrypt($jml_potongan),
                'gross'=>$this->cipher->encrypt($gross),
                'status'=>$this->cipher->encrypt($status),
                'maxgross'=>$this->cipher->encrypt($maxgross),
                'pajak'=>$this->cipher->encrypt($pajak),
                'jumlah_terima'=>$this->cipher->encrypt($jumlah_terima),
                'honor'=>$this->cipher->encrypt($honor),
                'thr'=>$this->cipher->encrypt($thr),
                'lembur'=>$this->cipher->encrypt($lembur),
                'thp_bulat'=>$this->cipher->encrypt($thp_bulat)
            );

            $this->Upload_model->update_isi_file($n_isi_file_id, $data);

            $data_gaji = array(
                'v_nik'=>$v_nik,
                //'v_nominal'=>$this->cipher->encrypt($v_nominal),
                'gapok'=>$this->cipher->encrypt($gapok),
                'rapel'=>$this->cipher->encrypt($rapel),
                'potongan_rs'=>$this->cipher->encrypt($potongan_rs),
                'tunjangan_khusus'=>$this->cipher->encrypt($tunjangan_khusus),
                'insentif'=>$this->cipher->encrypt($insentif),
                'pot_koperasi'=>$this->cipher->encrypt($pot_koperasi),
                'tunjangan_struktural'=>$this->cipher->encrypt($tunjangan_struktural),
                'potongan_jht'=>$this->cipher->encrypt($potongan_jht),
                'pot_btn'=>$this->cipher->encrypt($pot_btn),
                'tas'=>$this->cipher->encrypt($tas),
                'jaminan_pensiun'=>$this->cipher->encrypt($jaminan_pensiun),
                'tunai'=>$this->cipher->encrypt($tunai),
                'penyesuaian'=>$this->cipher->encrypt($penyesuaian),
                'bpjs_kesehatan'=>$this->cipher->encrypt($bpjs_kesehatan),
                'jml_potongan'=>$this->cipher->encrypt($jml_potongan),
                'gross'=>$this->cipher->encrypt($gross),
                'status'=>$this->cipher->encrypt($status),
                'maxgross'=>$this->cipher->encrypt($maxgross),
                'pajak'=>$this->cipher->encrypt($pajak),
                'jumlah_terima'=>$this->cipher->encrypt($jumlah_terima),
                'honor'=>$this->cipher->encrypt($honor),
                'thr'=>$this->cipher->encrypt($thr),
                'lembur'=>$this->cipher->encrypt($lembur),
                'thp_bulat'=>$this->cipher->encrypt($thp_bulat)
            );

            $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            /*if($potongan != "" OR $potongan != null){
                $data_gaji = array(
                    'nik'=>$nik,
                    'potongan'=>$this->cipher->encrypt($v_nominal)
                );

                $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            }else if($thp_bulat != "" OR $thp_bulat != null){

                $data_gaji = array(
                    'nik'=>$nik,
                    'thp_bulat'=>$this->cipher->encrypt($v_nominal)
                );

                $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            }else if($transfer_bank != "" OR $transfer_bank != null){

                $data_gaji = array(
                    'nik'=>$nik,
                    'transfer_bank'=>$this->cipher->encrypt($v_nominal)
                );

                $this->Upload_model->update_tb_gaji($n_gaji_id, $data_gaji);

            }*/

        }else{

            $data = array(
                'v_nik'=>$v_nik,
                //'v_nominal'=>$this->cipher->encrypt($v_nominal),
                'gapok'=>$this->cipher->encrypt($gapok),
                'rapel'=>$this->cipher->encrypt($rapel),
                'potongan_rs'=>$this->cipher->encrypt($potongan_rs),
                'tunjangan_khusus'=>$this->cipher->encrypt($tunjangan_khusus),
                'insentif'=>$this->cipher->encrypt($insentif),
                'pot_koperasi'=>$this->cipher->encrypt($pot_koperasi),
                'tunjangan_struktural'=>$this->cipher->encrypt($tunjangan_struktural),
                'potongan_jht'=>$this->cipher->encrypt($potongan_jht),
                'pot_btn'=>$this->cipher->encrypt($pot_btn),
                'tas'=>$this->cipher->encrypt($tas),
                'jaminan_pensiun'=>$this->cipher->encrypt($jaminan_pensiun),
                'tunai'=>$this->cipher->encrypt($tunai),
                'penyesuaian'=>$this->cipher->encrypt($penyesuaian),
                'bpjs_kesehatan'=>$this->cipher->encrypt($bpjs_kesehatan),
                'jml_potongan'=>$this->cipher->encrypt($jml_potongan),
                'gross'=>$this->cipher->encrypt($gross),
                'status'=>$this->cipher->encrypt($status),
                'maxgross'=>$this->cipher->encrypt($maxgross),
                'pajak'=>$this->cipher->encrypt($pajak),
                'jumlah_terima'=>$this->cipher->encrypt($jumlah_terima),
                'honor'=>$this->cipher->encrypt($honor),
                'thr'=>$this->cipher->encrypt($thr),
                'lembur'=>$this->cipher->encrypt($lembur),
                'thp_bulat'=>$this->cipher->encrypt($thp_bulat)
            );

            $this->Upload_model->update_isi_file($n_isi_file_id, $data);
        }
        
    }
     public function deleteFile($file){
        $this->load->library('ftp');
        $ftp_config['hostname'] = '192.168.2.61';
        $ftp_config['username'] = 'administrator';
        $ftp_config['password'] = '643139';
        $ftp_config['debug']    = FALSE;
        $this->ftp->connect($ftp_config);

        $destination = '/var/www/html/sipakar/file/upload_excel'.$file;
        $this->ftp->delete_file($destination);
        $this->ftp->close();

        if (file_exists('/var/www/html/sipakar/file/upload_excel'.$file)) {
            unlink('/var/www/html/sipakar/file/upload_excel'.$file);
        }
    }

}