<?php

$rfqNo = $this->input->post('rfq_no');
$privyId = $this->input->post('privy_id');
$otp_code = $this->input->post('otp_code');


$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];

  # code...
  $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
  $privyId = $privyId != "" ? $privyId : "DEVWI6049";

  $URL =  $this->config->item('URL_DEV_HASH').'/document/sign/process';
  $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
  $config['USERNAME'] = $this->config->item('USERNAME');
  $config['PASSWORD'] = $this->config->item('PASSWORD');
  $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
  $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
  $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

  //base64 imaage
  $getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
  $docToken = $getDataUskep['doc_token'];

  $data['doc_token'] = $docToken;
  $data['identifier'] = $privyId;
  $data['reason'] = "For testing only";
  $data['otp_code'] = $otp_code;
  
  $body = $data;
  $signature = $this->signature($body, 'POST', $timestamp);



  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => $URL,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_POST => 1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($body),
      CURLOPT_HTTPHEADER => array(
          'X-Authorization-Signature: ' . $signature,
          'X-Authorization-Timestamp: ' . $timestamp,
          'X-Flow-Process: default',
          'cache-control: no-cache',
          'Content-Type: application/json',
          'Merchant-Key:' . $config['MERCHANT_KEY'],
          'User-Agent: wika/1.0'
      ),
  ));

  $insert['rfq_no'] = $getDataUskep['rfq_number'];
  $insert['privy_id'] =  $privyId;
  $insert['type'] = 'BAKP';

  $this->db->insert('prc_tender_privy_sign', $insert);

  $this->db->where('rfq_no', $rfqId);
  $ttdList = $this->db->get('prc_tender_privy_sign')->result_array();
  $listTtd = explode(";",$getDataUskep['bakp_nip']);
  $recipients_wa = [];

  if(count($ttdList) > 0)
  {
       foreach ($listTtd as $key => $value) {
          # code...
          $this->db->where('nip', $value);
          $usr = $this->db->get('vw_user_employee_hcis')->row_array();
          
          if($usr != null)
          {
              
              if((count($listTtd) - 1) - count($ttdList) == $key)
              {
                  $recipients_wa = [
                      [
                          'number' =>"083898435858", //$usr['handphone_1'] != null ? str_replace("62","0",$usr['handphone_1']) : "0"  ,
                          'name' => $usr['nm_peg'],
                          'privy'=> $usr['signer_id']
          
                      ]
                  ];
              }

              


          }
      }

      foreach ($recipients_wa as $key => $value) {
          # code...
          $this->send_message_wa($rfqId,$value['privy'],$value['name'],$value['number']);
          
      }
  }
  



  $response = curl_exec($curl);
  $response = trim(str_replace('\u0026', '&', $response));
  curl_close($curl);
  $res = json_decode($response);
        

     $data = $res;

if ($data) {
    $this->response([
        'status' => true,
        'data' => $data,
    ], REST_Controller::HTTP_OK);
} else {
    $this->response([
        'status' => false,
        'message' => 'No data were found'
    ], REST_Controller::HTTP_NOT_FOUND);
}
