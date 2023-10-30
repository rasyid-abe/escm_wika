<?php

    use phpDocumentor\Reflection\PseudoTypes\False_;

    defined('BASEPATH') OR exit('No direct script access allowed');

    class TenderPo extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            //Do your magic here
            $this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));
            $this->load->config('privy');
            $this->load->config('whatsapp');


        }


        public function get_ajax_data()
        {
            $data = $this->db->get('prc_tender_po')->result_array();
            
            echo json_encode(array('data'=>$data));
        }

       

        public function update_contract_item_po($contract_id)
        {
            # code...
            $post = json_decode($this->input->post('values'));
            $key = $this->input->post('key');

            $this->db->where('contract_item_id', $key);
                
            $update = $this->db->update('ctr_contract_item', $post);
            $code = ($update) ? 200 : 400;

            $this->db->where('is_delete',0);
            $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            echo json_encode(array('code'=> $code,'data'=> $item2));

            
        }

        

        public function remove_contract_item_po($contract_id)
        {
            # code...
            $post = json_decode($this->input->post('values'));
            $key = $this->input->post('key');

            $this->db->where('contract_item_id', $key);
            $data['is_delete'] = 1;
            $update = $this->db->update('ctr_contract_item', $data);
            $code = ($update) ? 200 : 400;

            $this->db->where('is_delete',0);
            $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            echo json_encode(array('code'=> $code,'data'=> $item2));

            
        }

        


    }

?>