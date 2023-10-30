<?php

$this->db->trans_begin();

$this->db->where('pr_number', $id);
$act = $this->db->get("prc_risiko")->result_array();

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
?>