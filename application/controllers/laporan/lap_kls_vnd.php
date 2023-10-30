<?php 

$view = 'laporan/lap_kls_vnd_v';

if($param == '1'){
	$this->session->unset_userdata("klasifikasi_gbl");
}

$komoditi=$this->db->get("vw_com_catalog")->result_array();
$kantor=$this->Administration_m->get_dist_name()->result_array();
$klasifikasi_gbl = $this->session->userdata("klasifikasi_gbl");
$data = array(
	'klasifikasi_gbl'=>$klasifikasi_gbl,
	);
// var_dump($data);
// die();
$this->template($view,"Klasifikasi Vendor",$data);
