<?php
$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

if (is_numeric($id)) {
    $last_comment = $this->Comment_m->getProcurementPR("", $id)->row_array();
} else {
    $last_comment = $this->Comment_m->getProcurementPR($id . "")->row_array();
}

$pr_number = $last_comment['tender_id'];

$post = $this->input->post();
$userdata = $this->data['userdata'];
$input = array();

$this->db->trans_begin();

$input['pr_number'] = $pr_number;
$input['kategori'] = $post['rs_kategori'];
$input['risiko'] = $post['rs_risiko'];
$input['penyebab'] = $post['rs_penyebab'];
$input['dampak'] = $post['rs_dampak'];
$input['rating_probabilitas'] = $post['rs_rating_probabilitas'];
$input['rating_dampak'] = $post['rs_rating_dampak'];
$input['level_risiko'] = $post['rs_level_risiko'];
$input['pic'] = $post['rs_pic'];
$input['mitigasi'] = $post['rs_mitigasi'];
$input['date_created'] = date("Y-m-d H:i:s");
$input['created_by'] = $userdata['dept_name'];

$this->db->where('id', $post['id']);
$act = $this->db->update("prc_risiko", $input);

if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    $response = array(
        "status" => 500,
        "data" => $input,
    );
} else {
    $this->db->trans_commit();
    // $query = $this->db->query("SELECT * FROM prc_risiko ORDER BY id DESC LIMIT 1");
    // $result = $query->row_array();
    $response = array(
        "status" => 200,
        "data" => $act,
    );
}

echo json_encode($response);
