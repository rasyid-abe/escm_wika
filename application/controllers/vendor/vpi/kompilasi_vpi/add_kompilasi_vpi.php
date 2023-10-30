<?php 
$view = 'vendor/vpi/kompilasi_vpi/add_kompilasi_vpi_v';
$data_header = $this->Vendor_m->getDataKompilasiVPI($param3)->row_array();

$data['data_header'] = $data_header;

$this->db->select('contract_id, vendor_id, vendor_name, start_date, end_date, subject_work, ptm_dept_id, ptm_dept_name');
$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor.ptm_number');
$this->db->where('contract_id', $param3);
$contract_data = $this->db->get('vw_ctr_monitor')->row_array();
$data['contract_data'] = $contract_data;

$this->db->select('date');
$this->db->order_by('date', 'asc');
$complete_penilaian_date = $this->Vendor_m->getDataKompilasiVPI($param3)->result_array();
$this->db->select('vkv_date');
$this->db->order_by('vkv_date', 'asc');
$submitted_date = $this->Vendor_m->getVndKompilasiVPI($param3)->result_array();

$target_dan_bobot = $this->Administration_m->getTargetdanBobotKompilasiVPI()->result_array();

$data['target_dan_bobot'] = [];
  $arrayNew = array();

  foreach ($target_dan_bobot as $key => $value) {
  	$arrayNew[$value['abt_indicator']] = array('abt_value' => str_replace('.', ',', $value['abt_value'])); 
  }
array_push($data['target_dan_bobot'] , $arrayNew);
$data['target_dan_bobot'] = $data['target_dan_bobot'][0];

$data['date_range']['text'] = [];
$data['date_range']['val'] = [];
foreach ($complete_penilaian_date as $key => $value) {
	$date = $value['date'];
 	$dateconverted=DateTime::createFromFormat('Ym', $date ); 
 	$output=$dateconverted->format('F Y'); 

 	array_push($data['date_range']['text'], $output);
	array_push($data['date_range']['val'], $date);

	if (isset($submitted_date[$key]['vkv_date'])) {
		$date2 = $submitted_date[$key]['vkv_date'];
	 	$dateconverted2=DateTime::createFromFormat('Ym', $date2 ); 
	 	$output2=$dateconverted2->format('F Y');
		if ($key_val = array_search($submitted_date[$key]['vkv_date'], $data['date_range']['val']) !== false) {
			unset($data['date_range']['val'][$key_val]); 
		}

		if ($key_text = array_search($output2, $data['date_range']['text']) !== false) {
	 		unset($data['date_range']['text'][$key_text]);
		}
	}
		
}

$this->template($view,"Detail Kompilasi VPI",$data);