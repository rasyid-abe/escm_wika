<?php
	$view = 'uskep_online/dsp_v';
	// $position = $this->Administration_m->getPosition("PELAKSANA PENGADAAN");

	// if(!$position){
	// 	$this->noAccess("Hanya PELAKSANA PENGADAAN yang dapat membuat kontrak manual");
	// }

	$data = array();
	$this->db->where('is_locked', '0');
	$data['adm_user'] = $this->db->get('adm_user')->result_array();
	$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA");
	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();
	$data['person'] = $this->db->get('adm_user')->result_array();

	
	$this->template($view,"USKEP ONLINE",$data);
?>
