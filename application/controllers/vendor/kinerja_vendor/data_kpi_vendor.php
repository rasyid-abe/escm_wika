<?php 
$this->unset_session("query_export_kpi_vendor");

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

$klasifikasi = isset($get['klasifikasi']) ? $get['klasifikasi'] : ""; 
$kantor_gbl = $this->session->userdata("kantor_gbl");

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(fin_class_name)",$search);
  $this->db->or_like("LOWER(win::text)",$search);
  $this->db->or_like("LOWER(invited::text)",$search);
  $this->db->or_like("LOWER(reg::text)",$search);
  $this->db->or_like("LOWER(quote::text)",$search);
  $this->db->or_like("LOWER(reg_status_name)",$search);
  $this->db->or_like("LOWER(average_score::text)",$search);
  $this->db->group_end();
}

if(!empty($kantor_gbl)){
  $this->db->where("district_code",$kantor_gbl);
}
if(!empty($item_gbl)){
  $this->db->where("product_code",$item_gbl);
}
if (!empty($klasifikasi)) {
  $this->db->where("fin_class_name",$klasifikasi);
}


$data['total'] = $this->Vendor_m->getVendorKpi()->num_rows();

if(!empty($kantor_gbl)){
  $this->db->where("district_code",$kantor_gbl);
}
if(!empty($item_gbl)){
  $this->db->where("product_code",$item_gbl);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(fin_class_name)",$search);
  $this->db->or_like("LOWER(win::text)",$search);
  $this->db->or_like("LOWER(invited::text)",$search);
  $this->db->or_like("LOWER(reg::text)",$search);
  $this->db->or_like("LOWER(quote::text)",$search);
  $this->db->or_like("LOWER(reg_status_name)",$search);
  $this->db->or_like("LOWER(average_score::text)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}
if(!empty($limit)){
  $this->db->limit($limit,$offset);
}
if (!empty($klasifikasi)) {
  $this->db->where("fin_class_name",$klasifikasi);
}


$rows = $this->Vendor_m->getVendorKpi()->result_array();
$this->set_session("query_export_kpi_vendor",$this->db->last_query());

foreach ($rows as $key => $value) {
  
}

$data['rows'] = $rows;

echo json_encode($data);