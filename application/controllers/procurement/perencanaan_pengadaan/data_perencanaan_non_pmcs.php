<?php

$get = $this->input->get();
// $this->unset_session("query_data_kebutuhan_pmcs");
$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
// $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "created_date";

// if ($userdata['job_title'] != "ADMIN" && ($userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] != 'SCM')) {
//     $this->db->where('ppm_dept_id', $userdata['dept_id']);
// }

if(!empty($search)){
  $this->db->group_start();

  // $this->db->like("LOWER(spk_code)",$search);
  // $this->db->or_like("LOWER(project_name)",$search);
  // $this->db->or_like("LOWER(dept_code)",$search);
  // $this->db->or_like("LOWER(dept_name)",$search);
  // $this->db->or_like("LOWER(group_smbd_code)",$search);
  // $this->db->or_like("LOWER(group_smbd_name)",$search);
  // $this->db->or_like("LOWER(smbd_type)",$search);
  // $this->db->or_like("LOWER(smbd_code)",$search);
  // $this->db->or_like("LOWER(smbd_name)",$search);
  // $this->db->or_like("LOWER(unit)",$search);
  // $this->db->or_like("(smbd_quantity)::text", replace_comma($search));
  // $this->db->or_like("(coa_code)::text",$search);
  // $this->db->or_like("LOWER(coa_name)",$search);
  // $this->db->or_like("LOWER(currency)",$search);
  // $this->db->or_like("LOWER(is_matgis)",$search);

  $this->db->group_end();
}
;
$data['total'] = $this->db->get("vw_prc_matgis_header_detail")->num_rows();
// echo $this->db->last_query();

// if ($userdata['job_title'] != "ADMIN" && ($userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] != 'SCM')) {
//     $this->db->where('ppm_dept_id', $userdata['dept_id']);
// }

if(!empty($search)){
  $this->db->group_start();

  // $this->db->like("LOWER(spk_code)",$search);
  // $this->db->or_like("LOWER(project_name)",$search);
  // $this->db->or_like("LOWER(dept_code)",$search);
  // $this->db->or_like("LOWER(dept_name)",$search);
  // $this->db->or_like("LOWER(group_smbd_code)",$search);
  // $this->db->or_like("LOWER(group_smbd_name)",$search);
  // $this->db->or_like("LOWER(smbd_type)",$search);
  // $this->db->or_like("LOWER(smbd_code)",$search);
  // $this->db->or_like("LOWER(smbd_name)",$search);
  // $this->db->or_like("LOWER(unit)",$search);
  // $this->db->or_like("(smbd_quantity)::text", replace_comma($search));
  // $this->db->or_like("(coa_code)::text",$search);
  // $this->db->or_like("LOWER(coa_name)",$search);
  // $this->db->or_like("LOWER(currency)",$search);
  // $this->db->or_like("LOWER(is_matgis)",$search);
  $this->db->group_end();
}



if(!empty($order)){
  // $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}


$rows = $this->db->get("vw_prc_matgis_header_detail")->result_array();
// $this->set_session("query_data_kebutuhan_pmcs", $this->db->last_query());

foreach ($rows as $key => $value) {
  // $rows[$key]['smbd_quantity'] = number_format($rows[$key]['smbd_quantity']+0, 6, ',', '.') ;
};

$data['rows'] = $rows;
echo json_encode($data);
// echo $this->db->last_query();
