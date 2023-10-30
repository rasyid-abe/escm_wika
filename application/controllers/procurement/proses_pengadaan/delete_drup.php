<?php

$post = $this->input->post();

$this->db->where('id', $id);
$result = $this->db->delete('prc_proses_drup', array('id' => $id));

if($del){
	$this->setMessage("Berhasil menghapus data rks");
}

redirect(site_url('procurement/perencanaan_pengadaan/drup'));
