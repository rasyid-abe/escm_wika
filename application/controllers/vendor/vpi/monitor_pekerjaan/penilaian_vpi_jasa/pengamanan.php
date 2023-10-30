<?php 
$view = 'vendor/vpi/monitor_pekerjaan/penilaian_vpi_jasa/pengamanan_v';

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


$this->db->where('ap_status', "A");
$this->db->order_by('ap_seq', 'asc');
$data['pertanyaan'] = $this->Administration_m->getPengamanan("","jasa")->result_array();


$this->db->where('vvh_id', $vvh_id);
$prev_data_list =  $this->Vendor_m->getVPIPengamanan()->result_array();

$prev_data =  $this->Vendor_m->getVPIPengamanan()->row_array();
$data['prev_data'] = $prev_data;

if (count(array($prev_data_list)) > 0) {

	$this->db->where('vvp_id', $prev_data['vvp_id']);
	$prev_quest_data = $this->Vendor_m->getVPIPengamananScore()->result_array();

	foreach ($data['pertanyaan'] as $key => $value) {

		if ($value['ap_id'] != $prev_quest_data[$key]['vvps_pertanyaan_id']) {

			$this->db->where('ap_id', $value['ap_id']);
			$this->db->order_by('ap_seq', 'asc');
			$prev_pertanyaan = $this->Administration_m->getPengamanan("",'jasa')->result_array();
			
			$data['pertanyaan'] = array_merge($data['pertanyaan'], $prev_pertanyaan);
		}
		$data['pertanyaan'][$key]['vvps_value'] = str_replace('.', ',', $prev_quest_data[$key]['vvps_value']);
		$data['pertanyaan'][$key]['vvps_id'] = $prev_quest_data[$key]['vvps_id'];
	}

	$data['prev_data']['vvp_value'] = str_replace('.', ',', $data['prev_data']['vvp_value']);

}


$this->template($view,"Monitor Penilaian Pengamanan",$data);