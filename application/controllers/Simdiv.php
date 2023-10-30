<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// use Restserver\Libraries\REST_Controller;
require(APPPATH . 'libraries/REST_Controller.php');

class Simdiv extends REST_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
    }

    public function index_post(){

        $data2 = $this->post();
        $total_data = true;
        $data_null = false;

    	// $this->response(array('status' => $this->post(), 200));
        for($i = 0;$i<count($data2);$i++){
            if (count($data2[$i]) != 11) {
                $total_data = false;
            }
            // echo $i." ".count($os[$i])."<br>";
        }

        for($i=0;$i<11;$i++){
            if (in_array('', array_column($data2, $i))) {
                $data_null = true;
                if (in_array(null, array_column($data2, $i))) {
                    $data_null = true;
                }
            }
        }

        if ($data_null == true) {
          
            $this->response(array('status' => 'Terdapat data kosong!', 502));

        }elseif($total_data == false){

            $this->response(array('status' => 'Total data tidak sesuai!', 503));            

        }else{
    	$data = json_encode($this->post());
    	// echo $data;
    	$this->db->trans_begin();
    	$this->db->query("SELECT * FROM api_simdiv('".$data."')");
    	if ($this->db->trans_status() === FALSE)

		    {   
		        $this->db->trans_rollback();
		        $this->response(array('status' => 'fail', 502));
		    }else{
		        $this->db->trans_commit();
		        $this->response(array('status' => 'success', 200));
		    }
        }

    }

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */