<?php 

$this->db->where('status', "1");

$rows = $this->db->get("adm_master_pph")->result_array();

echo json_encode($rows);
