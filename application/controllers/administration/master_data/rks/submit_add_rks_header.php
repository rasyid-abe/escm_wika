<?php

$post = $this->input->post();

$data = array(
	'header_main' => $post['header_main']
	);

$insert = $this->db->insert('adm_rks', $data);

if($insert){
	$this->setMessage("Berhasil menambah data rks header");
}

redirect(site_url('administration/master_data/rks'));
