<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "";
$parent = (isset($get['parent']) && !empty($get['parent'])) ? $get['parent'] : "";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(group_code)",$search);
  $this->db->or_like("LOWER(unspsc_code)",$search);
  $this->db->or_like("LOWER(group_name)",$search);
  $this->db->group_end();
}

if(!empty($parent)){
  $this->db->where("group_parent", $parent);
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("group_status",null);
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
  $this->db->order_by('unspsc_code', 'desc');
}else{
  $this->db->order_by('srv_group_code','asc');
  $this->db->order_by('unspsc_code', 'desc'); 
}

$data['total'] = $this->Commodity_m->getSrvGroupSmbd()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(group_code)",$search);
  $this->db->or_like("LOWER(unspsc_code)",$search);
  $this->db->or_like("LOWER(group_name)",$search);
  $this->db->group_end();
}

if(!empty($parent)){
  $this->db->where("group_parent", $parent);
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("group_status",null);
}


if(!empty($order)){
  $this->db->order_by($field_order,$order);
  $this->db->order_by('unspsc_code', 'desc');
}else{
  $this->db->order_by('srv_group_code','asc');
  $this->db->order_by('unspsc_code', 'desc'); 
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Commodity_m->getSrvGroupSmbd()->result_array();

$selection = $this->data['selection_srv_group'];

$status = array("R"=>"Revisi","A"=>"Aktif");
$label_status = array('Aktif'=>'success','Belum Aktif'=> 'default');

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['srv_group_code'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['srv_group_status'] = (isset($status[$rows[$key]['srv_group_status']])) ? $status[$rows[$key]['srv_group_status']] : "Belum Disetujui";
  $label = (isset($label_status[$rows[$key]['status_name']])) ? $label_status[$rows[$key]['status_name']] : "primary";
  $rows[$key]['status_name'] = "<span class='label label-$label'>".$value['status_name']."</span>";
  //$rows[$key]["srv_group_parent"] = $this->Commodity_m->getSrvLevelName($rows[$key]["srv_group_parent"]);
  if(!empty($filtering) && $filtering == "approval"){
    $rows[$key]['operate'] = site_url("commodity/daftar_pekerjaan/approval_grup_jasa/".$rows[$key]["srv_group_code"]);
  }
}

$data['rows'] = $rows;

echo json_encode($data);
