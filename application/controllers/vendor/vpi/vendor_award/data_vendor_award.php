<?php

$this->unset_session("query_data_vendor_award");
$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(dept_name)",$search);
  $this->db->or_like("LOWER(total_contract_amount::text)",$search);
  $this->db->or_like("LOWER(total_proyek::text)",$search);
  $this->db->or_like("LOWER(masa_kerja::text)",$search);
  $this->db->or_like("LOWER(total_score_vpi::text)",$search);
  $this->db->or_like("LOWER(kompleksitas::text)",$search);
  $this->db->or_like("LOWER(jumlah)",$search);
  $this->db->or_like("LOWER(rank)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Vendor_m->getVendorAward()->num_rows();


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(dept_name)",$search);
  $this->db->or_like("LOWER(total_contract_amount::text)",$search);
  $this->db->or_like("LOWER(total_proyek::text)",$search);
  $this->db->or_like("LOWER(masa_kerja::text)",$search);
  $this->db->or_like("LOWER(total_score_vpi::text)",$search);
  $this->db->or_like("LOWER(kompleksitas::text)",$search);
  $this->db->or_like("LOWER(jumlah)",$search);
  $this->db->or_like("LOWER(rank)",$search);
  $this->db->group_end();
}

if (empty($field_order)) {
  $this->db->order_by("rank","asc");
}elseif(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Vendor_m->getVendorAward()->result_array();
$this->set_session("query_data_vendor_award", $this->db->last_query());

foreach ($rows as $key => $value) {
  $rows[$key]['total_contract_amount'] = inttomoney($rows[$key]['total_contract_amount']);
  $rows[$key]['jumlah_kontrak'] = inttomoney($rows[$key]['jumlah_kontrak']);
  $rows[$key]['total_proyek'] = inttomoney($rows[$key]['total_proyek']);
  $rows[$key]['masa_kerja'] = inttomoney($rows[$key]['masa_kerja']);
  $rows[$key]['total_score_vpi'] = inttomoney($rows[$key]['total_score_vpi']);
  $rows[$key]['jumlah'] = inttomoney($rows[$key]['jumlah']);
}

$data['rows'] = $rows;

echo json_encode($data);
