<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

$type =  isset($get['type']) AND $get['type'] == 'matgis' ? $get['type'] : ""; 

if(!empty($id)){

  if(strlen($id) <= 10){
      
      $getUnspsc = $this->Commodity_m->getUnspscGroupCode(substr($id, 0,3));

      $this->session->set_userdata("mat_unspsc_group_code",$getUnspsc['unspsc_code']);
  } 

   $this->db->where("mat_catalog_code",$id);
  
}


$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "cmc.updated_datetime";


$last_item = $this->session->userdata("mat_unspsc_group_code");

if (!empty($is_matgis)) {
    $this->db->where("cmc.is_matgis","t");
} 
// else {
//     $this->db->where("cmc.is_matgis","f");
//     $this->db->or_where("cmc.is_matgis", null);
// }

if(!empty($last_item) && empty($id)){
  $this->db->where("mat_unspsc_group_code",$last_item);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(mat_catalog_code)",$search);
  $this->db->or_like("LOWER(mat_unspsc_group_code)",$search);
  $this->db->or_like("LOWER(cg.group_name)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
  $this->db->or_like("LOWER(uom)",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

$data['total'] = $this->Commodity_m->getMatCatalogSmbd("",$type)->num_rows();

if (!empty($is_matgis)) {
    $this->db->where("cmc.is_matgis","t");
} 
// else {
//     $this->db->where("cmc.is_matgis","f");
//     $this->db->or_where("cmc.is_matgis", null);
// }

if(!empty($id)){
  $this->db->where("mat_catalog_code",$id);
}

if(!empty($last_item) && empty($id)){
  $this->db->where("mat_unspsc_group_code",$last_item);
}



if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(mat_catalog_code)",$search);
  $this->db->or_like("LOWER(mat_unspsc_group_code)",$search);
  $this->db->or_like("LOWER(cg.group_name)",$search);
  $this->db->or_like("LOWER(short_description)",$search);
  $this->db->or_like("LOWER(uom)",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("status","");
}

if(!empty($filtering) && $filtering == "approved"){
  $this->db->where("status","A");
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Commodity_m->getMatCatalogSmbd("",$type)->result_array();

$selection = $this->data['selection_mat_catalog'];

$status = array("R"=>"warning","A"=>"success","N"=>"default");

foreach ($rows as $key => $value) {

  if(!empty($selection) && in_array($value['mat_catalog_code'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["total_price"] = inttomoney($rows[$key]["total_price"]);
  //$rows[$key]["mat_group_code"] = $this->Commodity_m->getMatLevelName($rows[$key]["mat_group_code"]);
  $label = (isset($status[$rows[$key]['status']])) ? $status[$rows[$key]['status']] : "primary";
  $rows[$key]['status_name'] = "<span class='label label-$label'>".$value['status_name']."</span>";
  $rows[$key]['short_description'] = anchor(site_url("commodity/lihat_katalog_barang_sumberdaya/".$value["mat_catalog_code"]), $value["short_description"], 'target="_blank"');
  if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_kat_brg_smbd/".$rows[$key]["mat_catalog_code"]);
  }

}

$data['rows'] = $rows;

echo json_encode($data);