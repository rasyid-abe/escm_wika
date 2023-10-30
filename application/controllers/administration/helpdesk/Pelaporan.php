<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaporan extends MY_Controller {

	public function __construct(){
        parent::__construct();
    }

	public function index()
	{
		$opts = 
		array('http' =>
			array(
				'method'  => 'GET',
				'header'  => "Content-Type: application/json\r\n".
				"Authorization: Bearer " . $this->session->userdata("token")."\r\n",
				'timeout' => 60
			)
		);
					
		$context = stream_context_create($opts);
		$url = $this->config->item('api_url').'api/v1/vendor/pelaporan';
		$get_url = file_get_contents($url, false, $context);

		$data = array();		
		$data['title'] = 'Pelaporan';
		$data['get_data'] = json_decode($get_url, true);

		$this->load->view('administration/helpdesk/pelaporan_v',$data);
	}
}
