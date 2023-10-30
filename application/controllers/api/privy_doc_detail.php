<?php

$rfqNo = $this->uri->segment(3, 0);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];

        $output_filename = "privy/penilaian/bakp_".$rfqNo.".pdf";
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
     $data = $full_url;

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
