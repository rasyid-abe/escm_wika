<?php

$get = $this->input->get();
$filtering = $this->uri->segment(3, 0);
$userdata = $this->Administration_m->getLogin();
$dept = $this->Administration_m->getDeptUser();
$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : "";
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "pr_number";

if ($userdata['job_title'] != 'ADMIN' || $userdata['dept_name'] != 'SUPPLY CHAIN MANAGEMENT' || $userdata['dept_name'] != 'SCM') {
    $this->db->where_in("pr_dept_id", $userdata['dept_id']);
}

$data['total'] = $this->Procpr_m->getPR($id)->num_rows();

if (!empty($search)) {
    $this->db->group_start();
    $this->db->like("LOWER(pr_number)", $search);
    $this->db->or_like("LOWER(pr_requester_name)", $search);
    $this->db->or_like("LOWER(pr_subject_of_work)", $search);
    $this->db->or_like("LOWER(pr_packet)", $search);
    $nilai = str_replace(',', '.', str_replace('.', '', $search));
    $this->db->or_like('LOWER("nilai"::text)', is_numeric($nilai) ? $nilai + 0 : $nilai);
    $this->db->or_like("LOWER(pr_dept_name)", $search);
    $this->db->or_like("LOWER(status)", $search);
    $this->db->or_where("LOWER(pr_number)", $search);
    $this->db->group_end();
}
if (!empty($order)) {
    $this->db->order_by($field_order, $order);
}

if (!empty($limit)) {
    $this->db->limit($limit, $offset);
}


$rows = $this->Procpr_m->getPR($id)->result_array();
$total = $this->Procpr_m->getPR($id)->num_rows();

if ($rows) {
    $this->response([
        'status' => true,
        'total' => $total,
        'data' => $rows,
    ], REST_Controller::HTTP_OK);
} else {
    $this->response([
        'status' => FALSE,
        'message' => 'No data were found'
    ], REST_Controller::HTTP_NOT_FOUND);
}
