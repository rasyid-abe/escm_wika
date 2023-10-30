<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$deptid = $this->uri->segment(4, 0);

$deptuser = $userdata['dept_name'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ptm_number";


if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

$this->db->where_not_in("ptm_status", array(1902, 1903, 1904, 1906));
$data['total'] = $this->Laporan_m->getTender($deptid)->num_rows();

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$this->db->where_not_in("ptm_status", array(1902, 1903, 1904, 1906));
$rows = $this->Laporan_m->getTender($deptid)->result_array();

foreach ($rows as $key => $value) {
  $rows[$key]['hps'] = (empty($rows[$key]['hps'])) ? "-" : str_replace(',', '.',  number_format($rows[$key]['hps']));
  $rows[$key]['durasi'] = (empty($rows[$key]['durasi'])) ? "On Proses" : $rows[$key]['durasi']." hari";
  $rows[$key]['vendor_name'] = (empty($rows[$key]['vendor_name'])) ? "On Proses" : $rows[$key]['vendor_name'];
  $rows[$key]['tunjuk'] = (empty($rows[$key]['tunjuk'])) ? "On Proses" : $rows[$key]['tunjuk'];
  $rows[$key]['kirim_rfq'] = (empty($rows[$key]['kirim_rfq'])) ? "On Proses" : $rows[$key]['kirim_rfq'];
  $rows[$key]['total_contract'] = (empty($rows[$key]['total_contract'])) ? "On Proses" : str_replace(',', '.',  number_format($rows[$key]['total_contract']));
  $rows[$key]['efisiensi'] = (empty($rows[$key]['efisiensi'])) ? "-" : str_replace(',', '.',  number_format($rows[$key]['efisiensi']));
  $rows[$key]['selisih_persen'] = (empty($rows[$key]['selisih_persen'])) ? "-" : round($rows[$key]['selisih_persen'], 2)." %";
  $rows[$key]['ptm_project_name'] = (empty($rows[$key]['ptm_project_name'])) ? "Non Proyek" : $rows[$key]['ptm_project_name'];
  $rows[$key]['ptm_number'] = "<a href='".site_url()."/procurement/procurement_tools/monitor_pengadaan/lihat/".$rows[$key]['ptm_number']. "'  target='_blank'>".$rows[$key]['ptm_number']."</a></div>";

}

$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));