<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Log extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('UserModel'));
	}

	public function index()
	{
		$data['start']      = 1;
        $data['list_log']   = $this->UserModel->tampil_log();
        $data['content']    = 'Log_view';

		$this->load->view('template', $data);
	}

}