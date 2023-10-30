<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

$dept = $this->Administration_m->getDeptUser();

$query_emp_id = $this->db->where('employee_id', $userdata['employee_id'])->get('adm_employee_proyek')->result_array(); 

foreach ($query_emp_id as $key => $r) {
  $allppm[] = $r['ppm_id'];
}

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vw_daftar_pekerjaan_sppbj_sap.pr_number";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pr_number)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(pr_packet)",$search);
  $nilai = str_replace(',', '.', str_replace('.', '', $search));
  $this->db->or_like('LOWER("nilai"::text)', is_numeric($nilai) ? $nilai+0 : $nilai);
  $this->db->or_like("LOWER(pr_dept_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->or_where("LOWER(pr_number)",$search);
  $this->db->group_end();
}

if ($userdata['job_title'] != 'GENERAL MANAJER') {
  $this->db->where("ppv.ppv_remain >", 0);
  $this->db->where_in("vw_daftar_pekerjaan_sppbj_sap.ppm_id", $allppm);
}

$this->db->select('vw_daftar_pekerjaan_sppbj_sap.pr_number, pr_packet, pr_type_pengadaan, nilai, pr_metode_pengadaan, pr_created_date, pr_requester_name, prc_risiko_main, status, pr_mata_anggaran, pr_nama_mata_anggaran, pr_sub_mata_anggaran, pr_nama_sub_mata_anggaran');
$this->db->join('prc_pr_item ppi', 'vw_daftar_pekerjaan_sppbj_sap.pr_number = ppi.pr_number');      
$this->db->join('prc_plan_volume ppv', 'vw_daftar_pekerjaan_sppbj_sap.ppm_id = ppv.ppm_id');      

if ($userdata['type_proyek'] == 'Matgis') {
  $this->db->join('adm_dept', 'vw_daftar_pekerjaan_sppbj_sap.pr_dept_id = adm_dept.dept_id');
  $this->db->where("adm_dept.dept_id", 13);
  $this->db->where("ppi.ppis_pr_type", 'ZPW2');
} else {
  $this->db->where_in("ppi.ppis_pr_type",array('ZPW2','ZPW3','ZPW4'));
}

$this->db->group_by('vw_daftar_pekerjaan_sppbj_sap.pr_number, pr_packet, pr_type_pengadaan, nilai, pr_metode_pengadaan, pr_created_date, pr_requester_name, prc_risiko_main, status, pr_mata_anggaran, pr_nama_mata_anggaran, pr_sub_mata_anggaran, pr_nama_sub_mata_anggaran');
$data['total'] = $this->Procpr_m->getPR_Sap($id)->num_rows();

if ($userdata['job_title'] != 'GENERAL MANAJER') {
  $this->db->where("ppv.ppv_remain >", 0);
  $this->db->where_in("vw_daftar_pekerjaan_sppbj_sap.ppm_id", $allppm);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pr_number)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(pr_packet)",$search);
  $nilai = str_replace(',', '.', str_replace('.', '', $search));
  $this->db->or_like('LOWER("nilai"::text)', is_numeric($nilai) ? $nilai+0 : $nilai);
  $this->db->or_like("LOWER(pr_dept_name)",$search);
  $this->db->or_like("LOWER(status)",$search);
  $this->db->or_where("LOWER(pr_number)",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->select('vw_daftar_pekerjaan_sppbj_sap.pr_number, pr_packet, pr_type_pengadaan, nilai, pr_metode_pengadaan, pr_created_date, pr_requester_name, prc_risiko_main, status, pr_mata_anggaran, pr_nama_mata_anggaran, pr_sub_mata_anggaran, pr_nama_sub_mata_anggaran');
$this->db->join('prc_pr_item ppi', 'vw_daftar_pekerjaan_sppbj_sap.pr_number = ppi.pr_number');      
$this->db->join('prc_plan_volume ppv', 'vw_daftar_pekerjaan_sppbj_sap.ppm_id = ppv.ppm_id');      

if ($userdata['type_proyek'] == 'Matgis') {
  $this->db->join('adm_dept', 'vw_daftar_pekerjaan_sppbj_sap.pr_dept_id = adm_dept.dept_id');
  $this->db->where("adm_dept.dept_id", 13);
  $this->db->where("ppi.ppis_pr_type", 'ZPW2');
} else {
  $this->db->where_in("ppi.ppis_pr_type",array('ZPW2','ZPW3','ZPW4'));
}

$this->db->group_by('vw_daftar_pekerjaan_sppbj_sap.pr_number, pr_packet, pr_type_pengadaan, nilai, pr_metode_pengadaan, pr_created_date, pr_requester_name, prc_risiko_main, status, pr_mata_anggaran, pr_nama_mata_anggaran, pr_sub_mata_anggaran, pr_nama_sub_mata_anggaran');
$rows = $this->Procpr_m->getPR_Sap($id)->result_array();

$selection = $this->data['selection_permintaan_pengadaan'];

$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['pr_number'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]['mata_anggaran'] = $rows[$key]['pr_mata_anggaran']." - ".$rows[$key]['pr_nama_mata_anggaran'];
  $rows[$key]['sub_mata_anggaran'] = $rows[$key]['pr_sub_mata_anggaran']." - ".$value['pr_nama_sub_mata_anggaran'];
  $rows[$key]['nilai'] = inttomoney($rows[$key]['nilai']);
}

$data['rows'] = $rows;

echo json_encode($rows);
