<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class ProsesHitungGaji extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('Masterkaryawan_model'));
	}

	public function index()
	{
		$data['list_unitrs_cari']=$this->Masterkaryawan_model->get_list_all_unitrs();

		$data['content'] = 'PerhitunganGajiView';
		$this->load->view('template', $data);

	}

	public function getListEmployeeByUnitRs()
	{	
		$id_unit   = $this->input->post('unitrs_id');

		$list_employee_by_unit = $this->Masterkaryawan_model->get_karyawan_by_idunit($id_unit);

		$data = array(
            'list' => $list_employee_by_unit            
        );
        echo json_encode($data);
	}

	public function insert()
	{
		$nama_potongan   = $this->input->post('v_nama_potongan');

		$v_nama_potongan = strtoupper($nama_potongan);

		$data = array(
			'v_nama_potongan' => $v_nama_potongan
		);

		$sukses= $this->MasterPotongan_model->insert($data);
        echo json_encode(array("code" => 200, "response" => $sukses));

	}

	public function cari_potongan_by_id(){
        $n_potongan_id  = $this->input->post('n_potongan_id');
        $data_edit 		= $this->MasterPotongan_model->get_potongan_by_id($n_potongan_id);

        $response = array(
            'v_nama_potongan'=>$data_edit['v_nama_potongan']
        );

        echo json_encode(array("code" => 200, "response" => $response));
    }

    public function Update(){

        $n_potongan_id 	 = $this->input->post('n_potongan_id');
        $nama_potongan 	 = $this->input->post('v_nama_potongan');

        $v_nama_potongan = strtoupper($nama_potongan);

        $data = array(
            'v_nama_potongan'=>$v_nama_potongan
        );
        $this->MasterPotongan_model->update($n_potongan_id, $data);
    }

}