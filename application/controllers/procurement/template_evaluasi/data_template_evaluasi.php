<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

  $id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "evt_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(evt_id)",$search);
  $this->db->or_like("LOWER(evt_name)",$search);
  $this->db->or_like("LOWER(evt_passing_grade)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Procevaltemp_m->getTemplateEvaluasi($id)->num_rows();


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(evt_id)",$search);
  $this->db->or_like("LOWER(evt_name)",$search);
  $this->db->or_like("LOWER(evt_passing_grade)",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Procevaltemp_m->getTemplateEvaluasi($id)->result_array();

$selection = $this->data['selection_template_evaluasi'];

$status = array(0=>"Evaluasi Kualitas Terbaik",1=>"Evaluasi Kualitas Teknis dan Harga",2=>"Evaluasi Harga Terendah");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['evt_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['evt_name'] = "<a href='".site_url('/procurement/procurement_tools/lihat_template_evaluasi/'.$rows[$key]['evt_id'])."' target='_blank'>".$rows[$key]['evt_name']."</a>";
  $rows[$key]['evt_type_id'] = $rows[$key]['evt_type'];
  $rows[$key]['evt_type'] = $status[$rows[$key]['evt_type']];
}

$data['rows'] = $rows;

echo json_encode($data);
