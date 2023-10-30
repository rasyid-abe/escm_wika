<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

  $id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "avd_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(avd_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->or_like("(created_date)::text",$search);
  $this->db->or_like("(updated_date)::text",$search);
  $this->db->or_like("LOWER(vtm.vtm_name)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Vendor_m->getVndDoc()->num_rows();


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(avd_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->or_like("(created_date)::text",$search);
  $this->db->or_like("(updated_date)::text",$search);
  $this->db->or_like("LOWER(vtm.vtm_name)",$search);  
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Vendor_m->getVndDoc()->result_array();

foreach ($rows as $key => $value) {
   $rows[$key]['action'] = "
  <a class='btn btn-info btn-xs action' href='".site_url('vendor/vendor_tools/doc_vendor/edit/'.$value['avd_id'])."'>Ubah</a>";
  
}

$data['rows'] = $rows;

echo json_encode($data);
