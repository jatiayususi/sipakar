<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class MasterPotongan_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}

    function insert_log($data_log){
        $this->db->insert('payroll.tb_log_payroll', $data_log);
    }

	public function insert($data)
	{
		$this->db->insert('payroll.ms_potongan', $data);
	}

	function update($n_potongan_id, $data){
        $this->db->where('n_potongan_id', $n_potongan_id);
        $this->db->update('payroll.ms_potongan', $data);
    }

	public function get_list_all(){
		$query=$this->db->query("
            SELECT n_potongan_id, v_nama_potongan
            FROM payroll.ms_potongan ORDER BY v_nama_potongan ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

	function get_potongan_by_id($n_potongan_id)
    {
        $this->db->select('n_potongan_id, v_nama_potongan');
        $this->db->where('n_potongan_id', $n_potongan_id);
        $query = $this->db->get('payroll.ms_potongan');
        
        if($query->num_rows()>0){
            return $query->row_array();
        }
    }

}