<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Karyawan_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}

    function get_list_all_unitrs(){
        $query=$this->db->query("
            SELECT n_unitrsid, v_unitrsnama
            FROM ms_unitrs
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_unit_by_id($n_unitrsid){
        $query=$this->db->query("
            SELECT n_unitrsid, v_unitrsnama
            FROM ms_unitrs
            WHERE n_unitrsid = $n_unitrsid
        ");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function get_karyawan_by_unit($n_unitrsid){
        $query=$this->db->query("
            SELECT n_employee_id, v_nik, v_employee_name
            FROM ms_employee
            WHERE n_unitrsid = $n_unitrsid and d_employee_resign is null
            ORDER BY v_employee_name ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    // function get_karyawan_by_id($n_employee_id)
    // {
    //     $query = $this->db->query("
    //         SELECT n_employee_id, v_employee_name, v_nik, nama_golongan
    //         FROM ms_employee
    //         LEFT JOIN ms_golongan_employee ON ms_golongan_employee.id_golongan = ms_employee.id_golongan
    //         WHERE n_employee_id = $n_employee_id
    //     ");
    //     if($query->num_rows()>0){
    //         return $query->row_array();
    //     }
    // }

    function get_karyawan_by_id($n_employee_id){
        $query = $this->db->query("SELECT n_employee_id, v_nik, v_employee_name, v_employee_addr, v_employee_phone_number, d_employee_dob, d_date_of_appointment, ms_employee.d_blood_type, n_employee_id, tb_medical_record.n_mr_id, v_employee_degree, n_employee_status, d_employee_resign, ms_unitrs.n_unitrsid, ms_position.n_position_id, d_tglditerima, v_agama, v_gender, v_status_perkawinan, v_email, v_nik_ktp, v_npwp, v_no_kpj, v_no_jkn, v_jenis_jkn, ms_province.n_province_id, v_province_name, ms_regency.n_regency_id, v_regency_name, ms_sub_district.n_subdistrict_id, v_sub_district_name, ms_village.n_village_id, v_village_name,rfididentity, ms_golongan_employee.id_golongan, ms_bank.n_bank_id, v_no_rekening_gaji, v_mr_code, v_bank_name, nama_golongan, n_employee_status, n_alasan_id, d_employee_resign
            from ms_employee
            left join tb_medical_record on tb_medical_record.n_mr_id = ms_employee.n_mr_id
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            left join ms_alasan_keluar on ms_alasan_keluar.alasankeluarid = ms_employee.n_alasan_id
            left join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            where ms_employee.n_employee_id = '$n_employee_id'");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

function get_bulan_gaji_by_id($n_employee_id,$bulanTahun){
        $query = $this->db->query("SELECT v_nik,id_golongan,case
when substring('$bulanTahun',1,2)::int-DATE_PART('month',d_date_of_appointment) >=0 
    then substring('$bulanTahun',4)::int-DATE_PART('year',d_date_of_appointment)
when substring('$bulanTahun',1,2)::int-DATE_PART('month',d_date_of_appointment) <=0 and substring('$bulanTahun',4)::int-DATE_PART('year',d_date_of_appointment)=0
    then substring('$bulanTahun',4)::int-DATE_PART('year',d_date_of_appointment)
else substring('$bulanTahun',4)::int-DATE_PART('year',d_date_of_appointment)-1
end as th_gapok
from ms_employee WHERE d_date_of_appointment is not NULL and n_employee_id=$n_employee_id");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function getGapok($golongan,$tgGapok){
        $query = $this->db->query("select mg.v_gapok from payroll.ms_gapok mg
join payroll.ms_gapok_header mgh on mgh.n_gapok_header_id=mg.n_gapok_header_id
where n_golongan_id=$golongan and mg.n_bulan_gapok='$tgGapok' order by mgh.th_berlaku desc limit 1");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

}