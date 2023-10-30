<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$ptm_number = (isset($get['ptm_number']) && !empty($get['ptm_number'])) ? $get['ptm_number'] : $this->session->userdata("rfq_id");

$eauction_name = (isset($get['ptm_number']) && !empty($get['ptm_number'])) ? $get['ptm_number'] : "";

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "rank";


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ppm_id)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(jumlah_bid)",$search);
  $this->db->or_like("LOWER(rank)",$search);
  $this->db->group_end();
}

$data['total'] = $this->db->query("
SELECT * FROM prc_eauction_history pe
where pe.ppm_id  = '".$ptm_number."' and pe.vendor_id = '".$id."' ")->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(ppm_id)",$search);
  $this->db->or_like("LOWER(vendor_name)",$search);
  $this->db->or_like("LOWER(jumlah_bid)",$search);
  $this->db->or_like("LOWER(rank)",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
  $order_query = "order by $field_order $order";
}else{
  $this->db->order_by('rank', 'asc');
  $order_query = "order by rank asc";
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->db->query("
SELECT pe.ppm_id, pe.jumlah_bid , pe.tgl_bid , pe.vendor_id , vnd.vendor_name FROM prc_eauction_history pe
INNER JOIN vnd_header vnd ON pe.vendor_id=vnd.vendor_id
where pe.ppm_id  = '".$ptm_number."' and pe.vendor_id = '".$id."' ")->result_array();

foreach ($rows as $key => $value) {
    $rows[$key]['number'] = $key+1;
    $rows[$key]['jumlah_bid'] = inttomoney($value['jumlah_bid']);
}

$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));