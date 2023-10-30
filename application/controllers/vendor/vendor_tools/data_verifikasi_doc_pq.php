<?php 

$get = $this->input->get();
$user = $this->data['userdata'];
$filtering = $this->uri->segment(3, 0);


$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "created_datetime";

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(vdp_status_name)",$search);
  $this->db->or_like("LOWER(status_vendor)",$search);
  $this->db->group_end();
}


if($user['job_title'] != "PENGELOLA VENDOR") {
  $this->db->where('vdp_pos_id', 0); //supaya tidak muncul di selain pengelola vendor
}
$data['total'] = $this->Vendor_m->getDaftarPekerjaanVerifikasiDocPQ()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(vdp_status_name)",$search);
  $this->db->or_like("LOWER(status_vendor)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if($user['job_title'] != "PENGELOLA VENDOR") {
  $this->db->where('vdp_pos_id', 0); //supaya tidak muncul di selain pengelola vendor
}
$rows = $this->Vendor_m->getDaftarPekerjaanVerifikasiDocPQ()->result_array();


foreach ($rows as $key => $value) {


}

$data['rows'] = $rows;

echo json_encode($data);
