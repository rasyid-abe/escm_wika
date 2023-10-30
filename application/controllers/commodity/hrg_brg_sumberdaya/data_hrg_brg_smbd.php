<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "updated_datetime";

  if(!empty($id)){
    $this->db->where("mat_price_id",$id);
  }

if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("mat_catalog_code")',$search);
  $this->db->or_like('LOWER("short_description")',$search);
  $this->db->or_like('("unit_price")::text', str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like('LOWER("sourcing_name")',$search);
  $this->db->or_like('LOWER("vendor")',$search);
  $this->db->or_like('LOWER("status_name")',$search);
  $this->db->or_like('LOWER("dept")',$search);
  $this->db->or_like('LOWER("location")',$search);
  $this->db->or_like('LOWER("duration")',$search);
  $this->db->or_like('("thn_pengadaan")::text',$search);
  $this->db->group_end();
}

  if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

  if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

$data['total'] = $this->Commodity_m->getMatSmbdPrice()->num_rows();

  if(!empty($id)){
    $this->db->where("mat_price_id",$id);
  }


if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("mat_catalog_code")',$search);
  $this->db->or_like('LOWER("short_description")',$search);
  $this->db->or_like('("unit_price")::text', str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like('LOWER("sourcing_name")',$search);
  $this->db->or_like('LOWER("vendor")',$search);
  $this->db->or_like('LOWER("status_name")',$search);
  $this->db->or_like('LOWER("dept")',$search);
  $this->db->or_like('LOWER("location")',$search);
  $this->db->or_like('LOWER("duration")',$search);
  $this->db->or_like('("thn_pengadaan")::text',$search);
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


$rows = $this->Commodity_m->getMatSmbdPrice()->result_array();

$selection = $this->data['selection_mat_price'];

$status = array("R"=>"warning","A"=>"success","N"=>"default");
$no = $offset+1;
foreach ($rows as $key => $value) {

  $rows[$key]["no"] = $no;
  if(!empty($selection) && in_array($value['mat_price_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["short_description"] = "<a href='".site_url("commodity/detail_barang_sumberdaya/".$rows[$key]['mat_price_id']."")." ' target='_blank'>".$rows[$key]['short_description']."</a>";
  
  $rows[$key]["unit_price"] = inttomoney($rows[$key]["unit_price"]);
  $rows[$key]["handling_cost"] = inttomoney($rows[$key]["handling_cost"]);
  $rows[$key]["insurance_cost"] = inttomoney($rows[$key]["insurance_cost"]);
  $rows[$key]["freight_cost"] = inttomoney($rows[$key]["freight_cost"]);
  $rows[$key]["tax_duty"] = inttomoney($rows[$key]["tax_duty"]);
  $rows[$key]["total_cost"] = inttomoney($rows[$key]["total_cost"]);
  $rows[$key]["sourcing_date"] = date("d M Y H:i",strtotime($rows[$key]["sourcing_date"]));
  //$rows[$key]["sourcing_id"] = $this->Commodity_m->getSourcingName($rows[$key]["sourcing_id"]);
  $label = (isset($status[$rows[$key]['status']])) ? $status[$rows[$key]['status']] : "primary";
  $rows[$key]['status_name'] = "<span class='label label-$label'>".$value['status_name']."</span>";
  $rows[$key]['is_active'] = ($rows[$key]['is_active'] == 1) ? "Aktif" : "Tidak Aktif";
    if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_hrg_brg_smbd/".$rows[$key]["mat_price_id"]);
  }
  $no++;
}

$data['rows'] = $rows;
echo json_encode($data);
