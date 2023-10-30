<?php

$get = $this->input->get();

$filtering = $this->uri->segment(2, 0);

$idmat = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "cmh_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("mat_catalog_code",$search);
  $this->db->or_like("LOWER('short_description')",$search);
  $this->db->or_like("LOWER('currency')",$search);
  // $this->db->or_where("total_cost",$search);
  // $this->db->or_like("updated_datetime",$search);
  $this->db->group_end();
}
$data['total'] = $this->Commodity_m->getMatHist($idmat)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("mat_catalog_code",$search);
  $this->db->or_like("LOWER('short_description')",$search);
  $this->db->or_like("LOWER('currency')",$search);
  // $this->db->or_like("total_cost",$search);
  // $this->db->or_like("updated_datetime",$search);
  $this->db->group_end();
}
$this->db->order_by("cmh_id", "desc");
$rows = $this->Commodity_m->getMatHist($idmat)->result_array();
foreach ($rows as $key => $value) {
  $rows[$key]['cost'] = inttomoney($value['total_cost']); 
}

// echo $this->db->last_query();
$data['rows'] = $rows;
echo json_encode($data);