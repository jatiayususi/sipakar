<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class LapGajipergolongan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('LapGajipergolongan_model'));
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory','cipher'));
        date_default_timezone_set("Asia/Jakarta"); 
	}

    //I-XII
    public function lapBawahXIII(){

        $data['content'] = 'LapGajibawahxii_view';
        $this->load->view('template', $data); 
    }

    public function getJmlKaryawanXIIKeBawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getJmlKaryawan($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $data = array(
            'detail' => $getData            
        );
        echo json_encode($data);
    }

    public function getGapokXIIKeBawah(){
        $id_golongan = $this->input->post('id_golongan');
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getGapok($id_golongan, $bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $ecr=$this->LapGajipergolongan_model->getEnc();


        $data = array();
        foreach ($getData as $Data) {
            $data[]=array(
                'gapok' => (float)$this->cipher->decrypt($Data['gapok']),
                'tunjangan_struktural' => (float)$this->cipher->decrypt($Data['tunjangan_struktural']),
                'tunjangan_khusus' => (float)$this->cipher->decrypt($Data['tunjangan_khusus']),
                'tas' => (float)$this->cipher->decrypt($Data['tas']),
                'penyesuaian' => (float)$this->cipher->decrypt($Data['penyesuaian']),
                'maxgross' => (float)$this->cipher->decrypt($Data['maxgross']),
                'dinas_malam' => (float)$this->cipher->decrypt($Data['dinas_malam']),
                'lembur' => (float)$this->cipher->decrypt($Data['lembur']),
                'rapel' => (float)$this->cipher->decrypt($Data['rapel']),
                'insentif' => (float)$this->cipher->decrypt($Data['insentif']),
                'gross' => (float)$this->cipher->decrypt($Data['gross']),
                'potongan_jht' => (float)$this->cipher->decrypt($Data['potongan_jht']),
                'jaminan_pensiun' => (float)$this->cipher->decrypt($Data['jaminan_pensiun']),
                'pajak' => (float)$this->cipher->decrypt($Data['pajak']),
                'bpjs_kesehatan' => (float)$this->cipher->decrypt($Data['bpjs_kesehatan']),
                'thp_bulat' => (float)$this->cipher->decrypt($Data['thp_bulat']),
                'jumlah_terima' => (float)$this->cipher->decrypt($Data['jumlah_terima'])
            );

        }
        echo json_encode($data);        
    }

    
    public function getJumKaryawan(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getJumKaryawan($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        echo json_encode($getData);
    }

    public function getAllGapokXIIKeBawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getAllGapok($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $ecr=$this->LapGajipergolongan_model->getEnc();


        $data = array();
        foreach ($getData as $Data) {
            $data[]=array(
                'allgapok' => (float)$this->cipher->decrypt($Data['allgapok']),
                'tunjangan_struktural' => (float)$this->cipher->decrypt($Data['tunjangan_struktural']),
                'tunjangan_khusus' => (float)$this->cipher->decrypt($Data['tunjangan_khusus']),
                'tas' => (float)$this->cipher->decrypt($Data['tas']),
                'penyesuaian' => (float)$this->cipher->decrypt($Data['penyesuaian']),
                'maxgross' => (float)$this->cipher->decrypt($Data['maxgross']),
                'dinas_malam' => (float)$this->cipher->decrypt($Data['dinas_malam']),
                'lembur' => (float)$this->cipher->decrypt($Data['lembur']),
                'rapel' => (float)$this->cipher->decrypt($Data['rapel']),
                'insentif' => (float)$this->cipher->decrypt($Data['insentif']),
                'gross' => (float)$this->cipher->decrypt($Data['gross']),
                'potongan_jht' => (float)$this->cipher->decrypt($Data['potongan_jht']),
                'jaminan_pensiun' => (float)$this->cipher->decrypt($Data['jaminan_pensiun']),
                'pajak' => (float)$this->cipher->decrypt($Data['pajak']),
                'bpjs_kesehatan' => (float)$this->cipher->decrypt($Data['bpjs_kesehatan']),
                'thp_bulat' => (float)$this->cipher->decrypt($Data['thp_bulat']),
                'jumlah_terima' => (float)$this->cipher->decrypt($Data['jumlah_terima'])
            );

        }
        echo json_encode($data);        
    }

    
    //XIII
    public function lapAtasXIII(){
        $data['content'] = 'LapGajiatasxiii_view';
        $this->load->view('template', $data);
    }

    public function getJmlKaryawanXIIIKeAtas(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 2; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getJmlKaryawanXIIIKeAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $data = array(
            'detail' => $getData            
        );
        echo json_encode($data);
    }


    public function getGapokXIIIKeAtas(){
        $id_golongan = $this->input->post('id_golongan');
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 2; //atas (XIII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getGapokXIIIKeAtas($id_golongan, $bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $ecr=$this->LapGajipergolongan_model->getEnc();


        $data = array();
        foreach ($getData as $Data) {
            $data[]=array(
                'gapok' => (float)$this->cipher->decrypt($Data['gapok']),
                'tunjangan_struktural' => (float)$this->cipher->decrypt($Data['tunjangan_struktural']),
                'tunjangan_khusus' => (float)$this->cipher->decrypt($Data['tunjangan_khusus']),
                'tas' => (float)$this->cipher->decrypt($Data['tas']),
                'penyesuaian' => (float)$this->cipher->decrypt($Data['penyesuaian']),
                'maxgross' => (float)$this->cipher->decrypt($Data['maxgross']),
                'dinas_malam' => (float)$this->cipher->decrypt($Data['dinas_malam']),
                'lembur' => (float)$this->cipher->decrypt($Data['lembur']),
                'rapel' => (float)$this->cipher->decrypt($Data['rapel']),
                'insentif' => (float)$this->cipher->decrypt($Data['insentif']),
                'gross' => (float)$this->cipher->decrypt($Data['gross']),
                'potongan_jht' => (float)$this->cipher->decrypt($Data['potongan_jht']),
                'jaminan_pensiun' => (float)$this->cipher->decrypt($Data['jaminan_pensiun']),
                'pajak' => (float)$this->cipher->decrypt($Data['pajak']),
                'bpjs_kesehatan' => (float)$this->cipher->decrypt($Data['bpjs_kesehatan']),
                'thp_bulat' => (float)$this->cipher->decrypt($Data['thp_bulat']),
                'jumlah_terima' => (float)$this->cipher->decrypt($Data['jumlah_terima'])
            );

        }
        echo json_encode($data);        
    }

    function getJumKaryawanXIIIkeAtas(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 2; //atas (XIII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getJumKaryawan($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        echo json_encode($getData);
    }

    function getAllGapokXIIIKeAtas(){

        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 2; //atas (XIII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajipergolongan_model->getAllGapok($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $ecr=$this->LapGajipergolongan_model->getEnc();


        $data = array();
        foreach ($getData as $Data) {
            $data[]=array(
                'allgapok' => (float)$this->cipher->decrypt($Data['allgapok']),
                'tunjangan_struktural' => (float)$this->cipher->decrypt($Data['tunjangan_struktural']),
                'tunjangan_khusus' => (float)$this->cipher->decrypt($Data['tunjangan_khusus']),
                'tas' => (float)$this->cipher->decrypt($Data['tas']),
                'penyesuaian' => (float)$this->cipher->decrypt($Data['penyesuaian']),
                'maxgross' => (float)$this->cipher->decrypt($Data['maxgross']),
                'dinas_malam' => (float)$this->cipher->decrypt($Data['dinas_malam']),
                'lembur' => (float)$this->cipher->decrypt($Data['lembur']),
                'rapel' => (float)$this->cipher->decrypt($Data['rapel']),
                'insentif' => (float)$this->cipher->decrypt($Data['insentif']),
                'gross' => (float)$this->cipher->decrypt($Data['gross']),
                'potongan_jht' => (float)$this->cipher->decrypt($Data['potongan_jht']),
                'jaminan_pensiun' => (float)$this->cipher->decrypt($Data['jaminan_pensiun']),
                'pajak' => (float)$this->cipher->decrypt($Data['pajak']),
                'bpjs_kesehatan' => (float)$this->cipher->decrypt($Data['bpjs_kesehatan']),
                'thp_bulat' => (float)$this->cipher->decrypt($Data['thp_bulat']),
                'jumlah_terima' => (float)$this->cipher->decrypt($Data['jumlah_terima'])
            );

        }
        echo json_encode($data);    

    }



}