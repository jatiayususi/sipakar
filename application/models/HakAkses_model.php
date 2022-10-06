<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class HakAkses_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}

	public function insert($data)
	{
		$this->db->insert('payroll.tb_hak_akses', $data);
	}

	function update($id, $data){
        $this->db->where('id', $id);
        $this->db->update('payroll.tb_hak_akses', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('payroll.tb_hak_akses');
    }

	public function get_list_all(){
		$query=$this->db->query("
            SELECT id, v_employee_name, v_nik, n_hak_akses
            FROM payroll.tb_hak_akses tha
            JOIN ms_employee on ms_employee.n_employee_id = tha.n_employee_id
            ORDER BY id DESC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

    public function get_list_karyawan(){
        $query=$this->db->query("
            SELECT n_employee_id, v_employee_name, v_nik
            FROM ms_employee
            WHERE d_employee_resign is null
            ORDER BY v_employee_name ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

	function get_hak_akses_by_id($id)
    {
        $this->db->select('id, n_employee_id, n_hak_akses');
        $this->db->where('id', $id);
        $query = $this->db->get('payroll.tb_hak_akses');
        
        if($query->num_rows()>0){
            return $query->row_array();
        }
    }

    function get_list_karyawan_search($keyword){
         $query = $this->db->query("SELECT 
            n_employee_id, v_employee_name, v_nik
        FROM
            ms_employee
        WHERE
            upper(v_nik) like upper('%$keyword%')
        OR
            upper(v_employee_name) like upper('%$keyword%')");

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    //--encrypt

    public function cek_kode($id){
        $query=$this->db->query("
            SELECT encryption_iv, encryption_key from payroll.encr where id = $id
        ");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function update_chiper($id, $data){
        $this->db->where('id', $id);
        $this->db->update('payroll.encr', $data);
    }

}