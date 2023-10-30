<?php

use phpDocumentor\Reflection\PseudoTypes\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class PrivyDPKN extends CI_Controller {

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

    public function send_message_wa($rfqNo,$privyId,$fullname,$numberTo)
    {
        $ret = false;

        $url =  $this->config->item('URL');
        $numberFrom =  $this->config->item('SENDER');
        $api_key =  $this->config->item('API_KEY');
        $url_request = base_url()."uskep_online/privyDPKN/".$rfqNo."/".$privyId;
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

    public function get_position_signer($path)
    {
        # code...
        $pdfKey = "";
        $data = array();
        $posY = 0;

        $parser = new \Smalot\PdfParser\Parser();

        $pdfParser = $parser->parseFile($path);
        $numberOfPage = count($pdfParser->getPages());

        $text = $pdfParser->getPages()[$numberOfPage-1]->getDataTm();

        foreach ($text as $key => $value) {
            foreach($value as $key2 => $v){
                if($v == "Catatan Komisi Pengadaan: ")
                {
                    $pdfKey = $key;
                }
            }
        }
        $posY = $text[$pdfKey][0][5];

        $data['pos_y'] = (int)(880 - $posY);
        $data['page'] = $numberOfPage;

        return $data;
    }

    public function upload_doc($rfqId)
    {
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));

        $URL =  $this->config->item('URL_DEV_HASH').'/document/upload';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        //base64 imaage
        $getDataUskep = $this->db->get_where('uskep_online', ['no_rfq' => $rfqId])->row_array();
        $path = base_url()."uploads/".$getDataUskep['dpkn_filename'];
        $pos = $this->get_position_signer($path);

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
        $dataUploadPrivy['title'] = "Test Document Upload and Share DEPKN";
        $dataUploadPrivy['document'] = $base64;

        $contact = [
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
            ],
            [
                'number' =>'082370678751',
                'name' =>'ABE',
                'privy'=>'DEVAB8751'
            ]

        ];

        // line x = 1250
        // line y1 = 83
        // line y2 = 150
        // line y3 = 217
        // line y4 = 284
        // line y5 = 351
        // line y6 = 418
        // line y7 = 485

        $recipients = [
            [
                'identifier' => 'DEVAB8751',
                'type' => 'signer',
                'pos_x' => 1250,
                'pos_y' => 83,
                'page' => $pos['page']
            ],
            [
                'identifier' => 'DEVWI6055',
                'type' => 'signer',
                'pos_x' => 1250,
                'pos_y' => 150,
                'page' => $pos['page']
            ],
            [
                'identifier' => 'DEVWI6090',
                'type' => 'signer',
                'pos_x' => 1250,
                'pos_y' => 217,
                'page' => $pos['page']
            ],
            [
                'identifier' => 'DEVWI6049',
                'type' => 'signer',
                'pos_x' => 1100,
                'pos_y' => 284,
                'page' => $pos['page']
            ],

        ];

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

        $notif = [];
        $notif['rfq_no'] = $rfqId;
        $notif['desc'] = 'Document DEPKN';
        $notif['status'] = 0;
        $notif['uskep_tipe'] = 'manual';

        curl_close($curl);
        $res = json_decode($response);
        if($res->status == "SUCCESS")
        {
            $data_update = array(
                'dpkn_doc_token' => $res->data[0]->doc_token,
				'dpkn_is_share' => 1
            );
            $this->db->where('no_rfq', $rfqId);
			$this->db->update('uskep_online', $data_update);

            foreach ($contact as $key => $value) {
                $this->send_message_wa($rfqId,$value['privy'],$value['name'],$value['number']);

                $notif['user_id'] = '123' . $key;
                $notif['privy_id'] = $value['privy'];
                $notif['url'] = "uskep_online/privyDPKN/".$rfqId."/".$value['privy'];
                $this->db->insert('prc_uskep_privy_status', $notif);
            }
            echo True;
        } else {
            echo False;
        }

    }

    public function sign_in_doc_request($rfqId,$privyId)
    {
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));

        $URL =  $this->config->item('URL_DEV_HASH').'/document/sign';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        //base64 imaage
        $getDataUskep = $this->db->get_where('uskep_online', ['no_rfq' => $rfqId])->row_array();
        $docToken = $getDataUskep['dpkn_doc_token'];

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

    public function sign_in_doc_process($rfqId,$otp_code,$privyId)
    {
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));

        $URL =  $this->config->item('URL_DEV_HASH').'/document/sign/process';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        //base64 imaage
        $getDataUskep = $this->db->get_where('uskep_online', ['no_rfq' => $rfqId])->row_array();
        $docToken = $getDataUskep['dpkn_doc_token'];

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

        if($res->status == "SUCCESS")
        {
            $data_update = array(
                'dpkn_status_esign' => json_encode($res->data),
            );
            $this->db->where('no_rfq', $rfqId);
			$this->db->update('uskep_online', $data_update);
        }

        echo $response;

    }

    private function signature($jsonBody, $method, $timestamp)
    {
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

    public function save_doc($rfqNo)
    {
        $getDataUskep = $this->db->get_where('uskep_online', ['no_rfq' => $rfqNo])->row_array();
        $doc = json_decode($getDataUskep['dpkn_status_esign']);
        if ($doc->status == 'IN_PROGRESS') {
            $url = $doc->document_url->processed->url;
        } else {
            $url = $doc->document_url->signed->url;
        }

        $output_filename = "privy/depkn/depkn_".$rfqNo.".pdf";
        $host = $url;

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
