<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Base_Api_Controller.php';
require_once APPPATH . '/libraries/REST_Controller.php';

class Privy extends Base_Api_Controller {

	public function __construct($config = 'rest'){

      	// Call the Model constructor
		parent::__construct($config);
		$this->load->model('sync_postgre_model');
		$this->load->model('Administration_m');

	}

	public function privy_get(){   		
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}
      
		if (true) {	
			

			$this->response([
				'status' => true,
				'total' => 0,
				'data' => []
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */