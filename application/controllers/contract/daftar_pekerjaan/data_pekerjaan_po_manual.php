<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

// echo "<pre>";
// print_r($userdata);
// die;

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ptm_number";

$ty = "";
if (($userdata['job_title'] == 'PIC USER') || ($userdata['job_title'] == 'PELAKSANA PENGADAAN')){
    $ty = "user";
} else if ($userdata['job_title'] == 'APPROVAL LEGAL') {
    $ty = "legal";
} else {
    if(!empty($userdata['pos_id'])){
        $this->db->where("ccc_pos_code",$userdata['pos_id'],false);
    } else {
        $this->db->where("ptm_number","");
    }
}


if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("ptm_number")',$search);
  $this->db->or_like('LOWER("subject_work")',$search);
  $this->db->or_like('LOWER("vendor_name")',$search);
  $this->db->or_like('LOWER("contract_number")',$search);
  $this->db->or_like('LOWER("contract_type")',$search);
  $this->db->or_like('LOWER("activity")',$search);
  $this->db->or_like('LOWER("waktu")::text',$search);
  // $this->db->or_where("B.ptm_number",$search);
  $this->db->group_end();
}

$data['total'] = $this->Contract_m->getPekerjaan_po_manual($id,$userdata['employee_id'], $ty)->num_rows();

$ty = "";
if (($userdata['job_title'] == 'PIC USER') || ($userdata['job_title'] == 'PELAKSANA PENGADAAN')){
    $ty = "user";
} else if ($userdata['job_title'] == 'APPROVAL LEGAL') {
    $ty = "legal";
} else {
    if(!empty($userdata['pos_id'])){
        $this->db->where("ccc_pos_code",$userdata['pos_id'],false);
    } else {
        $this->db->where("ptm_number","");
    }
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like('LOWER("ptm_number")',$search);
  $this->db->or_like('LOWER("subject_work")',$search);
  $this->db->or_like('LOWER("vendor_name")',$search);
  $this->db->or_like('LOWER("contract_number")',$search);
  $this->db->or_like('LOWER("contract_type")',$search);
  $this->db->or_like('LOWER("activity")',$search);
  $this->db->or_like('LOWER("waktu")::text',$search);
  // $this->db->or_where("B.ptm_number",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Contract_m->getPekerjaan_po_manual($id,$userdata['employee_id'], $ty)->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
