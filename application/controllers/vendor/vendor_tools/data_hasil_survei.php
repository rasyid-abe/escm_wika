<?php 

$get = $this->input->get();
$user = $this->data['userdata'];
$filtering = $this->uri->segment(3, 0);


$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";


if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(reg_status_name_2)",$search);
  $this->db->or_like("LOWER(state_name)",$search);
  $this->db->group_end();
}

if($user['job_title'] == "PENGELOLA VENDOR") {
  $this->db->where_in("state_now", array(2));
  $this->db->where("reg_isactivate",'0');
}
else {
  $this->db->where_in("status", '7');
}

$data['total'] = $this->Vendor_m->getVendor()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(reg_status_name_2)",$search);
  $this->db->or_like("LOWER(state_name)",$search);
  $this->db->group_end();
}


if($user['job_title'] == "PENGELOLA VENDOR") {
  $this->db->where_in("state_now", array(2));
  $this->db->where("reg_isactivate",'0');
}
else {
  $this->db->where_in("status", '7');
}

$rows = $this->Vendor_m->getVendor()->result_array();

foreach ($rows as $key => $value) {

   $rows[$key]['reg_isactivate'] = (isset($status[$rows[$key]['reg_isactivate']])) ? $status[$rows[$key]['reg_isactivate']] : "-";

}

$data['rows'] = $rows;

echo json_encode($data);
