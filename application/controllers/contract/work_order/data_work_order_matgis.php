<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$ctr_active=$this->Settings_m->get_settings_num('_ACT_CTR_ACTIVE');
//echo $ctr_active;
//die();
$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "B.contract_number";

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
  $this->db->like("LOWER(B.subject_work)",$search);
  $this->db->or_like("LOWER(B.vendor_name)",$search);
  $this->db->or_where("B.contract_number",$search);
  $this->db->group_end();
}

$this->db->select("ccc_id");
$this->db->where("A.ccc_activity",$ctr_active);
//$this->db->where("contract_type","HARGA SATUAN");
$this->db->where("D.ptm_dept_id", $userdata['dept_id']);
$this->db->where("B.ctr_is_matgis",1);

$this->load->model('Procedure_matgis_m');
$data['total'] = $this->Procedure_matgis_m->getPekerjaan()->num_rows();
//echo $this->db->last_query();die;



if(!empty($userdata['pos_id']) && $userdata['job_title'] == "PIC USER"){
  //$this->db->where("ptm_requester_id",$uid,false);
} else {
  //$this->db->where("B.contract_number","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(B.subject_work)",$search);
  $this->db->or_like("LOWER(B.vendor_name)",$search);
  $this->db->or_where("B.contract_number",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select("ccc_id,A.contract_id,A.ptm_number,contract_number,subject_work,vendor_name,contract_type,awa_name as activity, ccc_start_date as waktu,contract_amount");
$this->db->where("A.ccc_activity",$ctr_active);
$this->db->where("contract_type","HARGA SATUAN");
$this->db->where("D.ptm_dept_id", $userdata['dept_id']);
$this->db->where("B.ctr_is_matgis",1);
$rows = $this->Contract_m->getPekerjaan($id,$uid2)->result_array();

foreach ($rows as $key => $value) {
  $rows[$key]['contract_amount'] = inttomoney($rows[$key]['contract_amount']);
  //$rows[$key]['mata_anggaran'] = $rows[$key]['ptm_mata_anggaran']." - ".$rows[$key]['ptm_nama_mata_anggaran'];
  //$rows[$key]['sub_mata_anggaran'] = $rows[$key]['ptm_sub_mata_anggaran']." - ".$value['ptm_nama_sub_mata_anggaran'];
}
//echo $this->db->last_query(); die;
$data['rows'] = $rows;

echo json_encode($data);
