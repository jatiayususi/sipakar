<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function validasi(){
        $nik = $this->input->post('username');
        $password = $this->input->post('password');
        $keyword = $this->input->post('keyword');
        $myVar=0;
        $login_data = $this->UserModel->validasi_user($nik, $password);
        $login_key = $this->UserModel->validasi_key($keyword);
        
        if($login_data['status'] == 200){
            if($login_key['status'] == 200){
                $session_data_payroll = array(
                    'nik_payroll' => $login_data['response']['v_nik'],
                    'nama_payroll' => $login_data['response']['v_employee_name'],
                    'id_unit_payroll'=> $login_data['response']['n_unitrsid'],
                    'nama_unit_payroll'=> $login_data['response']['v_unitrsnama'],
                    'gender'=> $login_data['response']['v_gender'],
                    //'is_admin'=> $this->UserModel->is_admin($login_data['response']['v_nik']),
                    'is_golbawahxiii'=> $this->UserModel->is_golbawahxiii($login_data['response']['v_nik']),
                    'is_golatasxiii'=> $this->UserModel->is_golatasxiii($login_data['response']['v_nik']),
                    'is_login_payroll'=> TRUE
                );
                $this->session->set_userdata($session_data_payroll);

                    //insert log
                    $data = array(
                        'v_nik' => $login_data['response']['v_nik'],
                        'v_desc'=>'Berhasil Login SIPAKAR'
                    );
                    $this->UserModel->insert_log($data);
                
                //$previlege = $this->UserModel->cek_previlege($login_data['response']['v_nik']);
                if($this->UserModel->is_golbawahxiii($login_data['response']['v_nik']) OR $this->UserModel->is_golatasxiii($login_data['response']['v_nik'])){
                    //redirect($previlege['url']);
                    if($this->UserModel->is_golbawahxiii($login_data['response']['v_nik'])){
                        redirect('DataGajiKaryawan/daftarBawahXIII');
                    } else if($this->UserModel->is_golatasxiii($login_data['response']['v_nik'])){
                        redirect('DataGajiKaryawan/daftarAtasXIII');
                    }
                    /*else if($this->UserModel->is_admin($login_data['response']['v_nik'])){
                        redirect('MasterPotongan');
                    }*/

                }else{
                    $this->session->set_flashdata('message', 'Login Gagal, Username tidak berhak mengakases SI PANJI.');

                    $data = array(
                        'v_nik' => $login_data['response']['v_nik'],
                        'v_desc'=>'Gagal Login SIPAKAR'
                    );
                    $this->UserModel->insert_log($data);

                    redirect('Administrator');
                }

            } else {

                $this->session->set_flashdata('message', 'Login Gagal, Username Password Salah !');

                $data = array(
                    'v_nik' => $login_data['response']['v_nik'],
                    'v_desc'=>'Gagal Login SIPAKAR'
                );
                $this->UserModel->insert_log($data);

                redirect('Administrator');
            }
            
        }else{

            $this->session->set_flashdata('message', 'Login Gagal, Username Password Salah !');

            $data = array(
                'v_nik' => $login_data['response']['v_nik'],
                'v_desc'=>'Gagal Login SIPAKAR'
            );
            $this->UserModel->insert_log($data);

            redirect('Administrator');
        }
    }

    public function logout(){
        $session_data_payroll = array(
            'nik_payroll' => 0,
            'nama_payroll' => 0,
            'id_unit_payroll'=> 0,
            'nama_unit_payroll'=> 0,
            'gender'=> 0,
            //'is_admin'=> 0,
            'is_golbawahxiii'=> 0,
            'is_golatasxiii'=> 0,
            'is_login_payroll'=> FALSE
        );

        $this->session->sess_destroy();
        $this->session->unset_userdata($session_data_payroll);

        redirect('Administrator');
    }

    public function error(){
        $data['content'] = '404';
        $this->load->view('template',$data);
    }

}
