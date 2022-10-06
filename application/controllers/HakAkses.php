<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class HakAkses extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('HakAkses_model'));
	}

	public function index()
	{
		$data['list_karyawan'] = $this->HakAkses_model->get_list_karyawan();
		$data['content'] = 'HakAkses_view';
		$this->load->view('template', $data);
	}

    public function cari_karyawan(){
        $keyword = $this->input->get('keyword');
        $data = $this->HakAkses_model->get_list_karyawan_search($keyword);
        echo json_encode($data);
    }

	public function getListHakAkses()
	{
		$list_hak_akses = $this->HakAkses_model->get_list_all();

		$data = array(
            'list' => $list_hak_akses            
        );
        echo json_encode($data);
	}

	public function insert()
	{
		$n_employee_id  = $this->input->post('n_employee_id');
		$n_hak_akses	= $this->input->post('n_hak_akses');

		$data = array(
			'n_employee_id'=> $n_employee_id,
			'n_hak_akses'=>$n_hak_akses,
			'v_who_create'=>$this->session->userdata('nik_payroll')
		);

		$sukses= $this->HakAkses_model->insert($data);
        echo json_encode(array("code" => 200, "response" => $sukses));

	}

	public function cari_hak_akses_by_id(){
        $id  		= $this->input->post('id');
        $data_edit  = $this->HakAkses_model->get_hak_akses_by_id($id);

        $response = array(
            'n_employee_id'=>$data_edit['n_employee_id'],
            'n_hak_akses'=>$data_edit['n_hak_akses']
        );

        echo json_encode(array("code" => 200, "response" => $response));
    }

    public function Update(){

        $id 	 		 = $this->input->post('id');
        $n_employee_id 	 = $this->input->post('n_employee_id');
        $n_hak_akses 	 = $this->input->post('n_hak_akses');

        $data = array(
            'n_employee_id'=>$n_employee_id,
            'n_hak_akses'=>$n_hak_akses
        );
        $this->HakAkses_model->update($id, $data);
    }

    public function Delete(){
        $id = $this->input->post('id');
        $this->HakAkses_model->delete($id);
    }

    public function cari_encrypt_by_id(){
        $id  		= $this->input->post('id');
        $data_edit  = $this->HakAkses_model->cek_kode($id);

        $response = array(
            'encryption_iv'=>$data_edit['encryption_iv'],
            'encryption_key'=>$data_edit['encryption_key']
        );

        echo json_encode(array("code" => 200, "response" => $response));
    }

    public function UpdateChiper(){

        $id              = $this->input->post('id');
        $kode_lama_iv    = base64_encode($this->input->post('kode_lama_iv'));
        $kode_lama_key   = base64_encode($this->input->post('kode_lama_key'));
        $kode_baru_iv    = base64_encode($this->input->post('kode_baru_iv'));
        $kode_baru_key   = base64_encode($this->input->post('kode_baru_key'));

        $cek_kode = $this->HakAkses_model->cek_kode($id);
        $kode_iv  = $cek_kode['encryption_iv'];
        $kode_key = $cek_kode['encryption_key'];

        if($kode_lama_iv == $kode_iv && $kode_lama_key == $kode_key){
            $data = array(
                'encryption_iv'=>$kode_baru_iv,
                'encryption_key'=>$kode_baru_key,
                'v_who_last_update'=>$this->session->userdata('nik_payroll'),
                'd_whn_last_update'=>date('Y-m-d H:i:s')
            );
            $this->HakAkses_model->update_chiper($id, $data);
            print_r("BENAR");
        }else{
            print_r("SALAH");
        }
        
    }

    /*public function UpdateChiper(){

        $id 	 		 = $this->input->post('id');
        $kode_lama_iv 	 = md5($this->input->post('kode_lama_iv'));
        $kode_lama_key 	 = md5($this->input->post('kode_lama_key'));
        $kode_baru_iv 	 = md5($this->input->post('kode_baru_iv'));
        $kode_baru_key 	 = md5($this->input->post('kode_baru_key'));

        $kosong = "d41d8cd98f00b204e9800998ecf8427e";

        $cek_kode = $this->HakAkses_model->cek_kode($id);
        $kode_iv  = $cek_kode['encryption_iv'];
        $kode_key = $cek_kode['encryption_key'];

        if($kode_lama_iv != $kosong && $kode_lama_key != $kosong){
        	if($kode_lama_iv == $kode_iv && $kode_lama_key == $kode_key){
	        	$data = array(
		            'encryption_iv'=>$kode_baru_iv,
		            'encryption_key'=>$kode_baru_key,
		            'v_who_last_update'=>$this->session->userdata('nik_payroll'),
		            'd_whn_last_update'=>date('Y-m-d H:i:s')
	        	);
        		$this->HakAkses_model->update_chiper($id, $data);
        		print_r("BENAR");
	        }else{
	        	print_r("SALAH");
	        }
        }else{
        	print_r("GAGAL");
        }
        
    }*/

}