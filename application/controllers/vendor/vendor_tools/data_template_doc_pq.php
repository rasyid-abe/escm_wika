<?php 

$get = $this->input->get();
$user = $this->data['userdata'];
$filtering = $this->uri->segment(3, 0);


$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "avd_id";


if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(avd_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}


$data['total'] = $this->Vendor_m->getTemplateDocPq("", $vtm_id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(avd_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}


$rows = $this->Vendor_m->getTemplateDocPq("", $vtm_id)->result_array();

foreach ($rows as $key => $value) {


}

$data['rows'] = $rows;

echo json_encode($data);
