<?php 

$get = $this->input->get();

switch ($kode) {
    case 'aktif':
        $table = 'vw_get_contract_aktif';
        break;

    case 'batal':
        $table = 'vw_get_contract_batal';
        break;

    case 'selesai':
        $table = 'vw_get_contract_selesai';
        break;

    case 'expired':
        $table = 'vw_get_contract_expired';
        break;

    case '3bln':
        $table = 'vw_get_contract_expired<3';
        break;

    case '1bln':
        $table = 'vw_get_contract_expired<1';
        break;
    
    default:
        $table = 'vw_get_contract_aktif';
        break;
}
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "contract_id";
$metode = (isset($get['metode']) && !empty($get['metode'])) ? $get['metode'] : 0;

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(contract_number)",$search);
  $this->db->or_like("(subject_work)::text",$search);
  $this->db->group_end();
}

$data['total'] = $this->db->get($table)->num_rows();

//echo $this->db->last_query();


if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(contract_number)",$search);
    $this->db->or_like("(subject_work)::text",$search);
    $this->db->group_end();
  }

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}


$rows = $this->db->get($table)->result_array();

$status = array(0=>"Nonaktif",1=>"Aktif");

foreach ($rows as $key => $value) {
  
  $rows[$key]['contract_number'] = "<a href='".site_url('contract/monitor/monitor_kontrak/lihat/'.$rows[$key]['contract_id'])."' target='_blank'>".$rows[$key]['contract_number']."</a>";

  }

$data['rows'] = $rows;

echo json_encode($data);