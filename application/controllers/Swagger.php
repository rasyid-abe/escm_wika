<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Swagger extends CI_Controller {

	public function index(){
		if (THIS_ENV == 'DEV') {
			$this->load->view('swagger_api_docs/swagger_api_docs_v');
		}else{
			show_404();

		}
	}

	public function swagger_json()
	{
		if (THIS_ENV == 'DEV') {
		$this->load->view('swagger_api_docs/swagger_json');
		}else{
			show_404();

		}
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */