<?php 
$view = 'vendor/vpi/daftar_pekerjaan/penilaian_header_v';
$data = array();
$this->db->select('contract_id, vendor_id, vendor_name, start_date, end_date, subject_work, ptm_dept_id, ptm_dept_name');
$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor.ptm_number');
$this->db->where('contract_id', $param3);
$contract_data = $this->db->get('vw_ctr_monitor')->row_array();

$data['contract_data'] = $contract_data;

$start = (new DateTime($contract_data['start_date'])) ;
$end   = (new DateTime($contract_data['end_date']));
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start->modify("-1 month"), $interval, $end->modify("+1 month"));

$data['date_range']['text'] = [];
$data['date_range']['val'] = [];

$this->db->select('vvh_date');
$this->db->where('vk_response', "1");
$this->db->where('vvh_contract_id', $contract_data['contract_id']);
$this->db->join('vnd_vpi_kompilasi b', 'b.vvh_id = vnd_vpi_header.vvh_id');
$submitted_date = $this->Vendor_m->getVPIHeader()->result_array();

$this->db->select('vvh_date,vvh_tipe');
$current_data = $this->Vendor_m->getVPIHeader($param3)->row_array();

foreach ($period as $dt) {
	array_push($data['date_range']['text'], $dt->format("F Y"));
	array_push($data['date_range']['val'], $dt->format("Ym"));
}

// if (count($submitted_date) >= 1) {

// 	foreach ($submitted_date as $key => $value) {
// 	 $vvh_date = $value['vvh_date'];
// 	 $vvh_date = DateTime::createFromFormat('Ym', $vvh_date ); 
// 	 $output = $vvh_date->format('F Y'); 
	 
// 	 $key_val = array_search($value['vvh_date'], $data['date_range']['val']);
// 	 	unset($data['date_range']['val'][$key_val]); 

// 	 $key_text = array_search($output, $data['date_range']['text']);
// 	 	unset($data['date_range']['text'][$key_text]);
	 
// 	}
// }

$data['pilihan_tipe'] = array(
							  'barang' 		=> 'Barang',
							  'jasa' 		=> 'Jasa',
							  'konsultan'	=> 'Konsultan'
							);

$this->template($view,"Header Penilaian VPI",$data);
?>