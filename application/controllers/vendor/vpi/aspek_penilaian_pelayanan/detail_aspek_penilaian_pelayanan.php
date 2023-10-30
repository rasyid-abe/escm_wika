<?php 
$view = 'vendor/vpi/aspek_penilaian_pelayanan/detail_aspek_penilaian_pelayanan_v';
$data_header = $this->Vendor_m->getDataPenilaianPelayanan("",$param3)->row_array();

$data['data_header'] = $data_header;

$this->db->select('contract_id, vendor_id, vendor_name, start_date, end_date, subject_work, ptm_dept_id, ptm_dept_name');
$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor.ptm_number');
$this->db->where('contract_id', $param3);
$contract_data = $this->db->get('vw_ctr_monitor')->row_array();
$data['contract_data'] = $contract_data;

$this->db->select('vpp_date');
$this->db->order_by('vpp_date', 'asc');
$submitted_date = $this->Vendor_m->getDataPenilaianPelayanan("",$param3)->result_array();


// $start = (new DateTime($contract_data['start_date'])) ;
// $end   = (new DateTime($contract_data['end_date']));
// $interval = DateInterval::createFromDateString('1 month');
// $period   = new DatePeriod($start, $interval, $end);

$data['date_range']['text'] = [];
$data['date_range']['val'] = [];

foreach ($submitted_date as $key => $value) {
	$vpp_date = $value['vpp_date'];
 	$date=DateTime::createFromFormat('Ym', $vpp_date ); 
 	$output=$date->format('F Y'); 

 	array_push($data['date_range']['text'], $output);
	array_push($data['date_range']['val'], $vpp_date);	
}

$this->db->where('app_status', "A");
$this->db->order_by('app_seq', 'asc');
$pertanyaan = $this->Administration_m->getAspekPenilaianPelayanan()->result_array();

$data['pertanyaan'] = $pertanyaan;

$this->template($view,"Detail Aspek Penilaian Pelayanan",$data);