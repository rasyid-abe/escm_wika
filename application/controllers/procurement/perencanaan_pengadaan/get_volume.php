<?php 

$get = $this->input->get();

if (!empty($get['smbd_code'])) {
	$this->db->select('ppm_id');
    $this->db->distinct();
    $this->db->where('ppm_project_id', $get['spk_code']);
    $perencanaan = $this->db->get('prc_plan_main')->row_array();

	$this->db->order_by('ppv_id', 'desc');
	$this->db->select('ppv_remain');
	$this->db->where('ppv_smbd_code', $get['smbd_code']);
	$this->db->where('ppm_id', $perencanaan['ppm_id']);
	$this->db->limit(1);
	$result = $this->db->get('prc_plan_volume')->result_array();

	$data['rows'] = $result;

	echo json_encode($data);
}

