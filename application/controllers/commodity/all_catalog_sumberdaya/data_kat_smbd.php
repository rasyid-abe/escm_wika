<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "";

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

if(!empty($id)){

  if(strlen($id) <= 10){
      
      $getUnspsc = $this->Commodity_m->getUnspscGroupCode(substr($id, 0,3));

      $this->session->set_userdata("unspsc_code",$getUnspsc['unspsc_code']);
  } 

   $this->db->where("catalog_code",$id);
  
}

$last_item = $this->session->userdata("code_group");

if(!empty($last_item) && empty($id)){
  $this->db->where("code_group",$last_item);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(catalog_code)",$search);
  $this->db->or_like("LOWER(jenis)",$search);
  $this->db->or_like("LOWER(cmc.unspsc_code)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

$data['total'] = $this->Commodity_m->getAllCatalogSmbd()->num_rows();

if(!empty($id)){
  $this->db->where("catalog_code",$id);
}

if(!empty($last_item) && empty($id)){
  $this->db->where("code_group",$last_item);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(catalog_code)",$search);
  $this->db->or_like("LOWER(jenis)",$search);
  $this->db->or_like("LOWER(cmc.unspsc_code)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
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

$rows = $this->Commodity_m->getAllCatalogSmbd()->result_array();

$selection = $this->data['selection_catalog'];

$status = array("R"=>"warning","A"=>"success","N"=>"default");

foreach ($rows as $key => $value) {

  if(!empty($selection) && in_array($value['catalog_code'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["total_price"] = inttomoney($rows[$key]["total_price"]);  
  if($value["jenis"] == "BARANG") {
    $rows[$key]['long_description'] = anchor(site_url("commodity/lihat_katalog_barang_sumberdaya/".$value["catalog_code"]), $value["long_description"], 'target="_blank"');
    $rows[$key]['description'] = $value["long_description"];    
  }
  if($value["jenis"] == "JASA") {
    $rows[$key]['long_description'] = anchor(site_url("commodity/lihat_katalog_jasa_sumberdaya/".$value["catalog_code"]), $value["long_description"], 'target="_blank"');    
    $rows[$key]['description'] = $value["long_description"];    
  }
  $label = (isset($status[$rows[$key]['status']])) ? $status[$rows[$key]['status']] : "primary";
  $rows[$key]['status_name'] = "<span class='label label-$label'>".$value['status_name']."</span>";
  if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_kat_jasa_smbd/".$rows[$key]["catalog_code"]);
  }

}

$data['rows'] = $rows;

echo json_encode($data);
