<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Auth extends MY_Api {

 
    public function get_token_post() {
        
        $credential = $this->post('credential'); //Username Posted
        $client = $this->post('client'); //Username Posted
        $p = sha1($this->post('private_key')); //Pasword Posted //h9tH33xwjY
        $q = array('credential' => $credential); //For where query condition
        $kunci  = $this->config->item('thekey');

        $invalidLogin = ['status' => 'Invalid Login']; //Respon if login invalid
        $val    = $this->Api_m->get_user($q)->row(); //Model to get single data row from database base on username
        // var_dump($val);

        if($this->Api_m->get_user($q)->num_rows() == 0) {
            $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }

		$match = $val->private_key;   //Get password for user from database
        if($p == $match && $credential == $val->credential && $client == $val->client){  //Condition if password matched
        	$token['id'] = $val->id;  //From here
            $token['credential'] = $credential;
            $token['client'] = $client;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*1; //To here is to generate token, expired in 2 hour
            $output['status'] = 1; //To here is to generate token, expired in 2 hour
            $output['type'] = 'Bearer';
            $output['token'] = JWT::encode($token,$kunci); //This is the output token
            $output['expired_in']= 60*60*1; //To here is to generate token, expired in 2 hour
            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        } else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
        }
    }

}
