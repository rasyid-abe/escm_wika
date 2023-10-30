<?php

$this->load->model("Procpr_m");

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

$selection = $this->data['selection_vendor_tender'];

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_where("vendor_id",$search);
  $this->db->group_end();
}

$data['total'] = $this->Procpr_m->getVendorPr($id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  $this->db->or_where("vendor_id",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->distinct();

$rows = $this->Procpr_m->getVendorPr($id)->result_array();

$klasifikasi = array("K"=>"Kecil","M"=>"Menengah","B"=>"Besar","I"=>"Mikro");

foreach ($rows as $key => $value) {
  $rows[$key]['vendor_name'] = "<a href='".site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$rows[$key]['vendor_id'])."' target='_blank'>".$rows[$key]['vendor_name']."</a>";
  $rows[$key]['fin_class'] = (isset($klasifikasi[$rows[$key]['fin_class']])) ? $klasifikasi[$rows[$key]['fin_class']] : "-";
}

$data['rows'] = $rows;

echo json_encode($data);