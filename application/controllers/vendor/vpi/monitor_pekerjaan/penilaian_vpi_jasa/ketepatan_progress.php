<?php 
$view = 'vendor/vpi/monitor_pekerjaan/penilaian_vpi_jasa/ketepatan_progress_v';

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

$this->db->where('vvh_id', $vvh_id);
$prev_data =  $this->Vendor_m->getDataPenilaianKetepatanProgress()->row_array();

if (count($prev_data) > 0) {
	$data['prev_data'] = $prev_data;
	$data['prev_data']['vpkp_value'] = str_replace('.', ',', $data['prev_data']['vpkp_value']);
}


$this->template($view,"Monitor Penilaian Ketepatan Progress",$data);