<?php

$error = false;

$this->db->trans_begin();
$post = $this->input->post();
$result = $this->db->delete('prc_comments', array('id' => $post['id']));

if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    $response = array(
        "status" => 500,
        "data" => $result,
    );
} else {
    $this->db->trans_commit();
    $response = array(
        "status" => 200,
        "data" => $result,
    );
}

echo json_encode($response);
