<?php

$get = $this->input->get();

$activity_active = $this->Settings_m->get_settings_num('_ACT_WO_MATGIS_ACTIVE');
$activity_canceled = $this->Settings_m->get_settings_num('_ACT_WO_MATGIS_CANCELED');
$activity_finished = $this->Settings_m->get_settings_num('_ACT_WO_MATGIS_FINISHED');

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];
//print_r($userdata);die;

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "B.contract_id";

if(!empty($userdata['pos_id'])){
  $this->db->where("cwo_pos_code",$userdata['pos_id'],false);
} else {
  $this->db->where("B.contract_id","");
}
//echo $this->db->last_query(); die;

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER('B.po_notes')",$search);
  $this->db->or_like("LOWER('B.vendor_name')",$search);
  $this->db->or_where("B.po_number",$search);
  $this->db->group_end();
}

$this->db->select("cwo_id");
$this->db->where_not_in("awa_id",array($activity_active,$activity_canceled,$activity_finished));
$data['total'] = $this->Contract_m->getPekerjaanWOMatgis($id)->num_rows();


if(!empty($userdata['pos_id'])){
  $this->db->where("cwo_pos_code",$userdata['pos_id'],false);
} else {
  $this->db->where("B.contract_id","");
}


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER('B.wo_notes')",$search);
  $this->db->or_like("LOWER('B.vendor_name')",$search);
  $this->db->or_where("B.wo_number",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where_not_in("awa_id",array($activity_active,$activity_canceled,$activity_finished));

$this->db->select("cwo_id,wo_number,contract_number,wo_notes,B.vendor_name,contract_type,awa_name as activity,to_date(cwo_start_date::text,'DD/MM/YYYY HH24:MI'::text) as waktu");

$rows = $this->Contract_m->getPekerjaanWOMatgis($id)->result_array();


foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;

echo json_encode($data);
