<?php 

$get = $this->input->get();
$klasifikasi_gbl = $this->session->userdata("klasifikasi_gbl");

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
   $this->db->or_like("LOWER('fin_class_name')",$search);
  $this->db->or_like("LOWER(reg_status_name)",$search);
  $this->db->group_end();
}
if(!empty($klasifikasi_gbl)){
  $this->db->where("fin_class",$klasifikasi_gbl);
}

$data['total'] = $this->db->get("vw_vnd_header")->num_rows();
if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
   $this->db->or_like("LOWER('fin_class_name')",$search);
  $this->db->or_like("LOWER(reg_status_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}
if(!empty($klasifikasi_gbl)){
  $this->db->where("fin_class",$klasifikasi_gbl);
}

$rows = $this->db->get("vw_vnd_header")->result_array();

foreach ($rows as $key => $value) {
     if ($rows[$key]['fin_class'] == 'K') {
       $rows[$key]['klasifikasi'] = 'Kecil';
     } else if ($rows[$key]['fin_class'] == 'M'){
      $rows[$key]['klasifikasi'] = 'Menengah';
     } else {
      $rows[$key]['klasifikasi'] = 'Besar';
     }
     
  }
// echo "<pre>";
//   var_dump($rows);
  
$data['rows'] = $rows;

echo json_encode($data);