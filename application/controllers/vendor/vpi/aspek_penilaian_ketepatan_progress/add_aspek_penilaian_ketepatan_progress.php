<?php 
$view = 'vendor/vpi/aspek_penilaian_ketepatan_progress/add_aspek_penilaian_ketepatan_progress_v';

$this->db->select('contract_id, vendor_id, vendor_name, start_date, end_date, subject_work, ptm_dept_id, ptm_dept_name');
$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor.ptm_number');
$this->db->where('contract_id', $param3);
$contract_data = $this->db->get('vw_ctr_monitor')->row_array();

$data['contract_data'] = $contract_data;

$start = (new DateTime($contract_data['start_date'])) ;
$end   = (new DateTime($contract_data['end_date']));
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start->modify("-1 month"), $interval, $end->modify("+1 month"));

$this->db->select('vpkp_date');
$this->db->where('vpkp_response', "1");
$submitted_date = $this->Vendor_m->getDataPenilaianKetepatanProgress("",$param3)->result_array();

$data['date_range']['text'] = [];
$data['date_range']['val'] = [];

foreach ($period as $dt) {
	array_push($data['date_range']['text'], $dt->format("F Y"));
	array_push($data['date_range']['val'], $dt->format("Ym"));
}

foreach ($submitted_date as $key => $value) {
 $vpkp_date = $value['vpkp_date'];
 $vpkp_date = DateTime::createFromFormat('Ym', $vpkp_date ); 
 $output = $vpkp_date->format('F Y'); 
 
 $key_val = array_search($value['vpkp_date'], $data['date_range']['val']);
 	unset($data['date_range']['val'][$key_val]); 

 $key_text = array_search($output, $data['date_range']['text']);
 	unset($data['date_range']['text'][$key_text]);
 
}

$this->template($view,"Aspek Penilaian Ketepatan Progress",$data);