<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/detail_permintaan_pengadaan_v';

$pr_number =  $this->uri->segment(5, 0);

$data['id'] = $pr_number;

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("LUMPSUM"=>"LUMPSUM","HARGA SATUAN"=>"HARGA SATUAN","RENTAL SERVICE"=>"RENTAL SERVICE");

$tender = $this->Procpr_m->getMonitorPR($pr_number)->row_array();

$data['permintaan'] = $tender;

$data['pr_number'] = $pr_number;

$data['is_matgis'] = $this->Procrfq_m->getPRData($pr_number)->row_array();

$activity_id = $tender['last_status'];

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$comment = $this->Comment_m->getProcurementPRActive($pr_number)->result_array();

$cekPR_sap = $this->Procpr_m->getPR($pr_number, 'sap')->row_array();

if ($cekPR_sap['pr_type_of_plan'] == 'sap') {

	$datapr = $this->Procpr_m->getPR($pr_number, 'sap')->row_array();

} else {

	$datapr = $this->Procpr_m->getPR($pr_number)->row_array();

}

$data['is_sap'] = $cekPR_sap;

$is_user = false;

$employee = $this->data['userdata'];

$data['pelaksana'] = $this->Procrfq_m->getRFQ($datapr['joinrfq'])->row_array();

foreach ($comment as $key => $value) {
	if($value['user_id'] == $employee['employee_id'] && !$is_user){
		$is_user = true;
	}
}

$data["comment_list"][0] = $comment;

$data['is_user'] = $is_user;

$data['document'] = $this->Procpr_m->getDokumenPR("",$pr_number)->result_array();

$data['item'] = $this->Procpr_m->getItemPR("",$pr_number)->result_array();

//permintaans
$data['permintaans'] = $this->Procpr_m->getPRCMain($pr_number)->row_array();
//risiko
$data['risiko'] = $this->Procpr_m->getPrNilaiRisiko($pr_number)->result_array();

// comment
$this->db->where('pr_number', $pr_number);
$komentar = $this->db->get('prc_comments');

// count thumbs
$thumbs_up = $this->db->where('pr_number', $pr_number);
$thumbs_up->where('pr_respon', 0);
$thumbs_up = $this->db->get('prc_comments');
$data['thumbs_up'] = $thumbs_up->num_rows();

$thumbs_down = $this->db->where('pr_number', $pr_number);
$thumbs_down->where('pr_respon', 1);
$thumbs_down = $this->db->get('prc_comments');
$data['thumbs_down'] = $thumbs_down->num_rows();

$comment = $this->db->where('pr_number', $pr_number);
$comment->where('pr_respon', 2);
$comment = $this->db->get('prc_comments');
$data['comment'] = $comment->num_rows();

$data['komentar'] = $komentar->result_array();

$data['com_num'] = $komentar->num_rows();

//skala nilai risiko
$skala_resiko_nilai = $this->db->get('adm_skala_resiko_paket');
$data['skala_resiko_nilai'] = $skala_resiko_nilai->result_array();

$data['risiko_detail'] = $this->Procpr_m->getPrRisikoDetail($pr_number)->result_array();

//Opportunity
$data['opportunity'] = $this->Procpr_m->getPrOpportunity($pr_number)->result_array();

$data['penilaian']= $this->db->get('adm_question_kpi_vendor')->result_array();

$data['redirect_back'] = 'procurement/procurement_tools/monitor_permintaan';

$this->session->set_userdata("pr_id",$pr_number);
//$this->template($view,$activity['awa_name'],$data);
$this->template($view,"Detail Permintaan (".$activity['awa_name'].")",$data);