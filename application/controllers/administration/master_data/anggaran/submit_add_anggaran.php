<?php

$post = $this->input->post();

$userdata = $this->Administration_m->getLogin();

$data = array(
	'kode_perkiraan' => $post['kode_perkiraan'],
	'nama_perkiraan' => $post['nama_perkiraan'],
	'pusat' => $post['pusat'] == 't' ? 't' : 'f',
	'devisi' => $post['devisi'] == 't' ? 't' : 'f',
	'proyek' => $post['proyek'] == 't' ? 't' : 'f',
	'date_created' => date('Y-m-d h:i:s')
	);

$insert = $this->db->insert('adm_coa_new', $data);

if($insert){
	$this->setMessage("Berhasil menambah data anggaran");
}

redirect(site_url('administration/master_data/anggaran'));
