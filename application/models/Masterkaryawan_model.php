<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterkaryawan_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
    }
    function insert($data){
        $this->db->insert('ms_employee', $data);
        return $this->db->insert_id();
    }

    function insertdokumen($data){
        $this->db->insert('ms_edocument', $data);
        return $this->db->insert_id();
    }

    function get_list_all(){
        $query = $this->db->query("SELECT ms_employee.n_employee_id, ms_employee.v_nik, ms_employee.v_employee_name, ms_employee.v_employee_addr, ms_employee.v_employee_phone_number, ms_employee.d_employee_dob, ms_employee.d_date_of_appointment, ms_employee.d_blood_type, ms_staff.n_staff_id, ms_employee.v_employee_degree, ms_employee.n_employee_status, ms_employee.d_employee_resign, ms_unitrs.n_unitrsid, ms_position.n_position_id, v_postion_name, ms_employee.d_tglditerima, ms_employee.v_agama, ms_employee.v_gender, ms_employee.v_status_perkawinan, ms_employee.v_email, ms_employee.v_nik_ktp, ms_employee.v_npwp, ms_employee.v_no_kpj, ms_employee.v_no_jkn, ms_employee.v_jenis_jkn, ms_province.n_province_id, v_province_name, ms_regency.n_regency_id, v_regency_name, ms_sub_district.n_subdistrict_id, v_sub_district_name, ms_village.n_village_id, v_village_name,ms_employee.rfididentity, ms_golongan_employee.id_golongan, ms_bank.n_bank_id, ms_employee.v_no_rekening_gaji, tb_medical_record.n_mr_id, v_mr_code, v_bank_name, nama_golongan,v_staff_name, ms_employee.n_employee_status, n_alasan_id
            from ms_employee
            join ms_staff on ms_staff.n_staff_id = ms_employee.n_staff_id
            join tb_medical_record on tb_medical_record.n_mr_id = ms_employee.n_mr_id
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            join ms_suratijinpraktek on ms_suratijinpraktek.n_employee_id = ms_employee.n_employee_id
            where d_employee_resign is null");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }

    function cariRefNota($v_kunci){
        $query = $this->db->query("SELECT n_urut FROM ref_nota WHERE v_kunci='$v_kunci'");
        return $query->row_array();
    }

    function insertRefNota($data1){
        $this->db->insert('ref_nota', $data1);
    }

    function updateRefNota($noRefNota, $v_kunci){
        $this->db->query("UPDATE ref_nota SET n_urut = $noRefNota WHERE v_kunci = '$v_kunci'");
    }

     function get_list_all_unitrs(){
        $query = $this->db->query("SELECT distinct mu.n_unitrsid,v_unitrskode,v_unitrsnama from ms_unitrs as mu
            join ms_employee on ms_employee.n_unitrsid=mu.n_unitrsid
            where ms_employee.d_employee_resign is null order by v_unitrsnama");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

     //daftar karyawan by unitrs id
    function get_karyawan_by_idunit($n_unitrsid){
        $query = $this->db->query("SELECT ms_employee.n_employee_id, ms_employee.v_nik, ms_employee.v_employee_name,golongan.nama_golongan
            d_employee_resign,d_tglditerima 
            from ms_employee
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_golongan_employee golongan on golongan.id_golongan=ms_employee.id_golongan
            where ms_unitrs.n_unitrsid = '$n_unitrsid' and d_employee_resign is null 
            order by ms_employee.v_nik");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_detail_karyawan($n_employee_id){
        $query = $this->db->query("SELECT * from ms_employee 
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            join ms_sekolah on ms_sekolah.n_sekolah_id = ms_employee.n_sekolah_id
            join ms_jurusan on ms_jurusan.n_jurusan_id = ms_employee.n_jurusan_id
            where n_employee_id = $n_employee_id");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }

    function get_detail_karyawan2($n_employee_id){
        $query = $this->db->query("SELECT * from ms_employee 
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            where n_employee_id = $n_employee_id");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }

    function get_detail_karyawan_user($n_employee_id,$n_staff_id){
        $query = $this->db->query("SELECT * from ms_employee 
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            join ms_sekolah on ms_sekolah.n_sekolah_id = ms_employee.n_sekolah_id
            join ms_jurusan on ms_jurusan.n_jurusan_id = ms_employee.n_jurusan_id
            where n_employee_id = '$n_employee_id' and n_staff_id='$n_staff_id'");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }

    function get_detail_karyawan_user2($n_employee_id,$n_staff_id){
        $query = $this->db->query("SELECT * from ms_employee 
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            where n_employee_id = '$n_employee_id' and n_staff_id='$n_staff_id'");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }

    function get_list_all_kodearea(){
        $query = $this->db->query("SELECT id_kodearea,kodearea, provinsi, kabkota 
            FROM ms_kodearea order by kabkota");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_list_all_dokumen(){
        $query = $this->db->query("SELECT n_jenis_document, v_nama_jenis_document
            FROM ms_jenis_document");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_list_emp(){
        $this->db->select('*');
                $query = $this->db->get('ms_employee');
        if($query->num_rows()>0){
            return $query->result_array();
        }
    }

    function get_detail_diklat($n_employee_id){
        $query = $this->db->query("SELECT tb_pesertadiklat.pstdiklatid, tb_pesertadiklat.jadwaldiklatid, ms_jadwaldiklat.diklatid, ms_diklat.diklatnama,
            tb_pesertadiklat.n_employee_id, ms_jadwaldiklat.jadwalsampai, ms_jadwaldiklat.jadwaldari from tb_pesertadiklat
            join ms_jadwaldiklat on ms_jadwaldiklat.jadwaldiklatid = tb_pesertadiklat.jadwaldiklatid
            join ms_employee on ms_employee.n_employee_id = tb_pesertadiklat.n_employee_id
            inner join ms_diklat on ms_diklat.diklatid = ms_jadwaldiklat.diklatid
            where tb_pesertadiklat.n_employee_id = '$n_employee_id'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }  
    }

    function get_detail_edocument($n_employee_id){
        $query = $this->db->query("SELECT n_edocument_id, n_employee_id, nama_file_edocument, nama_lokasi_file_edocument, ms_jenis_document.n_jenis_document, ms_jenis_document.v_nama_jenis_document, status
            from ms_edocument 
            join ms_jenis_document on ms_jenis_document.n_jenis_document = ms_edocument.n_jenis_document
            where n_employee_id = '$n_employee_id'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }  
    }

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
        $query = $this->db->query("SELECT v_nik,id_golongan,substring('$bulanTahun',1,2)::int-DATE_PART('month',d_date_of_appointment)as cekBulan,
substring('$bulanTahun',4)::int-DATE_PART('year',d_date_of_appointment) as y,DATE_PART('month',d_date_of_appointment)as m
from ms_employee WHERE d_date_of_appointment is not NULL and n_employee_id=971");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }


    function get_karyawan($n_employee_id){
        $query = $this->db->query("SELECT * from ms_employee 
        join ms_village on ms_village.n_village_id = ms_employee.n_village_id
        join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
        join ms_position on ms_position.n_position_id = ms_employee.n_position_id
        join ms_province on ms_province.n_province_id = ms_employee.n_province_id
        join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
        join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
        join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
        join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id/*n_employee_id, v_nik, v_employee_name, v_employee_addr, v_employee_phone_number, d_employee_dob, d_date_of_appointment, d_blood_type, n_employee_id, ms_staff.n_staff_id, tb_medical_record.n_mr_id, v_employee_degree, n_employee_status, d_employee_resign, ms_unitrs.n_unitrsid, ms_position.n_position_id, d_tglditerima, v_agama, v_gender, v_status_perkawinan, v_email, v_nik_ktp, v_npwp, v_no_kpj, v_no_jkn, v_jenis_jkn, ms_province.n_province_id, v_province_name, ms_regency.n_regency_id, v_regency_name, ms_sub_district.n_subdistrict_id, v_sub_district_name, ms_village.n_village_id, v_village_name,rfididentity, ms_golongan_employee.id_golongan, ms_bank.n_bank_id, v_no_rekening_gaji, v_mr_code, v_bank_name, nama_golongan, v_staff_name, n_employee_status, n_alasan_id, d_employee_resign
        from ms_employee
        join ms_staff on ms_staff.n_staff_id = ms_employee.n_staff_id
        join tb_medical_record on tb_medical_record.n_mr_id = ms_employee.n_mr_id
        join ms_village on ms_village.n_village_id = ms_employee.n_village_id
        join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
        join ms_position on ms_position.n_position_id = ms_employee.n_position_id
        join ms_province on ms_province.n_province_id = ms_employee.n_province_id
        join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
        join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
        join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
        join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id*/
        
        where ms_employee.n_employee_id = '$n_employee_id'");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function get_karyawan_alasan($n_employee_id){
        $query = $this->db->query("SELECT n_employee_id, v_nik, v_employee_name, v_employee_addr, v_employee_phone_number, d_employee_dob, d_date_of_appointment, d_blood_type, n_employee_id, ms_staff.n_staff_id, tb_medical_record.n_mr_id, v_employee_degree, n_employee_status, d_employee_resign, ms_unitrs.n_unitrsid, ms_position.n_position_id, d_tglditerima, v_agama, v_gender, v_status_perkawinan, v_email, v_nik_ktp, v_npwp, v_no_kpj, v_no_jkn, v_jenis_jkn, ms_province.n_province_id, v_province_name, ms_regency.n_regency_id, v_regency_name, ms_sub_district.n_subdistrict_id, v_sub_district_name, ms_village.n_village_id, v_village_name,rfididentity, ms_golongan_employee.id_golongan, ms_bank.n_bank_id, v_no_rekening_gaji, v_mr_code, v_bank_name, nama_golongan, v_staff_name, n_employee_status, n_alasan_id, d_employee_resign
        from ms_employee
        join ms_staff on ms_staff.n_staff_id = ms_employee.n_staff_id
        join tb_medical_record on tb_medical_record.n_mr_id = ms_employee.n_mr_id
        join ms_village on ms_village.n_village_id = ms_employee.n_village_id
        join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
        join ms_position on ms_position.n_position_id = ms_employee.n_position_id
        join ms_province on ms_province.n_province_id = ms_employee.n_province_id
        join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
        join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
        join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
        join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
        join ms_alasan_keluar on ms_alasan_keluar.alasankeluarid = ms_employee.n_alasan_id
        where ms_employee.n_employee_id = '$n_employee_id'");
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function update($n_employee_id, $data){
        $this->db->where('n_employee_id', $n_employee_id);
        $this->db->update('ms_employee', $data);
    }

    /*function insert($n_edocument_id, $data){
        $this->db->where('n_edocument_id', $n_edocument_id);
        $this->db->update('ms_edocument', $data);
    }*/



/*======= FOR USER =========*/
    function get_list_emp_user($n_staff_id){
        $this->db->select('*');
        $query = $this->db->get('ms_employee');
        if($query->num_rows()>0){
            return $query->result_array();
        }
    }

    /*function get_detail_karyawan_user($n_staff_id,$n_employee_id){

        $query = $this->db->query("SELECT distinct v_nik, v_employee_name, v_employee_addr, v_employee_phone_number, d_employee_dob, d_date_of_appointment, d_blood_type,
            n_employee_id, n_staff_id, n_mr_id, ms_employee.v_who_create, ms_employee.d_whn_create, v_employee_degree, n_employee_status, d_employee_resign, 
            ms_position.n_position_id, d_tglditerima, v_agama,v_gender, v_status_perkawinan, v_email, v_nik_ktp, v_npwp, v_no_kpj,
            v_no_jkn, v_jenis_jkn, ms_province.n_province_id, ms_province.v_province_name, ms_village.n_village_id, ms_village.v_village_name, ms_regency.n_regency_id, ms_regency.v_regency_name, ms_sub_district.v_sub_district_name, ms_sub_district.n_subdistrict_id, rfididentity, 
            ms_golongan_employee.id_golongan, ms_bank.n_bank_id, v_no_rekening_gaji,
            n_alasan_id, v_alamat_tinggal,v_telp_rumah, kodearea, ms_jurusan.n_jurusan_id, ms_jurusan.v_nama_jurusan, ms_employee.n_sekolah_id, ms_sekolah.v_nama_sekolah, n_th_masuk_sekolah, n_th_lulus_sekolah,
            ms_unitrs.n_unitrsid
            from ms_employee 
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_sekolah on ms_sekolah.n_sekolah_id = ms_employee.n_sekolah_id
            join ms_jurusan on ms_jurusan.n_jurusan_id = ms_jurusan.n_jurusan_id
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id 
            and ms_employee.n_staff_id='$n_staff_id' and ms_employee.n_employee_id='$n_employee_id'");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }

    function get_detail_karyawan_user_tanpadatasekolah($n_staff_id,$n_employee_id){

        $query = $this->db->query("SELECT * from ms_employee 
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            join ms_sekolah on ms_sekolah.n_sekolah_id = ms_employee.n_sekolah_id
            join ms_jurusan on ms_jurusan.n_jurusan_id = ms_employee.n_jurusan_id
            where ms_employee.n_staff_id='$n_staff_id' and ms_employee.n_employee_id='$n_employee_id'");

        $query = $this->db->query("SELECT distinct v_nik, v_employee_name, v_employee_addr, v_employee_phone_number, d_employee_dob, d_date_of_appointment, d_blood_type,
            n_employee_id, n_staff_id, n_mr_id, ms_employee.v_who_create, ms_employee.d_whn_create, v_employee_degree, n_employee_status, d_employee_resign, 
            ms_position.n_position_id, d_tglditerima, v_agama,v_gender, v_status_perkawinan, v_email, v_nik_ktp, v_npwp, v_no_kpj,
            v_no_jkn, v_jenis_jkn, ms_province.n_province_id, ms_province.v_province_name, ms_village.n_village_id, ms_village.v_village_name, ms_regency.n_regency_id, ms_regency.v_regency_name, ms_sub_district.v_sub_district_name, ms_sub_district.n_subdistrict_id, rfididentity, 
            ms_golongan_employee.id_golongan, ms_bank.n_bank_id, v_no_rekening_gaji,
            n_alasan_id, v_alamat_tinggal,v_telp_rumah, kodearea, n_th_masuk_sekolah, n_th_lulus_sekolah,
            ms_unitrs.n_unitrsid
            from ms_employee 
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_sekolah on ms_sekolah.n_sekolah_id = ms_employee.n_sekolah_id
            join ms_jurusan on ms_jurusan.n_jurusan_id = ms_jurusan.n_jurusan_id
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id 
            and ms_employee.n_staff_id='$n_staff_id' and ms_employee.n_employee_id='$n_employee_id'");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }*/

    function get_list_all_user($n_staff_id){
    
        $query = $this->db->query("SELECT ms_employee.n_employee_id, ms_employee.v_nik, ms_employee.v_employee_name, ms_employee.v_employee_addr, ms_employee.v_employee_phone_number, ms_employee.d_employee_dob, ms_employee.d_date_of_appointment, ms_employee.d_blood_type, ms_staff.n_staff_id, ms_employee.v_employee_degree, ms_employee.n_employee_status, ms_employee.d_employee_resign, ms_unitrs.n_unitrsid, ms_position.n_position_id, v_postion_name, ms_employee.d_tglditerima, ms_employee.v_agama, ms_employee.v_gender, ms_employee.v_status_perkawinan, ms_employee.v_email, ms_employee.v_nik_ktp, ms_employee.v_npwp, ms_employee.v_no_kpj, ms_employee.v_no_jkn, ms_employee.v_jenis_jkn, ms_province.n_province_id, v_province_name, ms_regency.n_regency_id, v_regency_name, ms_sub_district.n_subdistrict_id, v_sub_district_name, ms_village.n_village_id, v_village_name,ms_employee.rfididentity, ms_golongan_employee.id_golongan, ms_bank.n_bank_id, ms_employee.v_no_rekening_gaji, tb_medical_record.n_mr_id, v_mr_code, v_bank_name, nama_golongan,v_staff_name, ms_employee.n_employee_status, n_alasan_id
            from ms_employee
            join ms_staff on ms_staff.n_staff_id = ms_employee.n_staff_id
            join tb_medical_record on tb_medical_record.n_mr_id = ms_employee.n_mr_id
            join ms_village on ms_village.n_village_id = ms_employee.n_village_id
            join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid
            join ms_position on ms_position.n_position_id = ms_employee.n_position_id
            join ms_province on ms_province.n_province_id = ms_employee.n_province_id
            join ms_regency on ms_regency.n_regency_id = ms_employee.n_regency_id
            join ms_sub_district on ms_sub_district.n_subdistrict_id = ms_employee.n_subdistrict_id
            join ms_golongan_employee on ms_golongan_employee.id_golongan = ms_employee.id_golongan
            join ms_bank on ms_bank.n_bank_id = ms_employee.n_bank_id
            join ms_suratijinpraktek on ms_suratijinpraktek.n_employee_id = ms_employee.n_employee_id where ms_employee.n_staff_id='$n_staff_id'");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
      
    }
}