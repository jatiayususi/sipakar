<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 2636 93
 */
class UserModel extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
    }

    function insert_log($data){
		$this->db->insert('payroll.tb_log_payroll', $data);
	}

    function validasi_user($nik, $password){
		$query=$this->db->query("SELECT v_nik, v_employee_name, ms_employee.n_unitrsid, v_unitrsnama, v_gender
			from ms_employee
			join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
			where v_nik='$nik' and password = md5('$password')");
		if($query->num_rows()>=1){
			$response = array(
				'status' => 200,
				'response' => $query->row_array()
			);
		} else {
			$response = array(
				'status' => 0,
				'response' => 'Login Gagal, NIK atau Password Salah !'
			);
		}
		return $response;
	}

	function validasi_key($keyword){
		$query=$this->db->query("SELECT encryption_iv, encryption_key
			from payroll.encr
			where CONVERT_FROM(DECODE(encryption_key, 'BASE64'), 'UTF-8') = '$keyword'");
		if($query->num_rows()>=1){
			$response = array(
				'status' => 200,
				'response' => $query->row_array()
			);
		} else {
			$response = array(
				'status' => 0,
				'response' => 'Login Gagal !'
			);
		}
		return $response;
	}

	/*function validasi_key($keyword){
		$query=$this->db->query("SELECT encryption_iv, encryption_key
			from payroll.encr
			where encryption_key = md5('$keyword')");
		if($query->num_rows()>=1){
			$response = array(
				'status' => 200,
				'response' => $query->row_array()
			);
		} else {
			$response = array(
				'status' => 0,
				'response' => 'Login Gagal !'
			);
		}
		return $response;
	}*/

	/*function is_admin($nik){
		$query=$this->db->query("SELECT v_nik
			from ms_employee me
			join payroll.tb_hak_akses tha on tha.n_employee_id = me.n_employee_id
			where v_nik='$nik' and n_hak_akses in (1,2)");
		if($query->num_rows()>=1){
			return true;
		}else{
			return false;
		}
	}*/

	function is_golbawahxiii($nik){
		$query=$this->db->query("SELECT v_nik
			from ms_employee me
			join payroll.tb_hak_akses tha on tha.n_employee_id = me.n_employee_id
			where v_nik='$nik' and n_hak_akses = 1");
		if($query->num_rows()>=1){
			return true;
		}else{
			return false;
		}
	}

	function is_golatasxiii($nik){
		$query=$this->db->query("SELECT v_nik
			from ms_employee me
			join payroll.tb_hak_akses tha on tha.n_employee_id = me.n_employee_id
			where v_nik='$nik' and n_hak_akses = 2");
		if($query->num_rows()>=1){
			return true;
		}else{
			return false;
		}
	}

	function tampil_log(){
		$query = $this->db->query("SELECT v_nik, v_desc, d_whn_create::date as tanggal, substring(d_whn_create::varchar, 12, 5) as jam from payroll.tb_log_payroll order by tanggal desc, jam desc");
	       if ($query->num_rows() > 0) {
	            return $query->result_array();
	        }
	}

	/*function cek_previlege($nik){
		$query_cek_group=$this->db->query("SELECT v_url, tb_hak_group.n_screen_id
			from ms_employee
			join ms_user_in_group on ms_user_in_group.n_employee_id = ms_employee.n_employee_id
			join ms_user_group on ms_user_group.n_user_group_id = ms_user_in_group.n_user_group_id 
			join tb_hak_group on tb_hak_group.n_user_group_id = ms_user_group.n_user_group_id
			join ms_screen_dashboard on ms_screen_dashboard.n_screen_id = tb_hak_group.n_screen_id
			where v_nik='$nik' and tb_hak_group.n_screen_id in (68)"); //ADMIN SI PANJI
		$query_cek_group_array = $query_cek_group->row_array();
		if($query_cek_group->num_rows()>=1){
			$user_prev = array(
				'status' => 200,
				'response' => 'User Punya Hak Akses',
				'url' => $query_cek_group_array['v_url']
			);
		}else{
			$query_cek_user = $this->db->query("SELECT v_url, tb_hak_akses.n_screen_id
				from ms_employee
				join tb_hak_akses on tb_hak_akses.n_employee_id = ms_employee.n_employee_id
				join ms_screen_dashboard on ms_screen_dashboard.n_screen_id = tb_hak_akses.n_screen_id
				where v_nik='$nik' and tb_hak_akses.n_screen_id in (68)"); //ADMIN SI PANJI
			$query_cek_user_array = $query_cek_group->row_array();
			if($query_cek_user->num_rows()>=1){
				$user_prev = array(
					'status' => 200,
					'response' => 'User Punya Hak Akses',
					'url' => $query_cek_user_array['v_url']
				);
			}else{
				$user_prev = array(
					'status' => 0,
					'response' => 'Login Gagal, NIK tidak berhak mengakases SI PANJI !'
				);
			}
		}
		return $user_prev;
	}*/
}