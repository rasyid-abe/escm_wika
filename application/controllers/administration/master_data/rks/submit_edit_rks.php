<?php

$id = $this->input->post('id');

$data = array(
	'header_main' => $post['header_main'],
	'header_sub' => $post['header_sub'],
	'description' => $post['description'],
	);

$this->db->where('id', $id);
$update = $this->db->update('adm_rks', $data);

if($update){
	$this->setMessage("Berhasil mengubah data rks");
}

redirect(site_url('administration/master_data/rks'));
