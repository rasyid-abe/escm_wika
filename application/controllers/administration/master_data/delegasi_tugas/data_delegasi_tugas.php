<?php 

$get = $this->input->get();

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id";

if(!empty($search)){
  $this->db->group_start();
  // $this->db->like("LOWER(start_date)",$search);
  // $this->db->or_like("LOWER(end_date)",$search);
  $this->db->or_like("LOWER(from_name)",$search);
  $this->db->or_like("LOWER(to_name)",$search);
  $this->db->or_like("LOWER(notes)",$search);
  $this->db->group_end();
}
/*
$this->db->where("aktif",1);*/

//$data['total'] = $this->Administration_m->get_divisi_departemen()->num_rows();
$data['total'] = $this->db->where('aktif',"1")->get("vw_adm_delegasi")->num_rows();
//echo $this->db->last_query();

if(!empty($search)){
  $this->db->group_start();
  // $this->db->like("LOWER(start_date)",$search);
  // $this->db->or_like("LOWER(end_date)",$search);
  $this->db->or_like("LOWER(from_name)",$search);
  $this->db->or_like("LOWER(to_name)",$search);
  $this->db->or_like("LOWER(notes)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}
/*
 $this->db->where("aktif",1);*/

//$rows = $this->Administration_m->get_divisi_departemen()->result_array();
$rows = $this->db->where('aktif',"1")->get("vw_adm_delegasi")->result_array();

foreach ($rows as $key => $value) {
  

}

$data['rows'] = $rows;

echo json_encode($data);