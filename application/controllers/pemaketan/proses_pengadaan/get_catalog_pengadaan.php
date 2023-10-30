<?php

$error = false;

$this->db->trans_begin();

$url = "https://dev-ecatalog.scmwika.com/api_new/Product";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization:' . $_COOKIE["e_catalog_api"]
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$response = json_decode($result, true);

echo json_encode($response);
