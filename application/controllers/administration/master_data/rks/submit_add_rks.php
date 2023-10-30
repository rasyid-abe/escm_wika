<?php

$post = $this->input->post();

$data = array(
	'header_main' => $post['header_main'],
	'header_sub' => $post['header_sub'],
	'description' => $post['description'],
	);

$insert = $this->db->insert('adm_rks', $data);

if($insert){
	$this->setMessage("Berhasil menambah data rks");
}

redirect(site_url('administration/master_data/rks'));
