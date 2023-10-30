<?php
$this->load->model(array("Workflow_m", "Comment_m"));
$id = $this->uri->segment(3, 0);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];

$data = array();
$data['headline'] = $this->Procpr_m->getPRCMain($id)->row_array();
$item_sumberdaya = $this->Procpr_m->getItemPR("", $id)->result_array();
foreach ($item_sumberdaya as $k => $v) {
    if ($item_sumberdaya[$k]['ppi_lampiran']) {
        $item_sumberdaya[$k]['ppi_lampiran'] = $protocol.$domainName."/log/download_attachment/procurement/tender/".$v['ppi_lampiran'];
    }
}
$data['item_sumberdaya'] = $item_sumberdaya;

$data['detail_sumberdaya'] = $this->Procpr_m->getPrRisikoDetail($id)->result_array();

$document = $this->Procpr_m->getDocumentPr($id)->result_array();
foreach($document as $k => $v) {
    if ($document[$k]['ppd_file_name']) {
        $document[$k]['ppd_file_name'] = $protocol . $domainName . "/log/download_attachment/procurement/tender/" . $v['ppd_file_name'];
    }
}
$data['document'] = array($document);

$data['opportunity'] = $this->Procpr_m->getPrOpportunity($id)->result_array();

$penilaian_risiko = $this->Procpr_m->getPrNilaiRisiko($id)->result_array();
foreach($penilaian_risiko as $k => $v) {
    if ($penilaian_risiko[$k]['lampiran_risiko']) {
        $penilaian_risiko[$k]['lampiran_risiko'] = $protocol . $domainName . "/log/download_attachment/procurement/tender/" . $v['lampiran_risiko'];
    }
}
$data['penilaian_risiko'] = $penilaian_risiko;

$data['daftar_risiko'] = $this->Procpr_m->getRisikoPR("", $id)->result_array();

// comment
$comment_num = $this->db->where('pr_number', $id);
$comment_num = $this->db->get('prc_comments');
$comment = $this->db->where('pr_number', $id);
$comment = $this->db->get('prc_comments')->result_array();
foreach($comment as $k => $v) {
    if ($comment[$k]['pr_lampiran']) {
        $comment[$k]['pr_lampiran'] = $protocol . $domainName . "/log/download_attachment/procurement/tender/" . $v['pr_lampiran'];
    }
}

$komentar = $comment;

$thumbs_up = $this->db->where('pr_number', $id);
$thumbs_up->where('pr_respon', 0);
$thumbs_up = $this->db->get('prc_comments');

$thumbs_down = $this->db->where('pr_number', $id);
$thumbs_down->where('pr_respon', 1);
$thumbs_down = $this->db->get('prc_comments');

$comment = $this->db->where('pr_number', $id);
$comment->where('pr_respon', 2);
$comment = $this->db->get('prc_comments');

$data['catatan'] = array(
    "catatan_total" => $comment_num->num_rows(),
    "thumbs_up" => $thumbs_up->num_rows(),
    "thumbs_down" => $thumbs_down->num_rows(),
    "rows" => $komentar
);

$activity = $this->Comment_m->getProcurementPRActive($id)->result_array();

foreach($activity as $k => $v) {
    if ($activity[$k]['attachment']) {
        $activity[$k]['attachment'] = $protocol . $domainName . "/log/download_attachment/procurement/permintaan/" . $v['attachment'];
    }
}
$data['activity'] = $activity;

if ($data) {
    $this->response([
        'status' => true,
        'data' => $data,
    ], REST_Controller::HTTP_OK);
} else {
    $this->response([
        'status' => FALSE,
        'message' => 'No data were found'
    ], REST_Controller::HTTP_NOT_FOUND);
}
