<?php 

$input = $this->input->post();
$user = $this->data['userdata'];
$id = $input['id'];

// $query = $this->db->where('vendor_id', $id)->get('vnd_header')->row_array();
$query = $this->Vendor_m->getVendor($id)->row_array();

$activity = $this->Workflow_m->getActivity($input['activity_id'])->row_array();
$response = $this->Workflow_m->getResponse($input['status_inp'][0])->row_array();
$next_pos = $this->Administration_m->getPosbyJob("PENGELOLA VENDOR")->row_array();

	// $vnd_name = substr($query['vendor_name'],0,1);
 //    $year = date("y");
 //    $getnumber = $this->db->select('customer_code')->where('customer_code is NOT NULL', NULL)->get('vnd_header')->num_rows();
 //    $number =$getnumber+1;
 //    $fixnum = str_pad($number, 3, "0", STR_PAD_LEFT);  
 //    $codefication= $vnd_name.$year.$fixnum;

if ($input['activity_id'] == "6090") {

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
	
	$stat['status'] = 7;
	$stat['reg_status_id'] = 13;
	$stat['cot_id'] = $input['cot_inp'];

	$act = $this->Vendor_m->updateVendor($id, $stat);

	if ($act) {
		$com = $this->Comment_m->insertVendor($vendor_com);
	}


}else{

	$this->db->trans_begin();

	$vendor_com = [
		'vendor_id' 		=> $input['id'],
		'vc_position'		=> $user['pos_id'],
		'vc_name' 			=> $user['complete_name'],
		'vc_activity' 		=> $activity['awa_name'],
		'vc_response' 		=> $response['awr_name'],
		'vc_activity_code' 	=> $input['activity_id'],
		'vc_start_date' 	=> date("Y-m-d H:i:s"),
		'vc_end_date' 		=> date("Y-m-d H:i:s"),
		'vc_comment' 		=> $input['comment_inp'][0],
		'vc_attachment' 	=>'',
		'vc_active' 		=> $input['reg_isactivate_inp']
	];

	if($input['reg_isactivate_inp'] == '1'){
		$data = array(
			'reg_isactivate' => $input['reg_isactivate_inp'],
			'status' => 9,
			'reg_status_id' => 8,
			'district_id'=> $input['district_inp'],
			'survey_date' => ($input['survey_date_inp'] == "" ) ? NULL : $input['survey_date_inp'],
			'cot_id' => $input['cot_inp']
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

	}else {

		$data = array(
			'reg_isactivate' =>$input['reg_isactivate_inp'],
			'status' => 0,
			'reg_status_id' => 0,
			'district_id'=> $input['district_inp'],
			'survey_date' => ($input['survey_date_inp'] == "" ) ? NULL : $input['survey_date_inp'],
			'cot_id' => $input['cot_inp']
		);	
	}
	
	$act = $this->Vendor_m->updateVendor($id, $data);

	if ($act) {
		// $com = $this->Comment_m->updateVendor($input['comment_id'], $vendor_com);
		$com = $this->Comment_m->insertVendor($vendor_com);
	}
}

if($com){	
	if ($this->db->trans_status() === FALSE){
		$this->setMessage("Gagal mengubah data");
		$this->db->trans_rollback();
	}else{
		$this->setMessage("Berhasil mengubah data");
		$this->db->trans_commit();
	}
}

redirect(site_url('vendor/vendor_tools/aktivasi_vendor'));