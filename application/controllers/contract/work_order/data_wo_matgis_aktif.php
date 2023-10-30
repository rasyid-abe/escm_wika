<?php

$get = $this->input->get();
$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "B.contract_id";


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(B.wo_notes)",$search);
  $this->db->or_like("LOWER(B.vendor_name)",$search);
  $this->db->or_where("B.wo_number",$search);
  $this->db->group_end();
}
$this->db->select("cwo_id");


$data['total'] = $this->Contract_m->getPekerjaanWOMatgisAktif($id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(B.wo_notes)",$search);
  $this->db->or_like("LOWER(B.vendor_name)",$search);
  $this->db->or_where("B.wo_number",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}



// $this->db->select("cwo_id,po_number,contract_number,po_notes,B.vendor_name,contract_type,awa_name as activity,DATE_FORMAT(cwo_start_date,'%d/%m/%Y %H:%i') as waktu");

$rows = $this->Contract_m->getPekerjaanWOMatgisAktif($id)->result_array();
// var_dump($rows);
 //echo $this->db->last_query();die();
foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
