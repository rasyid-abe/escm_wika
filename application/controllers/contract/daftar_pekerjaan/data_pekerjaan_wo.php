<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "contract_id";

if(!empty($userdata['pos_id'])){
  $this->db->where("cwo_pos_code",$userdata['pos_id'],false);
} else {
  $this->db->where("contract_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("po_notes")',$search);
  $this->db->or_like('LOWER("vendor_name")',$search);
  $this->db->or_like('LOWER("contract_number")',$search);
  $this->db->or_like('LOWER("contract_type")',$search);
  $this->db->or_like('LOWER("activity")',$search);
  $this->db->or_like('LOWER("waktu")',$search);
  $this->db->or_where('LOWER("po_number")',$search);
  $this->db->group_end();
}

// $this->db->select("cwo_id");
$this->db->where_not_in("awa_id",array(2013,2014,2015));

$data['total'] = $this->Contract_m->getPekerjaanWO($id)->num_rows();


if(!empty($userdata['pos_id'])){
  $this->db->where("cwo_pos_code",$userdata['pos_id'],false);
} else {
  $this->db->where("contract_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("po_notes")',$search);
  $this->db->or_like('LOWER("vendor_name")',$search);
  $this->db->or_like('LOWER("contract_number")',$search);
  $this->db->or_like('LOWER("contract_type")',$search);
  $this->db->or_like('LOWER("activity")',$search);
  $this->db->or_like('LOWER("waktu")',$search);
  $this->db->or_where('LOWER("po_number")',$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where_not_in("awa_id",array(2013,2014,2015));

// $this->db->select("cwo_id,po_number,contract_number,po_notes,B.vendor_name,contract_type,awa_name as activity,to_date(cwo_start_date::text,'DD/MM/YYYY HH24:MI'::text) as waktu");

$rows = $this->Contract_m->getPekerjaanWO($id)->result_array();
// echo $this->db->last_query()."<br/>";


foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
