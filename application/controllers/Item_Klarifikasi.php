<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class item_Klarifikasi extends Telescoope_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));
        $this->load->config('privy');

    }


    public function index($detailId = "")
    {
    
    }

    public function get_data($id = "")
    {
        $data = array();
        $this->db->where('rfq_no', $id);
        $this->db->order_by('id', 'asc');
        
        $res = $this->db->get('prc_tender_item_klarifikasi_penawaran')->result_array();
        $data['data'] = $res;
        echo json_encode($data);
    }

    public function insert_item($id = 0)
    {
       $post = json_decode($this->input->post('values'));
       $post->rfq_no = $id;
       $this->db->insert('prc_tender_item_klarifikasi_penawaran', $post);
       
       $code = 200;
       echo json_encode(array('code'=> $code));

    }

    public function update_item()
    {
       $post = json_decode($this->input->post('values'));
       $key = $this->input->post('key');

       $this->db->where('id', $key);
        
     
       $this->db->update('prc_tender_item_klarifikasi_penawaran', $post);
       $code = 200;
       echo json_encode(array('code'=> $code));
       
    }

    public function delete_item($id = 0)
    {
       $post = json_decode($this->input->post('values'));
       $key = $this->input->post('key');

       $this->db->where('id', $key);
    
       $this->db->delete('prc_tender_item_klarifikasi_penawaran');

       $code = 200;
       echo json_encode(array('code'=> $code));
       
    }


// detail


    public function get_detail($id = "")
    {
        $data = array();
        $this->db->where('kegiatan_id', $id);
        
        $res = $this->db->get('adm_matriks_kewenangan_kegiatan')->result_array();
        $data['data'] = $res;
        echo json_encode($data);
    }

    public function insert_detail($id = 0)
    {
       $post = json_decode($this->input->post('values'));
       $post->kegiatan_id = $id;
       $this->db->insert('adm_matriks_kewenangan_kegiatan', $post);
       
       $code = 200;
       echo json_encode(array('code'=> $code));

    }

    public function update_detail()
    {
       $post = json_decode($this->input->post('values'));
       $key = $this->input->post('key');

       $this->db->where('id', $key);
        
     
       $this->db->update('adm_matriks_kewenangan_kegiatan', $post);
       $code = 200;
       echo json_encode(array('code'=> $code));
       
    }

    public function delete_detail($id = 0)
    {
       $post = json_decode($this->input->post('values'));
       $key = $this->input->post('key');

       $this->db->where('id', $key);
    
       $this->db->delete('adm_matriks_kewenangan_kegiatan');

       $code = 200;
       echo json_encode(array('code'=> $code));
       
    }

    public function get_job_position()
    {
        $data = array();
        
        $res = $this->db->get('adm_pos')->result_array();
        $data['data'] = $res;
        echo json_encode($data);
    }


   

   

}

/* End of file PrivyTest.php */


?>