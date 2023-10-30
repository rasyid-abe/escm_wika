<?php

$post= $this->input->post();

$id = $post['id'];

$userdata = $this->Administration_m->getLogin();

$data = array(
	'nama_perkiraan' => $post['nama_perkiraan'],
	'kode_perkiraan' => $post['kode_perkiraan'],
	'pusat' => $post['pusat'] == 't' ? 't' : 'f',
	'devisi' => $post['devisi'] == 't' ? 't' : 'f',
	'proyek' => $post['proyek'] == 't' ? 't' : 'f'
	);

$this->db->where('id', $id);
$update = $this->db->update('adm_coa_new', $data);

if($update){
	$this->setMessage("Berhasil mengubah data anggaran");
}

redirect(site_url('administration/master_data/anggaran'));
