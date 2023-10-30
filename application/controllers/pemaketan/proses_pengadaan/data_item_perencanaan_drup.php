<?php
$userdata = $this->data['userdata'];
$get = $this->input->get();


$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

$this->db->select('*');
$this->db->from('prc_proses_drup');
$this->db->join('adm_coa_new', 'prc_proses_drup.coa_id = adm_coa_new.id');

if (!empty($id)) {
    $this->db->where('kode_sumber_daya', $id);
}
$this->db->where('pemilik_program', $userdata['dept_name']);
$query = $this->db->get()->result_array();

$data['rows'] = $query;


echo json_encode($data);
