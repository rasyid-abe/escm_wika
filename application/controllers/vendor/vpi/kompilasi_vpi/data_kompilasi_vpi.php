<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "contract_id";
$contract_id = (isset($get['contract_id']) && !empty($get['contract_id'])) ? $get['contract_id'] : "";
$date = (isset($get['date']) && !empty($get['date'])) ? $get['date'] : "";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(contract_number)",$search);
  $this->db->or_like("LOWER(contract_type)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(status_name)",$search);
  $this->db->group_end();
}
if (!empty($contract_id)) {
  $this->db->where('contract_id', $contract_id);
}else if (!empty($date)) {
  $this->db->where('date', $date);
}

$data['total'] = $this->Vendor_m->getDataKompilasiVPI()->num_rows();


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(contract_number)",$search);
  $this->db->or_like("LOWER(contract_type)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(status_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}
if (!empty($contract_id)) {
  $this->db->where('contract_id', $contract_id);
}else if (!empty($date)) {
  $this->db->where('date', $date);
}
$rows = $this->Vendor_m->getDataKompilasiVPI()->result_array();


foreach ($rows as $key => $value) {
  $rows[$key]['ptm_number'] = $rows[$key]['ptm_number'];
}

$data['rows'] = $rows;

echo json_encode($data);
