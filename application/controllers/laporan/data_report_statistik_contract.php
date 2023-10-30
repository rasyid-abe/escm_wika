<?php 

$get = $this->input->get();

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "statistik_kontrak";
$metode = (isset($get['metode']) && !empty($get['metode'])) ? $get['metode'] : 0;

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(statistik_kontrak)",$search);
  $this->db->or_like("(jml)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->group_end();
}

$data['total'] = $this->db->get('vw_statistik_kontrak')->num_rows();

//echo $this->db->last_query();


if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(statistik_kontrak)",$search);
    $this->db->or_like("(jml)::text",str_replace(',', '.', str_replace('.', '', $search)));
    $this->db->group_end();
  }

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}


$rows = $this->db->get('vw_statistik_kontrak')->result_array();

$status = array(0=>"Nonaktif",1=>"Aktif");

foreach ($rows as $key => $value) {
  
  $rows[$key]['jml'] = "<a href='".site_url('laporan/report_statistik_contract_detail/'.$rows[$key]['kode'])."' target='_blank'>".$rows[$key]['jml']."</a>";

  }

$data['rows'] = $rows;

echo json_encode($data);