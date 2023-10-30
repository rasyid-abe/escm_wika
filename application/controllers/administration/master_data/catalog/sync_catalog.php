<?php

$this->load->model("Sinkron_Catalog_m");

$position = $this->Administration_m->getPosition("ADMIN");

if(!$position){
    $this->noAccess("Hanya Admin yang dapat melakukan Syncron Data");
}

$login_status = $this->Sinkron_Catalog_m->do_sinkron();

if ($login_status == 'success') {
	$status = 'success';
	$msg = 'Sukses mensinkronkan data';
	
} elseif ($login_status == 'fail') {
	$status = 'fail';
	$msg = 'Gagal mensinkronkan data';

} elseif ($login_status == 'not_found') {
	$status = 'not_found';
	$msg = 'Data tidak ditemukan';

} else {
	$status = 'error_ws';
	$msg = 'Terjadi kesalahan teknis';
}

redirect(site_url("administration/master_data/catalog?status=$status&msg=$msg"));