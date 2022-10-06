<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class MasterPotongan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('MasterPotongan_model'));
	}

	public function index()
	{
		$data['content'] = 'MasterPotongan_view';
		$this->load->view('template', $data);
	}

	public function getListMasterPotongan()
	{
		$list_master_potongan = $this->MasterPotongan_model->get_list_all();

		$data = array(
            'list' => $list_master_potongan            
        );
        echo json_encode($data);
	}

	public function insert()
	{
		$nama_potongan   = $this->input->post('v_nama_potongan');
		$group_pengurang=$this->input->post('group_pengurang');
		$group_tambahan=$this->input->post('group_tambahan');

		$v_nama_potongan = strtoupper($nama_potongan);

		$data = array(
			'v_nama_potongan' => $v_nama_potongan,
			'group_pengurangan'=>$group_pengurang,
			'group_penambah'=>$group_tambahan
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

    public function insert_log(){
    	
    	$desc 	 = $this->input->post('desc');

    	$data_log = array(
            'v_nik' => $this->session->userdata('nik_payroll'),
            'v_desc'=>$desc
        );
        $this->MasterPotongan_model->insert_log($data_log);
    }

}