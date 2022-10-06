<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class UploadGapok extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
        if ($this->session->userdata('is_login_payroll')== FALSE){
            redirect('Administrator');
        }
        $this->load->model(array('Gapok_model'));
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory','cipher'));

	}

	public function index()
	{
		$data['list_master_gapok'] = $this->Gapok_model->get_list_all();
        $data['content']='UploadGapok_view';

		$this->load->view('template', $data);
	}

	public function getListUploadFile()
	{
		$list_upload = $this->Gapok_model->get_list_all();

		$data = array(
            'list_upload' => $list_upload            
        );
        echo json_encode($data);
	}

	public function uploadMasterGapok(){
        // $this->db->trans_begin();
        if ($_FILES['file']['error'] != 4){
            $fileName = $_FILES['file']['name'];
            
            $config['upload_path']   = 'file/upload_excel';
            $config['file_name']     = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size']      = 10000;
            $config['overwrite']     = TRUE;
            
            $this->load->library('upload', $config);

            $tahun_berlaku = $this->input->post('tahun_berlaku');
            $keterangan = $this->input->post('text_keterangan');

            if($this->upload->do_upload("file")){
                $media = $this->upload->data();

                $FileGapokTmp = 'file/upload_excel/'.$media['file_name'];
                 
                $data = array(
                     'th_berlaku'=>$tahun_berlaku,
                     'v_keterangan'=>$keterangan,
                     'v_who_create'=>'2098'                     
                  );
                $this->db->trans_begin();
                $lastHeaderId=$this->Gapok_model->insert($data);
                $this->upload_detail($lastHeaderId,$FileGapokTmp);
                unlink($FileGapokTmp);
                $this->session->set_flashdata('berhasil', 'Berhasil Upload');
                redirect('UploadGapok');
                
            }else{
                // $this->db->trans_rollback();
                echo $this->upload->display_errors();
            }
           
        }
        else {
            $this->session->set_flashdata('gagal', 'Gagal Upload');
            redirect('UploadGapok');
        }
        // if ($this->db->trans_status() === FALSE)
        //     {
        //             $this->db->trans_rollback();
        //     }
        // else
        //     { 
        //             $this->db->trans_commit();
        //     }
    }

    public function upload_detail($n_header_gapok,$FileGapokTmp){
         try {
                $FileType = IOFactory::identify($FileGapokTmp);
                $objReader = IOFactory::createReader($FileType);
                $objPHPExcel = $objReader->load($FileGapokTmp);
            } 
        catch(Exception $e) {
                die('Error loading file "'.pathinfo($FileGapokTmp,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++){                  
        //  Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                            NULL,
                                            TRUE,
                                            FALSE);
            // echo "<pre>";
            // print_r($rowData);                           
            //Sesuaikan sama nama kolom tabel di database
            $golongan_id=$this->Gapok_model->getDataGolonganByKode(($rowData[0][0]))["id_golongan"];
            $golongan_enc=$this->cipher->encrypt($golongan_id);
            $bulan_gapok=$this->cipher->encrypt($rowData[0][1]); 
            $gapok=$this->cipher->encrypt($rowData[0][2]); 

            echo "golongan: ".$golongan_id;
            echo "<br>";
            echo "bulan_gapok: ".$bulan_gapok;
            echo "<br>";
            echo "nominal: ".$gapok;

            $detailGapok= array(
              "n_golongan_id"=>$golongan_id,
              "n_bulan_gapok"=>$bulan_gapok,
              "v_gapok"=>$gapok,
              "v_who_create"=>'2098',
              "n_gapok_header_id"=>$n_header_gapok
            );
            $this->Gapok_model->insertDetail($detailGapok);
        } 

    }

    public function cari_detail(){
        $header_id    = $this->input->post('n_header_id');
            
        $dataGapokEnc= $this->Gapok_model->get_detail($header_id);
        $dataGapokDec = array();
        foreach ($dataGapokEnc as $detailGapok) {
            $dataGapokDec[]=array(
                'gapok' => $this->cipher->decrypt($detailGapok['v_gapok']),
                'golongan'=>$detailGapok['nama_golongan'],
                'bulan_gapok'=>$this->cipher->decrypt($detailGapok['n_bulan_gapok']),
                'id_gapok'=>$detailGapok['n_gapok_id'] 
            );
        }

        echo json_encode($dataGapokDec);
    }

    public function hapusFile(){
        $n_header_id = $this->input->post('n_header_id');

        $this->Gapok_model->delete_isi_file($n_header_id);
        $this->Gapok_model->delete($n_header_id);
    }

    /*public function lihatExcel()
    {
        $data['content'] = 'lihatExcel';
        $this->load->view('template', $data);
    }*/

}