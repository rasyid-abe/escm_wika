<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);
$metod = $this->uri->segment(5, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "template_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(atk_name)",$search);
  $this->db->or_like("LOWER(periode)",$search);
  // $this->db->or_like("(created_datetime)::text",$search);
  // $this->db->or_like("(updated_datetime)::text",$search);
  $this->db->group_end();
}

// if (isset($metod)) {
//   $this->db->where('atk_status', "Aktif");
// }
$data['total'] = $this->Administration_m->getHasilKompilasi()->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(atk_name)",$search);
  $this->db->or_like("LOWER(periode)",$search);
  // $this->db->or_like("(created_datetime)::text",$search);
  // $this->db->or_like("(updated_datetime)::text",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

// if (isset($metod)) {
//   $this->db->where('atk_status', "Aktif");
// }
$rows = $this->Administration_m->getHasilKompilasi()->result_array();

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);