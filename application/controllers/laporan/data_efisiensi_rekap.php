<?php 

$get = $this->input->get();

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "metode";
$metode = (isset($get['metode']) && !empty($get['metode'])) ? $get['metode'] : 0;

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(metode)",$search);
  $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("(total_contract)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("(jumlah)::text",$search);
  $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->group_end();
}

switch ($metode) {

  case 1:
    $this->db->where('metode_id',0);
    break;

  case 2:
    $this->db->where('metode_id',1);
    break;

  case 3:
    $this->db->where('metode_id',2);
    break;
  
  default: 
    $this->db->where('metode_id IS NOT NULL');
    break;
}


$data['total'] = $this->Laporan_m->getEfisiensiRekap()->num_rows();

//echo $this->db->last_query();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(metode)",$search);
  $this->db->or_like("(hps)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("(total_contract)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("(jumlah)::text",$search);
  $this->db->or_like("(efisiensi)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->or_like("(efisiensi_percent)::text",str_replace(',', '.', str_replace('.', '', $search)));
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}


switch ($metode) {

  case 1:
    $this->db->where('metode_id',0);
    break;

  case 2:
    $this->db->where('metode_id',1);
    break;

  case 3:
    $this->db->where('metode_id',2);
    break;
  
  default: 
    $this->db->where('metode_id IS NOT NULL');
    break;
}

$rows = $this->Laporan_m->getEfisiensiRekap()->result_array();

$status = array(0=>"Nonaktif",1=>"Aktif");

foreach ($rows as $key => $value) {
  $rows[$key]['hps'] = inttomoney($rows[$key]['hps']);
  $rows[$key]['total_contract'] = inttomoney($rows[$key]['total_contract']);
  $rows[$key]['efisiensi'] = inttomoney($rows[$key]['efisiensi']);
  $rows[$key]['efisiensi_percent'] = $this->truncate_number($rows[$key]['efisiensi_percent'],2).'%';

  }

$data['rows'] = $rows;

echo json_encode($data);