<?php 
$view = 'vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/k3ldan5r_v';

$vvh_id = $param3;
$this->db->select('vvh_date,contract_id, vendor_id, vendor_name, start_date, end_date, subject_work, ptm_dept_id, ptm_dept_name,vvh_tipe');
$this->db->join('ctr_contract_header b', 'b.contract_id = vnd_vpi_header.vvh_contract_id');
$this->db->join('prc_tender_main a', 'a.ptm_number = b.ptm_number');
$vvh_data = $this->Vendor_m->getVPIHeader("",$vvh_id)->row_array();
$data['vvh_data'] = $vvh_data;

$vvh_date = $vvh_data['vvh_date'];
$vvh_date = DateTime::createFromFormat('Ym', $vvh_date ); 
$data['vvh_data']['vvh_date_text'] = $vvh_date->format('F Y'); 
$data['vvh_id'] = $vvh_id;


$this->db->where('ak_status', "A");
$this->db->order_by('ak_seq', 'asc');
$data['pertanyaan_k3l'] = $this->Administration_m->getK3l("","jasa")->result_array();
$this->db->where('ar_status', "A");
$this->db->order_by('ar_seq', 'asc');
$data['pertanyaan_5r'] = $this->Administration_m->get5r("","jasa")->result_array();

$this->db->where('vvh_id', $vvh_id);
$prev_data_list =  $this->Vendor_m->getVPIK3l5r()->result_array();
$this->db->where('vvh_id', $vvh_id);
$prev_data =  $this->Vendor_m->getVPIK3l5r()->row_array();
$data['prev_data'] = $prev_data;
// print_r($prev_data);
// exit;
if (count($prev_data_list) > 0) {

	$this->db->where('vvk_id', $prev_data['vvh_id']);
	$this->db->where('vvks_type', 'k3l');
	$prev_quest_data = $this->Vendor_m->getVPIK3l5rScore()->result_array();
	if(count($prev_quest_data) > 0){
		foreach ($data['pertanyaan_k3l'] as $key => $value) {
		
			if ($value['ak_id'] != $prev_quest_data[$key]['vvks_pertanyaan_id']) {
	
				// $this->db->where('ak_id', $value['ak_id']);
				// $this->db->order_by('ak_seq', 'asc');
				// $prev_pertanyaan = $this->Administration_m->getK3l("",'jasa')->result_array();
				
				// $data['pertanyaan_k3l'] = array_merge($data['pertanyaan_k3l'], $prev_pertanyaan);
			}
			$data['pertanyaan_k3l'][$key]['vvks_value'] = str_replace('.', ',', $prev_quest_data[$key]['vvks_value']);
			$data['pertanyaan_k3l'][$key]['vvks_id'] = $prev_quest_data[$key]['vvks_id'];
		}
	
		$this->db->where('vvk_id', $prev_data['vvh_id']);
		$this->db->where('vvks_type', '5r');
		$prev_quest_data = $this->Vendor_m->getVPIK3l5rScore()->result_array();
	
		foreach ($data['pertanyaan_5r'] as $key => $value) {
			if ($value['ar_id'] != $prev_quest_data[$key]['vvks_pertanyaan_id']) {
				// $this->db->where('ar_id', $value['ar_id']);
				// $this->db->order_by('ar_seq', 'asc');
				// $prev_pertanyaan = $this->Administration_m->get5r("",'jasa')->result_array();
	
				// $data['pertanyaan_5r'] = array_merge($data['pertanyaan_5r'], $prev_pertanyaan);
			}
			$data['pertanyaan_5r'][$key]['vvks_value'] = str_replace('.', ',', $prev_quest_data[$key]['vvks_value']);
			$data['pertanyaan_5r'][$key]['vvks_id'] = $prev_quest_data[$key]['vvks_id'];
		}
	
		$data['prev_data']['vvk_k3l_value'] = str_replace('.', ',', $data['prev_data']['vvk_k3l_value']);
		$data['prev_data']['vvk_5r_value'] = str_replace('.', ',', $data['prev_data']['vvk_5r_value']);
	}
	

}


$this->template($view,"Penilaian K3L / 5R",$data);