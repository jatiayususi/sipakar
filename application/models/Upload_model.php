<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Upload_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}

    public function insert_upload($data)
    {
        $this->db->insert('payroll.ms_upload_file', $data);
    }

    function update_isi_file($n_isi_file_id, $data){
        $this->db->where('n_isi_file_id', $n_isi_file_id);
        $this->db->update('payroll.tb_isi_file', $data);
    }

    function update_tb_gaji($n_gaji_id, $data_gaji){
        $this->db->where('n_gaji_id', $n_gaji_id);
        $this->db->update('payroll.tb_gaji', $data_gaji);
    }

    function delete_isi_file($n_upload_file_id) {
        $this->db->where('n_upload_file_id', $n_upload_file_id);
        $this->db->delete('payroll.tb_isi_file');
    }

    function delete($n_upload_file_id) {
        $this->db->where('n_upload_file_id', $n_upload_file_id);
        $this->db->delete('payroll.ms_upload_file');
    }

    public function get_list_all(){
        $query=$this->db->query("
            SELECT n_upload_file_id, v_nama_file, v_nama_potongan, n_bulan, n_tahun
            FROM payroll.ms_upload_file muf
            JOIN payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id ORDER BY n_upload_file_id DESC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_list_all_by_grup_golongan($v_grup_golongan){
        $query=$this->db->query("
            SELECT n_upload_file_id, v_nama_file, v_nama_potongan, n_bulan, n_tahun, muf.n_potongan_id, jenis
            FROM payroll.ms_upload_file muf
            LEFT JOIN payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
            WHERE v_grup_golongan IN ($v_grup_golongan)
            ORDER BY n_upload_file_id DESC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_list_all_tunjangan(){
        $query=$this->db->query("
            SELECT n_upload_file_id, v_nama_file, v_nama_potongan, n_bulan, n_tahun
            FROM payroll.ms_upload_file muf
            JOIN payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id 
            where group_penambah is not null
            ORDER BY n_upload_file_id DESC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_detail($n_upload_file_id){
        $query=$this->db->query("
            SELECT v_unitrsnama, tif.v_nik, v_employee_name, n_isi_file_id, v_nominal, jumlah_terima
            from payroll.tb_isi_file tif
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            join ms_employee emp on emp.v_nik = tif.v_nik
            left join ms_unitrs unit on unit.n_unitrsid = emp.n_unitrsid
            where tif.n_upload_file_id = $n_upload_file_id order by v_nik asc
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_encr(){
        $query = $this->db->query("SELECT encryption_iv,encryption_key from payroll.encr");
       if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_cek_nik($nik, $group){
        $query = $this->db->query("
            SELECT v_nik from ms_employee me
            join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            where v_nik = '$nik' and n_group = $group
        ");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*public function get_cek_group($nik, $group){
        $query = $this->db->query("
            SELECT n_group from ms_golongan_employee mge
            join ms_employee me on me.id_golongan = mge.id_golongan
            where v_nik = '$nik' and n_group = $group
        ");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }*/

    public function get_list_master_potongan(){
        $query=$this->db->query("
            SELECT n_potongan_id, v_nama_potongan
            FROM payroll.ms_potongan ORDER BY v_nama_potongan ASC
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getPotonganKaryawan($employee_id,$tahun,$bulan){
        $query=$this->db->query("
            SELECT v_nominal,group_pengurangan from payroll.tb_isi_file tif
            join payroll.ms_upload_file ms_file on ms_file.n_upload_file_id=tif.n_upload_file_id
            join payroll.ms_potongan potongan on potongan.n_potongan_id=ms_file.n_potongan_id
            join ms_employee on ms_employee.v_nik=tif.v_nik
            where ms_employee.n_employee_id='$employee_id' and n_tahun='$tahun' and n_bulan='$bulan' and potongan.group_pengurangan<>'-'
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getTambahanKaryawan($employee_id,$tahun,$bulan){
        $query=$this->db->query("
            SELECT v_nominal,group_penambah from payroll.tb_isi_file tif
            join payroll.ms_upload_file ms_file on ms_file.n_upload_file_id=tif.n_upload_file_id
            join payroll.ms_potongan potongan on potongan.n_potongan_id=ms_file.n_potongan_id
            join ms_employee on ms_employee.v_nik=tif.v_nik
            where ms_employee.n_employee_id='$employee_id' and n_tahun='$tahun' and n_bulan='$bulan' and potongan.group_penambah<>'-'
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_isi_file_by_id($n_isi_file_id){
        $query=$this->db->query("
            SELECT tif.n_upload_file_id, tif.v_nik, v_nominal, n_tahun, n_bulan, v_employee_name, gapok, tunjangan_khusus, tunjangan_struktural, penyesuaian, tas, maxgross, dinas_malam, lembur, rapel, insentif, gross, potongan_jht, jaminan_pensiun, bpjs_kesehatan, sta, pajak, thp_bulat, potongan_kopkar, nominal_rek, nominal_lain, nominal_prr_btn, nominal_btnsolo, nominal_koperasi, ket_rek_rs, ket_lain, ket_prr_btn, ket_btn_solo, ket_koperasi, jumlah_terima, titik_perubahan, nominal_ekstra, ket_ekstra, jenis_ekstra, jenis, honor, thr, status, potongan_rs, pot_btn, tunai, pot_koperasi, pot_jkn_kelg, jml_potongan
            from payroll.tb_isi_file tif
            join ms_employee me on me.v_nik = tif.v_nik 
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            where n_isi_file_id = $n_isi_file_id
        ");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_gaji_generate($nik, $bulan, $tahun, $jenis){
        $query = $this->db->query("SELECT nik, bulan, tahun, jenis
        from payroll.tb_gaji tg
        where nik = '$nik' and bulan = $bulan and tahun = $tahun and jenis = $jenis");
       if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_gaji_generateXIIIAtas($nik, $bulan, $tahun){
        $query = $this->db->query("SELECT nik, bulan, tahun, jenis
        from payroll.tb_gaji tg where nik = '$nik' and bulan = $bulan and tahun = $tahun");
       if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_gaji_generateXIIBawah($nik, $bulan, $tahun){
        $query = $this->db->query("SELECT nik, bulan, tahun, jenis
        from payroll.tb_gaji tg where nik = '$nik' and bulan = $bulan and tahun = $tahun");
       if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_potongan_gaji($nik, $bulan, $tahun){
        $query = $this->db->query("SELECT nik, bulan, tahun
        from payroll.tb_gaji tg
        where nik = '$nik' and bulan = $bulan and tahun = $tahun");
       if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_potongan_gaji_by_id($nik, $bulan, $tahun){
        $query = $this->db->query("SELECT n_gaji_id, potongan, thp_bulat, transfer_bank
        from payroll.tb_gaji tg
        where nik = '$nik' and bulan = $bulan and tahun = $tahun");
       if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_upload($n_upload_file_id){
        $query = $this->db->query("SELECT n_potongan_id, n_bulan, n_tahun, v_grup_golongan
            from payroll.ms_upload_file muf
            where n_upload_file_id = $n_upload_file_id");
       if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

     /*public function cek_upload_to_generate($bulan, $tahun, $jenis_potongan, $v_grup_golongan, $hasil_nik){

        if($jenis_potongan == 7){
            $jenis = 'thp_bulat';
        }else if($jenis_potongan == 8){
            $jenis = 'potongan';
        }else if($jenis_potongan == 9){
            $jenis = 'transfer_bank';
        }

        $query=$this->db->query("
            SELECT $jenis, bulan, tahun, nik, n_group
            from payroll.tb_gaji tg
            join ms_employee me on me.v_nik = tg.nik
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            where bulan = $bulan and tahun = $tahun and $jenis is not null and $jenis <> '' and n_group = $v_grup_golongan
            and nik in ($hasil_nik)
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }*/

    public function cek_upload_to_generate($bulan, $tahun, $v_grup_golongan, $hasil_nik){

        $query=$this->db->query("
            SELECT bulan, tahun, nik, n_group
            from payroll.tb_gaji tg
            join ms_employee me on me.v_nik = tg.nik
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            where bulan = $bulan and tahun = $tahun and n_group = $v_grup_golongan
            and nik in ($hasil_nik)
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

}