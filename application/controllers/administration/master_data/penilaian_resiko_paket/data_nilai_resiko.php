<?php 

$rows = $this->db->get('adm_nilai_resiko_paket')->result_array();
$data['rows'] = $rows;

echo json_encode($data);