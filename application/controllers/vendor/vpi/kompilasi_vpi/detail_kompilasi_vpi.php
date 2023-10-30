<?php 
$view = 'vendor/vpi/kompilasi_vpi/detail_kompilasi_vpi_v';
$data_header = $this->Vendor_m->getDataDetailKompilasiVPI($param3)->row_array();

$data['data_header'] = $data_header;

$this->db->select('contract_id, vendor_id, vendor_name, start_date, end_date, subject_work, ptm_dept_id, ptm_dept_name');
$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor.ptm_number');
$this->db->where('contract_id', $param3);
$contract_data = $this->db->get('vw_ctr_monitor')->row_array();
$data['contract_data'] = $contract_data;

$this->db->select('vkv_date');
$this->db->order_by('vkv_date', 'asc');
$submitted_date = $this->Vendor_m->getDataDetailKompilasiVPI($param3)->result_array();

$data['date_range']['text'] = [];
$data['date_range']['val'] = [];

foreach ($submitted_date as $key => $value) {
	$date = $value['vkv_date'];
 	$dateconverted=DateTime::createFromFormat('Ym', $date ); 
 	$output=$dateconverted->format('F Y'); 

 	array_push($data['date_range']['text'], $output);
	array_push($data['date_range']['val'], $date);	
}


$this->template($view,"Detail Kompilasi VPI",$data);