<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Template_petunjuk_score extends Telescoope_Controller {

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

    public function get_score($id = "")
    {
        $data = array();
        $this->db->where('detail_evaluasi_id', $id);
        
        $res = $this->db->get('prc_evaluation_petunjuk_score')->result_array();
        $data['data'] = $res;
        echo json_encode($data);
    }

    public function insert_score($id = 0)
    {
       $post = json_decode($this->input->post('values'));
       $post->detail_evaluasi_id = $id;
       $this->db->insert('prc_evaluation_petunjuk_score', $post);
       
       $code = 200;
       echo json_encode(array('code'=> $code));

    }

    public function update_score()
    {
       $post = json_decode($this->input->post('values'));
       $key = $this->input->post('key');

       $this->db->where('id', $key);
        
     
       $this->db->update('prc_evaluation_petunjuk_score', $post);
       $code = 200;
       echo json_encode(array('code'=> $code));
       
    }

    public function delete_score($id = 0)
    {
       $post = json_decode($this->input->post('values'));
       $key = $this->input->post('key');

       $this->db->where('id', $key);
    
       $this->db->delete('prc_evaluation_petunjuk_score');

       $code = 200;
       echo json_encode(array('code'=> $code));
       
    }

   

   

}

/* End of file PrivyTest.php */


?>