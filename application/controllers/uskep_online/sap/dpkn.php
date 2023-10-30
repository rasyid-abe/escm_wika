<?php
	$view = 'uskep_online/dpkn_sap_v';
	$position = $this->Administration_m->getPosition("PELAKSANA PENGADAAN");

	if(!$position){
		$this->noAccess("Hanya PELAKSANA PENGADAAN yang dapat membuat kontrak manual");
	}

	$data = array();
	//$this->db->order_by("vendor_id", "asc");
	$data['bidderList'] = $this->db->get('vnd_header')->result_array();

	$data['winner'] = $win;
	$data['mtd'] = $mtd;
	$data['rfq'] = $this->Procrfq_m->getUrutRFQ();
	$data['k_spk'] = '';
	$data['k_proyek'] = '';

	$this->template($view,"USKEP ONLINE",$data);
?>
