<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class DataGajiKaryawan_model extends CI_Model
{

	function __construct()
	{
		parent:: __construct();
	}

    public function insert_gaji($data)
    {
        $this->db->insert('payroll.tb_gaji', $data);
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

    /*function get_data_gaji_karyawan($bulan, $tahun, $grup){
        $thpbulat       = '"thpbulat"';
        $potongan       = '"potongan"';
        $totaltransfer  = '"totaltransfer"';

        $query = $this->db->query("SELECT tif.v_nik, v_employee_name, v_unitrsnama, nama_golongan, baca, d_whn_read::date as tglbaca, d_whn_read::time as jam,
            max(case when mp.n_potongan_id = 7 then tif.v_nominal end) as $thpbulat,
            max(case when mp.n_potongan_id = 8 then tif.v_nominal end) as $potongan,
            max(case when mp.n_potongan_id = 9 then tif.v_nominal end) as $totaltransfer
            from payroll.tb_isi_file tif
            join ms_employee me on me.v_nik = tif.v_nik
            left join ms_unitrs mu on mu.n_unitrsid = me.n_unitrsid
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id
            left join payroll.tb_gaji tg on tg.nik = tif.v_nik
            where n_bulan = $bulan and n_tahun = $tahun and v_grup_golongan = $grup
            and mp.n_potongan_id in (7,8,9)
            group by tif.v_nik, v_employee_name, v_unitrsnama, nama_golongan, baca, d_whn_read
            order by v_unitrsnama, nama_golongan asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }*/

    function get_data_gaji_karyawanXIIIKeatas($bulan, $tahun, $grup, $jenis_gaji){
        $query = $this->db->query("SELECT tif.v_nik, v_employee_name, v_unitrsnama, nama_golongan, '-' as baca, '-' as tglbaca, '-' as jam, tif.gapok, tif.tunjangan_khusus, tif.tunjangan_struktural, tif.penyesuaian, tif.tas, tif.maxgross, tif.dinas_malam, tif.lembur, tif.rapel, tif.insentif, tif.gross, tif.potongan_jht, tif.jaminan_pensiun, tif.bpjs_kesehatan, tif.sta, tif.pajak, tif.thp_bulat, tif.potongan_kopkar, tif.nominal_rek, tif.nominal_lain, tif.nominal_prr_btn, tif.nominal_btnsolo, tif.nominal_koperasi, tif.ket_rek_rs, tif.ket_lain, tif.ket_prr_btn, tif.ket_btn_solo, tif.ket_koperasi, tif.jumlah_terima, tif.titik_perubahan, muf.jenis, tif.nominal_ekstra, tif.ket_ekstra, tif.jenis_ekstra,tif.potongan_rs, tif.pot_koperasi, tif.pot_btn, tif.tunai, tif.jml_potongan, tif.status, tif.jumlah_terima, tif.honor, tif.thr,tif.tf_cimb_niaga, tif.tf_bca,tif.tf_bca,tif.tunai,pot_jkn_kelg,tif.potongan_rs, tif.pot_koperasi, tif.pot_btn
        from payroll.tb_isi_file tif
        join ms_employee me on me.v_nik = tif.v_nik
        left join ms_unitrs mu on mu.n_unitrsid = me.n_unitrsid
        left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
        join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
        left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id --potongan
        -- left join payroll.tb_gaji tg on tg.nik = tif.v_nik 
        where n_bulan = $bulan and n_tahun = $tahun and v_grup_golongan = $grup and muf.jenis = $jenis_gaji 
        order by v_unitrsnama, nama_golongan asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_data_gaji_karyawan($bulan, $tahun, $grup, $jenis_gaji){
            $query = $this->db->query("SELECT distinct tif.v_nik, v_employee_name, v_unitrsnama, nama_golongan, '-' as baca, '-' as tglbaca, '-' as jam, tif.gapok, tif.tunjangan_khusus, tif.tunjangan_struktural, tif.penyesuaian, tif.tas, tif.maxgross, tif.dinas_malam, tif.lembur, tif.rapel, tif.insentif, tif.gross, tif.potongan_jht, tif.jaminan_pensiun, tif.bpjs_kesehatan, tif.sta, tif.pajak, tif.thp_bulat, tif.potongan_kopkar, tif.nominal_rek, tif.nominal_lain, tif.nominal_prr_btn, tif.nominal_btnsolo, tif.nominal_koperasi, tif.ket_rek_rs, tif.ket_lain, tif.ket_prr_btn, tif.ket_btn_solo, tif.ket_koperasi, tif.jumlah_terima, tif.titik_perubahan, muf.jenis, tif.nominal_ekstra, tif.ket_ekstra, tif.jenis_ekstra,tif.jml_potongan,tif.tf_cimb_niaga, tif.tf_bca,tif.tunai,tif.pot_jkn_kelg,tif.potongan_rs, tif.pot_koperasi, tif.pot_btn,tif.thr,tg.d_whn_read,tg.n_gaji_id from payroll.tb_isi_file tif join ms_employee me on me.v_nik = tif.v_nik left join ms_unitrs mu on mu.n_unitrsid = me.n_unitrsid left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan 
                join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id left join payroll.ms_potongan mp on mp.n_potongan_id = muf.n_potongan_id 
                left join payroll.tb_gaji tg on tg.nik = tif.v_nik and tg.bulan =n_bulan and tg.tahun =n_tahun
                where n_bulan = '$bulan' and n_tahun = '$tahun' and v_grup_golongan = '$grup' and muf.jenis = '$jenis_gaji' order by v_unitrsnama, nama_golongan asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    /*function get_cek_data_gaji_karyawan($bulan, $tahun, $grup){

        $query = $this->db->query("SELECT nik, tg.thp_bulat, tg.potongan, tg.transfer_bank, n_bulan, n_tahun
            from payroll.tb_gaji tg 
            join payroll.tb_isi_file tif on tif.v_nik = tg.nik
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            where bulan = $bulan and tahun = $tahun and v_grup_golongan = $grup
            and muf.n_potongan_id in (7,8,9)");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }*/

    function get_cek_data_gaji_karyawan($bulan, $tahun, $grup, $jenis_gaji){

        $query = $this->db->query("SELECT nik, n_bulan, n_tahun, tg.jumlah_terima
            from payroll.tb_gaji tg 
            join payroll.tb_isi_file tif on tif.v_nik = tg.nik
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            where bulan = $bulan and tahun = $tahun and n_tahun='$tahun' and n_bulan='$bulan' and v_grup_golongan = $grup and tg.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_data_baca($bulan, $tahun, $grup, $hasil_nik){

        $query = $this->db->query("SELECT nik, baca
            from payroll.tb_gaji tg
            join ms_employee me on me.v_nik = tg.nik
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            left join ms_unitrs mu on mu.n_unitrsid = me.n_unitrsid
            where bulan = $bulan and tahun = $tahun and n_group = $grup
            and nik in ($hasil_nik)
            order by v_unitrsnama, nama_golongan asc");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function get_detail($bulan, $tahun, $v_grup_golongan){
        $query=$this->db->query("
            SELECT nik
            from payroll.tb_gaji tg
            join ms_employee me on me.v_nik = tg.nik
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            where bulan = $bulan and tahun = $tahun and n_group = $v_grup_golongan
        ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function get_cek_data_gaji_karyawan_personal($bulan, $tahun, $nik, $jenis_gaji){

        $query = $this->db->query("SELECT nik, n_bulan, n_tahun, tg.jumlah_terima
            from payroll.tb_gaji tg 
            join payroll.tb_isi_file tif on tif.v_nik = tg.nik
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            where bulan = $bulan and tahun = $tahun and nik = '$nik' and n_tahun='$tahun' and n_bulan='$bulan' and tg.jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function cek_baca($bulan,$tahun,$nik,$jenis){
        $query=$this->db->query("SELECT d_whn_read from payroll.tb_gaji tg where tg.bulan =$bulan and tg.tahun=$tahun and nik='$nik' and jenis=$jenis order by d_whn_read asc limit 1");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function get_data_gaji_karyawan_personal($bulan, $tahun, $nik, $jenis_gaji){
        $query = $this->db->query("SELECT tif.v_nik, v_employee_name, v_unitrsnama, nama_golongan, baca, d_whn_read::date as tglbaca, substring(d_whn_read::varchar, 12, 5) as jam, tif.gapok, tif.tunjangan_khusus, tif.tunjangan_struktural, tif.penyesuaian, tif.tas, tif.maxgross, tif.dinas_malam, tif.lembur, tif.rapel, tif.insentif, tif.gross, tif.potongan_jht, tif.jaminan_pensiun, tif.bpjs_kesehatan, tif.sta, tif.pajak, tif.thp_bulat, tif.potongan_kopkar, tif.nominal_rek, tif.nominal_lain, tif.nominal_prr_btn, tif.nominal_btnsolo, tif.nominal_koperasi, tif.ket_rek_rs, tif.ket_lain, tif.ket_prr_btn, tif.ket_btn_solo, tif.ket_koperasi, tif.jumlah_terima, tif.titik_perubahan, muf.jenis, tif.nominal_ekstra, tif.ket_ekstra, tif.jenis_ekstra,tif.jml_potongan,tif.tf_cimb_niaga,tif.tf_bca,tif.tunai,tif.pot_jkn_kelg,tif.potongan_rs, tif.pot_koperasi, tif.pot_btn,tif.thr
            from payroll.tb_isi_file tif
            join ms_employee me on me.v_nik = tif.v_nik
            left join ms_unitrs mu on mu.n_unitrsid = me.n_unitrsid
            left join ms_golongan_employee mge on mge.id_golongan = me.id_golongan
            join payroll.ms_upload_file muf on muf.n_upload_file_id = tif.n_upload_file_id
            left join payroll.tb_gaji tg on tg.nik = tif.v_nik and tg.bulan =n_bulan and tg.tahun =n_tahun
            where n_bulan = $bulan and n_tahun = $tahun and tif.v_nik = '$nik' and muf.jenis = $jenis_gaji
            order by v_unitrsnama, nama_golongan asc");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    // cetak slip gaji
    function cekdata($bulan, $tahun, $nik, $jenis_gaji){
        $query = $this->db->query("SELECT n_gaji_id ,gapok ,tunjangan ,penyesuaian,gross,tas ,maxgross,rapel ,dinas_malam ,lembur,total_maxgross ,premi_asuransi ,premi_jkn ,total_gross_premi ,tunjangan_jabatan ,
            potongan_jht ,jaminan_pensiun ,bpjs_kesehatan ,dasar_perhitungan_pajak ,ptkp ,
            pendapatan_kena_pajak ,pajak ,thp ,thp_bulat ,bulan ,tahun ,status,potongan,transfer_bank,
            nik,tunjangan_khusus ,tunjangan_struktural,insentif,sta ,potongan_kopkar ,nominal_rek ,
            nominal_lain ,nominal_prr_btn ,nominal_btnsolo ,nominal_koperasi ,ket_rek_rs ,ket_lain ,
            ket_prr_btn ,ket_btn_solo ,ket_koperasi ,jumlah_terima ,titik_perubahan ,jenis ,
            nominal_ekstra ,ket_ekstra ,jenis_ekstra ,honor ,thr ,status_gaji ,potongan_rs ,pot_btn ,
            tunai ,pot_koperasi ,jml_potongan ,pot_jkn_kelg ,tf_cimb_niaga ,tf_bca, ms_employee.v_employee_name, 
            ms_unitrs.v_unitrsnama 
            from payroll.tb_gaji
            left join ms_employee on ms_employee.v_nik = payroll.tb_gaji.nik 
            left join ms_unitrs on ms_unitrs.n_unitrsid = ms_employee.n_unitrsid 
            where bulan = $bulan and tahun = $tahun and nik= '$nik' and jenis = $jenis_gaji");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return 0;
        }
    }

    function cekinfo($periode, $nik){
        $query = $this->db->query("SELECT dekripsi_info from tb_infokaryawan ti 
            where v_nik = '$nik' and bulan_gaji = '$periode'");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return 0;
        }
    }

}