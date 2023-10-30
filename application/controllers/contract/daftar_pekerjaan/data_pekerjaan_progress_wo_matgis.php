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
  $this->db->where("b.current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("b.current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("progress_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("progress_id",(int)$search);
  $this->db->group_end();
}

$this->db->select("progress_id")
->where("COALESCE(b.status) !=",null)
->join("ctr_wo_header c","c.wo_id=b.wo_id")
->join("ctr_contract_header a","a.contract_id=c.contract_id");

$data['total'] = $this->db->get("ctr_wo_progress_header b")->num_rows();

//echo $this->db->last_query(); die;

if(!empty($userdata['pos_id'])){
  $this->db->group_start();
  $this->db->where("b.current_approver_id",$userdata['employee_id'],false);
  $this->db->or_where("b.current_approver_pos",$userdata['pos_id'],false);
  $this->db->group_end();
} else {
  $this->db->where("progress_id","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(progress_description)",$search);
  $this->db->or_like("LOWER(creator_name)",$search);
  $this->db->or_where("progress_id",(int)$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select("b.*,c.wo_number,
  CASE b.status::integer
      WHEN 1 THEN 'Menunggu Persetujuan PIC User'
      WHEN 2 THEN 'Menunggu Persetujuan Manajer User'
      WHEN 3 THEN 'Menunggu Persetujuan VP USER'
      WHEN 4 THEN 'Menunggu Persetujuan PIC BAST'
      WHEN 5 THEN 'Menunggu Persetujuan Manajer BAST'
      WHEN 6 THEN 'Finalisasi Persetujuan VP BAST'
      WHEN 99 THEN 'Revisi'
  ELSE 'Aktif' END AS activity
  ");
$this->db->where("COALESCE(b.status) !=",null)
->join("ctr_wo_header c","c.wo_id=b.wo_id")
->join("ctr_contract_header a","a.contract_id=c.contract_id");

$rows = $this->db->get("ctr_wo_progress_header b")->result_array();

//echo $this->db->last_query();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
