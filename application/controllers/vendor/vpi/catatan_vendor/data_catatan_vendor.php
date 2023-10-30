<?php

$this->unset_session("query_data_vendor_note");
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
  $this->db->like("LOWER(nama)",$search);
  $this->db->or_like("LOWER(is_good)",$search);
  $this->db->or_like("LOWER(note::text)",$search);
  $this->db->or_like("LOWER(lampiran::text)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Vendor_m->getVendorAward()->num_rows();


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(nama)",$search);
  $this->db->or_like("LOWER(is_good)",$search);
  $this->db->or_like("LOWER(note::text)",$search);
  $this->db->or_like("LOWER(lampiran::text)",$search);
  $this->db->group_end();
}

if (empty($field_order)) {
  $this->db->order_by("id","asc");
}elseif(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Vendor_m->getVendorNote();
$this->set_session("query_data_vendor_note", $this->db->last_query());

// foreach ($rows as $key => $value) {
//   $rows[$key]['nama'] = inttomoney($rows[$key]['nama']);
//   $rows[$key]['is_good'] = inttomoney($rows[$key]['is_good']);
//   $rows[$key]['note'] = inttomoney($rows[$key]['note']);
//   $rows[$key]['lampiran'] = inttomoney($rows[$key]['lampiran']);
//   $rows[$key]['date_create'] = inttomoney($rows[$key]['date_create']);
// }

$data['rows'] = $rows;

echo json_encode($data);
