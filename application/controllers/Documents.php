<?php

use phpDocumentor\Reflection\PseudoTypes\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));
        $this->load->config('privy');
        $this->load->config('whatsapp');
    }

    public function Uploads_Doc($type,$rfqNo)
    {
        # code..
			$status = "";
            $messages = "";
            $dir = $type == '1' ? './uploads/surat_pemenang/':'./uploads/surat_penunjuk/';

            if (!file_exists($dir)){
				mkdir($dir, 0777, true);
			}
            $config['upload_path'] = $dir;
            $config['allowed_types'] = 'pdf';
			$config['encrypt_name'] = true;
			$config['max_size'] = 10120; //y max file upload
          
			$this->load->library('upload', $config);

			if(!empty($_FILES['file_pemenang']['tmp_name'])){

				if ($this->upload->do_upload('file_pemenang')){
					$upl = $this->upload->data();
                    $insert['rfq_no'] = $rfqNo;
                    $insert['filename'] = $upl['file_name'];
                    $insert['tipe'] = $type;

                    $insert['upload_dt'] = date('Y-m-d H:i:s');

                    if($this->data_exits($rfqNo,$type))
                    {
                        $this->db->where('rfq_no', $rfqNo);
                        $this->db->update('prc_doc_pengumuman', $insert);
                        
                    } else {
                        $this->db->insert('prc_doc_pengumuman', $insert);
                        
                    }

					$message = "Berhasil";
					$status = "success";
				} else {
					$message = $this->upload->display_errors('', '');
					$status = "error";

				}

			} else {
				$message = "No file";
			}
      
            echo $status;
            //redirect(site_url("procurement/procurement_tools/monitor_pengadaan/lihat/".$rfqNo));
    }

    private function data_exits($rfqNo,$type)
    {
        # code...
        $ret = false;
        $this->db->where('rfq_no', $rfqNo);
        $this->db->where('tipe', $type);

        $data = $this->db->get('prc_doc_pengumuman')->row_array();
        
        if($data!= null) $ret = true;

        return $ret;
        
    }
}

?>