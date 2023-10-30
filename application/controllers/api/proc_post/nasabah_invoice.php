<?php 

$input = $this->input->post();
$nasabah =[
	'npwp_no' => $input['npwp_no'],
	'invoice_stat' => $input['invoice_stat']
]; 

$check = $this->Procurementapi_m->check_vnd($nasabah['npwp_no']);		

if ($check) {
	$insert = $this->Procurementapi_m->cust_code($check['vendor_id'], $nasabah['invoice_stat']);
	$response 	= [
		'status'	=> 200,
		'response'	=> 'Success',
		'data' 		=> $nasabah
	];
	$this->set_response($response, REST_Controller::HTTP_OK); 
}else{
	$response 	= [
		'status'	=> 404,
		'response'	=> 'Vendor name not found',
		'data' 		=> $nasabah
	];
	$this->set_response($response, REST_Controller::HTTP_NOT_FOUND); 
}

?>