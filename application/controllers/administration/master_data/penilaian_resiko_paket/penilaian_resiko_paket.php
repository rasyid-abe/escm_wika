<?php

$view = 'administration/master_data/penilaian_resiko_paket/penilaian_resiko_paket_v';

$rows = $this->db->get('adm_nilai_resiko_paket')->result_array();
$data['rows'] = $rows;

$this->template($view, "Penilaian Resiko Paket", $data);
