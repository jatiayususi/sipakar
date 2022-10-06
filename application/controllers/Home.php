<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
	
	function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_login_diklat')== FALSE){
            redirect('Administrator');
        }
    }

	function index(){
		redirect('MasterPotongan');
	}
}