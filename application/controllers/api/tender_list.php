<?php

$tender = array();

$no_tender = $this->get('no_tender');
$nama_paket = $this->get('nama_paket');
$jenis_pengadaan = $this->get('jenis_pengadaan');
$anggaran = $this->get('anggaran');
$posisi = $this->get('posisi');
$status = $this->get('status');
$metode = $this->get('metode');

$offset = $this->get('offset');
$limit = $this->get('limit');

$this->db->select('prc.ptm_created_date, prc.ptm_number, prc.ptm_sub_mata_anggaran, prc.ptm_nama_sub_mata_anggaran, prc.ptm_nama_mata_anggaran, prc.ptm_mata_anggaran, prc.ptm_subject_of_work, prc.ptm_packet, prc.ptm_dept_name, prc.jenis_pengadaan, prc.last_pos, prc.status, prc.ptm_dept_id, prc.ptm_dept, prc.last_status, prc.ptm_pagu_anggaran, prc.tender_metode, count(prc.ptm_number) as jml_bidder');
$this->db->join('vw_prc_bidder_list bidder', 'prc.ptm_number = bidder.ptm_number', 'left');
$this->db->group_by('prc.ptm_created_date, prc.ptm_number, prc.ptm_sub_mata_anggaran, prc.ptm_nama_sub_mata_anggaran, prc.ptm_nama_mata_anggaran, prc.ptm_mata_anggaran, prc.ptm_subject_of_work, prc.ptm_packet, prc.ptm_dept_name, prc.jenis_pengadaan, prc.last_pos, prc.status, prc.ptm_dept_id, prc.ptm_dept, prc.last_status, prc.ptm_pagu_anggaran, prc.tender_metode');
$this->db->order_by("prc.ptm_created_date", "desc");

if (isset($no_tender)) {
    $this->db->or_like("prc.ptm_number", $no_tender);
}
if (isset($nama_paket)) {
    $this->db->or_like("prc.ptm_packet", $nama_paket);
}
if (isset($jenis_pengadaan)) {
    $this->db->or_where("prc.jenis_pengadaan", $jenis_pengadaan);
}
if (isset($anggaran)) {
    $this->db->or_like("CAST(prc.ptm_pagu_anggaran as TEXT)", $anggaran);
}
if (isset($posisi)) {
    $this->db->or_like("prc.last_pos", $posisi);
}
if (isset($status)) {
    $this->db->or_like("prc.status", $status);
}
if (isset($metode)) {
    $this->db->or_like("prc.tender_metode", $metode);
}
if ($limit > 0 || $offset > 0) {
    $this->db->limit($limit, $offset);
}

$data = $this->db->get("vw_prc_monitor prc")->result_array();
$total = $this->db->get("vw_prc_monitor prc")->num_rows();

if ($data) {
    foreach ($data as $key => $val) {
        $tender[$key]['no_tender'] = $val['ptm_number'];
        $tender[$key]['nama_paket'] = $val['ptm_packet'];
        $tender[$key]['jenis_pengadaan'] = $val['jenis_pengadaan'];
        $tender[$key]['anggaran'] = $val['ptm_pagu_anggaran'];
        $tender[$key]['posisi'] = $val['last_pos'];
        $tender[$key]['status'] = $val['status'];
        $tender[$key]['metode'] = $val['tender_metode'];
        $tender[$key]['bidder'] = $val['jml_bidder'];
        $tender[$key]['created_date'] = $val['ptm_created_date'];
    }
    $this->response([
        'status' => true,
        'total' => $total,
        'data' => $tender
    ], REST_Controller::HTTP_OK);
} else {
    $this->response([
        'status' => FALSE,
        'message' => 'No contract were found'
    ], REST_Controller::HTTP_NOT_FOUND);
}
