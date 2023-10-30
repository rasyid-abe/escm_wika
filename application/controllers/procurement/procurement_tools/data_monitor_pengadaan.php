<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$deptuser = $userdata['dept_name'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "prc.ptm_number";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(prc.ptm_number)",$search);
  $this->db->or_like("LOWER(prc.ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(prc.ptm_requester_name)",$search);
  $this->db->or_like("LOWER(prc.ptm_scope_of_work)",$search);
  $this->db->or_like("LOWER(prc.ptm_requester_pos_name)",$search);
  $this->db->or_like("LOWER(prc.ptm_packet)",$search);
  $this->db->or_like("LOWER(prc.status)",$search);
  $this->db->or_like("LOWER(prc.jenis_pengadaan)",$search);
  $this->db->or_like("LOWER(prc.last_pos)",$search);
  $this->db->or_like("LOWER(prc.tender_metode)",$search);
  $this->db->group_end();
}

if($userdata['job_title'] == 'PIC USER'){
  $this->db->group_start();
  $this->db->where('prc.ptm_requester_name', $userdata['complete_name']);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "active"){
  $this->db->where("prc.last_status !=", 1902);
} elseif(!empty($filtering) && $filtering == "rfq_ongoing"){
  $this->db->where('prc.last_status <', 1180);
} elseif(!empty($filtering) && $filtering == "rfq_selesai"){
  $this->db->group_start();
  $this->db->where('prc.last_status', 1901);
  $this->db->where('prc.last_status <', 1902);
  $this->db->group_end();
} else{
  $this->db->where("prc.last_status !=",null,false);
}

if ($userdata['job_title'] == 'ADMIN' || $userdata['job_title'] == 'PIC USER' || $userdata['job_title'] == 'GENERAL MANAJER' || $userdata['pos_name'] == 'GM SCM Strategis' || $userdata['pos_name'] == 'Kepala Divisi SCM' || $userdata['dept_name'] == 'SCM' && $userdata['dept_name'] == 'DIVISI SUPPLY CHAIN MANAGEMENT' || preg_match('/(DIREKTUR)/i', $userdata['job_title'])) {

}else{

  $this->db->group_start();
  if($userdata['pos_name'] == 'Manajer Sub Dept. Infrastruktur 1'){
    $ar = array('28','54','48');
    $this->db->where_in('prc.ptm_dept_id', $ar);
  } else {
    $this->db->where('prc.ptm_dept_id', $userdata['dept_id']);
    $this->db->or_like('prc.ptm_dept', $deptuser);
  }
  $this->db->group_end();

}

$this->db->select("prc.ptm_number");
$this->db->like('prc.pr_number', 'PR', 'after');
$this->db->where("prc.ptm_status !=",null,false);
$data['total'] = $this->Procrfq_m->getMonitorRFQandBidder($id)->num_rows();

if($userdata['job_title'] == 'PIC USER'){
    $this->db->group_start();
    $this->db->where('prc.ptm_requester_name', $userdata['complete_name']);
    $this->db->group_end();
}

if(!empty($filtering) && $filtering == "active"){
  $this->db->where("prc.last_status !=", 1902);
} elseif(!empty($filtering) && $filtering == "rfq_ongoing"){
  $this->db->where('prc.last_status <', 1180);
} elseif(!empty($filtering) && $filtering == "rfq_selesai"){
  $this->db->where('prc.last_status <', 1902);
} else{
  $this->db->where("prc.last_status !=",null,false);
}

if ($userdata['job_title'] == 'ADMIN' || $userdata['job_title'] == 'PIC USER' || $userdata['job_title'] == 'GENERAL MANAJER' || $userdata['pos_name'] == 'GM SCM Strategis' || $userdata['pos_name'] == 'Kepala Divisi SCM' || $userdata['dept_name'] == 'SCM' && $userdata['dept_name'] == 'DIVISI SUPPLY CHAIN MANAGEMENT' || preg_match('/(DIREKTUR)/i', $userdata['job_title'])) {

}else{

  $this->db->group_start();
  if($userdata['pos_name'] == 'Manajer Sub Dept. Infrastruktur 1'){
    $ar = array('28','54','48');
    $this->db->where_in('prc.ptm_dept_id', $ar);
  } else {
    $this->db->where('prc.ptm_dept_id', $userdata['dept_id']);
    $this->db->or_like('prc.ptm_dept', $deptuser);
  }
  $this->db->group_end();

}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(prc.ptm_number)",$search);
  $this->db->or_like("LOWER(prc.ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(prc.ptm_requester_name)",$search);
  $this->db->or_like("LOWER(prc.ptm_scope_of_work)",$search);
  $this->db->or_like("LOWER(prc.ptm_requester_pos_name)",$search);
  $this->db->or_like("LOWER(prc.ptm_packet)",$search);
  $this->db->or_like("LOWER(prc.status)",$search);
  $this->db->or_like("LOWER(prc.jenis_pengadaan)",$search);
  $this->db->or_like("LOWER(prc.last_pos)",$search);
  $this->db->or_like("LOWER(prc.tender_metode)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->like('prc.pr_number', 'PR', 'after');
$this->db->where("prc.ptm_status !=",null,false);
$rows = $this->Procrfq_m->getMonitorRFQandBidder($id)->result_array();

foreach ($rows as $key => $value) {
  $rows[$key]['mata_anggaran'] = $rows[$key]['ptm_mata_anggaran']." - ".$rows[$key]['ptm_nama_mata_anggaran'];
  $rows[$key]['sub_mata_anggaran'] = $rows[$key]['ptm_sub_mata_anggaran']." - ".$value['ptm_nama_sub_mata_anggaran'];
}

$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));
