<?php
$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

if (is_numeric($id)) {
    $last_comment = $this->Comment_m->getProcurementPR("", $id)->row_array();
} else {
    $last_comment = $this->Comment_m->getProcurementPR($id . "")->row_array();
}

$pr_number = $last_comment['tender_id'];

$this->db->trans_begin();

$this->db->where('pr_number', $pr_number);
$act = $this->db->get("prc_comments")->result_array();

if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    $response = array(
        "status" => 500,
        "data" => $act,
    );
} else {
    $this->db->trans_commit();
    $response = array(
        "status" => 200,
        "data" => $act,
    );
}

echo json_encode($response);
