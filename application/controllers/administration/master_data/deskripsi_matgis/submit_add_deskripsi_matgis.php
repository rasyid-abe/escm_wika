<?php 

$post = $this->input->post();

$userdata = $this->data['userdata'];

$input = array(
		'label'=>$this->security->xss_clean($post['label_inp']),
		'status'=>2,
		'desc'=>$this->security->xss_clean($post['desc_inp'])
	);

$insert = $this->db->insert('adm_desc_matgis', $input); 

if($insert){

	$this->setMessage("Berhasil menambah deskripsi matgis");
	
}

redirect(site_url('administration/master_data/deskripsi_matgis'));
