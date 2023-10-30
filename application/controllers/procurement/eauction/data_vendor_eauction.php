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
 SELECT DISTINCT a.vendor_id, a.ppm_id,
    b.vendor_name,
    a.jumlah_bid,
    row_number() OVER (ORDER BY a.jumlah_bid) AS rank
   FROM (( SELECT prc_eauction_history.ppm_id,
            prc_eauction_history.vendor_id,
            min(prc_eauction_history.jumlah_bid) AS jumlah_bid
           FROM prc_eauction_history
           WHERE ppm_id = '".$ptm_number."'
           AND selected = 1
          GROUP BY prc_eauction_history.vendor_id, prc_eauction_history.ppm_id) a
     JOIN vnd_header b ON ((b.vendor_id = a.vendor_id)))")->num_rows();
// $this->db->select("vendor_name,jumlah_bid,rank")->where("ppm_id",$ptm_number)
// ->get("$table a")->num_rows();

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
 SELECT DISTINCT a.vendor_id, a.ppm_id,
    b.vendor_name,
    a.jumlah_bid,
    row_number() OVER (ORDER BY a.jumlah_bid) AS rank
   FROM (( SELECT prc_eauction_history.ppm_id,
            prc_eauction_history.vendor_id,
            min(prc_eauction_history.jumlah_bid) AS jumlah_bid
           FROM prc_eauction_history
           WHERE ppm_id = '".$ptm_number."'
           AND selected = 1
          GROUP BY prc_eauction_history.vendor_id, prc_eauction_history.ppm_id) a
     JOIN vnd_header b ON ((b.vendor_id = a.vendor_id))) order by rank asc")->result_array();


foreach ($rows as $key => $value) {
  $bid_before = $this->db->query("SELECT jumlah_bid as bid_before, tgl_bid FROM prc_eauction_history pc where
    pc.ppm_id = '".$ptm_number."' and pc.vendor_id = '".$rows[$key]['vendor_id']."'
    and pc.selected = 0
    order by id asc limit 1")->result();

  $rows[$key]['tgl_bid'] = !empty($bid_before[0]->tgl_bid) ? $bid_before[0]->tgl_bid : "-";
  $rows[$key]['jumlah_bid'] = inttomoney($rows[$key]['jumlah_bid']);
  $rows[$key]['bid_now'] = ($rows[$key]['jumlah_bid']);
  $rows[$key]['bid_before'] = !empty($bid_before[0]->bid_before) ? inttomoney($bid_before[0]->bid_before) : "-";
}

$data['rows'] = $rows;

$this->output->set_content_type('application/json')->set_output(json_encode($data));