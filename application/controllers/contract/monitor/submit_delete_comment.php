<?php

	$error = false;

	$this->db->trans_begin();

	$this->db->where('id', $id);
	$contract_id = $this->db->get('ctr_comment_all_div')->row_array();

	$this->db->where('id', $id);
	$result = $this->db->delete('ctr_comment_all_div', array('id' => $id));
	
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
		redirect(site_url("contract/monitor/monitor_kontrak/lihat/" . $contract_id['cad_contract_id']));
	}

?>