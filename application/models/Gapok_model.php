<?php
declare(strict_types=1);
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Gapok_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}

    public function insert($data)
    {
        $this->db->insert('payroll.ms_gapok_header',$data);
        return $this->db->insert_id();
    }

    public function insertDetail($data)
    {
        $this->db->insert('payroll.ms_gapok',$data);
        
    }

    function delete_isi_file($n_header_id) {
        $this->db->where('n_gapok_header_id', $n_header_id);
        $this->db->delete('payroll.ms_gapok');
    }

    function delete($n_header_id) {
        $this->db->where('n_gapok_header_id', $n_header_id);
        $this->db->delete('payroll.ms_gapok_header');
    }

    public function get_list_all(){
        $query=$this->db->query("
            SELECT mgh.th_berlaku,creator.v_employee_name as dibuat_oleh, case 
            when editor.v_employee_name is null then '-'
            else editor.v_employee_name
            end as last_editor, v_keterangan,mgh.n_gapok_header_id from payroll.ms_gapok_header as mgh
                join ms_employee as creator on creator.v_nik=mgh.v_who_create
                left join ms_employee as editor on editor.v_nik=mgh.v_last_update order by mgh.d_whn_create DESC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_detail($header_id){
        $query=$this->db->query("
            SELECT mg.n_gapok_id,gh.th_berlaku,golongan.nama_golongan,golongan.kode_golongan,mg.n_bulan_gapok,v_gapok
            from payroll.ms_gapok as mg
            join ms_golongan_employee golongan on golongan.id_golongan=mg.n_golongan_id
            join payroll.ms_gapok_header gh on gh.n_gapok_header_id=mg.n_gapok_header_id 
            where mg.n_gapok_header_id=$header_id order by nama_golongan asc
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_cek_nik($nik){
        $query = $this->db->query("
            SELECT v_nik from ms_employee where v_nik = '$nik'
        ");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_list_master_potongan(){
        $query=$this->db->query("
            SELECT n_potongan_id, v_nama_potongan
            FROM payroll.ms_potongan ORDER BY v_nama_potongan ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
     public function getDataGolonganByKode($kode){
        $query=$this->db->query("
            SELECT id_golongan,nama_golongan,kode_golongan,keterangan 
            from ms_golongan_employee as mge 
            where mge.kode_golongan='$kode'
        ");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
  

}