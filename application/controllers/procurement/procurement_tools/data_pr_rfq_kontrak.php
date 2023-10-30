<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "pr_number";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pr_number)",$search);
  $this->db->or_like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_requester_pos_name)",$search);
  $this->db->or_like("LOWER(pr_packet)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

// if($userdata['job_title'] == 'PIC USER'){
//   $this->db->where("pr_dept_id",$userdata['dept_id']);
// } elseif ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] != 'SCM') {
//   $this->db->where('pr_dept_id', $userdata['dept_id']);
// } 

if ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'SCM' && $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || preg_match('/(DIREKTUR)/i', $userdata['job_title'])) {
    $this->db->group_start();
      $this->db->where('ptm_dept_id', $userdata['dept_id']);
      $this->db->or_like('ptm_dept', $deptuser);
       $this->db->group_end();
  }

$this->db->where("pr_status !=",1906);

$data['total'] = $this->Procpr_m->getMonitorPR($id)->num_rows();

// if($userdata['job_title'] == 'PIC USER'){
//   $this->db->where("pr_dept_id",$userdata['dept_id']);
// }elseif ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] != 'SCM') {
//       $this->db->where('pr_dept_id', $userdata['dept_id']);
// } 

if ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'SCM' && $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || preg_match('/(DIREKTUR)/i', $userdata['job_title'])) {
    $this->db->group_start();
      $this->db->where('ptm_dept_id', $userdata['dept_id']);
      $this->db->or_like('ptm_dept', $deptuser);
       $this->db->group_end();
  }
  
if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pr_number)",$search);
  $this->db->or_like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_requester_pos_name)",$search);
  $this->db->or_like("LOWER(pr_packet)",$search);
  //haqim
  $this->db->or_like("LOWER(last_pos)",$search);
  // end
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where("pr_status !=",1906);

$rows = $this->Procpr_m->getMonitorPR($id)->result_array();

$this->load->model("Contract_m");

foreach ($rows as $key => $value) {

  $this->db->where("pr_number", $value['pr_number']);
  $rfq = $this->Procrfq_m->getRFQ()->row_array();
  $ctr = $this->Contract_m->getData("", $rfq['ptm_number'])->row_array();

  $rows[$key]['rfq_numb'] = $rfq['ptm_number'];
  $rows[$key]['ctr_numb'] = $ctr['contract_number'];
  $rows[$key]['mata_anggaran'] = $rows[$key]['pr_mata_anggaran']." - ".$rows[$key]['pr_nama_mata_anggaran'];
  $rows[$key]['sub_mata_anggaran'] = $rows[$key]['pr_sub_mata_anggaran']." - ".$value['pr_nama_sub_mata_anggaran'];
}

$data['rows'] = $rows;
// var_dump($rows);

$this->output->set_content_type('application/json')->set_output(json_encode($data));