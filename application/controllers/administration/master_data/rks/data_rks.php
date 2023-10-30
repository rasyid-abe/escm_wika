<?php

$get = $this->input->get();
$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(header_main)",$search);
  $this->db->or_like("LOWER(header_sub)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("id",$id);
}

// $this->db->where("kode_perkiraan",$userdata['dept_code']);

$data['total'] = $this->db->get("adm_rks")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(header_main)",$search);
  $this->db->or_like("LOWER(header_sub)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("id",$id);
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->db->get("adm_rks")->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

$this->output
->set_content_type('application/json')
->set_output(json_encode($data));
ob_flush();
