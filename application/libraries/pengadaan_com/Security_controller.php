<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Security_controller  {
  protected $ci;
  var $datetime;
  var $data;

  public function __construct()
  {
      $this->ci =& get_instance();
      $this->datetime = date("c",strtotime(date('Y-m-d H:i:s')));
  }

    public function login() {

        $curl = curl_init();    

        $data_token = array(
          'token' => '7D67DB6F-8610-4566-BFB7-EB613EE7535B'
        );
    
        $payload_token = json_encode( $data_token );
        
        curl_setopt_array($curl, array(      
          CURLOPT_URL => "https://pdc-api.pengadaan.com/security/login",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $payload_token,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
          ),
        ));
    
        $response_token = curl_exec($curl);
        $err = curl_error($curl);	  
    
        curl_close($curl);  
    
        if ($err) {
          echo "cURL Error #:" . $err;
          $this->data = null;
          return $this->data;
          
        } else {
          $this->data = json_decode($response_token);
        
        }
        
        return $this->data;
    }

}
