<?php 
$view = 'vendor/vpi/monitor_pekerjaan/penilaian_vpi_konsultan/pelayanan_v';

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

$this->db->where('app_status', "A");
$this->db->order_by('app_seq', 'asc');
$pertanyaan = $this->Administration_m->getAspekPenilaianPelayanan()->result_array();
$data['pertanyaan'] = $pertanyaan;

$this->db->where('vvh_id', $vvh_id);
$prev_data =  $this->Vendor_m->getVPIPelayanan()->row_array();
$data['prev_data'] = $prev_data;

if (count($prev_data) > 0) {

	$this->db->where('vpp_id', $prev_data['vpp_id']);
	$prev_quest_data = $this->Vendor_m->getVPIPelayananScore()->result_array();

	foreach ($data['pertanyaan'] as $key => $value) {

		if ($value['app_id'] != $prev_quest_data[$key]['vppa_pertanyaan_id']) {

			$this->db->where('app_id', $value['app_id']);
			$this->db->order_by('app_seq', 'asc');
			$prev_pertanyaan = $this->Administration_m->getK3l("",'konsultan')->result_array();
			
			$data['pertanyaan'] = array_merge($data['pertanyaan'], $prev_pertanyaan);
		}
		$data['pertanyaan'][$key]['vppa_value'] = str_replace('.', ',', $prev_quest_data[$key]['vppa_value']);
		$data['pertanyaan'][$key]['vppa_id'] = $prev_quest_data[$key]['vppa_id'];
	}

	$data['prev_data']['vpp_value'] = str_replace('.', ',', $data['prev_data']['vpp_value']);

}



$this->template($view,"Monitor Penilaian Pelayanan",$data);