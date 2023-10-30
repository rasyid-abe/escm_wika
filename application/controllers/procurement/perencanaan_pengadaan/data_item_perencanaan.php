<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$perencanaan = null;

if (isset($get['spk_code'])) {
  $this->db->select('ppm_id');
  $this->db->distinct();
  $this->db->where('ppm_project_id', $get['spk_code']);
  $perencanaan = $this->db->get('prc_plan_main')->row_array();   
}

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "asc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "smbd_code";

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER((group_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((smbd_code)::text)",$search);
  $this->db->or_like("LOWER(smbd_name)",$search);
  $this->db->or_like("LOWER(unit)",$search);
  $this->db->or_like("LOWER((price)::text)",$search);
  $this->db->or_like("LOWER(group_smbd_name)",$search);
  $this->db->group_end();
}

if(!empty($id)){

  $group_code = substr($id, 0, 3);
  $smbd_code =  $id;
  $arr = array(
    'smbd_code' => $smbd_code
  );
  $this->db->where($arr);
}

if (!empty($perencanaan)) {
  $this->db->where('ppm_id', $perencanaan['ppm_id']); 
}

$result = $this->db->get("vw_prc_plan_item a");

$data['total'] = $result->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER((group_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((smbd_code)::text)",$search);
  $this->db->or_like("LOWER(smbd_name)",$search);
  $this->db->or_like("LOWER(unit)",$search);
  $this->db->or_like("LOWER((price)::text)",$search);
  $this->db->or_like("LOWER(group_smbd_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by("smbd_code",$order);
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if(!empty($id)){

 $group_code = substr($id, 0, 3);
 $smbd_code =  $id;
 $arr = array(
  'smbd_code' => $smbd_code
);
 $this->db->where($arr);

}

if (!empty($perencanaan)) {
  $this->db->where('ppm_id', $perencanaan['ppm_id']); 
}

$result = $this->db->get("vw_prc_plan_item a");

$rows = $result->result_array();

foreach ($rows as $key => $value) {

  $rows[$key]['checkbox'] = true;
  $rows[$key]["price"] = inttomoney($rows[$key]["price"]);
  $rows[$key]["ppv_max"] = $rows[$key]["ppv_max"]+0;
  $rows[$key]["ppv_remain"] = $rows[$key]["ppv_remain"]+0;

}

if (!empty($id)) {
  $this->db->select("substr((periode_pengadaan::text), 1,4) as tahun");
  $this->db->where('spk_code', $get['spk_code']);
  $this->db->where('smbd_code', substr($id, 3,6));
  $this->db->group_by("substr((periode_pengadaan::text), 1,4)");
  $periode_pengadaan_tahun = $this->db->get('prc_plan_integrasi')->result_array();
  $n = 0;
  foreach ($periode_pengadaan_tahun as $key => $value_thn) {

    $rows['periode_pengadaan'][$n] = array(
      'id' => $value_thn['tahun'],
      'text' => $value_thn['tahun'],
      'children' => array()
    );
    
    $tahun = $value_thn['tahun'];
    $this->db->select('periode_pengadaan');
    $this->db->where('spk_code', $get['spk_code']);
    $this->db->where('smbd_code', substr($id, 3,6));
    $this->db->like('(periode_pengadaan)::text', "$tahun");
    $periode_pengadaan = $this->db->get('prc_plan_integrasi')->result_array();
    $no = 1;
    foreach ($periode_pengadaan as $key => $value) {

     $date = date_create($value['periode_pengadaan']);
     $rows['periode_pengadaan'][$n]['children'][] = array(
      'parent' => $value_thn['tahun'],
      'id' => $value['periode_pengadaan'],
      'text' => date_format($date,"d-M-Y")
    );

     $no++;
   }
   
   $n++;
 }
}


$data['rows'] = $rows;

echo json_encode($data);
