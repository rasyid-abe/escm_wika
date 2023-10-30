<?php

$post = $this->input->post();

$data = array (
			'header_main' => $this->input->post('header_main'),
			'header_sub' => $this->input->post('header_sub'),
			'created_at' => date('Y-m-d h:i:s')
		);

$insert = $this->db->insert('adm_rks', $data);

if($insert){
	$this->setMessage("Berhasil menambah data");
}

redirect(site_url('administration/master_data/rks'));
