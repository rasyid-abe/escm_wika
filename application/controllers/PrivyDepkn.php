<?php

use phpDocumentor\Reflection\PseudoTypes\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class PrivyDepkn extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));
        $this->load->config('privy');
        $this->load->config('whatsapp');


    }


    public function index()
    {
        
    }

    public function send_message_wa($rfqNo,$privyId,$fullname = 'ADIP', $numberTo = '081316448288')
    {
        $ret = false;

        $url =  $this->config->item('URL');
        $numberFrom =  $this->config->item('SENDER');
        $api_key =  $this->config->item('API_KEY');
        $url_request = base_url()."/procurement/privy/request_sign_depkn/".$rfqNo."/".$privyId;
        $message = "hello ".$fullname.", SISTEM DEPKN sudah di share. untuk melalakukan e-sign, cek link berikut : ".$url_request;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "api_key": "'.$api_key.'",
            "sender": "'.$numberFrom.'",
            "number": "'.$numberTo.'",
            "message": "'.$message.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        if($response->status == true) {
            $ret = true;
        }

        return $ret;

    }

    public function upload_doc($rfqId)
    {
        
        # code...
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));

        $URL =  $this->config->item('URL_DEV_HASH').'/document/upload';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        //base64 imaage
        $getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();

        $path = base_url()."uploads/".$getDataUskep['filename_depkn'];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
        $dataUploadPrivy['title'] = "Test Document Upload and Share BAPK";
        $dataUploadPrivy['document'] = $base64;

        // $numberHp = [
        //     ['number' =>'083898435858'],
        //     ['number' =>'081314031553'],
        //     ['number' =>'081316448288']

        // ];

        $numberHp = [
            [
                'number' =>'083898435858',
                'name' =>'ADIP',
                'privy'=>'DEVWI6049'

            ],
            [
                'number' =>'081314031553',
                'name' =>'HAFIZH',
                'privy'=>'DEVWI6055'
            ],
            [
                'number' =>'081316448288',
                'name' =>'YUDI',
                'privy'=>'DEVWI6090'
            ]

        ];

        $recipients = [
            [
                'identifier' => 'DEVWI6055',
                'type' => 'signer',
                'pos_x' => 0,
                'pos_y' => 720,
                'page' => 1
            ],
            [
                'identifier' => 'DEVWI6090',
                'type' => 'signer',
                'pos_x' => 350,
                'pos_y' => 720,
                'page' => 1
            ],
            [
                'identifier' => 'DEVWI6049',
                'type' => 'signer',
                'pos_x' => 1053,
                'pos_y' => 720,
                'page' => 1
            ],

        ];
        //array 3 mengusulkan

        $dataUploadPrivy['recipients'] = $recipients;
        $body = [$dataUploadPrivy];
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


        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);
        if($res->status == "SUCCESS")
        {
            $data_update = array(
                'doc_token_depkn' => $res->data[0]->doc_token,
                'depkn_is_share' =>1
            );
            $this->Procrfq_m->updateDataUskep($rfqId, $data_update);
            foreach ($numberHp as $key => $value) {
                # code...
            $this->send_message_wa($rfqId,$value['privy']);

            }
        }


        echo $response;

    }

    public function sign_in_doc_request($rfqId,$privyId = "")
    {
        
        # code...
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
        
        $privyId = $privyId == "" ? "DEVWI6049" : $privyId; //testing;
        $URL =  $this->config->item('URL_DEV_HASH').'/document/sign';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        //base64 imaage
        $getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
        $docToken = $getDataUskep['doc_token_depkn'];

       

        $data['doc_token'] = $docToken;
        $data['identifier'] = $privyId;
        
        
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


        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);
       


        echo $response;

    }

    public function sign_in_doc_process($rfqId,$otp_code= "46979",$privyId = "")
    {
        
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
        $docToken = $getDataUskep['doc_token_depkn'];

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


        $response = curl_exec($curl);
        $response = trim(str_replace('\u0026', '&', $response));
        curl_close($curl);
        $res = json_decode($response);
       


        echo $response;

    }

    public function doc_detail($rfqId,$privyId = "")
    {
        
        # code...
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
        $privyId = "DEVWI0989"; //testing;
        $URL =  $this->config->item('URL_DEV_HASH').'/document/detail';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        //base64 imaage
        $getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
        $docToken = $getDataUskep['doc_token_depkn'];

       

        $data['doc_token'] = $docToken;
        //$data['identifier'] = $privyId;
        
        
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


        $response = curl_exec($curl);
        $response = trim(str_replace('\u0026', '&', $response));
        curl_close($curl);
        $res = json_decode($response);
       


        echo $response;

    }

    private function document_detail($rfqId,$privyId = "")
    {
        
        # code...
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
        $privyId = "DEVWI0989"; //testing;
        $URL =  $this->config->item('URL_DEV_HASH').'/document/detail';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        //base64 imaage
        $getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
        $docToken = $getDataUskep['doc_token_depkn'];

       

        $data['doc_token'] = $docToken;
        //$data['identifier'] = $privyId;
        
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


        $response = curl_exec($curl);
        $response = trim(str_replace('\u0026', '&', $response));
        curl_close($curl);
        $res = json_decode($response);
       


        return $res;

    }

    private function signature($jsonBody, $method, $timestamp)
    {
        # code...
        $clientId = $this->config->item('CLIENT_ID');
        $clientSecret = $this->config->item('CLIENT_SECRET');
        $jsonBody2 = json_encode($jsonBody);
        $jsonBody2 = trim(preg_replace('/\s/', '', $jsonBody2));
        $jsonBody2 = trim(preg_replace('/\n/', '', $jsonBody2));
        $jsonBody2 = trim(str_replace('\\', '', $jsonBody2));
        $bodyMD5 = md5($jsonBody2, true);
        $bodyMD5 = base64_encode($bodyMD5);

        $hmac_signature = $timestamp . ":" . $clientId . ":" . $method . ":" . $bodyMD5;
        $hmac = hash_hmac('sha256', $hmac_signature, $clientSecret, true);
        $hmac_base64 = base64_encode($hmac);

        $signature = "#" . $clientId . ":#" . $hmac_base64;
        $signature = base64_encode($signature);

        return $signature;
    }

    public function hook_upload()
    {
        # code...
        print_r($_POST);
        print_r($_GET);
        exit;


    }

    public function save_doc($rfqNo,$url = "https://stg-onpremise-minio.privy.id/staging-privy-onpremise-sdk/SDKHASHSIGN/signed/signed-hs256b2b-1271cf25-209e-c043d4c70e82004260d633ef74bf7d4258bde67a108c6f6ae392017428981f95?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=admin%2F20220224%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20220224T084226Z&X-Amz-Expires=172800&X-Amz-SignedHeaders=host&X-Amz-Signature=b3cffce20e26913536aaeb660f128c843b7b16b7aa008645f22ed5eafb291e0e")
    {
        $output_filename = "privy/penilaian/depkn_".$rfqNo.".pdf";
        $documentDetail = $this->document_detail($rfqNo);
        $host = $documentDetail->data->document_url->signed->url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
    
        // the following lines write the contents to a file in the same directory (provided permissions etc)
        $fp = fopen($output_filename, 'wb');
        fwrite($fp, $result);
        fclose($fp);

        $full_url = base_url().$output_filename;
        redirect($full_url);
            
    }

}

/* End of file PrivyTest.php */


?>