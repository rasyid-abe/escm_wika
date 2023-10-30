<?php

$get = $this->input->get();
$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "id";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(project_name)",$search);
  $this->db->or_like("LOWER(description)",$search);
  $this->db->or_like("LOWER(date_start)",$search);
  $this->db->or_like("LOWER(date_end)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->group_end();
}

if(!empty($id)){
  $this->db->where("id",$id);
}
$disabled = 1;
if (!empty($picker)) {
  $this->db->where('status', "aktif");
}
$this->db->where("disabled !=", $disabled);
$data['total'] = $this->db->get("vw_adm_project_list")->num_rows();

$ch_info = curl_init( CRM_WIKA_INFO );

$post = $this->input->post();

$year = date('Y');

if(isset($post['periode_inp'])){
  $year = $post['periode_inp'];
}

$data_info = array(
  'Tahun' => $year
);

$payload_info = json_encode( $data_info );

// $fullPath = dir(getcwd());
//
// $cookie_jar = $fullPath->path . '\assets\crmtmp.tmp';
//
// $BPMCSRF = isset($_COOKIE['BPMCSRF']) ? $_COOKIE['BPMCSRF'] : '1';
//
// curl_setopt($ch_info, CURLOPT_COOKIEFILE, $cookie_jar);
// curl_setopt($ch_info, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch_info, CURLINFO_HEADER_OUT, true);
// curl_setopt($ch_info, CURLOPT_POST, true);
// curl_setopt($ch_info, CURLOPT_POSTFIELDS, $payload_info);
// curl_setopt($ch_info, CURLOPT_HTTPHEADER, array(
//   'Content-Type: application/json',
//   'BPMCSRF:'. $BPMCSRF)
// );
//
// $result_info = curl_exec($ch_info);
//
// $value = json_decode($result_info, true);
$bpmcsrf = $this->Administration_m->sync();
$result_info = $this->Administration_m->get_data_api_crm($payload_info, $bpmcsrf);

$value = json_decode($result_info, true);
$datacrm = $value != '' ? $value['GetProyekSCMInfoResult']['Data'] : [];

$data['total'] = count($datacrm);
$data['rows'] = $datacrm;

echo json_encode($data);
