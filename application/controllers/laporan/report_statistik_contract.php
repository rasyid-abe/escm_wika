<?php 
$view = 'laporan/report_statistik_contract_v';
$data = array();
$byTime = $this->db->get('vw_statistik_kontrak_expire')->result_array();
$byStatus = $this->db->get('vw_statistik_kontrak_status')->result_array();
$data['total'] = array_merge($byStatus, $byTime);

$this->template($view,"Rekap Statistik Kontrak",$data);
?>