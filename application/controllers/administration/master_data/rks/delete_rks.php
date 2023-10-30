<?php

$this->db->where('id', $id);
$del = $this->db->delete('adm_rks');

if($del){
	$this->setMessage("Berhasil menghapus data rks");
}

redirect(site_url('administration/master_data/rks'));
