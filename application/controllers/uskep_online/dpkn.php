<?php
	$view = 'uskep_online/dpkn_v';
	// $position = $this->Administration_m->getPosition("PELAKSANA PENGADAAN");

	// if(!$position){
	// 	$this->noAccess("Hanya PELAKSANA PENGADAAN yang dapat membuat kontrak manual");
	// }

	$data = array();
	$this->db->where('is_locked', '0');
	$data['adm_user'] = $this->db->get('adm_user')->result_array();
	$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA");
	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();

	$arr_data = [];
	$arr_data['kode_spk'] = json_decode($this->input->get('data'))[0];
	$arr_data['pengadaan'] = json_decode($this->input->get('data'))[1];
	$arr_data['rfq'] = json_decode($this->input->get('data'))[3];
	$arr_data['proyek'] = $this->db->get_where('project_info', ['kode_spk' => json_decode($this->input->get('data'))[0]])->row('nama_spk');
	$arr_data['code_proyek'] = json_decode($this->input->get('data'))[0];
	$vendor = [];
	foreach (json_decode($this->input->get('data'))[2] as $key => $value) {
		$vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
		array_push($vendor, $vend);
	}
	$arr_data['vendor'] = $vendor;
	$arr_data['span'] = 2 * count($vendor);

	$data['import'] = $arr_data;

	$this->template($view,"USKEP ONLINE",$data);
?>
