<?php 

$check = $this->Vendor_m->getVndDoc($id)->row();

if ($type == 'aktif') { //mengaktifkan
	$description = "Mengaktifkan Data";
	$this->db->where('vtm_id', $check->vtm_id);
	$this->Vendor_m->updateVndDoc("", array("status"=>"Non Aktif"));

	$result = $this->Vendor_m->updateVndDoc($id, array("status"=>"Aktif"));	
}else{

	$description = "Menonaktifkan Data";
	$result = $this->Vendor_m->updateVndDoc($id, array("status"=>"Non Aktif"));
}

if ($result) {
	$this->setMessage("Berhasil $description");
}else{
	$this->setMessage("Gagal $description");
}

redirect(site_url('vendor/vendor_tools/doc_vendor'));