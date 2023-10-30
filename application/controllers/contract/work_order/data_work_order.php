<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

/*

$officer = $this->Administration_m->getPosition();

$pos = array();

foreach ($officer as $key => $value) {
  $pos[] = $value['pos_id'];
}

*/

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "contract_number";

$uid = $userdata['employee_id'];
$uid2 = $uid;

if(!empty($userdata['pos_id']) && $userdata['job_title'] == "PIC USER"){
  $this->db->where("ptm_requester_id",$uid,false);
  $uid2 = null;
} else {
  //$this->db->where("B.contract_number","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(contract_number)",$search);
  $this->db->or_like("LOWER(subject_work)",$search);
  $this->db->or_like("LOWER(contract_type)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like('("contract_amount")::text',str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("LOWER(activity)",$search);
  $this->db->group_end();
}

// $this->db->select("ccc_id");

$this->db->where("ccc_activity",2901);
$this->db->where("contract_type","HARGA SATUAN");
$this->db->where("ptm_dept_id", $userdata['dept_id']);
$this->db->where("ctr_is_matgis",0);

$data['total'] = $this->Contract_m->getPekerjaan($id,$uid2)->num_rows();

if(!empty($userdata['pos_id']) && $userdata['job_title'] == "PIC USER"){
  $this->db->where("ptm_requester_id",$uid,false);
} else {
  //$this->db->where("B.contract_number","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(contract_number)",$search);
  $this->db->or_like("LOWER(subject_work)",$search);
  $this->db->or_like("LOWER(contract_type)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like('("contract_amount")::text',str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("LOWER(activity)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where("ccc_activity",2901);
$this->db->where("contract_type","HARGA SATUAN");
$this->db->where("ptm_dept_id", $userdata['dept_id']);
$this->db->where("ctr_is_matgis",0);
$rows = $this->Contract_m->getPekerjaan($id,$uid2)->result_array();
foreach ($rows as $key => $value) {
  $rows[$key]['contract_amount'] = inttomoney($rows[$key]['contract_amount']);
  //$rows[$key]['mata_anggaran'] = $rows[$key]['ptm_mata_anggaran']." - ".$rows[$key]['ptm_nama_mata_anggaran'];
  //$rows[$key]['sub_mata_anggaran'] = $rows[$key]['ptm_sub_mata_anggaran']." - ".$value['ptm_nama_sub_mata_anggaran'];
}

$data['rows'] = $rows;

echo json_encode($data);
