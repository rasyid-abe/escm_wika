<?php

$cek = $this->db->where('id', $id)->get('ctr_gr_ses')->num_rows();

if($cek > 0){
	
    $this->db->where('id', $id)->delete('ctr_gr_ses');
    $this->setMessage("Data berhasil dihapus", "Success");

} else {

	$this->setMessage("Data tidak ditemukan", "Error");

}

redirect(site_url('contract/gr_ses'));
