<?php 

$get = $this->input->get();

if (isset($get['smbd_code']) AND !empty($get['smbd_code']) AND isset($get['spk_code']) AND !empty($get['spk_code'])) {

	$this->db->select('ppi_periode_pengadaan');
	$this->db->where('ppi_code', $get['smbd_code']);
	$this->db->where('ppi_spk_code', $get['spk_code']);
	$check_pp = $this->db->get('prc_pr_item')->row_array();
	if (count($check_pp) == 1) {
		$existing_pp = explode(" , ", $check_pp['ppi_periode_pengadaan']);
	}else{
		$existing_pp = array("");
	}
	$this->db->select('periode_pengadaan');
	$this->db->where('smbd_code', substr($get['smbd_code'],3,6));
	$this->db->where('spk_code', $get['spk_code']);
	$this->db->where_not_in('periode_pengadaan', $existing_pp);
	$this->db->order_by('periode_pengadaan', 'asc');
	$pp = $this->db->get('prc_plan_integrasi')->result_array();
	$list['data']  = array();
	foreach ($pp as $key => $value) {
		// $list['data']['pp_id'] = $value['periode_pengadaan'];
		// $list['data']['pp_text'] = date_format(date_create($value['periode_pengadaan']),"d-M-Y");
		$array = array(
			'pp_id' => $value['periode_pengadaan'],
			'pp_text' => date_format(date_create($value['periode_pengadaan']),"d-M-Y")
		);
		array_push($list['data'], $array);
	}

	echo json_encode($list);
}else{
	$list['data']  = array();
	echo json_encode($list);
}
