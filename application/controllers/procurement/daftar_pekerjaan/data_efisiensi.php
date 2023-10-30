<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];



$dept = $userdata['dept_id'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "efisiensi";


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("efisiensi",$search);
  $this->db->or_like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_dept_name)",$search);
  $this->db->or_like("contract_amount",$search);
  $this->db->or_like("efisiensi_percent",$search);
  $this->db->or_like("inefisiensi_percent",$search);
  $this->db->or_like("inefisiensi",$search);
  $this->db->group_end();
}


$rows = $this->db->get('vw_efisiensi')->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("efisiensi",$search);
  $this->db->or_like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_dept_name)",$search);
  $this->db->or_like("contract_amount",$search);
  $this->db->or_like("efisiensi_percent",$search);
  $this->db->or_like("inefisiensi_percent",$search);
  $this->db->or_like("inefisiensi",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if (!empty($limit)) {
  $this->db->limit(5);
}
$rows = $this->db->get('vw_efisiensi')->result_array();

$data['rows'] = array();
foreach ($rows as $key => $value) {
  $rows[$key]['efisiensi_percent'] = number_format($rows[$key]['efisiensi_percent'],2,',','.');
  $rows[$key]['inefisiensi_percent'] = number_format($rows[$key]['inefisiensi_percent'],2,',','.');
  $rows[$key]['contract_amount'] = number_format($rows[$key]['contract_amount'],2,',','.');
  $rows[$key]['hps'] = number_format($rows[$key]['hps'],2,',','.');
  $rows[$key]['efisiensi'] = number_format($rows[$key]['efisiensi'],2,',','.');
  $rows[$key]['inefisiensi'] = number_format($rows[$key]['inefisiensi'],2,',','.');
}

$data['rows'] = $rows;

echo json_encode($data);
