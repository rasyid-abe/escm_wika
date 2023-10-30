<?php

  	$get = $this->input->get();

	$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
	$limit = (isset($get['limit'])) ? $get['limit'] : 10;
	$offset = (isset($get['offset'])) ? $get['offset'] : 0;
	$vnd_id = (isset($get['vnd_id']) && !empty($get['vnd_id'])) ? $get['vnd_id'] : "";

	$ch = curl_init( UMKM_PADI );
	$page = $offset == 0 ? 1 : floor(($offset/$limit) + 1);
	
	$payload = json_encode( array( "get_transaksi" => array("size" => (int)$limit, "page" => (int)$page) ) );

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
		'Content-Type:application/json',
		'x-api-key:' . API_KEY_PADI,
		'User-Agent:WIKA_E-SCM_V2'
	));

	$result = curl_exec($ch);

	$res_padi = json_decode($result, true);

	$rows = $res_padi["data"];
  
	curl_close($ch);
  
	$data['rows'] = $rows;
  
	$data['total'] = $res_padi["count"];

	if(!empty($limit)){
		$this->db->limit($limit,$offset);
	}

	foreach ($rows as $key => $value) {
		$rows[$key]['transaksi_id'] = $rows[$key]['transaksi_id'];
	}

  	echo json_encode($data);

?>
