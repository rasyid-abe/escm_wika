<?php

$userdata = $this->data['userdata'];

$error = false;

$post = $this->input->post();

$contract_id = $post['id'];

$activity = 2902;

$input = array();
$input2 = array('status'=>$activity);

$this->db->trans_begin();

$update = $this->Contract_m->updateData($contract_id,$input2);

if($update){

	$this->db->order_by("ccc_id", "desc");
	$com = $this->db->where("contract_id", $contract_id)->get("ctr_contract_comment")->row_array();

	$input['contract_id'] = $contract_id;
	$input['ptm_number'] = $post['ptm_number'];
	$input['ccc_pos_code'] = $userdata['pos_id'];
	$input['ccc_position'] =  $userdata['pos_name'];
	$input['ccc_name'] =  $userdata['complete_name'];
	$input['ccc_activity'] = $activity;
	$input['ccc_comment'] = $post['comment_inp'][0];
	$input['ccc_start_date'] = date("Y-m-d H:i:s");
	$input['ccc_response'] = "Pembatalan kontrak melalui tools";
	
	if ($com['ccc_user'] == NULL) {
		$this->db->where("ccc_id", $com['ccc_id'])->update("ctr_contract_comment", array("ccc_name"=>" ", "ccc_user"=>$userdata['employee_id']));
	}

	$this->db->insert("ctr_contract_comment",$input);

}

if ($this->db->trans_status() === FALSE || $error === TRUE)
{
	$this->db->trans_rollback();
	$this->setMessage("Gagal mengubah data");
	$this->renderMessage("error");
}
else
{
	$this->db->trans_commit();
	$this->renderMessage("success");
}
