<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "progress_id";

if(!empty($userdata['pos_id'])){
  $this->db->group_start();
  $this->db->where("current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("progress_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(po_number)",$search);
  $this->db->or_like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_like('("progress_percentage")::text',$search);
  $this->db->or_like("LOWER(activity)",$search);
  $this->db->group_end();
}

$this->db
->where("COALESCE(status) !=",null);

$data['total'] = $this->Contract_m->getPekerjaanProgressWO()->num_rows();
// echo $this->db->last_query();

if(!empty($userdata['pos_id'])){
  $this->db->group_start();
  $this->db->where("current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("progress_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(po_number)",$search);
  $this->db->or_like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_like('("progress_percentage")::text',$search);
  $this->db->or_like("LOWER(activity)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where("COALESCE(status) !=",null);

$rows = $this->Contract_m->getPekerjaanProgressWO()->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
