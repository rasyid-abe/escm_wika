<?php

$get = $this->input->get();
$userdata = $this->data['userdata'];
$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ppm_id";

if ($userdata['job_title'] != 'ADMIN') {
  if ( $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] != 'SCM') {
    $this->db->where('ppm_dept_id', $userdata['dept_id']);    
  }
}

if(!empty($search)){
  $this->db->group_start();
  //$this->db->where("ppm_id",$search);
  $this->db->or_like("LOWER(ppm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ppm_planner)",$search);
  $this->db->or_like("LOWER(ppm_planner_pos_name)",$search);
  $this->db->or_like("LOWER(ppm_renc_kebutuhan_vw)",$search);
  $this->db->or_like("LOWER(ppm_renc_pelaksanaan_vw)",$search);
  $this->db->or_like("LOWER(ppm_status_name)",$search);
 // $this->db->where("ppm_status",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where("ppm_status", 3);
$data['total'] = $this->Procplan_m->getPerencanaanPengadaan($id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  //$this->db->where("ppm_id",$search);
  $this->db->or_like("LOWER(ppm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ppm_planner)",$search);
  $this->db->or_like("LOWER(ppm_planner_pos_name)",$search);
  $this->db->or_like("LOWER(ppm_renc_kebutuhan_vw)",$search);
  $this->db->or_like("LOWER(ppm_renc_pelaksanaan_vw)",$search);
  $this->db->or_like("LOWER(ppm_status_name)",$search);
 // $this->db->where("ppm_status",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if ($userdata['job_title'] != 'ADMIN') {
  if ( $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] != 'SCM') {
    $this->db->where('ppm_dept_id', $userdata['dept_id']);    
  }
}
$this->db->where("ppm_status", 3);
$rows = $this->Procplan_m->getPerencanaanPengadaan($id)->result_array();

$data['rows'] = $rows;
//echo $this->db->last_query();
$this->output->set_content_type('application/json')->set_output(json_encode($data));