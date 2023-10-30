<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Base_Api_Controller.php';
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

use chriskacerguis\RestServer\RestController;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Auth extends Base_Api_Controller {

	public function __construct($config = 'rest'){

      	// Call the Model constructor
		parent::__construct($config);
		$this->load->model('sync_postgre_model');
		$this->load->model('Administration_m');

	}

	public function login_post(){               
		$exp = time() + 9800;
		$date = date("H:i:s d-M-Y", $exp);
		$token = array(
			"iss" => 'apprestservice',
			"aud" => 'lcts',
			"iat" => time(),
			"nbf" => time() + 10,
			"exp" => $exp,
			"data" => array(
				"username" => $this->input->post('username'),
				"password" => $this->input->post('password')
			)
		);       

		$check = $this->Administration_m->checkLogin($this->input->post('username'), $this->input->post('password'))->row_array();

		if(!empty($check)){

			if(empty($check['is_locked']) && empty($check['status'])){

			$jwt = JWT::encode($token, $this->configToken()['secretkey']);

			$data = array(
				'code' => 200, 
				'message' => 'Success generate token.', 
				'data' => array(
					'token' => $jwt, 
					'expired' => $date
				)
			);

			$this->response($data, 200); 

			} else {
			$data = array(
				'code' => 423, 
				'message' => 'Sorry, your account is suspended.'
			);

			$this->response($data, 423);
			}

		} else {
			$data = array(
			'code' => 404, 
			'message' => 'Wrong username and password.'
			);

			$this->response($data, 404);
		}
			
	}
}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */