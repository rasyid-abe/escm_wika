<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vmh_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vmh_address)",$search);
  $this->db->or_like("(vmh_npwp)::text",$search);
  $this->db->or_like("LOWER(vmh_name)",$search);
  $this->db->or_like("LOWER(vmh_email)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Vendor_m->getMandor()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vmh_address)",$search);
  $this->db->or_like("(vmh_npwp)::text",$search);
  $this->db->or_like("LOWER(vmh_name)",$search);
  $this->db->or_like("LOWER(vmh_email)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Vendor_m->getMandor()->result_array();

foreach ($rows as $key => $value) {

  if ($value['status'] == 'A') {
    $rows[$key]['reg_status_name'] = 'Active';
  } elseif($value['status'] == 'WA') {
    $rows[$key]['reg_status_name'] = 'Waiting Approval';
  }else {
    $rows[$key]['reg_status_name'] = 'Inactive';
  }

}

$data['rows'] = $rows;

echo json_encode($data);