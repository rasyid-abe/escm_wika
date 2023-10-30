<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(kualifikasi)",$search);
  $this->db->or_like("LOWER(klasifikasi)",$search);
  $this->db->or_like("LOWER(jml)",$search);
  $this->db->group_end();
}

$rows = $this->db->get('vw_kinerja_vendor')->result_array();
$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));