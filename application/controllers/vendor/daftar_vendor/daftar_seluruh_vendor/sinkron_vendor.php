<?php

$this->load->model("Sinkron_m");
$this->load->model("Auth_model");

$selection = $this->data['selection_vendor'];

$input_id_vendor = $this->input->post('vendor_id_sync');

$vendor_id = isset($input_id_vendor) ? $input_id_vendor : $vendor_id; 

$login_status = $this->Sinkron_m->do_sinkron($vendor_id);

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

redirect(site_url("vendor/daftar_vendor/daftar_seluruh_vendor?status=$status&msg=$msg"));