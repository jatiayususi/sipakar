<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class GajiKaryawan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('Karyawan_model','Masterkaryawan_model','Upload_model'));
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory','cipher'));
	}

	public function index()
	{
		$data['list_unitrs']=$this->Karyawan_model->get_list_all_unitrs();
		$data['content'] = 'GajiKaryawan_view';
		$this->load->view('template', $data);
	}

	public function refresh_table_karyawan() {
        if ($this->input->post('n_unitrsid') != null){
            $n_unitrsid = $this->input->post('n_unitrsid');
            
            $data['list_unitrs'] = $this->Karyawan_model->get_unit_by_id($n_unitrsid);
            
            $data['list_karyawan'] = $this->Karyawan_model->get_karyawan_by_unit($n_unitrsid);

            echo json_encode($data);
        }
    }

    public function getListKaryawan() {
        if ($this->input->post('n_unitrsid') != null){
            $n_unitrsid = $this->input->post('n_unitrsid');
            
            $data['list_unitrs'] = $this->Karyawan_model->get_unit_by_id($n_unitrsid);
            
            $data['list_karyawan'] = $this->Karyawan_model->get_karyawan_by_unit($n_unitrsid);

            echo json_encode($data);
        }
    }

    public function cari_detail_karyawan(){
         $n_employee_id = $this->input->post('n_employee_id');
         $bulanTahun=$this->input->post('bulanTahunGajiHitung');

            // $n_employee_id=971;
            // $bulanTahun='01/2020';

        $detail_karyawan = $this->Karyawan_model->get_karyawan_by_id($n_employee_id);
        $tahunGapok= $this->Karyawan_model->get_bulan_gaji_by_id( $n_employee_id,$bulanTahun);

        $golongan=$tahunGapok['id_golongan'];
        $thGapok=$tahunGapok['th_gapok'];

        $thGapokEnc=$this->cipher->encrypt($thGapok); 
        $gapok=$this->Karyawan_model->getGapok($golongan,$thGapokEnc);
        $gapokDec=$this->cipher->decrypt($gapok['v_gapok']);

        $tahun=substr($bulanTahun,3, 4);
        $bulan=substr($bulanTahun,0, 2);


        $potongan = $this->Upload_model->getPotonganKaryawan($n_employee_id,$tahun,$bulan);

        foreach ($potongan as $detail) {
            $dataDec[]=array(
                'jenis_potongan' => $detail['group_pengurangan'],
                'v_nominal'=>$this->cipher->decrypt($detail['v_nominal'])
            );
        }

        $tambahan = $this->Upload_model->getTambahanKaryawan($n_employee_id,$tahun,$bulan);

        foreach ($tambahan as $detail) {
            $dataTambahanDec[]=array(
                'jenis_tambahan' => $detail['group_penambah'],
                'v_nominal'=>$this->cipher->decrypt($detail['v_nominal'])
            );
        }

        $data = array(
           'data_karyawan'=>$detail_karyawan,
            'thGapok'=>$tahunGapok,
            'gapok'=>$gapokDec,
            'potongan'=>$dataDec,
            'tambahan'=>$dataTambahanDec            
        );
         echo json_encode($data);
         // var_dump($potongan);
    }

    public function cari_potongan_karyawan($employee_id,$bulan,$tahun){
        // $nik='2098';
        // $bulan='12';
        // $tahun='2019';

        $potongan = $this->Upload_model->getPotonganKaryawan($employee_id,$tahun,$bulan);

        $dataDec = array();
        foreach ($potongan as $detail) {
            $dataDec[]=array(
                'jenis_potongan' => $detail['group_pengurangan'],
                'v_nominal'=>$this->cipher->decrypt($detail['v_nominal'])
            );
        }
        echo json_encode($dataDec);
        // var_dump($dataDec);
    }


}