<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class LapGajipergolongan_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}

    //I - XII
    function getJmlKaryawan($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
        $query = $this->db->query("SELECT case when mge.id_golongan = 12 then 'I'
                    when mge.id_golongan = 1 then 'IV'
                    when mge.id_golongan = 2 then 'VI'
                    when mge.id_golongan = 3 then 'VII-A'
                    when mge.id_golongan = 4 then 'VII-B'
                    when mge.id_golongan = 5 then 'IX'
                    when mge.id_golongan = 6 then 'X'
                    when mge.id_golongan = 7 then 'XII'
                    end as golongan,
                    count (n_employee_id) as jumlah_karyawan,  mge.id_golongan
                    from payroll.tb_isi_file tif
                    join ms_employee me on me.v_nik = tif.v_nik
                    left join ms_unitrs mu on mu.n_unitrsid = me.n_unitrsid
                    left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
                    join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
                    left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
                    where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = '$v_grup_golongan' and muf.jenis = $jenis_gaji and mge.n_group = 1
                    group by mge.id_golongan order by nama_golongan asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function getGapok($id_golongan, $bulan, $tahun, $jenis_gaji, $v_grup_golongan){
        $query = $this->db->query("SELECT gapok, tunjangan_struktural, tunjangan_khusus,tas, penyesuaian, maxgross, dinas_malam, lembur, rapel, insentif, gross, potongan_jht,jaminan_pensiun,pajak, bpjs_kesehatan, thp_bulat, jumlah_terima, mge.id_golongan
            from payroll.tb_isi_file tif
            join ms_employee me on me.v_nik = tif.v_nik
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            where mge.id_golongan = $id_golongan and n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }


    //============ footer (total semua) ==============
    function getJumKaryawan($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
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


    function getAllGapok($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
        $query = $this->db->query("SELECT gapok as allgapok, tunjangan_struktural, tunjangan_khusus, tas, penyesuaian, maxgross, dinas_malam, lembur, rapel, insentif, gross, potongan_jht, jaminan_pensiun, pajak, bpjs_kesehatan, thp_bulat, jumlah_terima from payroll.tb_isi_file tif
            join ms_employee me on me.v_nik = tif.v_nik
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function getEnc(){
        $query = $this->db->query("SELECT encryption_iv,encryption_key from payroll.encr");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    } 



    //XIII keatas
    function getJmlKaryawanXIIIKeAtas($bulan, $tahun, $jenis_gaji, $v_grup_golongan){
        $query = $this->db->query("SELECT case when mge.id_golongan = 13 then 'XIII'
                    when mge.id_golongan = 14 then 'XIV'
                    when mge.id_golongan = 15 then 'XV'
                    when mge.id_golongan = 16 then 'XVII'
                    end as golongan,
                    count (n_employee_id) as jumlah_karyawan,  mge.id_golongan
                    from payroll.tb_isi_file tif
                    join ms_employee me on me.v_nik = tif.v_nik
                    left join ms_unitrs mu on mu.n_unitrsid = me.n_unitrsid
                    left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
                    join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
                    left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
                    where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = '$v_grup_golongan' and muf.jenis = $jenis_gaji and mge.n_group = 2
                    group by mge.id_golongan order by nama_golongan asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function getGapokXIIIKeAtas($id_golongan, $bulan, $tahun, $jenis_gaji, $v_grup_golongan){
        $query = $this->db->query("SELECT gapok, tunjangan_struktural, tunjangan_khusus,tas, penyesuaian, maxgross, dinas_malam, lembur, rapel, insentif, gross, potongan_jht,jaminan_pensiun,pajak, bpjs_kesehatan, thp_bulat, jumlah_terima, mge.id_golongan
            from payroll.tb_isi_file tif
            join ms_employee me on me.v_nik = tif.v_nik
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            where mge.id_golongan = $id_golongan and n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = $v_grup_golongan and muf.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

    }
}