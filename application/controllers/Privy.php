<?php

use phpDocumentor\Reflection\PseudoTypes\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class Privy extends CI_Controller {

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
        $url_request = base_url()."procurement/privy/request_sign_bakp?rfqno=".$rfqNo."&privyid=".$privyId;
        $message = "hello ".$fullname.", SISTEM USKEP ONLINE sudah di share. untuk melalakukan e-sign, cek link berikut : ".$url_request;

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

    public function get_position_signer_penilaian($path)
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
        
        foreach ($text as $key => $value) {
            # code...
            foreach($value as $key2 => $v){
                if($v == "PERINGKAT")
                {
                    $pdfKey = $key;                
                }
            }
        }
        $posY = $text[$pdfKey][0][5] - 30;

        $data['pos_x'] = $posX;
        $data['pos_y'] = $posY;
        $data['page'] = $numberOfPage;

        // print_r($text);
        // exit;
        return $data;
    }

    public function get_count_page($path)
    {
        $parser = new \Smalot\PdfParser\Parser();

        $pdfParser = $parser->parseFile($path);
        $numberOfPage = count($pdfParser->getPages());
        
       
        return $numberOfPage;
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

        $path = base_url()."uploads/".$getDataUskep['filename'];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
        $dataUploadPrivy['title'] = "Test Document Upload and Share BAPK";
        $dataUploadPrivy['document'] = $base64;

        $page = $this->get_count_page($path);
        $listTtd = explode(";",$getDataUskep['bakp_nip']);
        $penilaian_ttd = explode("-",$getDataUskep['penilaian_ttd']);

        $recipients = [];
        $recipientsPenilaian = [];
        $recipientsBAKP = [];

        $recipients_wa = [];
        $recipients_wa_penilaian = [];

        // get start position y
        $this->db->where('key_number', '1');
        $this->db->where('tipe_uskep', "BAKP");
        $posBAKP = $this->db->get('adm_privy_pos_sign')->row_array();
        
        $pos_y_bakp = $posBAKP['pos_y'];
        $pos_x_penilaian = $posBAKP['pos_x'];
        $pos_y_penilaian = $posBAKP['pos_y'];

        foreach ($listTtd as $key => $value) {
            # code...
            $this->db->where('nip', $value);
            $usr = $this->db->get('vw_user_employee_hcis')->row_array();
            
            if($usr != null)
            {
                //get_position
                $position[0]["pos_x"] = (int)$posBAKP['pos_x'];
                $position[0]["pos_y"] = (int)$pos_y_bakp;
                $position[0]["page"] = $page - 2;
                $position[1]["pos_x"] = (int)$posBAKP['pos_x'];
                $position[1]["pos_y"] = (int)$pos_y_bakp;
                $position[1]["page"] = $page;
                
                $recipientsBAKP[$key]['identifier'] = $usr['signer_id'];
                    $recipientsBAKP[$key]['type'] = 'signer';
                    $recipientsBAKP[$key]['sign_multiple'] = 'true';
                    $recipientsBAKP[$key]['signature_number'] = 2;
                    $recipientsBAKP[$key]['positions'] = $position;

                if((count($listTtd) - 1) == $key)
                {
                    $recipients_wa = [
                        [
                            'number' =>$usr['handphone_1'] != null ? $usr['handphone_1'] : "083898435858",//0895338684277 //$usr['handphone_1'] != null ? str_replace("62","0",$usr['handphone_1']) : "0"  ,
                            'name' => $usr['nm_peg'],
                            'privy'=> $usr['signer_id']
            
                        ]
                    ];
                }

                $pos_y_bakp = $pos_y_bakp + $posBAKP['div_pos'];


            }
        }
       
        //set signer penilaian
        //rifan TWD4277
        $this->db->where('nm_peg', $penilaian_ttd[0]);
        $signer = $this->db->get('vw_user_employee_hcis')->row_array();

        $recipientsPenilaian = [
            [
                'identifier' => $signer != null ? $signer['signer_id'] : "",
                'type' => 'signer',
                'pos_x' => $pos_x_penilaian,
                'pos_y' => $pos_y_penilaian,
                'page' => $page - 1
            ]
        ];

        $recipients_wa_penilaian = [
            [
                'number' => $signer['handphone_1'] != null ? str_replace("62","0",$usr['handphone_1']) : "0"  ,
                'name' => $signer['nm_peg'],
                'privy'=> $signer['signer_id']

            ]
        ];

        $mergeRecipients = $recipientsBAKP;
        // if($signer != NULL)
        // {
        //     $mergeRecipients = array_merge($recipientsBAKP,$recipientsPenilaian);

        // }

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

        
        $recipients = $mergeRecipients;
        // $recipients = [
        //     [
        //         'identifier' => 'DEVWI6049',
        //         'type' => 'signer',
        //         'pos_x' => 320,
        //         'pos_y' => 113,
        //         'page' => $page - 2
        //     ],
        //     [
        //         'identifier' => 'DEVWI6090',
        //         'type' => 'signer',
        //         'pos_x' => 320,
        //         'pos_y' => 187,
        //         'page' => $page - 2
        //     ],
        //     [
        //         'identifier' => 'DEVWI6055',
        //         'type' => 'signer',
        //         'pos_x' => 320,
        //         'pos_y' => 261,
        //         'page' => $page - 2
        //     ],

        // ];

       

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
                'doc_token' => $res->data[0]->doc_token,
                'bakp_is_share' =>1
            );
            $this->Procrfq_m->updateDataUskep($rfqId, $data_update);
            foreach ($recipients_wa as $key => $value) {
                # code...
            $this->send_message_wa($rfqId,$value['privy'],$value['name'],$value['number']);

            }


            // foreach ($recipients_wa_penilaian as $key => $value) {
            //     # code...
            // $this->send_message_wa($rfqId,$value['privy'],$value['name'],$value['number']);

            // }

        }


        echo $response;

    }

    public function sign_in_doc_request($rfqId,$privyId = "")
    {
        
        # code...
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
        $privyId = $privyId != "" ? $privyId : "DEVWI6049"; //testing;
        $URL =  $this->config->item('URL_DEV_HASH').'/document/sign';
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
        $docToken = $getDataUskep['doc_token'];

       

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

    public function registration()
    {
        
        # code...
        $timestamp = date("c",strtotime(date('Y-m-d H:i:s')));

        $URL =  $this->config->item('URL_DEV_REG').'/registration';
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
		$config['USERNAME'] = $this->config->item('USERNAME');
        $config['PASSWORD'] = $this->config->item('PASSWORD');
        $config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
        $config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
        $config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

        $post = $this->input->post();
        
        $identity['nik'] = $post['nik'];
        $identity['nama'] = $post['nama'];
        $identity['tanggalLahir'] = $post['tanggal_lahir'];

        

     
        $dataRegister['email'] = $post['email'];
        $dataRegister['phone'] = $post['phone'];
        $dataRegister['selfie'] = $_FILES['selfie']['name'];
        $dataRegister['ktp'] = $_FILES['ktp']['name'];
        $dataRegister['identity'] = json_encode($identity);

        $body = $dataRegister;

      
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
                //'X-Authorization-Signature: ' . $signature,
                'X-Authorization-Timestamp: ' . $timestamp,
                'X-Flow-Process: default',
                'cache-control: no-cache',
                'Content-Type: form-data',
                'Merchant-Key:' . $config['MERCHANT_KEY'],
                'User-Agent: wika/1.0'
            ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);
       
        var_dump($response);
        exit;


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
        $docToken = $getDataUskep['doc_token'];

       

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
		$output_filename = "uploads/USKEP_BAKP_".$rfqNo.".pdf";
        $documentDetail = $this->document_detail($rfqNo);
        $host = $documentDetail->data->document_url->signed->url == "" ? $documentDetail->data->document_url->original->url : $documentDetail->data->document_url->signed->url ;

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