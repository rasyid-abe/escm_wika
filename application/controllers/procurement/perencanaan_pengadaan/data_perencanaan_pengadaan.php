<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ppm_created_date";

$this->db->distinct();

$this->db->where('ppm_next_pos_id', $userdata['pos_id']);

$total_proses = $this->db->get('prc_plan_main a')->num_rows();

$pos = $this->Administration_m->getPosition();

$alldept = array();

$alldist = array();

$allppm = array();

foreach ($pos as $key => $value) {
  $alldept[] = $value['dept_id'];
  $alldist[] = $value['district_id'];
}

$query_emp_id = $this->db->where('employee_id', $userdata['employee_id'])->get('adm_employee_proyek')->result_array(); 

foreach ($query_emp_id as $key => $r) {
  $allppm[] = $r['ppm_id'];
}

$is_proyek = false;

$limit_anggaran = ($is_proyek) ? 200000000000 : 20000000000;

if(!empty($id)){
  $this->db->where("ppm_id",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(ppm_planner)",$search);
  $this->db->or_like("LOWER(ppm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ppm_dept_name)",$search);
  $this->db->or_like("LOWER(ppm_renc_kebutuhan_vw)",$search);
  $this->db->or_like("LOWER(ppm_renc_pelaksanaan_vw)",$search);
  $this->db->or_like("LOWER(ppm_created_date_vw)",$search);
  $this->db->or_like("LOWER(ppm_status_name)",$search);
  $this->db->or_like("LOWER(ppm_type_of_plan)",$search);
  $this->db->or_like("LOWER(ppm_type_of_plan2)",$search);
  $this->db->group_end();
}

$this->db->select("
  vw_prc_plan_main_v2.ppm_id, 
  ppm_created_date, 
  ppm_dept_id, 
  ppm_renc_kebutuhan, 
  ppm_renc_pelaksanaan, 
  ppm_pagu_anggaran, 
  ppm_sisa_anggaran,
  ppm_status,
  ppm_project_id,
  ppm_subject_of_work,
  ppm_dept_name,
  ppms_start_date,
  ppms_finish_date,
  ppm_type_of_plan
");

if(!empty($filtering)){

  switch ($filtering) {

    case 'approval':
      $this->db->where('ppm_next_pos_id', $userdata['pos_id']);
      $this->db->where("ppm_status !=",3);
    break;

    case 'matgis':
      $this->db->where("ppm_sisa_anggaran >",$limit_anggaran);
      $this->db->where('ppm_next_pos_id', 212);
      $this->db->where("ppm_status",3);
      $this->db->where("ppm_dept_id", $userdata['dept_id']);
    break;

    case 'approved':
      $this->db->where( array(
        'ppm_next_pos_id'=> 212,
        "ppm_status"=>3,
        "ppm_type_of_plan !=" => "rkp_matgis"
      ));
    break;

    case 'sap':
      $this->db->join('prc_plan_item ppi', 'vw_prc_plan_main_v2.ppm_id = ppi.ppm_id');      
      $this->db->where_in("vw_prc_plan_main_v2.ppm_id", $allppm);
      break;
      
    case 'sap_nonproyek':
      $this->db->join('prc_plan_item ppi', 'vw_prc_plan_main_v2.ppm_id = ppi.ppm_id');      
      $this->db->where_in("vw_prc_plan_main_v2.ppm_id", $allppm);
    break;
    
    case 'sap_matgis':
      $this->db->join('prc_plan_item ppi', 'vw_prc_plan_main_v2.ppm_id = ppi.ppm_id');      
      $this->db->where_in("vw_prc_plan_main_v2.ppm_id", $allppm);
    break;
    
    case 'update':
      $this->db->where_in("ppm_status",array(0,4));
    break;

    case 'pmcs':
      $this->db->where_in("ppm_is_integrated",'1');
    break;

    break;

  }

}

$this->db->group_by("
  vw_prc_plan_main_v2.ppm_id, 
  ppm_dept_id,
  ppm_created_date, 
  ppm_renc_kebutuhan, 
  ppm_renc_pelaksanaan, 
  ppm_pagu_anggaran, 
  ppm_sisa_anggaran,
  ppm_status,
  ppm_project_id,
  ppm_subject_of_work,
  ppm_dept_name,
  ppms_start_date,
  ppms_finish_date,
  ppm_type_of_plan
");

$data['total'] = $this->Procplan_m->getPerencanaanPengadaan()->num_rows();

if(!empty($id)){
  $this->db->where("ppm_id",$id);
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(ppm_planner)",$search);
  $this->db->or_like("LOWER(ppm_subject_of_work)",$search);
  $this->db->or_like("LOWER(ppm_dept_name)",$search);
  $this->db->or_like("LOWER(ppm_renc_kebutuhan_vw)",$search);
  $this->db->or_like("LOWER(ppm_renc_pelaksanaan_vw)",$search);
  $this->db->or_like("LOWER(ppm_created_date_vw)",$search);
  $this->db->or_like("LOWER(ppm_status_name)",$search);
  $this->db->or_like("LOWER(ppm_type_of_plan)",$search);
  $this->db->or_like("LOWER(ppm_type_of_plan2)",$search);
  $this->db->group_end();
}

$this->db->select("
  vw_prc_plan_main_v2.ppm_id, 
  ppm_created_date, 
  ppm_renc_kebutuhan, 
  ppm_renc_pelaksanaan, 
  ppm_pagu_anggaran, 
  ppm_sisa_anggaran,
  ppm_status,
  ppm_project_id,
  ppm_subject_of_work,
  ppm_dept_name,
  ppms_start_date,
  ppms_finish_date,
  ppm_type_of_plan
");

if(!empty($filtering)){

  switch ($filtering) {

    case 'approval':
      $this->db->where('ppm_next_pos_id', $userdata['pos_id']);
      $this->db->where("ppm_status !=",3);
    break;

    case 'matgis':
      $this->db->where("ppm_sisa_anggaran >",$limit_anggaran);
      $this->db->where('ppm_next_pos_id', 212);
      $this->db->where("ppm_status",3);
      $this->db->where("ppm_dept_id", $userdata['dept_id']);
    break;

    case 'approved':
      $this->db->where( array(
        'ppm_next_pos_id'=> 212,
        "ppm_status"=>3,
        "ppm_type_of_plan !=" => "rkp_matgis"
      ));
    break;

    case 'sap':      
      $this->db->join('prc_plan_item ppi', 'vw_prc_plan_main_v2.ppm_id = ppi.ppm_id');      
      $this->db->where_in("vw_prc_plan_main_v2.ppm_id", $allppm);
      break;
      
    case 'sap_nonproyek':
      $this->db->join('prc_plan_item ppi', 'vw_prc_plan_main_v2.ppm_id = ppi.ppm_id');      
      $this->db->where_in("vw_prc_plan_main_v2.ppm_id", $allppm);
    break;

    case 'sap_matgis':
      $this->db->join('prc_plan_item ppi', 'vw_prc_plan_main_v2.ppm_id = ppi.ppm_id');
      $this->db->where_in("vw_prc_plan_main_v2.ppm_id", $allppm);
    break;

    case 'update':
      $this->db->where_in("ppm_status",array(0,4));
    break;
    
    case 'pmcs':
      $this->db->where_in("ppm_is_integrated",'1');
      break;
      
    break;

  }

}

$this->db->group_by("
  vw_prc_plan_main_v2.ppm_id, 
  ppm_created_date, 
  ppm_dept_id,
  ppm_renc_kebutuhan, 
  ppm_renc_pelaksanaan, 
  ppm_pagu_anggaran, 
  ppm_sisa_anggaran,
  ppm_status,
  ppm_project_id,
  ppm_subject_of_work,
  ppm_dept_name,
  ppms_start_date,
  ppms_finish_date,
  ppm_type_of_plan
");

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

$selection = $this->data['selection_perencanaan_pengadaan'];

$status = array(0=>"Simpan Sementara",1=>"Belum Disetujui",2=>"Telah Disetujui User",3=>"Telah Disetujui Kepala Anggaran",4=>"Revisi");

foreach ($rows as $key => $value) {
  
  if(!empty($selection) && in_array($value['ppm_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }

  $year = substr($rows[$key]["ppm_renc_kebutuhan"], 0, 4);
  $month = substr($rows[$key]["ppm_renc_kebutuhan"], 4, 2);
  $year = substr($rows[$key]["ppm_renc_pelaksanaan"], 0, 4);
  $month = substr($rows[$key]["ppm_renc_pelaksanaan"], 4, 2);
  $rows[$key]["ppm_created_date"] = date(DEFAULT_FORMAT_DATETIME,strtotime($rows[$key]['ppm_created_date']));
  $rows[$key]["ppm_pagu_anggaran"] = inttomoney($rows[$key]["ppm_pagu_anggaran"]);
  $rows[$key]["ppm_sisa_anggaran"] = inttomoney($rows[$key]["ppm_sisa_anggaran"]);
  $rows[$key]["ppm_renc_kebutuhan"] = getmonthname($month)." ".$year;
  $rows[$key]["ppm_renc_pelaksanaan"] = getmonthname($month)." ".$year;
  $rows[$key]['ppm_status'] = (isset($status[$rows[$key]['ppm_status']])) ? $status[$rows[$key]['ppm_status']] : "Belum Disetujui";
  
};

$data['rows'] = $rows;  

echo json_encode($data);