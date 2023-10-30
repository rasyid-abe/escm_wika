<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(address_street)",$search);
  $this->db->or_like("(vendor_id)::text",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(contact_name)",$search);
  $this->db->or_like("LOWER(customer_code)",$search);
  $this->db->or_like("LOWER(email_address)",$search);
  $this->db->or_like("LOWER(nasabah_code)",$search);
  $this->db->or_like("LOWER(reg_status_name)",$search);
  $this->db->or_like("LOWER(vnd_jenis)",$search);  
  $this->db->group_end();
}

$data['total'] = $this->Vendor_m->getVendor_v2()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(address_street)",$search);
  $this->db->or_like("(vendor_id)::text",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(contact_name)",$search);
  $this->db->or_like("LOWER(customer_code)",$search);
  $this->db->or_like("LOWER(email_address)",$search);
  $this->db->or_like("LOWER(nasabah_code)",$search);
  $this->db->or_like("LOWER(reg_status_name)",$search);  
  $this->db->or_like("LOWER(vnd_jenis)",$search);  
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Vendor_m->getVendor_v2()->result_array();

$status = array("R"=>"Revisi","A"=>"Aktif","N"=>"Nonaktif");

foreach ($rows as $key => $value) {
  
}

$data['rows'] = $rows;

echo json_encode($data);