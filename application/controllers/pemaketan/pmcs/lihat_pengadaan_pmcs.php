<?php

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$view = 'pemaketan/pmcs/detail_permintaan_pengadaan_v';

$data = array();

$id = $this->uri->segment(4, 0);

$data['permintaan'] = $this->Procpr_m->getPR($id)->row_array();

$status = ($data['permintaan']['pr_status'] >= 1020) ? 1020 : $data['permintaan']['pr_status'];

$data['content'] = $this->Workflow_m->getContentByActivity($status)->result_array();

$data['document'] = $this->Procpr_m->getDocumentPr($id)->result_array();

$data['item'] = $this->Procpr_m->getItemPR("", $id)->result_array();

$data['redirect_back'] = 'procurement/proses_pengadaan/daftar_permintaan_pengadaan';

$data["comment_list"][0] = $this->Comment_m->getProcurementPRActive($id)->result_array();


//header
$data['permintaans'] = $this->Procpr_m->getPRCMain($id)->row_array();
//risiko
$data['risiko'] = $this->Procpr_m->getPrNilaiRisiko($id)->result_array();

$data['risiko_detail'] = $this->Procpr_m->getPrRisikoDetail($id)->result_array();

//skala nilai risiko
$skala_resiko_nilai = $this->db->get('adm_skala_resiko_paket');
$data['skala_resiko_nilai'] = $skala_resiko_nilai->result_array();

//Opportunity
$data['opportunity'] = $this->Procpr_m->getPrOpportunity($id)->result_array();
// comment
$this->db->where('pr_number', $id);
$komentar = $this->db->get('prc_comments');

// count thumbs
$thumbs_up = $this->db->where('pr_number', $id);
$thumbs_up->where('pr_respon', 0);
$thumbs_up = $this->db->get('prc_comments');
$data['thumbs_up'] = $thumbs_up->num_rows();

$thumbs_down = $this->db->where('pr_number', $id);
$thumbs_down->where('pr_respon', 1);
$thumbs_down = $this->db->get('prc_comments');
$data['thumbs_down'] = $thumbs_down->num_rows();

$comment = $this->db->where('pr_number', $id);
$comment->where('pr_respon', 2);
$comment = $this->db->get('prc_comments');
$data['comment'] = $comment->num_rows();

$data['komentar'] = $komentar->result_array();
$data['com_num'] = $komentar->num_rows();

$this->template($view, "Detail Paket Pengadaan", $data);
