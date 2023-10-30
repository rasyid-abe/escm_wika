<?php 

// $error = false;

$token = $this->Contract_m->get_token_simpb();

$this->db->where("push", NULL);
$allpo = $this->Contract_m->getDataWO()->result_array();
$return = NULL;

foreach ($allpo as $key => $value) {
	$vendor = $this->db->where("vendor_id", $value['vendor_id'])->get("vnd_header")->row_array();
	$value['address'] = $vendor['address_street'];
	$value['country'] = $vendor['address_country'];
		 
	$ress = $this->Contract_m->push_simpb($token, $value);
	$return = $this->Contract_m->updateWOData($value['po_id'], array("push" => 1));
}
// var_dump($ress);
if ($return == NULL) {
	$this->setMessage("Tidak ada po yang dipush");
}else{
	$this->setMessage("Sukses push data po");
}
redirect(site_url('contract/work_order'));