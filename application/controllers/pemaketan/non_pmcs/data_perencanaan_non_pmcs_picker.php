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

foreach ($pos as $key => $value) {
    $alldept[] = $value['dept_id'];
    $alldist[] = $value['district_id'];
}

$is_proyek = false;

$limit_anggaran = ($is_proyek) ? 200000000000 : 20000000000;

if ($userdata['job_title'] == "ADMIN" && ($userdata['dept_name'] == 'DIVISI SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT') || $userdata['job_title'] == 'PIC ANGGARAN') {
} else {
    //$this->db->where('ppm_dept_id', $userdata['dept_id']);
}

if (!empty($id)) {
    $this->db->where("ppm_id", $id);
}

// echo "line 55\n";
if (!empty($search)) {
    $this->db->group_start();
    $this->db->or_like("LOWER(ppm_planner)", $search);
    $this->db->or_like("LOWER(ppm_subject_of_work)", $search);
    $this->db->or_like("LOWER(ppm_dept_name)", $search);
    $this->db->or_like("LOWER(ppm_renc_kebutuhan_vw)", $search);
    $this->db->or_like("LOWER(ppm_renc_pelaksanaan_vw)", $search);
    $this->db->or_like("LOWER(ppm_created_date_vw)", $search);
    $this->db->or_like("LOWER(ppm_status_name)", $search);
    $this->db->or_like("LOWER(ppm_type_of_plan)", $search);
    $this->db->or_like("LOWER(ppm_type_of_plan2)", $search);
    $this->db->group_end();
}

if (!empty($filtering)) {

    switch ($filtering) {

        case 'approval':

            //if ($total_proses > 0) {

            $this->db->where('ppm_next_pos_id', $userdata['pos_id']);

            //$this->db->where("ppm_status !=",0);

            $this->db->where("ppm_status !=", 3);

            //} else {

            //$this->db->where("ppm_status",99);

            //}

            break;

        case 'matgis':

            $this->db->where("ppm_sisa_anggaran >", $limit_anggaran);

            $this->db->where('ppm_next_pos_id', 212);

            $this->db->where("ppm_status", 3);

            //$this->db->where("ppm_type_of_plan","rkp_matgis");

            $this->db->where("ppm_dept_id", $userdata['dept_id']);

            break;

        case 'approved':

            $this->db->where(array(
                'ppm_next_pos_id' => 212,
                "ppm_status" => 3,
                //"ppm_dept_id" => $userdata['dept_id'],
                "ppm_type_of_plan !=" => "rkp_matgis"
            ));

            break;

        case 'update':

            $this->db->where_in("ppm_status", array(0, 4));

            break;

        case 'pmcs':

            $this->db->where_in("ppm_is_integrated", '1');

            break;

            break;
    }
} else {
    /*
  if ($userdata['job_title'] == 'ADMIN' || $userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT') {

    $this->db->where_in("ppm_district_id",$alldist);
    $this->db->where_in("ppm_dept_id",$alldept);

  } else {

    $this->db->where('ppm_dept_id', $userdata['dept_id']);

  }
  */
}

// $this->db->distinct();
// $this->db->select('a.*');
// $this->db->join('prc_plan_comment b', 'b.ppm_id = a.ppm_id','right');
$data['total'] = $this->Procplan_m->getPerencanaanPengadaan()->num_rows();

if ($userdata['job_title'] == "ADMIN" && ($userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] == 'SCM') || $userdata['job_title'] == 'PIC ANGGARAN') {
} else {
    //$this->db->where('ppm_dept_id', $userdata['dept_id']);
}

/*
if ($userdata['job_title'] == 'ADMIN' || $userdata['dept_name'] == 'SUPPLY CHAIN MANAGEMENT') {
  $this->db->where_in("ppm_district_id",$alldist);
  $this->db->where_in("ppm_dept_id",$alldept);
} else {
  $this->db->where('ppm_dept_id', $userdata['dept_id']);
}
*/

if (!empty($id)) {
    $this->db->where("ppm_id", $id);
}

// echo "line 55\n";
if (!empty($search)) {
    $this->db->group_start();
    $this->db->or_like("LOWER(ppm_planner)", $search);
    $this->db->or_like("LOWER(ppm_subject_of_work)", $search);
    $this->db->or_like("LOWER(ppm_dept_name)", $search);
    $this->db->or_like("LOWER(ppm_renc_kebutuhan_vw)", $search);
    $this->db->or_like("LOWER(ppm_renc_pelaksanaan_vw)", $search);
    $this->db->or_like("LOWER(ppm_created_date_vw)", $search);
    $this->db->or_like("LOWER(ppm_status_name)", $search);
    $this->db->or_like("LOWER(ppm_type_of_plan)", $search);
    $this->db->or_like("LOWER(ppm_type_of_plan2)", $search);
    $this->db->group_end();
}

if (!empty($filtering)) {

    switch ($filtering) {

        case 'approval':

            //if ($total_proses > 0) {

            $this->db->where('ppm_next_pos_id', $userdata['pos_id']);

            //$this->db->where("ppm_status !=",0);

            $this->db->where("ppm_status !=", 3);

            //} else {

            //$this->db->where("ppm_status",99);

            //}

            break;

        case 'matgis':
            $this->db->where("ppm_sisa_anggaran >", $limit_anggaran);
            $this->db->where('ppm_next_pos_id', 212);
            $this->db->where("ppm_status", 3);
            //$this->db->where("ppm_type_of_plan","rkp_matgis");
            $this->db->where("ppm_dept_id", $userdata['dept_id']);
            break;

        case 'approved':

            $this->db->where(array(
                'ppm_next_pos_id' => 212,
                "ppm_status" => 3,
                //"ppm_dept_id" => $userdata['dept_id'],
                "ppm_type_of_plan !=" => "rkp_matgis"
            ));

            break;

        case 'update':

            $this->db->where_in("ppm_status", array(0, 4));

            break;

        case 'pmcs':

            $this->db->where_in("ppm_is_integrated", '1');

            break;

            break;
    }
}

if (!empty($order)) {
    $this->db->order_by($field_order, $order);
}

if (!empty($limit)) {
    $this->db->limit($limit, $offset);
}
$rows = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

$status = array(0 => "Simpan Sementara", 1 => "Belum Disetujui", 2 => "Telah Disetujui User", 3 => "Telah Disetujui Kepala Anggaran", 4 => "Revisi");

$data['rows'] = $rows;
echo json_encode($data);
