<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class LapGajiperunit_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}  
	function insert($data){
        $this->db->insert('payroll.total_perunit',$data);
        return $this->db->insert_id();
    }

    function gettotalPerunitXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
    	$query = $this->db->query("SELECT ms_unitrs.v_unitrsnama, t_gapok, ms_unitrs.n_unitrsid, bulan, tahun, t_penyesuaian, t_gross, t_tas,
				t_maxgross, t_rapellain, t_dinasmalam, t_lembur, t_potjht, t_jaminanpensiun,
				t_potjkn, t_thpbulat, t_pph21, t_tunjkhusus, t_tunjstruktural,
				t_insentif, v_grup_golongan, t_gajibersih 
				from payroll.total_perunit 
				join ms_unitrs on ms_unitrs.n_unitrsid = payroll.total_perunit.n_unitrsid
				where bulan = '$bulan' and tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and jenis_gaji = $jenis_gaji
				order by ms_unitrs.v_unitrsnama asc");
    	if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function cekData($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
    	$query = $this->db->query("SELECT bulan, tahun, jenis_gaji, v_grup_golongan
				from payroll.total_perunit 
				where bulan = '$bulan' and tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and jenis_gaji = $jenis_gaji");
    	if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

	function getEnc(){
        $query = $this->db->query("SELECT encryption_iv,encryption_key from payroll.encr");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    } 

	function getUnitGolXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
		$query = $this->db->query("SELECT distinct v_unitrsnama, count(tif.v_nik) as total, ms_unitrs.n_unitrsid
			from payroll.tb_isi_file tif
			join ms_employee on ms_employee.v_nik = tif.v_nik
			join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid 
			left join ms_golongan_employee mge on mge.id_golongan = ms_employee.id_golongan
			join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
			left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
			where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji
			group by ms_unitrs.v_unitrsnama, ms_unitrs.n_unitrsid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

	function getDataGajiGolXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan, $n_unitrsid){
		$query = $this->db->query("SELECT gapok, tunjangan_struktural, tunjangan_khusus,tas, penyesuaian, maxgross, 
			dinas_malam, lembur, rapel, insentif, gross, potongan_jht,jaminan_pensiun,pajak, 
			bpjs_kesehatan, thp_bulat, jumlah_terima, mge.id_golongan
			from payroll.tb_isi_file tif
			join ms_employee on ms_employee.v_nik = tif.v_nik
			join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid 
			left join ms_golongan_employee mge on mge.id_golongan = ms_employee.id_golongan
			join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
			left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
			where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan =  $v_grup_golongan and muf.jenis = $jenis_gaji and ms_unitrs.n_unitrsid = $n_unitrsid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

	function getJumKaryawanXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
		$query = $this->db->query("SELECT 
                count (n_employee_id) as total_karyawan
                from payroll.tb_isi_file tif
                join ms_employee me on me.v_nik = tif.v_nik
                left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
                join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
                where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
	}

	function getTotalDetailXIIBawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
		$query = $this->db->query("SELECT gapok as allgapok, tunjangan_struktural, tunjangan_khusus,tas, penyesuaian, maxgross, 
			dinas_malam, lembur, rapel, insentif, gross, potongan_jht,jaminan_pensiun,pajak, 
			bpjs_kesehatan, thp_bulat, jumlah_terima, mge.id_golongan
			from payroll.tb_isi_file tif
			join ms_employee on ms_employee.v_nik = tif.v_nik
			join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid 
			left join ms_golongan_employee mge on mge.id_golongan = ms_employee.id_golongan
			join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
			left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
			where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

	function getUnitGolXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
		$query = $this->db->query("SELECT distinct v_unitrsnama, count(tif.v_nik) as total, ms_unitrs.n_unitrsid
			from payroll.tb_isi_file tif
			join ms_employee on ms_employee.v_nik = tif.v_nik
			join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid 
			left join ms_golongan_employee mge on mge.id_golongan = ms_employee.id_golongan
			join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
			left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
			where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji
			group by ms_unitrs.v_unitrsnama, ms_unitrs.n_unitrsid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

	function getDataGajiGolXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan, $n_unitrsid){
		$query = $this->db->query("SELECT gapok, tunjangan_struktural, tunjangan_khusus,tas, penyesuaian, maxgross, 
			dinas_malam, lembur, rapel, insentif, gross, potongan_jht,jaminan_pensiun,pajak, 
			bpjs_kesehatan, thp_bulat, jumlah_terima, mge.id_golongan
			from payroll.tb_isi_file tif
			join ms_employee on ms_employee.v_nik = tif.v_nik
			join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid 
			left join ms_golongan_employee mge on mge.id_golongan = ms_employee.id_golongan
			join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
			left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
			where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan =  $v_grup_golongan and muf.jenis = $jenis_gaji and ms_unitrs.n_unitrsid = $n_unitrsid");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

	function getJumKaryawanXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
		$query = $this->db->query("SELECT 
                count (n_employee_id) as total_karyawan
                from payroll.tb_isi_file tif
                join ms_employee me on me.v_nik = tif.v_nik
                left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
                join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
                where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
	}

	function getTotalDetailXIIIAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
		$query = $this->db->query("SELECT gapok as allgapok, tunjangan_struktural, tunjangan_khusus,tas, penyesuaian, maxgross, 
			dinas_malam, lembur, rapel, insentif, gross, potongan_jht,jaminan_pensiun,pajak, 
			bpjs_kesehatan, thp_bulat, jumlah_terima, mge.id_golongan
			from payroll.tb_isi_file tif
			join ms_employee on ms_employee.v_nik = tif.v_nik
			join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid 
			left join ms_golongan_employee mge on mge.id_golongan = ms_employee.id_golongan
			join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
			left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
			where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}

	function update($data, $bulan, $tahun, $jenis_gaji, $n_unitrsid){
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);
		$this->db->where('jenis_gaji', $jenis_gaji);
		$this->db->where('n_unitrsid', $n_unitrsid);
        $this->db->update('payroll.total_perunit', $data);

	}

	function gettotalAllGajiPerunitXIIKebawah($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
		$query = $this->db->query("SELECT ms_unitrs.v_unitrsnama, t_gapok, ms_unitrs.n_unitrsid, bulan, tahun, t_penyesuaian, t_gross, t_tas,
			t_maxgross, t_rapellain, t_dinasmalam, t_lembur, t_potjht, t_jaminanpensiun,
			t_potjkn, t_thpbulat, t_pph21, t_tunjkhusus, t_tunjstruktural,
			t_insentif, v_grup_golongan, t_gajibersih 
			from payroll.total_perunit 
			join ms_unitrs on ms_unitrs.n_unitrsid = payroll.total_perunit.n_unitrsid
			where bulan = '$bulan' and tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and jenis_gaji = $jenis_gaji
			order by ms_unitrs.v_unitrsnama asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
	}


 
}