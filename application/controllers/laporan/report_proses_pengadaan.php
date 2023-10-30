<?php 
$view = 'laporan/report_proses_pengadaan_v';
$data = array();

$method_label = array(0=>"Penunjukkan Langsung",1=>"Pemilihan Langsung",2=>"Pelelangan");
$method = $this->db->select("count(ptp_id) as total,ptp_tender_method")->where("ptp_tender_method is not null")->group_by("ptp_tender_method")->get('prc_tender_prep')->result_array();
foreach ($method as $key => $value) {
	$method[$key]['label'] = $method_label[$value['ptp_tender_method']];
}

$data['top_proc_method'] = $method;

$this->template($view,"Rekap Jumlah Paket Pengadaan",$data);
?>