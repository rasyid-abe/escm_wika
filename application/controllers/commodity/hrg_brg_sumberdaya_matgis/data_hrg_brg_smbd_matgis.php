<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;


$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "created_date";
  if(!empty($id)){
    $this->db->where("mat_price_id",$id);
  }

if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("mat_catalog_code")',$search);
  $this->db->or_like('LOWER("short_description")',$search);
  $this->db->or_like('("price")::text', str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like('LOWER("sourcing_name")',$search);
  $this->db->or_like('LOWER("vendor_name")',$search);
  $this->db->or_like('LOWER("valid_start_date")',$search);
  $this->db->or_like('LOWER("valid_end_date")',$search);
  $this->db->or_like('LOWER("created_date")',$search);
  $this->db->or_like('LOWER("volume_remain")',str_replace(',', '.', str_replace('.', '', $search)));
  // $this->db->or_like('LOWER("status_name")',$search);
  $this->db->group_end();
}

  if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

  if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

$data['total'] = $this->db->get("vw_com_mat_price_smbd_matgis")->num_rows();
// echo $this->db->last_query();
// exit();

  if(!empty($id)){
    $this->db->where("mat_price_id",$id);
  }


if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("mat_catalog_code")',$search);
  $this->db->or_like('LOWER("short_description")',$search);
  $this->db->or_like('("price")::text', str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like('LOWER("sourcing_name")',$search);
  $this->db->or_like('LOWER("vendor_name")',$search);
  $this->db->or_like('LOWER("valid_start_date")',$search);
  $this->db->or_like('LOWER("valid_end_date")',$search);
  $this->db->or_like('LOWER("created_date")',$search);
  $this->db->or_like('LOWER("volume_remain")',str_replace(',', '.', str_replace('.', '', $search)));
  // $this->db->or_like('LOWER("status_name")',$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

  if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

  if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}


$rows = $this->db->get("vw_com_mat_price_smbd_matgis")->result_array();

$selection = $this->data['selection_mat_price'];

$status = array("R"=>"warning","A"=>"success","N"=>"default");
$no = $offset+1;
foreach ($rows as $key => $value) {

  $rows[$key]["no"] = $no;
  $rows[$key]["price"] = inttomoney($rows[$key]["price"]+0);
  $rows[$key]["image"] =  $rows[$key]["image"] == "" ? base_url('assets/img/noimage.jpg') : base_url("uploads/commodity/barang/".$rows[$key]["image"]);
  if(!empty($selection) && in_array($value['mat_price_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["short_description"] = "<a href='".site_url("commodity/detail_barang_sumberdaya/".$rows[$key]['mat_price_id']."")." ' target='_blank'>".$rows[$key]['short_description']."</a>";

  $no++;
}

$data['rows'] = $rows;
echo json_encode($data);