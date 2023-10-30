<?php

$userdata = $this->data['userdata'];

$error = false;

$post = $this->input->post();

$ptm_number = $post['id'];

$activity = 1902;

$input = array();

$input2 = array('ptm_status'=>$activity);

$contract = $this->Procrfq_m->getCTRbyRFQ($ptm_number);

foreach ($contract as $key => $value) {
	
	$number = ($value['contract_number'] == NULL) ? "pengadaan ".$ptm_number : $value['contract_number'];

	if ($ptm_number != NULL && $value['ptm_number'] != NULL && $value['status'] != "2902") {
		$this->setMessage("Kontrak dengan no ".$number." harus dibatalkan terlebih dulu");
		$error = TRUE;
	}	
}

$this->db->trans_begin();

$update = $this->Procrfq_m->updateDataRFQ($ptm_number,$input2);

if($update){

	$input['ptm_number'] = $ptm_number;
	$input['ptc_pos_code'] = $userdata['pos_id'];
	$input['ptc_position'] =  $userdata['pos_name'];
	$input['ptc_name'] =  $userdata['complete_name'];
	$input['ptc_activity'] = $activity;
	$input['ptc_comment'] = $post['comment_inp'][0];
	$input['ptc_start_date'] = date("Y-m-d H:i:s");
	$input['ptc_response'] = "Pembatalan pengadaan melalui procurement tools";
	$this->db->insert("prc_tender_comment",$input);

}


if ($this->db->trans_status() === FALSE)
{
	$this->setMessage("Gagal mengubah data");
	$this->renderMessage("error");
	$this->db->trans_rollback();
}
else
{
	$this->db->trans_commit();
	$this->renderMessage("success");
}
