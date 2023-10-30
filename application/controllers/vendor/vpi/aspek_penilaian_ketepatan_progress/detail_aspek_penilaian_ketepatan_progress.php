<?php 
$view = 'vendor/vpi/aspek_penilaian_ketepatan_progress/detail_aspek_penilaian_ketepatan_progress_v';
$data_header = $this->Vendor_m->getDataPenilaianMutu("",$param3)->row_array();

$data['data_header'] = $data_header;

$this->db->select('contract_id, vendor_id, vendor_name, start_date, end_date, subject_work, ptm_dept_id, ptm_dept_name');
$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor.ptm_number');
$this->db->where('contract_id', $param3);
$contract_data = $this->db->get('vw_ctr_monitor')->row_array();
$data['contract_data'] = $contract_data;

$this->db->select('vpkp_date');
$this->db->order_by('vpkp_date', 'asc');
$submitted_date = $this->Vendor_m->getDataPenilaianKetepatanProgress("",$param3)->result_array();


$data['date_range']['text'] = [];
$data['date_range']['val'] = [];

foreach ($submitted_date as $key => $value) {
	$vpkp_date = $value['vpkp_date'];
 	$date=DateTime::createFromFormat('Ym', $vpkp_date ); 
 	$output=$date->format('F Y'); 

 	array_push($data['date_range']['text'], $output);
	array_push($data['date_range']['val'], $vpkp_date);	
}

$this->template($view,"Detail Aspek Penilaian Ketepatan Progress",$data);