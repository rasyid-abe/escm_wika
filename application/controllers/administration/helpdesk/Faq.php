<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends MY_Controller {

	public function __construct(){
        parent::__construct();
    }

	public function index()
	{		
		$url1 = $this->config->item('api_url').'api/v1/vendor/faq?page=0&size=10&sortBy=&sortValue=DESC&category=1';
		$url2 = $this->config->item('api_url').'api/v1/vendor/faq?page=0&size=10&sortBy=&sortValue=DESC&category=2';
		$url3 = $this->config->item('api_url').'api/v1/vendor/faq?page=0&size=10&sortBy=&sortValue=DESC&category=3';
		$url4 = $this->config->item('api_url').'api/v1/vendor/faq?page=0&size=10&sortBy=&sortValue=DESC&category=4';
		
		$get_url1 = file_get_contents($url1);
		$get_url2 = file_get_contents($url2);
		$get_url3 = file_get_contents($url3);
		$get_url4 = file_get_contents($url4);

		$data = array();		
		$data['title'] = '';
		$data['get_list1'] = json_decode($get_url1, true);
		$data['get_list2'] = json_decode($get_url2, true);
		$data['get_list3'] = json_decode($get_url3, true);
		$data['get_list4'] = json_decode($get_url4, true);

		$this->load->view('administration/helpdesk/faq_v',$data);
	}

	public function delete_faq( $id = null )
    {        
        $result = $this->db->delete('vnd_faq_helpdesk', array('faq_id' => $id));

        $this->session->set_flashdata('tab', 'del');
		if ($result) {
			$this->session->set_flashdata('res', '1');
			return redirect('administration/helpdesk/faq');
		} else {
			$this->session->set_flashdata('res', '2');
			return redirect('administration/helpdesk/faq');
		}  
    }
}
