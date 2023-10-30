<?php

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/ubah_permintaan_pengadaan_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

*/

$this->db->where("job_title", "PELAKSANA PENGADAAN");

$data['pelaksana_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

$data['id'] = $id;

$data['pos'] = $position;

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$data['del_point_list'] = $this->Administration_m->get_divisi_departemen()->result_array();

$data['district_list'] = $this->Administration_m->getDistrict()->result_array();

$data['contract_type'] = array("LUMPSUM" => "LUMPSUM");

$last_comment = $this->Comment_m->getProcurementPR("", $id)->row_array();

$pr_number = $last_comment['tender_id'];

$permintaan = $this->Procpr_m->getPR($pr_number)->row_array();

$cek_sap = $this->Procpr_m->getPR_Sap($pr_number)->row_array();

if ($cek_sap['pr_is_sap'] == 1) {

  $permintaan = $this->Procpr_m->getPR_Sap($pr_number)->row_array();

} 

$project_cost = $this->Procpr_m->getProjectCost($pr_number)->result_array();

$data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($permintaan['ppm_id'])->row_array();

$data['is_sap'] = $cek_sap['pr_is_sap'] == 1 ? 'sap' : '';

$data['pr_number'] = $pr_number;

//header
$data['permintaans'] = $this->Procpr_m->getPRCMain($pr_number)->row_array();
//risiko
$data['risiko'] = $this->Procpr_m->getPrNilaiRisiko($pr_number)->result_array();

//skala nilai risiko
$skala_resiko_nilai = $this->db->get('adm_skala_resiko_paket');
$data['skala_resiko_nilai'] = $skala_resiko_nilai->result_array();

$data['skala_resiko_nilai_header'] = $this->db->where('pr_number', $pr_number)->get("VW_PRC_PENILAIAN_RESIKO")->row_array();

$this->db->join('vnd_header', 'vnd_header.vendor_id = prc_pr_vendor.vendor_id', 'left');
$data['vendor_usulan'] = $this->db->where('pr_number', $pr_number)->get("prc_pr_vendor")->result_array();

//Opportunity
$data['opportunity'] = $this->Procpr_m->getPrOpportunity($pr_number)->result_array();

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

$data['last_comment'] = $last_comment;

$data['permintaan'] = $permintaan;

$data['project_cost'] = $project_cost;

$default_act = ($data['permintaan']['pr_type'] == "MATERIAL STRATEGIS") ? 1001 : 1000;

$activity_id = (!empty($last_comment['activity'])) ? $last_comment['activity'] : $default_act;

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['awa_id'] = $activity['awa_id'];

$data['workflow_list'] = $this->Procedure_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = $this->Comment_m->getProcurementPRActive($pr_number)->result_array();

$data['document'] = $this->Procpr_m->getDokumenPR("", $pr_number)->result_array();

$data['item'] = $this->Procpr_m->getItemPR("", $pr_number)->result_array();

$data['risiko_list'] = $this->Procpr_m->getRisikoPR("", $pr_number)->result_array();

$data['risiko_detail'] = $this->Procpr_m->getPrRisikoDetail($permintaan['pr_number'])->result_array();

$this->db->where('jenis_penilaian', 'barang');
$skala_resiko = $this->db->get('adm_nilai_resiko_paket');
$data['skala_nilai'] = $skala_resiko->result_array();

$this->db->where('jenis_penilaian', 'jasa');
$skala_resiko_jasa = $this->db->get('adm_nilai_resiko_paket');
$data['skala_nilai_jasa'] = $skala_resiko_jasa->result_array();

$this->db->where('pr_number', $pr_number);
$data['data_penilaian_risiko'] = $this->db->get('prc_penilaian_risiko')->result_array();
$dataPrcResiko = array();

foreach ($data['data_penilaian_risiko'] as $key => $value) {
  $dataPrcResiko[$value['id_risiko']]['id'] = $value['id'];
  $dataPrcResiko[$value['id_risiko']]['category_risiko'] = $value['category_risiko'];
  $dataPrcResiko[$value['id_risiko']]['lampiran_risiko'] = $value['lampiran_risiko'];
  $dataPrcResiko[$value['id_risiko']]['bobot_risiko'] = $value['bobot_risiko'];
  $dataPrcResiko[$value['id_risiko']]['total_nilai_bobot'] = $value['total_nilai_bobot'];
  $dataPrcResiko[$value['id_risiko']]['pr_number'] = $value['pr_number'];
  $dataPrcResiko[$value['id_risiko']]['id_risiko'] = $value['id_risiko'];
  $dataPrcResiko[$value['id_risiko']]['nilai_risiko'] = $value['nilai_risiko'];
  $dataPrcResiko[$value['id_risiko']]['created_by'] = $value['created_by'];
  $dataPrcResiko[$value['id_risiko']]['created_date'] = $value['created_date'];

}

$data['data_trx_penilaian_risiko'] = $dataPrcResiko;

$this->db->order_by("fullname", "asc");

$data['penata_perencana'] = $this->Administration_m->getUserByJob("PENATA PERENCANAAN")->result_array();

$this->db->order_by("fullname", "asc");

$data['pelaksana'] = $this->Administration_m->getUserByJob("PELAKSANA PENGADAAN")->result_array();

$data['pr_type'] = array("KONSOLIDASI" => "KONSOLIDASI", "NON KONSOLIDASI" => "NON KONSOLIDASI", "MATERIAL STRATEGIS" => "MATERIAL STRATEGIS"); //y tipe pr

$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['del_point_list'] = $this->Administration_m->get_divisi_departemen()->result_array();
$data['contract_type'] = array("LUMPSUM" => "LUMPSUM");
$data['workflow_list'] = $this->Procedure_m->getResponseList($activity['awa_id']);
$data['pr_type'] = array("KONSOLIDASI" => "KONSOLIDASI", "NON KONSOLIDASI" => "NON KONSOLIDASI"); //y tipe pr

$this->db->limit(1);
$permintaan = $this->Procpr_m->getPR('','sap')->row_array();

if (!empty($permintaan)) {
	foreach ($permintaan as $key => $value) {
		$permintaan[$key] = null;
	}
}

$data['pr_main'] = $this->db->where('pr_number', $pr_number)->get('prc_pr_main')->row_array();
$data['item_sap'] = $this->db->where('pr_number', $pr_number)->get('vw_prc_perencanaan_rari')->result_array();
$data['pr_item_row'] = $this->db->where('pr_number', $pr_number)->get('prc_pr_item')->row_array();
$data['adm_incoterm'] = $this->db->get('adm_incoterm')->result_array();
$data['doc_type'] = $this->db->get('adm_doc_type')->result_array();
$data['tax_code'] = $this->db->get('adm_tax_code')->result_array();

$this->template($view, $activity['awa_name'] . " (" . $activity['awa_id'] . ")", $data);
