<?php 

$input = $this->input->post();

$user = $this->data['userdata'];

$id = $input['id'];

$query = $this->Vendor_m->getVendor($id)->row_array();
$activity = $this->Workflow_m->getActivity($input['activity_id'])->row_array();
$response = $this->Workflow_m->getResponse($input['status_inp'][0])->row_array();
$next_pos = $this->Administration_m->getPosbyJob("PENGELOLA VENDOR")->row_array();

$next_state = ($input['status_inp'][0] == "611") ? 2 : 1;

$vendor_com = [
	'vendor_id' => $input['id'],
	'vc_position' => $user['pos_id'],
	'vc_name' => $user['complete_name'],
	'vc_activity' => $activity['awa_name'],
	'vc_activity_code' => $input['activity_id'],
	'vc_start_date' => date("Y-m-d H:i:s"),
	'vc_end_date' => date("Y-m-d H:i:s"),
	'vc_response' => $response['awr_name'],
	'vc_comment' => $input['comment_inp'][0],
	'vc_attachment' =>'',
	'vc_next_pos_code' => $next_pos['pos_id'],
	'vc_next_pos_name' => $next_pos['pos_name']
];


$this->db->trans_begin();

$data['state_now'] = $next_state;

$act = $this->Vendor_m->updateVendor($id, $data);

$com = $this->Comment_m->insertVendor($vendor_com);


if ($this->db->trans_status() === FALSE){
	$this->setMessage("Gagal mengubah data");
	$this->db->trans_rollback();
}else{
	$this->setMessage("Berhasil mengubah data");
	$this->db->trans_commit();
}

redirect(site_url('vendor/daftar_pekerjaan'));