<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_id)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->group_end();
}
$this->db->where("reg_isactivate",'0');
$data['total'] = $this->Vendor_m->getVendor()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_id)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where("status","-2");
$this->db->where("aktif","1");

$rows = $this->Vendor_m->getVendorCommodity()->result_array();

$status = array("-2"=>"Nonaktif","5"=>"Aktif");

foreach ($rows as $key => $value) {

   $rows[$key]['status'] = (isset($status[$rows[$key]['status']])) ? $status[$rows[$key]['status']] : "-";

}

$data['rows'] = $rows;

echo json_encode($data);