<?php 

$input = $this->input->post();

$user = $this->data['userdata'];

$id = $input['id'];

$query = $this->Vendor_m->getVendor($id)->row_array();
$activity = $this->Workflow_m->getActivity($input['activity_id'])->row_array();
$response = $this->Workflow_m->getResponse($input['status_inp'][0])->row_array();
$next_pos = $this->Administration_m->getPosbyJob("PENGELOLA VENDOR")->row_array();

$vendor_active_code = sprintf("%05s", $id) . '/SUB-WIKA-SCM/' . date('m') . '/' . date('Y');

$this->db->trans_begin();

if ($response['awr_name'] == 'Revisi') {

	$data = array(
		'status' => 0,
		'reg_status_id' => 0
	);	

	$vendor_com = [
		'vendor_id' => $input['id'],
		'vc_position' => $user['pos_id'],
		'vc_name' => $user['complete_name'],
		'vc_activity' => 'Revisi Registrasi Vendor',
		'vc_activity_code' => 6088,
		'vc_start_date' => date("Y-m-d H:i:s"),
		'vc_end_date' => date("Y-m-d H:i:s"),
		'vc_response' => $response['awr_name'],
		'vc_comment' => $input['comment_inp'][0],
		'vc_attachment' =>''
	];

	$act = $this->Vendor_m->updateVendor($id, $data);
	
	$com = $this->Comment_m->insertVendor($vendor_com);	

} else {
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
	
	if($input['reg_isactivate_inp'] == '1'){
		$data = array(
			'reg_isactivate' => $input['reg_isactivate_inp'],
			'status' => 9,
			'reg_status_id' => 8,
			'district_id'=> $input['district_inp'],
			'cot_id' => $input['cot_inp'][0],
			'vnd_cot' => implode(',', $input['cot_inp']),
			'cot_jenis' => $input['jenis_inp'],
			'cot_kelompok' => $input['jenis_inp'], //jenis dan kelompok disamakan
			'is_3pl_ins' => $input['is_3pl_ins_inp'],
			'vendor_code' => $vendor_active_code
			);
	
		$msg = "Dengan hormat,
		<br/>
		<br/>
		Bersama ini kami sampaikan bahwa ".COMPANY_NAME." telah mengaktifkan akun vendor login anda.
		untuk dapat berpartisipasi dalam pengadaan dapat diakses melalui <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a>. Akun ini terintegrasi dengan <a href='http://vendor.pengadaan.com' target='_blank'>vendor.pengadaan.com</a>.
		<br/>
		<br/>
		Salam,
		<br/>
		".COMPANY_NAME;
	
		$mail = $query['email_address'];
	
		$email = $this->sendEmail($mail,"Pemberitahuan Aktivasi Vendor",$msg);
	
	} else {
	
		$data = array(
			'reg_isactivate' =>$input['reg_isactivate_inp'],
			'status' => 0,
			'reg_status_id' => 0,
			'district_id'=> $input['district_inp'],
			'cot_id' => $input['cot_inp'][0],
			'vnd_cot' => implode(',', $input['cot_inp']),
			'cot_jenis' => $input['jenis_inp'],
			'cot_kelompok' => $input['jenis_inp'] 
		);	
	}
	
	$act = $this->Vendor_m->updateVendor($id, $data);
	
	$com = $this->Comment_m->insertVendor($vendor_com);	
}

if ($this->db->trans_status() === FALSE){
	$this->setMessage("Gagal mengubah data");
	$this->db->trans_rollback();
}else{
	$this->setMessage("Berhasil mengubah data");
	$this->db->trans_commit();
}

redirect(site_url('vendor/daftar_vendor/daftar_seluruh_vendor'));