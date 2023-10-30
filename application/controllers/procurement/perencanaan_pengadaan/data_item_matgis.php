<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "asc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "a.smbd_catalog_code";

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

$last_item_code = (isset($get['last_item_code']) && !empty($get['last_item_code'])) ? $get['last_item_code'] : "";

$get_group = null;

// if (isset($last_item_code) && !empty($last_item_code)) {
  // $get_group = $this->db->where("mat_catalog_code",$last_item_code)
  // ->get("vw_grouping_catalog")->row_array();
  // if(!empty($get_group)){
    // $this->db->where("a.group_smbd_code",$get_group['mat_group_code']);
  // } else {
    // $kepala = substr($last_item_code, 0, 3);
    // $this->db->where("substring(a.smbd_catalog_code::text from 1 for 3) = '".$kepala."'");
  // }
// }

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER((a.group_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((a.smbd_catalog_code)::text)",$search);
  $this->db->or_like("LOWER(a.smbd_name)",$search);
  $this->db->or_like("LOWER(a.unit)",$search);
  $this->db->or_like("LOWER((a.price)::text)",$search);
  // $this->db->or_like("LOWER((a.periode_pengadaan)::text)",$search);
  $this->db->or_like("LOWER(a.group_smbd_name)",$search);
  $this->db->group_end();
}

// $this->db->select("Distinct on(a.mat_catalog_code) a.mat_catalog_code as smbd_catalog_code,b.group_code as group_smbd_code,b.group_name as group_smbd_name,a.mat_catalog_code as smbd_catalog_code,a.mat_catalog_code as smbd_code,a.long_description,a.short_description as smbd_name, a.uom as unit,(SELECT AVG(c.price) FROM prc_plan_integrasi c WHERE c.smbd_code = a.mat_catalog_code AND c.is_matgis = 't') as price,(SELECT SUM(c.smbd_quantity) FROM prc_plan_integrasi c WHERE c.smbd_code = a.mat_catalog_code AND c.is_matgis = 't') as smbd_quantity");

if(!empty($id)){

 $arr = ['smbd_catalog_code'=>$id];
 $this->db->where($arr);

}

// $this->db->join("com_group_smbd b","b.group_code=a.mat_group_code","left")
// ->where("b.is_matgis","t");

$result = $this->db->get("vw_data_item_matgis a");

$data['total'] = $result->num_rows();

// if (isset($last_item_code) && !empty($last_item_code)) {
  // if(!empty($get_group)){
    // $this->db->where("a.group_smbd_code",$get_group['mat_group_code']);
  // } else {
    // $kepala = substr($last_item_code, 0, 3);
    // $this->db->where("substring(a.smbd_catalog_code::text from 1 for 3) = '".$kepala."'");
  // }
// }

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER((a.group_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((a.smbd_catalog_code)::text)",$search);
  $this->db->or_like("LOWER(a.smbd_name)",$search);
  $this->db->or_like("LOWER(a.unit)",$search);
  $this->db->or_like("LOWER((a.price)::text)",$search);
  // $this->db->or_like("LOWER((a.periode_pengadaan)::text)",$search);
  $this->db->or_like("LOWER(a.group_smbd_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by("a.smbd_catalog_code",$order);
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

// $this->db->select("Distinct on(a.mat_catalog_code) a.mat_catalog_code as smbd_catalog_code,b.group_code as group_smbd_code,b.group_name as group_smbd_name,a.mat_catalog_code as smbd_catalog_code,a.mat_catalog_code as smbd_code,a.long_description, a.short_description as smbd_name, a.uom as unit,(SELECT AVG(c.price) FROM prc_plan_integrasi c WHERE c.smbd_code = a.mat_catalog_code AND c.is_matgis = 't') as price,(SELECT SUM(c.smbd_quantity) FROM prc_plan_integrasi c WHERE c.smbd_code = a.mat_catalog_code AND c.is_matgis = 't') as smbd_quantity");

if(!empty($id)){

  $arr = ['smbd_catalog_code'=>$id];
  $this->db->where($arr);

}

// $this->db->join("com_group_smbd b","b.group_code=a.mat_group_code","left")
// ->where("b.is_matgis","t");

$this->db->order_by('smbd_catalog_code', 'asc');

$result = $this->db->get("vw_data_item_matgis a");

$rows = $result->result_array();

foreach ($rows as $key => $value) {

  $rows[$key]['checkbox'] = true;

  // $rows[$key]["price"] = inttomoney($rows[$key]["price"]);

}
if (!empty($id) AND isset($get['spk_code'])) {
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
