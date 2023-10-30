<?php

$get = $this->input->get();
$code = $get['program_code'];

$this->db->select('ppm_id');
$this->db->where('ppm_kode_rencana', $code);
$ppm_id = $this->db->get('prc_plan_main')->row_array();

$this->db->select('pr_packet');
$this->db->where('ppm_id', $ppm_id['ppm_id']);
$nama_paket_pengadaan = $this->db->get('prc_pr_main')->result_array();

$paket_pengadaan = array();
foreach ($nama_paket_pengadaan as $key => $value) {
  foreach ($value as $key => $value) {
    if (!empty($value)) {
      $paket_pengadaan[] = $value;
    }
  }
}

if (count($paket_pengadaan) == 0) {
  $paket_pengadaan[] = "";
}

$this->db->select('pps_paket_pengadaan_name');
$this->db->where('pps_program_code', $code);
$this->db->where_not_in('pps_paket_pengadaan_name', $paket_pengadaan);
$rows = $this->db->get('prc_plan_simdiv')->result_array();

$data['rows'] = $rows;
echo json_encode($data);