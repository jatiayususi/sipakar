<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class UploadTunjangan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
        $this->load->model(array('Upload_model'));
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory','cipher'));
	}

	public function index()
	{
		$data['list_potongan'] = $this->Upload_model->get_list_master_potongan();
        $data['content']       = 'Upload_view';

		$this->load->view('template', $data);
	}

	public function getListUploadFile()
	{
		$list_upload = $this->Upload_model->get_list_all_tunjangan();

		$data = array(
            'list_upload' => $list_upload            
        );
        echo json_encode($data);
	}

	public function uploadFile(){

        if ($_FILES['file']['error'] != 4){

            $fileName = $_FILES['file']['name'];
             
            $config['upload_path']   = 'file/upload_excel';
            $config['file_name']     = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size']      = 10000;
            $config['overwrite']     = TRUE;
             
            $this->load->library('upload', $config);

            $n_potongan_id = $this->input->post('potongan_tambah');
            $bulan_tahun = $this->input->post('bulantahun_tambah');

            $bulan = substr($bulan_tahun,0,2);
            $tahun = substr($bulan_tahun,3,4);


            if($this->upload->do_upload("file")){
                $media = $this->upload->data();

                $inputFileName = 'file/upload_excel/'.$media['file_name'];
                 
                $data = array(
                    'v_nama_file'=>$fileName,
                    'v_lokasi_file'=>$inputFileName,
                    'n_potongan_id'=>$n_potongan_id,
                    'n_bulan'=>$bulan,
                    'n_tahun'=>$tahun
                 );
                
                $this->Upload_model->insert_upload($data);

                $n_upload_file_id=$this->db->insert_id();
                $this->upload_detail($n_upload_file_id,$inputFileName);

            }else{

            	echo $this->upload->display_errors();
            }

            $this->session->set_flashdata('berhasil', 'Berhasil Upload');
            redirect('Upload');
            //echo $this->upload->display_errors();
        } else {
            //echo $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload');
            redirect('Upload');
        }
    }

    public function upload_detail($n_upload_file_id,$inputFileName){

        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);

        } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            
            $cek = 0;
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                $nominalEncr=$this->cipher->encrypt($rowData[0][2]); 
                                                 
                //Sesuaikan sama nama kolom tabel di database                                
                $data = array(
                    //"n_isi_file_id"=> $rowData[0][0],
                    "n_upload_file_id"=> $n_upload_file_id,
                    "v_nik"=> $rowData[0][1],
                    "v_nominal"=> $nominalEncr
                );
                 
                //sesuaikan nama dengan nama tabel

                // $nik = $data['v_nik'];
                // $nik = $rowData[0][1];

                $ceknik = $this->Upload_model->get_cek_nik($rowData[0][1]);

                if($ceknik){
                    $insert = $this->db->insert("payroll.tb_isi_file",$data);
                }else{
                    $nik_salah .= $rowData[0][1].", ";
                    $cek++;
                }
                     
            }
            if ($cek > 0) {
                $nik_salah = trim($nik_salah, ", ");
                $this->session->set_flashdata('data_salah', 'NIK yang salah : '.$nik_salah);
            }
    }

    public function cari_detail(){
        $n_upload_file_id    = $this->input->post('n_upload_file_id');
            
        // $data['list_detail'] = $this->Upload_model->get_detail($n_upload_file_id);
        $dataEnc= $this->Upload_model->get_detail($n_upload_file_id);


        $dataDec = array();
        foreach ($dataEnc as $detail) {
            $dataDec[]=array(
                'v_unitrsnama' => $detail['v_unitrsnama'],
                'v_nik' => $detail['v_nik'],
                'v_employee_name'=>$detail['v_employee_name'],
                'v_nominal'=>$this->cipher->decrypt($detail['v_nominal'])
            );
        }

        echo json_encode($dataDec);
    }

    public function hapusFile(){
        $n_upload_file_id = $this->input->post('n_upload_file_id');

        $this->Upload_model->delete_isi_file($n_upload_file_id);
        $this->Upload_model->delete($n_upload_file_id);
    }

    /*public function lihatExcel()
    {
        $data['content'] = 'lihatExcel';
        $this->load->view('template', $data);
    }*/

}