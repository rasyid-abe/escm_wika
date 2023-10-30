<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Karya_controller  {
  protected $ci;
  var $datetime;
  var $data;

  public function __construct()
  {
      $this->ci =& get_instance();
      $this->datetime = date("c",strtotime(date('Y-m-d H:i:s')));
  }

    public function getDashboard($accessToken,$tokenType) {

        $curl = curl_init();    
        
        curl_setopt_array($curl, array(      
          CURLOPT_URL => "https://pdc-api.pengadaan.com:443/karya/dashboardSummary",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $tokenType . ' ' . $accessToken
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

    public function getDashboardSummary($accessToken,$tokenType,$dateStart,$dateEnd) {

        $curl = curl_init();    
        
        curl_setopt_array($curl, array(      
          CURLOPT_URL => "https://pdc-api.pengadaan.com:443/karya/dashboardSummaryFilter?completedDateEnd=".$dateEnd."&completedDateFrom=".$dateStart,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $tokenType . ' ' . $accessToken
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

    public function pushVendorPerformance($accessToken,$tokenType,$dataPost)
    {
      # code...
      $curl = curl_init();    


      
        $payload = json_encode($dataPost);
        
        curl_setopt_array($curl, array(      
          CURLOPT_URL => "https://pdc-api.pengadaan.com:443/karya/pushVendorPerformance",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: ' . $tokenType . ' ' . $accessToken
          ),
        ));
    
        $response_token = curl_exec($curl);
        $err = curl_error($curl);	  
    
        curl_close($curl);  
    
        if ($err) {
         
          $this->data = array(
            'status' => 500,
            'message' => $err
          );
          
          
        } else {
          $res =  json_decode($response_token);
          $this->data = array(
              'status' => isset($res->resultCode) ? $res->resultCode : $res->status,
              'message' => isset($res->resultCode) ? "Push Pengadaan.com Berhasil" : $res->message,
          );
        
        }
        
        return $this->data;
    }


    public function pushVendorContract($accessToken,$tokenType,$dataPost)
    {
      # code...
      $curl = curl_init();    

        $payload = json_encode($dataPost);
        
        curl_setopt_array($curl, array(      
          CURLOPT_URL => "https://pdc-api.pengadaan.com:443/karya/pushContract",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: ' . $tokenType . ' ' . $accessToken
          ),
        ));
    
        $response_token = curl_exec($curl);
        $err = curl_error($curl);	  
    
        curl_close($curl);  
    
        if ($err) {
         
          $this->data = array(
            'status' => 500,
            'message' => $err
          );
          
          
        } else {
          $res =  json_decode($response_token);
          $this->data = array(
              'status' => isset($res->resultCode) ? $res->resultCode : $res->status,
              'message' => isset($res->resultCode) ? "Push Pengadaan.com Berhasil" : $res->message,
          );
        
        }
        
        return $this->data;
    }
}
