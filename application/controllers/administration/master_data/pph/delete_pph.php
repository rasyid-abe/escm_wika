<?php

$data = array("status"=>0);
$this->db->where('id', $id);
$del = $this->db->update('adm_master_pph',$data); 

if($del){
	$this->setMessage("Berhasil menghapus data pph");
}

redirect(site_url('administration/master_data/pph'));