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
$input['pr_obj_nilai'] = $post['prc_obj_nilai_edit'];
$input['pr_no_telp'] = $post['prc_no_telp_edit'];
$input['pr_lampiran'] = $post['prc_lampiran_edit'];
$input['pr_comment'] = $post['prc_comment_edit'];
$input['pr_respon'] = $post['prc_respon_edit'];
$input['pr_user_id'] = $userdata['pos_id'];
$input['pr_user_name'] =  $userdata['complete_name'];
$input['pr_position'] =  $userdata['pos_name'];
$input['pr_created_date'] = date("Y-m-d H:i:s");
$input['pr_divisi'] = $userdata['dept_name'];

$this->db->where('id', $post['prc_id']);
$act = $this->db->update("prc_comments", $input);

if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    $response = array(
        "status" => 500,
        "data" => $input,
    );
} else {
    $this->db->trans_commit();
    $query = $this->db->query("SELECT * FROM prc_comments ORDER BY id DESC LIMIT 1");
    $result = $query->row_array();
    $response = array(
        "status" => 200,
        "data" => $result,
    );
}

echo json_encode($response);
