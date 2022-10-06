<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class DataGajiKaryawan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
		$this->load->model(array('DataGajiKaryawan_model','Masterkaryawan_model','Upload_model'));
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory','cipher'));
	}

    public function daftarAtasXIII(){

        $data['content'] = 'DataGajiKaryawanAtasXIII_view';
        $this->load->view('template', $data);
    }

    public function getListDataGajiKaryawanAtasXIII() {
        if ($this->input->post('periode') != null){
            $periode = $this->input->post('periode');
            $jenis_gaji = $this->input->post('jenis_gaji');

            $bulan = substr($periode, 0,2);
            $tahun = substr($periode, 3,4);

            $encr_key   = $this->Upload_model->get_encr();
            $iv         = $encr_key['encryption_iv'];
            $key        = $encr_key['encryption_key'];
            
            //$data['list_datagajikaryawan'] = $this->DataGajiKaryawan_model->get_data_gaji_karyawan($bulan, $tahun);

            $list_datagajikaryawan=$this->DataGajiKaryawan_model->get_data_gaji_karyawan($bulan, $tahun, 2, $jenis_gaji);

            if($list_datagajikaryawan){
                $data = array();
                foreach ($list_datagajikaryawan as $karyawan) {
                    $tglbaca ='-';
                    $dataBaca=$this->DataGajiKaryawan_model->cek_baca($bulan,$tahun,$karyawan['v_nik'],$jenis_gaji);
                    if($dataBaca['d_whn_read']){
                        $tglbaca = date("d/m/Y H:i", strtotime($dataBaca['d_whn_read']));
                    }
                    
                    $data[]=array(
                        'v_nik' => $karyawan['v_nik'],
                        'v_employee_name' => $karyawan['v_employee_name'],
                        'v_unitrsnama' => $karyawan['v_unitrsnama'],
                        'nama_golongan' => $karyawan['nama_golongan'],
                        'jenis' => $karyawan['jenis'],
                        'baca' => $karyawan['baca'],
                        'tglbaca' => $tglbaca,
                        'jambaca' => $karyawan['jam'],
                        //'thpbulat' => $this->cipher->decrypt($karyawan['thpbulat']),
                        //'potongan' => $this->cipher->decrypt($karyawan['potongan']),
                        'jumlah_terima' => $this->cipher->decrypt($karyawan['jumlah_terima'])
                    );
                }

                echo json_encode($data);

            }else{

                echo json_encode("kosong");
            }
            
        }
    }

    //-------- I - XII

    public function daftarBawahXIII(){

        $data['content'] = 'DataGajiKaryawanBawahXIII_view';
        $this->load->view('template', $data);
    }

    public function getListDataGajiKaryawanBawahXIII() {
        if ($this->input->post('periode') != null){
            $periode = $this->input->post('periode');
            $jenis_gaji = $this->input->post('jenis_gaji');

            $bulan = substr($periode, 0,2);
            $tahun = substr($periode, 3,4);

            $encr_key   = $this->Upload_model->get_encr();
            $iv         = $encr_key['encryption_iv'];
            $key        = $encr_key['encryption_key'];
            
            //$data['list_datagajikaryawan'] = $this->DataGajiKaryawan_model->get_data_gaji_karyawan($bulan, $tahun);

            $list_datagajikaryawan=$this->DataGajiKaryawan_model->get_data_gaji_karyawan($bulan, $tahun, 1, $jenis_gaji);
            
            if($list_datagajikaryawan){
                $data = array();
                foreach ($list_datagajikaryawan as $karyawan) {
                   $tglbaca ='-';
                    $dataBaca=$this->DataGajiKaryawan_model->cek_baca($bulan,$tahun,$karyawan['v_nik'],$jenis_gaji);
                    if($dataBaca['d_whn_read']){
                        $tglbaca = date("d/m/Y H:i", strtotime($dataBaca['d_whn_read']));
                    }
                    
                    $data[]=array(
                        'v_nik' => $karyawan['v_nik'],
                        'v_employee_name' => $karyawan['v_employee_name'],
                        'v_unitrsnama' => $karyawan['v_unitrsnama'],
                        'nama_golongan' => $karyawan['nama_golongan'],
                        'jenis' => $karyawan['jenis'],
                        'baca' => $karyawan['baca'],
                        'tglbaca' => $tglbaca,
                        'jambaca' => $karyawan['jam'],
                        //'thpbulat' => $this->cipher->decrypt($karyawan['thpbulat']),
                        //'potongan' => $this->cipher->decrypt($karyawan['potongan']),
                        'jumlah_terima' => $this->cipher->decrypt($karyawan['jumlah_terima'])
                    );
                }

                //$hasil_nik = $this->get_nik_detail($bulan, $tahun, $v_grup_golongan);

                //$list_baca = $this->DataGajiKaryawan_model->get_data_baca($bulan, $tahun, 1, $hasil_nik);

                echo json_encode($data);

            }else{

                echo json_encode("kosong");
            }
            
        }
    }

    /*public function get_nik_detail($bulan, $tahun, $v_grup_golongan){
        $v_nik = "";
        $cek_detail = $this->DataGajiKaryawan_model->get_detail($bulan, $tahun, $v_grup_golongan);
        if(is_array($cek_detail)) {
            foreach ($cek_detail as $value) {
                $v_nik .= "'".$value['v_nik']."'".",";
            }
            $result_nik = rtrim($v_nik, ",");
        }else{
            $result_nik = "0";
        }
        return $result_nik;
    }*/

      public function getListGajiToGenerateXIIIKeatas() {
        if ($this->input->post('periode') != null){
            $periode    = $this->input->post('periode');
            $gol        = $this->input->post('gol');
            $jenis_gaji = $this->input->post('jenis_gaji');

            $bulan = substr($periode, 0,2);
            $tahun = substr($periode, 3,4);

            $list_datagajikaryawan=$this->DataGajiKaryawan_model->get_data_gaji_karyawanXIIIKeatas($bulan, $tahun, $gol, $jenis_gaji);
            
            if($list_datagajikaryawan){
                $data = array();
                foreach ($list_datagajikaryawan as $karyawan) {
                    $data[]=array(
                        'v_nik' => $karyawan['v_nik'],
                        'v_employee_name' => $karyawan['v_employee_name'],
                        'v_unitrsnama' => $karyawan['v_unitrsnama'],
                        'nama_golongan' => $karyawan['nama_golongan'],
                        
                        'gapok'=>$this->cipher->decrypt($karyawan['gapok']),
                        'rapel'=>$this->cipher->decrypt($karyawan['rapel']),
                        'potongan_rs'=>$this->cipher->decrypt($karyawan['potongan_rs']),
                        'tunjangan_khusus'=>$this->cipher->decrypt($karyawan['tunjangan_khusus']),
                        'insentif'=>$this->cipher->decrypt($karyawan['insentif']),
                        'pot_koperasi'=>$this->cipher->decrypt($karyawan['pot_koperasi']),
                        'tunjangan_struktural'=>$this->cipher->decrypt($karyawan['tunjangan_struktural']),
                        'potongan_jht'=>$this->cipher->decrypt($karyawan['potongan_jht']),
                        'pot_btn'=>$this->cipher->decrypt($karyawan['pot_btn']),
                        'tas'=>$this->cipher->decrypt($karyawan['tas']),
                        'jaminan_pensiun'=>$this->cipher->decrypt($karyawan['jaminan_pensiun']),
                        'tunai'=>$this->cipher->decrypt($karyawan['tunai']),
                        'penyesuaian'=>$this->cipher->decrypt($karyawan['penyesuaian']),
                        'bpjs_kesehatan'=>$this->cipher->decrypt($karyawan['bpjs_kesehatan']),
                        'jml_potongan'=>$this->cipher->decrypt($karyawan['jml_potongan']),
                        'gross'=>$this->cipher->decrypt($karyawan['gross']),
                        'status'=>$this->cipher->decrypt($karyawan['status']),
                        'maxgross'=>$this->cipher->decrypt($karyawan['maxgross']),
                        'pajak'=>$this->cipher->decrypt($karyawan['pajak']),
                        'jumlah_terima'=>$this->cipher->decrypt($karyawan['jumlah_terima']),
                        'honor'=>$this->cipher->decrypt($karyawan['honor']),
                        'thr'=>$this->cipher->decrypt($karyawan['thr']),
                        'lembur'=>$this->cipher->decrypt($karyawan['lembur']),
                        'thp_bulat'=>$this->cipher->decrypt($karyawan['thp_bulat']),
                        'pot_jkn_kelg'=>$this->cipher->decrypt($karyawan['pot_jkn_kelg']),
                        'tb_cimb_niaga'=>$this->cipher->decrypt($karyawan['tb_cimb_niaga']),
                        'tb_bca'=>$this->cipher->decrypt($karyawan['tb_bca'])
                    );
                }

                echo json_encode($data);

            }else{

                echo json_encode("kosong");
            }
            
        }
    }

    public function getListGajiToGenerate() {
        if ($this->input->post('periode') != null){
            $periode    = $this->input->post('periode');
            $gol        = $this->input->post('gol');
            $jenis_gaji = $this->input->post('jenis_gaji');

            $bulan = substr($periode, 0,2);
            $tahun = substr($periode, 3,4);

            $list_datagajikaryawan=$this->DataGajiKaryawan_model->get_data_gaji_karyawan($bulan, $tahun, $gol, $jenis_gaji);
            
            if($list_datagajikaryawan){
                $data = array();
                foreach ($list_datagajikaryawan as $karyawan) {
                    $data[]=array(
                        'v_nik' => $karyawan['v_nik'],
                        'v_employee_name' => $karyawan['v_employee_name'],
                        'v_unitrsnama' => $karyawan['v_unitrsnama'],
                        'nama_golongan' => $karyawan['nama_golongan'],
                        //'thpbulat' => $this->cipher->decrypt($karyawan['thpbulat']),
                        //'potongan' => $this->cipher->decrypt($karyawan['potongan']),
                        'gapok'=>$this->cipher->decrypt($karyawan['gapok']),
                        'tunjangan_khusus'=>$this->cipher->decrypt($karyawan['tunjangan_khusus']),
                        'tunjangan_struktural'=>$this->cipher->decrypt($karyawan['tunjangan_struktural']),
                        'penyesuaian'=>$this->cipher->decrypt($karyawan['penyesuaian']),
                        'tas'=>$this->cipher->decrypt($karyawan['tas']),
                        'maxgross'=>$this->cipher->decrypt($karyawan['maxgross']),
                        'dinas_malam'=>$this->cipher->decrypt($karyawan['dinas_malam']),
                        'lembur'=>$this->cipher->decrypt($karyawan['lembur']),
                        'rapel'=>$this->cipher->decrypt($karyawan['rapel']),
                        'insentif'=>$this->cipher->decrypt($karyawan['insentif']),
                        'gross'=>$this->cipher->decrypt($karyawan['gross']),
                        'potongan_jht'=>$this->cipher->decrypt($karyawan['potongan_jht']),
                        'jaminan_pensiun'=>$this->cipher->decrypt($karyawan['jaminan_pensiun']),
                        'bpjs_kesehatan'=>$this->cipher->decrypt($karyawan['bpjs_kesehatan']),
                        'sta'=>$this->cipher->decrypt($karyawan['sta']),
                        'pajak'=>$this->cipher->decrypt($karyawan['pajak']),
                        'thp_bulat'=>$this->cipher->decrypt($karyawan['thp_bulat']),
                        'potongan_kopkar'=>$this->cipher->decrypt($karyawan['potongan_kopkar']),
                        'jml_potongan'=>$this->cipher->decrypt($karyawan['jml_potongan']),
                        'nominal_rek'=>$this->cipher->decrypt($karyawan['nominal_rek']),
                        'nominal_lain'=>$this->cipher->decrypt($karyawan['nominal_lain']),
                        'nominal_prr_btn'=>$this->cipher->decrypt($karyawan['nominal_prr_btn']),
                        'nominal_btnsolo'=>$this->cipher->decrypt($karyawan['nominal_btnsolo']),
                        'nominal_koperasi'=>$this->cipher->decrypt($karyawan['nominal_koperasi']),
                        'ket_rek_rs'=>$karyawan['ket_rek_rs'],
                        'ket_lain'=>$karyawan['ket_lain'],
                        'ket_prr_btn'=>$karyawan['ket_prr_btn'],
                        'ket_btn_solo'=>$karyawan['ket_btn_solo'],
                        'ket_koperasi'=>$karyawan['ket_koperasi'],
                        'jumlah_terima'=>$this->cipher->decrypt($karyawan['jumlah_terima']),
                        'titik_perubahan'=>$karyawan['titik_perubahan'],
                        'nominal_ekstra'=>$this->cipher->decrypt($karyawan['nominal_ekstra']),
                        'ket_ekstra'=>$karyawan['ket_ekstra'],
                        'jenis_ekstra'=>$karyawan['jenis_ekstra'],
                         'tf_cimb_niaga'=>$this->cipher->decrypt($karyawan['tf_cimb_niaga']),
                         'tf_bca'=>$this->cipher->decrypt($karyawan['tf_bca'])
                    );
                }

                echo json_encode($data);

            }else{

                echo json_encode("kosong");
            }
            
        }
    }

    public function tambahDataGajiKaryawan(){
        $periode        = $this->input->post('periode');
        $v_nik          = $this->input->post('v_nik');
        $jenis_gaji     = $this->input->post('jenis_gaji');

        if($this->input->post('gapok')){
            $gapok  = $this->cipher->encrypt($this->input->post('gapok'));
        }else{
            $gapok  = null;
        }

        if($this->input->post('tunjangan_khusus')){
            $tunjangan_khusus  = $this->cipher->encrypt($this->input->post('tunjangan_khusus'));
        }else{
            $tunjangan_khusus  = null;
        }

        if($this->input->post('tunjangan_struktural')){
            $tunjangan_struktural  = $this->cipher->encrypt($this->input->post('tunjangan_struktural'));
        }else{
            $tunjangan_struktural  = null;
        }

        if($this->input->post('penyesuaian')){
            $penyesuaian  = $this->cipher->encrypt($this->input->post('penyesuaian'));
        }else{
            $penyesuaian  = null;
        }

        if($this->input->post('tas')){
            $tas  = $this->cipher->encrypt($this->input->post('tas'));
        }else{
            $tas  = null;
        }

        if($this->input->post('maxgross')){
            $maxgross  = $this->cipher->encrypt($this->input->post('maxgross'));
        }else{
            $maxgross  = null;
        }

        if($this->input->post('dinas_malam')){
            $dinas_malam  = $this->cipher->encrypt($this->input->post('dinas_malam'));
        }else{
            $dinas_malam  = null;
        }

        if($this->input->post('lembur')){
            $lembur  = $this->cipher->encrypt($this->input->post('lembur'));
        }else{
            $lembur  = null;
        }

        if($this->input->post('rapel')){
            $rapel  = $this->cipher->encrypt($this->input->post('rapel'));
        }else{
            $rapel  = null;
        }

        if($this->input->post('insentif')){
            $insentif  = $this->cipher->encrypt($this->input->post('insentif'));
        }else{
            $insentif  = null;
        }

        if($this->input->post('gross')){
            $gross  = $this->cipher->encrypt($this->input->post('gross'));
        }else{
            $gross  = null;
        }

        if($this->input->post('potongan_jht')){
            $potongan_jht  = $this->cipher->encrypt($this->input->post('potongan_jht'));
        }else{
            $potongan_jht  = null;
        }

        if($this->input->post('jaminan_pensiun')){
            $jaminan_pensiun  = $this->cipher->encrypt($this->input->post('jaminan_pensiun'));
        }else{
            $jaminan_pensiun  = null;
        }

        if($this->input->post('bpjs_kesehatan')){
            $bpjs_kesehatan  = $this->cipher->encrypt($this->input->post('bpjs_kesehatan'));
        }else{
            $bpjs_kesehatan  = null;
        }

        if($this->input->post('sta')){
            $sta  = $this->cipher->encrypt($this->input->post('sta'));
        }else{
            $sta  = null;
        }

        if($this->input->post('pajak')){
            $pajak  = $this->cipher->encrypt($this->input->post('pajak'));
        }else{
            $pajak  = null;
        }

        if($this->input->post('thp_bulat')){
            $thp_bulat  = $this->cipher->encrypt($this->input->post('thp_bulat'));
        }else{
            $thp_bulat  = null;
        }

        if($this->input->post('potongan_kopkar')){
            $potongan_kopkar  = $this->cipher->encrypt($this->input->post('potongan_kopkar'));
        }else{
            $potongan_kopkar  = null;
        }

        if($this->input->post('jml_potongan')){
            $jml_potongan  = $this->cipher->encrypt($this->input->post('jml_potongan'));
        }else{
            $jml_potongan  = null;
        }

        if($this->input->post('nominal_rek')){
            $nominal_rek  = $this->cipher->encrypt($this->input->post('nominal_rek'));
        }else{
            $nominal_rek  = null;
        }

        if($this->input->post('nominal_lain')){
            $nominal_lain  = $this->cipher->encrypt($this->input->post('nominal_lain'));
        }else{
            $nominal_lain  = null;
        }

        if($this->input->post('nominal_prr_btn')){
            $nominal_prr_btn  = $this->cipher->encrypt($this->input->post('nominal_prr_btn'));
        }else{
            $nominal_prr_btn  = null;
        }

        if($this->input->post('nominal_btnsolo')){
            $nominal_btnsolo  = $this->cipher->encrypt($this->input->post('nominal_btnsolo'));
        }else{
            $nominal_btnsolo  = null;
        }

        if($this->input->post('nominal_koperasi')){
            $nominal_koperasi  = $this->cipher->encrypt($this->input->post('nominal_koperasi'));
        }else{
            $nominal_koperasi  = null;
        }

        if($this->input->post('ket_rek_rs')){
            $ket_rek_rs  = $this->input->post('ket_rek_rs');
        }else{
            $ket_rek_rs  = null;
        }

        if($this->input->post('ket_lain')){
            $ket_lain  = $this->input->post('ket_lain');
        }else{
            $ket_lain  = null;
        }

        if($this->input->post('ket_prr_btn')){
            $ket_prr_btn  = $this->input->post('ket_prr_btn');
        }else{
            $ket_prr_btn  = null;
        }

        if($this->input->post('ket_btn_solo')){
            $ket_btn_solo  = $this->input->post('ket_btn_solo');
        }else{
            $ket_btn_solo  = null;
        }

        if($this->input->post('ket_koperasi')){
            $ket_koperasi  = $this->input->post('ket_koperasi');
        }else{
            $ket_koperasi  = null;
        }

        if($this->input->post('jumlah_terima')){
            $jumlah_terima  = $this->cipher->encrypt($this->input->post('jumlah_terima'));
        }else{
            $jumlah_terima  = null;
        }

        if($this->input->post('titik_perubahan')){
            $titik_perubahan  = $this->input->post('titik_perubahan');
        }else{
            $titik_perubahan  = null;
        }

        if($this->input->post('nominal_ekstra')){
            $nominal_ekstra  = $this->cipher->encrypt($this->input->post('nominal_ekstra'));
        }else{
            $nominal_ekstra  = null;
        }

        if($this->input->post('ket_ekstra')){
            $ket_ekstra  = $this->input->post('ket_ekstra');
        }else{
            $ket_ekstra  = null;
        }

        if($this->input->post('jenis_ekstra')){
            $jenis_ekstra  = $this->input->post('jenis_ekstra');
        }else{
            $jenis_ekstra  = null;
        }

        if($this->input->post('tf_cimb_niaga')){
            $tf_cimb_niaga  = $this->cipher->encrypt($this->input->post('tf_cimb_niaga'));
        }else{
            $tf_cimb_niaga  = null;
        }

        if($this->input->post('tf_bca')){
            $tf_bca  = $this->cipher->encrypt($this->input->post('tf_bca'));
        }else{
            $tf_bca  = null;
        }
        
        

        $bulan = substr($periode, 0,2);
        $tahun = substr($periode, 3,4);

        $data = array(
            'bulan' => $bulan,
            'tahun'=>$tahun,
            // 'thp_bulat'=>$thp_bulat,
            // 'potongan'=>$potongan,
            // 'transfer_bank'=>$totaltransfer,
            'nik'=>$v_nik,
            'jenis'=>$jenis_gaji,

                'gapok'=>$gapok,
                'tunjangan_khusus'=>$tunjangan_khusus,
                'tunjangan_struktural'=>$tunjangan_struktural,
                'penyesuaian'=>$penyesuaian,
                'tas'=>$tas,
                'maxgross'=>$maxgross,
                'dinas_malam'=>$dinas_malam,
                'lembur'=>$lembur,
                'rapel'=>$rapel,
                'insentif'=>$insentif,
                'gross'=>$gross,
                'potongan_jht'=>$potongan_jht,
                'jaminan_pensiun'=>$jaminan_pensiun,
                'bpjs_kesehatan'=>$bpjs_kesehatan,
                'sta'=>$sta,
                'pajak'=>$pajak,
                'thp_bulat'=>$thp_bulat,
                'potongan_kopkar'=>$potongan_kopkar,
                'nominal_rek'=>$nominal_rek,
                'nominal_lain'=>$nominal_lain,
                'nominal_prr_btn'=>$nominal_prr_btn,
                'nominal_btnsolo'=>$nominal_btnsolo,
                'nominal_koperasi'=>$nominal_koperasi,
                'ket_rek_rs'=>$ket_rek_rs,
                'ket_lain'=>$ket_lain,
                'ket_prr_btn'=>$ket_prr_btn,
                'ket_btn_solo'=>$ket_btn_solo,
                'ket_koperasi'=>$ket_koperasi,
                'jumlah_terima'=>$jumlah_terima,
                'titik_perubahan'=>$titik_perubahan,
                'nominal_ekstra'=>$nominal_ekstra,
                'ket_ekstra'=>$ket_ekstra,
                'jenis_ekstra'=>$jenis_ekstra,
                'jml_potongan'=>$jml_potongan,
                'tf_cimb_niaga'=>$tf_cimb_niaga,
                'tf_bca'=>$tf_bca,
                'v_who_create'=>$this->session->userdata('nik_payroll')
        );

        $sukses= $this->DataGajiKaryawan_model->insert_gaji($data);
        echo json_encode(array("code" => 200, "response" => $sukses));

    }

        public function tambahDataGajiKaryawanXIIIKeatas(){
        $periode        = $this->input->post('periode');
        $v_nik          = $this->input->post('v_nik');
        $jenis_gaji     = $this->input->post('jenis_gaji');

        if($this->input->post('gapok') == null){
            $gapok  = null;

        }else{
            $gapok  = $this->cipher->encrypt($this->input->post('gapok'));
        }

        if($this->input->post('rapel') == null){
            $rapel  = null;
        }else{
            $rapel  = $this->cipher->encrypt($this->input->post('rapel'));
        }

        if($this->input->post('potongan_rs') == null){
            $potongan_rs  = null;
        }else{           
            $potongan_rs  = $this->cipher->encrypt($this->input->post('potongan_rs'));
        }

        if($this->input->post('tunjangan_khusus')== null){
            $tunjangan_khusus  = null;
        }else{            
            $tunjangan_khusus  = $this->cipher->encrypt($this->input->post('tunjangan_khusus'));
        }

        if($this->input->post('insentif') == null){            
            $insentif  = null;
        }else{
            $insentif  = $this->cipher->encrypt($this->input->post('insentif'));
        }

        if($this->input->post('pot_koperasi') == null){
            $pot_koperasi  = null;
        }else{
            
            $pot_koperasi  = $this->cipher->encrypt($this->input->post('pot_koperasi'));
        }

        if($this->input->post('tunjangan_struktural') == null){
            $tunjangan_struktural  = null;
        }else{
            $tunjangan_struktural  = $this->cipher->encrypt($this->input->post('tunjangan_struktural'));
        }

        if($this->input->post('potongan_jht') == null){
            $potongan_jht  = null;
        }else{            
            $potongan_jht  = $this->cipher->encrypt($this->input->post('potongan_jht'));
        }

        if($this->input->post('pot_btn') == null){
            $pot_btn  = null;
        }else{
            $pot_btn  = $this->cipher->encrypt($this->input->post('pot_btn'));
        }

        if($this->input->post('tas') == null){
            $tas = null;
        }else{
            $tas  = $this->cipher->encrypt($this->input->post('tas'));
        }

        if($this->input->post('jaminan_pensiun') == null){
            $jaminan_pensiun = null;
        }else{
            $jaminan_pensiun  = $this->cipher->encrypt($this->input->post('jaminan_pensiun'));
        }

        if($this->input->post('tunai') == null){
            $tunai  = null;
        }else{
            
            $tunai  = $this->cipher->encrypt($this->input->post('tunai'));
        }

        if($this->input->post('penyesuaian') == null){
            $penyesuaian  = null;
        }else{            
            $penyesuaian  = $this->cipher->encrypt($this->input->post('penyesuaian'));
        }

        if($this->input->post('bpjs_kesehatan') == null){
            $bpjs_kesehatan = null;
        }else{
            $bpjs_kesehatan  = $this->cipher->encrypt($this->input->post('bpjs_kesehatan'));
        }

        if($this->input->post('jml_potongan') == null){
            $jml_potongan = null;
        }else{
            $jml_potongan  = $this->cipher->encrypt($this->input->post('jml_potongan'));
        }

        if($this->input->post('gross') == null){
            $gross = null;
        }else{
            $gross  = $this->cipher->encrypt($this->input->post('gross'));
        }

        if($this->input->post('status_gaji') == null){
            $status_gaji = null;
        }else{
            $status_gaji  = $this->cipher->encrypt($this->input->post('status_gaji'));
        }

        if($this->input->post('maxgross') == null){
            $maxgross  = null;
        }else{
            $maxgross  = $this->cipher->encrypt($this->input->post('maxgross'));
        }

        if($this->input->post('pajak')){
            $pajak = null;
        }else{
            $pajak  = $this->cipher->encrypt($this->input->post('pajak'));
        }

        if($this->input->post('jumlah_terima') == null){
            $jumlah_terima  = null;
        }else{            
            $jumlah_terima  = $this->cipher->encrypt($this->input->post('jumlah_terima'));
        }

        if($this->input->post('honor') == null){
            $honor = null;
        }else{
            $honor  = $this->cipher->encrypt($this->input->post('honor'));
        }

        if($this->input->post('thr') == null){
            $thr = null;
        }else{
            $thr  = $this->cipher->encrypt($this->input->post('thr'));
        }

        if($this->input->post('lembur') == null){
            $lembur = null;
        }else{
            $lembur  = $this->cipher->encrypt($this->input->post('lembur'));
        }

        if($this->input->post('thp_bulat') == null){
            $thp_bulat - null;
        }else{
            $thp_bulat  = $this->cipher->encrypt($this->input->post('thp_bulat'));
        }

        if($this->input->post('pot_jkn_kelg') == null){
            $pot_jkn_kelg = null;
        }else{
            $pot_jkn_kelg  = $this->cipher->encrypt($this->input->post('pot_jkn_kelg'));
        }

        if($this->input->post('tf_cimb_niaga')){
            $tf_cimb_niaga  = $this->cipher->encrypt($this->input->post('tf_cimb_niaga'));
        }else{
            $tf_cimb_niaga  = null;
        }

        if($this->input->post('tf_bca')){
            $tf_bca  = $this->cipher->encrypt($this->input->post('tf_bca'));
        }else{
            $tf_bca  = null;
        }

        // tambahan detail potongan
        if($this->input->post('potongan_rs')){
            $potongan_rs  = $this->cipher->encrypt($this->input->post('potongan_rs'));
        }else{
            $potongan_rs  = null;
        }

        if($this->input->post('pot_jkn_kelg')){
            $pot_jkn_kelg  = $this->cipher->encrypt($this->input->post('pot_jkn_kelg'));
        }else{
            $pot_jkn_kelg  = null;
        }

        if($this->input->post('pot_btn')){
            $pot_jkn_kelg  = $this->cipher->encrypt($this->input->post('pot_btn'));
        }else{
            $pot_jkn_kelg  = null;
        }


        if($this->input->post('pot_koperasi')){
            $pot_jkn_kelg  = $this->cipher->encrypt($this->input->post('pot_koperasi'));
        }else{
            $pot_jkn_kelg  = null;
        }
// end tambahan detail potongan 
        $bulan = substr($periode, 0,2);
        $tahun = substr($periode, 3,4);

        $data = array(
            'bulan' => $bulan,
            'tahun'=>$tahun,
            // 'thp_bulat'=>$thp_bulat,
            // 'potongan'=>$potongan,
            // 'transfer_bank'=>$totaltransfer,
            'nik'=>$v_nik,
            'jenis'=>$jenis_gaji,

            'gapok'=>$gapok,
            'rapel'=>$rapel,
            'potongan_rs'=>$potongan_rs,
            'tunjangan_khusus'=>$tunjangan_khusus,
            'insentif'=>$insentif,
            'pot_koperasi'=>$pot_koperasi,
            'tunjangan_struktural'=>$tunjangan_struktural,
            'potongan_jht'=>$potongan_jht,
            'pot_btn'=>$pot_btn,
            'tas'=>$tas,
            'jaminan_pensiun'=>$jaminan_pensiun,
            'tunai'=>$tunai,
            'penyesuaian'=>$penyesuaian,
            'bpjs_kesehatan'=>$bpjs_kesehatan,
            'jml_potongan'=>$jml_potongan,            
            'gross'=>$gross,
            'status_gaji'=>$status_gaji,
            'maxgross'=>$maxgross,
            'pajak'=>$pajak,
            'jumlah_terima'=>$jumlah_terima,
            'honor'=>$honor,
            'thr'=>$thr,
            'lembur'=>$lembur,
            'thp_bulat'=>$thp_bulat,
            'pot_jkn_kelg'=>$pot_jkn_kelg,
            'tf_cimb_niaga'=>$tf_cimb_niaga,
            'tf_bca'=>$tf_bca,
             // tambahan detail potongan golongan xiii ke atas
             'potongan_rs'=>$potongan_rs,
             'pot_jkn_kelg'=>$pot_jkn_kelg,
             'pot_btn'=>$pot_btn,
             'pot_koperasi'=>$pot_koperasi,
            'v_who_create'=>$this->session->userdata('nik_payroll')
        );

        $sukses= $this->DataGajiKaryawan_model->insert_gaji($data);
        echo json_encode(array("code" => 200, "response" => $sukses));

    }

    public function cek_generate(){
        $periode    = $this->input->post('periode');  //bulan tahun
        $gol        = $this->input->post('gol');
        $jenis_gaji = $this->input->post('jenis_gaji');

        $bulan = substr($periode, 0,2);
        $tahun = substr($periode, 3,4);

        $list_datagajikaryawan=$this->DataGajiKaryawan_model->get_cek_data_gaji_karyawan($bulan, $tahun, $gol, $jenis_gaji);

        if($list_datagajikaryawan){
            echo json_encode($list_datagajikaryawan);
        }else{
            echo json_encode("kosong");
        }

    }

    //--generate personal

    public function cek_generate_personal(){
        $periode    = $this->input->post('periode');  //bulan tahun
        $nik        = $this->input->post('nik');
        $jenis_gaji = $this->input->post('jenis_gaji');

        $bulan = substr($periode, 0,2);
        $tahun = substr($periode, 3,4);

        $list_datagajikaryawan_personal=$this->DataGajiKaryawan_model->get_cek_data_gaji_karyawan_personal($bulan, $tahun, $nik, $jenis_gaji);

        if($list_datagajikaryawan_personal){
            echo json_encode($list_datagajikaryawan_personal);
        }else{
            echo json_encode("kosong");
        }

    }

        public function getPersonalGajiToGenerateXIIKeatas() {
        if ($this->input->post('periode') != null){
            $periode    = $this->input->post('periode');
            $nik        = $this->input->post('nik');
            $jenis_gaji = $this->input->post('jenis_gaji');

            $bulan = substr($periode, 0,2);
            $tahun = substr($periode, 3,4);

            $datagajikaryawanpersonal = $this->DataGajiKaryawan_model->get_data_gaji_karyawan_personal($bulan, $tahun, $nik, $jenis_gaji);
            
            if($datagajikaryawanpersonal){
                $karyawan = $datagajikaryawanpersonal;
                $data = array(
                    'v_nik' => $karyawan['v_nik'],
                    'v_employee_name' => $karyawan['v_employee_name'],
                    'v_unitrsnama' => $karyawan['v_unitrsnama'],
                    'nama_golongan' => $karyawan['nama_golongan'],
                    //'thpbulat' => $this->cipher->decrypt($karyawan['thpbulat']),
                    //'potongan' => $this->cipher->decrypt($karyawan['potongan']),
                    'gapok'=>$this->cipher->decrypt($karyawan['gapok']),
                    'rapel'=>$this->cipher->decrypt($karyawan['rapel']),
                    'potongan_rs'=>$this->cipher->decrypt($karyawan['potongan_rs']),
                    'tunjangan_khusus'=>$this->cipher->decrypt($karyawan['tunjangan_khusus']),
                    'insentif'=>$this->cipher->decrypt($karyawan['insentif']),
                    'pot_koperasi'=>$this->cipher->decrypt($karyawan['pot_koperasi']),
                    'tunjangan_struktural'=>$this->cipher->decrypt($karyawan['tunjangan_struktural']),
                    'potongan_jht'=>$this->cipher->decrypt($karyawan['potongan_jht']),
                    'pot_btn'=>$this->cipher->decrypt($karyawan['pot_btn']),
                    'tas'=>$this->cipher->decrypt($karyawan['tas']),
                    'jaminan_pensiun'=>$this->cipher->decrypt($karyawan['jaminan_pensiun']),
                    'tunai'=>$this->cipher->decrypt($karyawan['tunai']),
                    'penyesuaian'=>$this->cipher->decrypt($karyawan['penyesuaian']),
                    'bpjs_kesehatan'=>$this->cipher->decrypt($karyawan['bpjs_kesehatan']),
                    'jml_potongan'=>$this->cipher->decrypt($karyawan['jml_potongan']),
                    'gross'=>$this->cipher->decrypt($karyawan['gross']),
                    'status'=>$this->cipher->decrypt($karyawan['status']),
                    'maxgross'=>$this->cipher->decrypt($karyawan['maxgross']),
                    'pajak'=>$this->cipher->decrypt($karyawan['pajak']),
                    'jumlah_terima'=>$this->cipher->decrypt($karyawan['jumlah_terima']),
                    'honor'=>$this->cipher->decrypt($karyawan['honor']),
                    'thr'=>$this->cipher->decrypt($karyawan['thr']),
                    'lembur'=>$this->cipher->decrypt($karyawan['lembur']),
                    'thp_bulat'=>$this->cipher->decrypt($karyawan['thp_bulat']),
                    'pot_jkn_kelg'=>$this->cipher->decrypt($karyawan['pot_jkn_kelg']),
                    'tb_cimb_niaga'=>$this->cipher->decrypt($karyawan['tb_cimb_niaga']),
                    'tb_bca'=>$this->cipher->decrypt($karyawan['tb_bca'])
                );

                echo json_encode($data);

            }else{

                echo json_encode("kosong");
            }
            
        }
    }

    public function getPersonalGajiToGenerate() {
        if ($this->input->post('periode') != null){
            $periode    = $this->input->post('periode');
            $nik        = $this->input->post('nik');
            $jenis_gaji = $this->input->post('jenis_gaji');

            $bulan = substr($periode, 0,2);
            $tahun = substr($periode, 3,4);

            $datagajikaryawanpersonal = $this->DataGajiKaryawan_model->get_data_gaji_karyawan_personal($bulan, $tahun, $nik, $jenis_gaji);
            
            if($datagajikaryawanpersonal){
                $karyawan = $datagajikaryawanpersonal;

                $data = array(
                    'v_nik' => $karyawan['v_nik'],
                    'v_employee_name' => $karyawan['v_employee_name'],
                    'v_unitrsnama' => $karyawan['v_unitrsnama'],
                    'nama_golongan' => $karyawan['nama_golongan'],
                    //'thpbulat' => $this->cipher->decrypt($karyawan['thpbulat']),
                    //'potongan' => $this->cipher->decrypt($karyawan['potongan']),
                    'gapok'=>$this->cipher->decrypt($karyawan['gapok']),
                    'tunjangan_khusus'=>$this->cipher->decrypt($karyawan['tunjangan_khusus']),
                    'tunjangan_struktural'=>$this->cipher->decrypt($karyawan['tunjangan_struktural']),
                    'penyesuaian'=>$this->cipher->decrypt($karyawan['penyesuaian']),
                    'tas'=>$this->cipher->decrypt($karyawan['tas']),
                    'maxgross'=>$this->cipher->decrypt($karyawan['maxgross']),
                    'dinas_malam'=>$this->cipher->decrypt($karyawan['dinas_malam']),
                    'lembur'=>$this->cipher->decrypt($karyawan['lembur']),
                    'rapel'=>$this->cipher->decrypt($karyawan['rapel']),
                    'insentif'=>$this->cipher->decrypt($karyawan['insentif']),
                    'gross'=>$this->cipher->decrypt($karyawan['gross']),
                    'potongan_jht'=>$this->cipher->decrypt($karyawan['potongan_jht']),
                    'jaminan_pensiun'=>$this->cipher->decrypt($karyawan['jaminan_pensiun']),
                    'bpjs_kesehatan'=>$this->cipher->decrypt($karyawan['bpjs_kesehatan']),
                    'sta'=>$this->cipher->decrypt($karyawan['sta']),
                    'pajak'=>$this->cipher->decrypt($karyawan['pajak']),
                    'thp_bulat'=>$this->cipher->decrypt($karyawan['thp_bulat']),
                    'potongan_kopkar'=>$this->cipher->decrypt($karyawan['potongan_kopkar']),
                    'jml_potongan'=>$this->cipher->decrypt($karyawan['jml_potongan']),
                    'nominal_rek'=>$this->cipher->decrypt($karyawan['nominal_rek']),
                    'nominal_lain'=>$this->cipher->decrypt($karyawan['nominal_lain']),
                    'nominal_prr_btn'=>$this->cipher->decrypt($karyawan['nominal_prr_btn']),
                    'nominal_btnsolo'=>$this->cipher->decrypt($karyawan['nominal_btnsolo']),
                    'nominal_koperasi'=>$this->cipher->decrypt($karyawan['nominal_koperasi']),
                    'ket_rek_rs'=>$karyawan['ket_rek_rs'],
                    'ket_lain'=>$karyawan['ket_lain'],
                    'ket_prr_btn'=>$karyawan['ket_prr_btn'],
                    'ket_btn_solo'=>$karyawan['ket_btn_solo'],
                    'ket_koperasi'=>$karyawan['ket_koperasi'],
                    'jumlah_terima'=>$this->cipher->decrypt($karyawan['jumlah_terima']),
                    'titik_perubahan'=>$karyawan['titik_perubahan'],
                    'nominal_ekstra'=>$this->cipher->decrypt($karyawan['nominal_ekstra']),
                    'ket_ekstra'=>$karyawan['ket_ekstra'],
                    'jenis_ekstra'=>$karyawan['jenis_ekstra'],
                    'tf_cimb_niaga'=>$this->cipher->decrypt($karyawan['tf_cimb_niaga']),
                    'tf_bca'=>$this->cipher->decrypt($karyawan['tf_bca'])
                );

                echo json_encode($data);

            }else{

                echo json_encode("kosong");
            }
            
        }
    }

}