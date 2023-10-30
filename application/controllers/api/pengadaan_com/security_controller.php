<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Security_controller extends CI_Controller {

    public function login() {
        $curl = curl_init();    


        $data_token = array(
            'token' => '9401A056-B477-499D-AF52-FC3A4F573092'
        );
    
        $payload_token = json_encode( $data_token );
        
        curl_setopt_array($curl, array(      
          CURLOPT_URL => "https://devpdc-api.pengadaan.com/security/login",
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
          return "cURL Error #:" . $err;
          exit();
        } else {
          $obj_response = json_decode($response_token);
        //   $accessToken = $obj_response->accessToken;
        //   $tokenType = $obj_response->tokenType;
          echo $obj_response;
        }
        
    }

}
