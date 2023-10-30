<?php

	$userdata = $this->data['userdata'];

	$error = false;

	$post = $this->input->post();

	$input = array();

	$this->db->trans_begin();

	$input['cad_contract_id'] = $post['cad_contract_id'];
	$input['cad_ptm_number'] = $post['cad_ptm_number'];
	$input['cad_comment'] = $post['cad_comment'];
	$input['cad_user_id'] = $userdata['pos_id'];
	$input['cad_position'] =  $userdata['pos_name'];
	$input['cad_user_name'] =  $userdata['complete_name'];
	$input['cad_created_date'] = date("Y-m-d H:i:s");
	$input['cad_obj_nilai'] = $post['cad_obj_nilai'];
	$input['cad_lampiran'] = $post['cad_lampiran'];
	$input['cad_respon'] = $post['cad_respon'];
	$input['cad_no_telp'] = $post['cad_no_telp'];
	$input['cad_divisi'] = $userdata['dept_name'];

	$act = $this->db->insert("ctr_comment_all_div", $input);	

	if ($this->db->trans_status() === FALSE)
	{
		$this->db->trans_rollback();
		$this->setMessage("Gagal mengubah data");
		$this->renderMessage("error");
	}

	else
	{
		$this->db->trans_commit();
		$this->setMessage("Berhasil mengubah data");
		$this->renderMessage("success");		
		redirect(site_url("contract/monitor/monitor_kontrak/lihat/" . $post['cad_contract_id'] . "#form-comment"));
	}

?>