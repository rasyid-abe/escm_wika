<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$contract_id = isset($get['contract_id']) ? $get['contract_id'] : "";
$date = isset($get['date']) ? $get['date'] : "";

if (!empty($contract_id)) {
  $this->db->where('vkv_contract_id', $contract_id);
}
if (!empty($date)) {
  $this->db->where('vkv_date', $date);
}

$data['total'] = $this->Vendor_m->getDataDetailKompilasiVPI()->num_rows();

if (!empty($contract_id)) {
  $this->db->where('vkv_contract_id', $contract_id);
}
if (!empty($date)) {
  $this->db->where('vkv_date', $date);
}
$rows = $this->Vendor_m->getDataDetailKompilasiVPI()->result_array();


foreach ($rows as $key => $value) {
}

$data['rows'] = $rows;

echo json_encode($data);
