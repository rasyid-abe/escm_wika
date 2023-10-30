<?php

use phpDocumentor\Reflection\PseudoTypes\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class PrivyDSP extends CI_Controller {

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
        $url_request = base_url()."uskep_online/privyDSP/".$rfqNo."/".$privyId;
        $message = "hello ".$fullname.", SISTEM PENILAIAN sudah di share. untuk melakukan e-sign, cek link berikut : ".$url_request;

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
        $posX = 475;
        $posY = 0;

        $parser = new \Smalot\PdfParser\Parser();

        $pdfParser = $parser->parseFile($path);
        $numberOfPage = count($pdfParser->getPages());

        $text = $pdfParser->getPages()[$numberOfPage-1]->getDataTm();
        $p = end($text);
        // foreach ($text as $key => $value) {
        //     foreach($value as $key2 => $v){
        //         if($v == "PERINGKAT")
        //         {
        //             $pdfKey = $key;
        //         }
        //     }
        // }
        // $posY = $text[$pdfKey][0][5] - 30;

        // $data['pos_x'] = $p[0][4];
        // $data['pos_y'] = $p[0][5];
        $data['pos_x'] = $posX;
        $data['pos_y'] = (int)(950 - $p[0][5]);
        $data['page'] = $numberOfPage;

        // echo "<pre>";
        // print_r($data);
        // die;

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

        $path = base_url()."uploads/".$getDataUskep['dsp_filename'];
        $pos = $this->get_position_signer($path);

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
        $dataUploadPrivy['title'] = "Test Document Upload and Share Penilaian";
        $dataUploadPrivy['document'] = $base64;

        $privyId = 'DEVWI6090';
        $recipients = [
            [
                'identifier' => $privyId,
                'type' => 'signer',
                'pos_x' => 475,
                'pos_y' => 35,
                'page' => $pos['page']
            ]
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
        $notif['user_id'] = '123';
        $notif['desc'] = 'Document Penilaian';
        $notif['status'] = 0;
        $notif['privy_id'] = $privyId;
        $notif['uskep_tipe'] = 'manual';
        $notif['url'] = "uskep_online/privyDSP/".$rfqId."/".$privyId;

        curl_close($curl);
        $res = json_decode($response);
        if($res->status == "SUCCESS")
        {
            $data_update = array(
                'dsp_doc_token' => $res->data[0]->doc_token,
				'dsp_is_share' => 1
            );
            $this->db->where('no_rfq', $rfqId);
			$this->db->update('uskep_online', $data_update);

            $this->send_message_wa($rfqId, $privyId, 'YUDI', '081316448288');

            $this->db->insert('prc_uskep_privy_status', $notif);

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
        $docToken = $getDataUskep['dsp_doc_token'];

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
        $docToken = $getDataUskep['dsp_doc_token'];

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
                'dsp_status_esign' => json_encode($res->data),
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
        $doc = json_decode($getDataUskep['dsp_status_esign']);
        $url = $doc->document_url->signed->url;

        $output_filename = "privy/penilaian/sistem_penilaian-".$rfqNo.".pdf";
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
