<?php 

  $view = 'vendor/daftar_vendor/daftar_seluruh_vendor/daftar_seluruh_vendor_v';

  $data = array(
            'jumlah' =>1
          );

  $userdata = $this->data['userdata'];

  $curl = curl_init();    

  $data_token = array(
      // 'token' => '9401A056-B477-499D-AF52-FC3A4F573092'

      'token' => '7D67DB6F-8610-4566-BFB7-EB613EE7535B'
  );

  $payload_token = json_encode( $data_token );
  
  curl_setopt_array($curl, array(      
    CURLOPT_URL => "https://pdc-api.pengadaan.com:443/security/login",
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
    $accessToken = $obj_response->accessToken;
    $tokenType = $obj_response->tokenType;
  }

  // summay vendor

    $url_vendor_summary = "https://pdc-api.pengadaan.com:443/karya/dashboardSummary"; 

    $ch = curl_init($url_vendor_summary);        
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);    
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: ' . $tokenType . ' ' . $accessToken
    ));                                                                                                            
    
    $response_summary = curl_exec($ch);
    
    $arrays_summary = json_decode($response_summary, true);

    if (count($arrays_summary["data"]) < 1){
      return 'not_found';
    } 

    $datasummary = $arrays_summary["data"];

    curl_close($ch);
    
    if ($arrays_summary['resultCode'] != 200) {
      echo $arrays_summary['resultCode'];
      exit();
    }
  
    $data['totalVndActive'] = $datasummary['totalVndActive']; 
    $data['totalVndSuspend'] = $datasummary['totalVndSuspend']; 
    $data['totalVndWarning'] = $datasummary['totalVndWarning']; 
    $data['totalVndBlacklist'] = $datasummary['totalVndBlacklist']; 

  // end summary
  
  if ($userdata['job_title'] == 'PENGELOLA VENDOR') {
    $data['sync_btn'] = true;
  }
  
  $this->template($view,"Daftar Seluruh Vendor",$data);