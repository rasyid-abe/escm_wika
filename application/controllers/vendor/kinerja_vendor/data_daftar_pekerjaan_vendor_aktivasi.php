<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(vc_activity)",$search);
  $this->db->or_like("LOWER(reg_islisted)",$search);
  $this->db->group_end();
}

$position = $this->Administration_m->getPosition("PENGELOLA VENDOR");

if(!$position){
  $this->db->where("vendor_id",0);
}

$this->db->where('nextpostcode',$userdata['pos_id']);
$data['total'] = $this->db->get('vw_daftar_pekerjaan_vendor_aktivasi')->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(vc_activity)",$search);
  $this->db->or_like("LOWER(reg_islisted)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if(!$position){
  $this->db->where("vendor_id",0);
}
$this->db->where('nextpostcode',$userdata['pos_id']);
$rows = $this->db->get('vw_daftar_pekerjaan_vendor_aktivasi')->result_array();
  
$status = array("A"=>"Aktif","N"=>"Non Aktif");

foreach ($rows as $key => $value) {
  
  }

$data['rows'] = $rows;

echo json_encode($data);