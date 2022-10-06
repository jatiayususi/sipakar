<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Karyawan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('Karyawan_model'));
	}

	public function index()
	{
		$data['list_unitrs']=$this->Karyawan_model->get_list_all_unitrs();
		$data['content'] = 'Karyawan_view';
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
        $detail_karyawan = $this->Karyawan_model->get_karyawan_by_id($n_employee_id);
        $data = array(
            'detail' => $detail_karyawan            
        );
       echo json_encode($data);
    }

}