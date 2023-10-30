<?php 
$view = 'laporan/report_durasi_proses_v';
$data = array();

$method_label = array(0=>"Penunjukkan Langsung",1=>"Pemilihan Langsung",2=>"Pelelangan");
$method = $this->db->get('vw_rata_durasi_proses')->result_array();
foreach ($method as $key => $value) {
	$method[$key]['label'] = $method_label[$value['ptp_tender_method']];
}

$data['top_proc_method'] = $method;


$this->template($view,"Rekap Rata-Rata Durasi Proses Pengadaan",$data);
?>