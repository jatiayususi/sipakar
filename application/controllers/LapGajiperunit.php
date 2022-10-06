<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class LapGajiperunit extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('LapGajiperunit_model'));
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory','cipher'));
        date_default_timezone_set("Asia/Jakarta"); 
	}


    //I-XII
    function lapPerunitBawahXII(){
        $data['content'] = 'LapGajiperunitbawahxii_view';
        $this->load->view('template', $data); 
    }

    function getUnitGolXIIBawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);
        $getData = $this->LapGajiperunit_model->getUnitGolXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $data = array(
            'detail' => $getData            
        );
        echo json_encode($data);
    }

    function getDataGajiGolXIIBawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $n_unitrsid = $this->input->post('n_unitrsid');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);
        $getData = $this->LapGajiperunit_model->getDataGajiGolXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan, $n_unitrsid);
        $ecr=$this->LapGajiperunit_model->getEnc();

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


    function insertdata(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $n_unitrsid = $this->input->post('n_unitrsid');
        $t_gapok = $this->input->post('t_gapok');
        $t_penyesuaian = $this->input->post('t_penyesuaian');
        $t_gross = $this->input->post('t_gross');
        $t_tas = $this->input->post('t_TAS');
        $t_maxgross = $this->input->post('t_maxgross');
        $t_rapellain = $this->input->post('t_rapellain');
        $t_dinasmalam = $this->input->post('t_dinasmalam');
        $t_lembur = $this->input->post('t_lembur');
        $t_potjht = $this->input->post('t_potJHT');
        $t_jaminanpensiun = $this->input->post('t_jaminanpensiun');
        $t_potjkn = $this->input->post('t_PotJKN');
        $t_thpbulat = $this->input->post('t_ThpBulat');
        $t_pph21 = $this->input->post('t_pph21');
        $t_tunjkhusus = $this->input->post('t_tunjKhusus');
        $t_tunjstruktural = $this->input->post('t_tunjStruktural');
        $t_insentif = $this->input->post('t_insentif');
        $t_gajibersih = $this->input->post('t_GajiBersih');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

      
        $data = array(
            'n_unitrsid' => $n_unitrsid,
            'jenis_gaji' => $jenis_gaji,
            'bulan' => $bulan,
            'tahun' => $tahun,
            't_gapok' => $t_gapok,
            't_penyesuaian' => $t_penyesuaian,
            't_gross' => $t_gross,
            't_tas' => $t_tas,
            't_maxgross' => $t_maxgross,
            't_rapellain' => $t_rapellain,
            't_dinasmalam' => $t_dinasmalam,
            't_lembur' => $t_lembur,
            't_potjht' => $t_potjht,
            't_jaminanpensiun' => $t_jaminanpensiun,
            't_potjkn' => $t_potjkn,
            't_thpbulat' => $t_thpbulat,
            't_pph21' => $t_pph21,
            't_tunjkhusus' => $t_tunjkhusus,
            't_tunjstruktural' => $t_tunjstruktural,
            't_insentif' => $t_insentif,
            'v_grup_golongan' => $v_grup_golongan,
            't_gajibersih' => $t_gajibersih
        );

        $sukses= $this->LapGajiperunit_model->insert($data);
        echo json_encode(array("code" => 200, "response" => $sukses));
    }

    function updatedata(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $n_unitrsid = $this->input->post('n_unitrsid');
        $t_gapok = $this->input->post('t_gapok');
        $t_penyesuaian = $this->input->post('t_penyesuaian');
        $t_gross = $this->input->post('t_gross');
        $t_tas = $this->input->post('t_TAS');
        $t_maxgross = $this->input->post('t_maxgross');
        $t_rapellain = $this->input->post('t_rapellain');
        $t_dinasmalam = $this->input->post('t_dinasmalam');
        $t_lembur = $this->input->post('t_lembur');
        $t_potjht = $this->input->post('t_potJHT');
        $t_jaminanpensiun = $this->input->post('t_jaminanpensiun');
        $t_potjkn = $this->input->post('t_PotJKN');
        $t_thpbulat = $this->input->post('t_ThpBulat');
        $t_pph21 = $this->input->post('t_pph21');
        $t_tunjkhusus = $this->input->post('t_tunjKhusus');
        $t_tunjstruktural = $this->input->post('t_tunjStruktural');
        $t_insentif = $this->input->post('t_insentif');
        $t_gajibersih = $this->input->post('t_GajiBersih');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        //by bulan, tahun, jenis gaji dan n_unitrsid
        $data = array(
            'n_unitrsid' => $n_unitrsid,
            'jenis_gaji' => $jenis_gaji,
            'bulan' => $bulan,
            'tahun' => $tahun,
            't_gapok' => $t_gapok,
            't_penyesuaian' => $t_penyesuaian,
            't_gross' => $t_gross,
            't_tas' => $t_tas,
            't_maxgross' => $t_maxgross,
            't_rapellain' => $t_rapellain,
            't_dinasmalam' => $t_dinasmalam,
            't_lembur' => $t_lembur,
            't_potjht' => $t_potjht,
            't_jaminanpensiun' => $t_jaminanpensiun,
            't_potjkn' => $t_potjkn,
            't_thpbulat' => $t_thpbulat,
            't_pph21' => $t_pph21,
            't_tunjkhusus' => $t_tunjkhusus,
            't_tunjstruktural' => $t_tunjstruktural,
            't_insentif' => $t_insentif,
            'v_grup_golongan' => $v_grup_golongan,
            't_gajibersih' => $t_gajibersih
        );

        $this->LapGajiperunit_model->update($data, $bulan, $tahun, $jenis_gaji, $n_unitrsid);
        // echo json_encode(array("code" => 200, "response" => $sukses));
    }

    function cekData(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajiperunit_model->cekData($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        echo json_encode($getData);
    }

    function gettotalPerunitXIIBawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajiperunit_model->gettotalPerunitXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        echo json_encode($getData);
    }

    function getJumKaryawanXIIBawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajiperunit_model->getJumKaryawanXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $data = array(
            'detail' => $getData            
        );
        echo json_encode($data);
        
    }


    function getTotalDetailXIIBawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajiperunit_model->getTotalDetailXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $ecr=$this->LapGajiperunit_model->getEnc();


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

     //XIII keatas
    function lapPerunitAtasXIII(){
        $data['content'] = 'LapGajiperunitatasxiii_view';
        $this->load->view('template', $data); 
    }

    function getUnitGolXIIIAtas(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 2; //atas (XIII ke atas)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);
        $getData = $this->LapGajiperunit_model->getUnitGolXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $data = array(
            'detail' => $getData            
        );
        echo json_encode($data);
    }

    function getDataGajiGolXIIIAtas(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $n_unitrsid = $this->input->post('n_unitrsid');
        $v_grup_golongan = 2; //atas (XIII ke atas)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);
        $getData = $this->LapGajiperunit_model->getDataGajiGolXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan, $n_unitrsid);
        $ecr=$this->LapGajiperunit_model->getEnc();

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

    function getJumKaryawanXIIIAtas(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 2; //atas (XIII atas)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajiperunit_model->getJumKaryawanXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        echo json_encode($getData);
    }


    function getTotalDetailXIIIAtas(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 2; //atas (XIII atas)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajiperunit_model->getTotalDetailXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        $ecr=$this->LapGajiperunit_model->getEnc();


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

    function gettotalAllGajiPerunitXIIKebawah(){
        $periode_gaji = $this->input->post('periode_gaji');
        $jenis_gaji = $this->input->post('jenis_gaji');
        $v_grup_golongan = 1; //bawah (I-XII)

        $bulan = substr($periode_gaji, 0,2);
        $tahun = substr($periode_gaji, 3,4);

        $getData = $this->LapGajiperunit_model->gettotalAllGajiPerunitXIIKebawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan);
        // $ecr=$this->LapGajipergolongan_model->getEnc();


        $data = array();
        foreach ($getData as $Data) {
            $data[]=array(
                't_gapok'             => (float)$Data['t_gapok'],
                't_penyesuaian'       => (float)$Data['t_penyesuaian'],
                't_gross'             => (float)$Data['t_gross'],
                't_tas'               => (float)$Data['t_tas'],
                't_maxgross'          => (float)$Data['t_maxgross'],
                't_rapellain'         => (float)$Data['t_rapellain'],
                't_dinasmalam'        => (float)$Data['t_dinasmalam'],
                't_lembur'            => (float)$Data['t_lembur'],
                't_potjht'            => (float)$Data['t_potjht'],
                't_jaminanpensiun'    => (float)$Data['t_jaminanpensiun'],
                't_thpbulat'          => (float)$Data['t_thpbulat'],
                't_pph21'             => (float)$Data['t_pph21'],
                't_potjkn'            => (float)$Data['t_potjkn'],
                't_tunjkhusus'        => (float)$Data['t_tunjkhusus'],
                't_tunjstruktural'    => (float)$Data['t_tunjstruktural'],
                't_insentif'          => (float)$Data['t_insentif'],
                'v_grup_golongan'     => (float)$Data['v_grup_golongan'],
                't_gajibersih'        => (float)$Data['t_gajibersih']
            );

        }
        echo json_encode($data);  
    }


}