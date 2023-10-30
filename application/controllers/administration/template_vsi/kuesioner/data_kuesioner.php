<?php 

$get = $this->input->get();

$template_id = $this->uri->segment(5, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "avk_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(avk_quest)",$search);
  $this->db->like("LOWER(avk_parent)",$search);
  $this->db->like("LOWER(avk_status)",$search);
  $this->db->or_like("LOWER(created_datetime)::text",$search);
  $this->db->group_end();
}
// $this->db->where('avk_status', "Aktif");
$data['total'] = $this->Administration_m->getKuesioner("", $template_id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(avk_quest)",$search);
  $this->db->like("LOWER(avk_parent)",$search);
  $this->db->like("LOWER(avk_status)",$search);
  $this->db->or_like("LOWER(created_datetime)::text",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}
// $this->db->where('avk_status', "Aktif");
$rows = $this->Administration_m->getKuesioner("", $template_id)->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);