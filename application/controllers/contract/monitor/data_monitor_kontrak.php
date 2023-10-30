<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$officer = $this->Administration_m->getPosition();

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "contract_id";
$vnd_id = (isset($get['vnd_id']) && !empty($get['vnd_id'])) ? $get['vnd_id'] : "";

if($filtering === "active"){
  $this->db->where("status",2901);
}
else if ($filtering === "tools") {
  $this->db->where("status !=", 2902);
}
else if ($filtering === "activeandfinish") {
  $this->db->group_start();
  $this->db->where("vw_ctr_monitor_amandemen.status",2901);
  $this->db->or_where("vw_ctr_monitor_amandemen.status",2903);
  $this->db->group_end();
}
else if ($filtering === "monitor_kompilasi_vpi") {
  $this->db->join('vw_vnd_vpi_header b', 'b.vvh_contract_id = vw_ctr_monitor_amandemen.contract_id');
  $this->db->join('vnd_vpi_kompilasi c', 'b.vvh_id = c.vvh_id');
}

if (!empty($vnd_id)) {
  $this->db->where('vendor_id', $vnd_id);
}

$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor_amandemen.ptm_number');
if ($userdata['job_title'] == 'ADMIN' || $userdata['pos_name'] == 'GM SCM Strategis' || $userdata['pos_name'] == 'Kepala Divisi SCM' || $userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] == 'SCM') {
} else{
      $this->db->where('a.ptm_dept_id', $userdata['dept_id']);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(a.ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.ptm_number)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.contract_number)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.contract_type)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.vendor_name)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.status_name)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Contract_m->getMonitor($id)->num_rows();

if($filtering === "active"){
  $this->db->where("vw_ctr_monitor_amandemen.status",2901);
}
else if ($filtering === "tools") {
  $this->db->where("vw_ctr_monitor_amandemen.status !=", 2902);
}
else if ($filtering === "activeandfinish") {
  $this->db->group_start();
  $this->db->where("vw_ctr_monitor_amandemen.status",2901);
  $this->db->or_where("vw_ctr_monitor_amandemen.status",2903);
  $this->db->group_end();
}
else if ($filtering === "monitor_kompilasi_vpi") {
  $this->db->join('vw_vnd_vpi_header b', 'b.vvh_contract_id = vw_ctr_monitor_amandemen.contract_id');
  $this->db->join('vnd_vpi_kompilasi c', 'b.vvh_id = c.vvh_id');
}

if (!empty($vnd_id)) {
  $this->db->where('vendor_id', $vnd_id);
}

$this->db->join('prc_tender_main a', 'a.ptm_number = vw_ctr_monitor_amandemen.ptm_number');
if ($userdata['job_title'] == 'ADMIN' || $userdata['pos_name'] == 'GM SCM Strategis' || $userdata['pos_name'] == 'Kepala Divisi SCM' || $userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] == 'SCM') {
} else{
      $this->db->where('a.ptm_dept_id', $userdata['dept_id']);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(a.ptm_subject_of_work)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.ptm_number)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.contract_number)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.contract_type)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.vendor_name)",$search);
  $this->db->or_like("LOWER(vw_ctr_monitor_amandemen.status_name)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Contract_m->getMonitor($id)->result_array();

$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {
  $rows[$key]['vw_ctr_monitor_amandemen.ptm_number'] = $rows[$key]['ptm_number'];
}

$data['rows'] = $rows;

echo json_encode($data);
