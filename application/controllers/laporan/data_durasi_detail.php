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
  $this->db->or_like("LOWER(ptm_dept_name)",$search);
  $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ptm_number)",$search);
  $this->db->or_like("LOWER(ppm_project_name)",$search);
  $this->db->or_like("(av)::text","(".str_replace(',', '.', str_replace('.', '', $search)).")::text");
  $this->db->or_like("(ptm_created_date)::text","(".$search.")::text");
  $this->db->or_like("(ptm_completed_date)::text","(".$search.")::text");
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

$data['total'] = $this->Laporan_m->getDurasiDetail()->num_rows();

if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(metode)",$search);
    $this->db->or_like("LOWER(ptm_dept_name)",$search);
    $this->db->or_like("LOWER(ptm_subject_of_work)",$search);
    $this->db->or_like("LOWER(ptm_number)",$search);
    $this->db->or_like("LOWER(ppm_project_name)",$search);
    $this->db->or_like("(av)::text","(".str_replace(',', '.', str_replace('.', '', $search)).")::text");
    $this->db->or_like("(ptm_created_date)::text","(".$search.")::text");
    $this->db->or_like("(ptm_completed_date)::text","(".$search.")::text");
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

$rows = $this->Laporan_m->getDurasiDetail()->result_array();

$status = array(0=>"Nonaktif",1=>"Aktif");

foreach ($rows as $key => $value) {
  $rows[$key]['ptm_number'] = "<a href='".site_url("procurement/procurement_tools/monitor_pengadaan/lihat/".$rows[$key]['ptm_number']."")." ' target='_blank'>".$rows[$key]['ptm_number']."</a>"; 
  $rows[$key]['ptm_created_date'] =  date("d-m-Y", strtotime($rows[$key]['ptm_created_date']));
  $rows[$key]['ptm_completed_date'] =  date("d-m-Y", strtotime($rows[$key]['ptm_completed_date']));
  $rows[$key]['ppm_project_name'] = (!empty($rows[$key]['ppm_project_name'])) ? $rows[$key]['ppm_project_name'] : $rows[$key]['ptm_type_of_plan'];
  }

$data['rows'] = $rows;

echo json_encode($data);