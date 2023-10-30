<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BumnKarya extends CI_Controller {
    var $post;
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->library('pengadaan_com/security_controller',null,"karya_security");
        $this->load->library('pengadaan_com/karya_controller',null,"karya");
        $this->post = $this->input->post();
		$this->load->model(array("Procedure2_m","Procedure3_m","Contract_m","Procrfq_m","Administration_m","Comment_m","Administration_m","Workflow_m","Addendum_m","Procplan_m","Procpr_m"));
    }

    public function post_vnd_performance()
    {
        
        $login = $this->karya_security->login();
        $accessToken = $login != null ? $login->accessToken : "";
        $tokenType = $login != null ? $login->tokenType : "";

        $push = $this->karya->pushVendorPerformance($accessToken,$tokenType,$this->post);

        if($push['status'] == 200)
        {
            $this->db->insert('vnd_vpi_push_performance', $this->post);   
        }

        echo json_encode($push);

    }

    public function post_vnd_contract()
    {
        
        $login = $this->karya_security->login();
        $accessToken = $login != null ? $login->accessToken : "";
        $tokenType = $login != null ? $login->tokenType : "";

        $contract = $this->Contract_m->getData($this->post['contract_id'])->row_array();
        // print_r($contract);
        // exit;
        $data = array(
            "contractDescription"=> $contract['subject_work'],
            "contractEndDate"=> date("Y-m-d\TH:i:s.000\Z", strtotime($contract['end_date'])),
            "contractNumber"=> $contract['contract_number'],
            "contractNumberMain"=> "string",
            "contractSignDate"=> date("Y-m-d\TH:i:s.000\Z", strtotime($contract['sign_date'])),
            "contractStartDate"=>date("Y-m-d\TH:i:s.000\Z", strtotime($contract['start_date'])),
            "contractTypeId"=> 0,
            "contractValue"=> $contract['contract_amount'],
            "currency"=> $contract['currency'],
            "vendorId"=> $contract['vendor_id'],
            "vendorNpwp"=> ""
        );

        $push = $this->karya->pushVendorContract($accessToken,$tokenType,$data);

        if($push['status'] == 200)
        {
            $this->db->insert('vnd_push_contract', $data);
            
        }
        
        echo json_encode($push);

    }

    public function get_vendor($id)
    {
        $this->db->where('vendor_id', $id);
        echo json_encode($this->db->get('vnd_header')->row_array());
        
    }

    public function get_vendor_performance($id)
    {
        # code...
        echo json_encode($this->db->where('vendorId', $id)->get('vnd_vpi_push_performance')->row_array());

    }


}

/* End of file PrivyTest.php */


?>