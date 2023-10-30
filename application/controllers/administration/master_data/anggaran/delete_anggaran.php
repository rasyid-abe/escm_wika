<?php

$this->db->where('id', $id);
$del = $this->db->delete('adm_coa_new'); 

if($del){
	$this->setMessage("Berhasil menghapus data anggaran");
}

redirect(site_url('administration/master_data/anggaran'));
