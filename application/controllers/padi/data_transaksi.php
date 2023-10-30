<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "transaksi_id";

if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(nama_project)",$search);
    $this->db->or_like("LOWER(transaksi_id)",$search);
    $this->db->group_end();
}

$data['total'] = $this->Padi_m->get_daftar_transaksi()->num_rows();

if(!empty($search)){
    $this->db->group_start();
    $this->db->like("LOWER(nama_project)",$search);
    $this->db->or_like("LOWER(transaksi_id)",$search);
    $this->db->group_end();
}

if(!empty($order)){
    $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
    $this->db->limit($limit,$offset);
}

$rows = $this->Padi_m->get_daftar_transaksi()->result_array();

foreach ($rows as $key => $value) {
  
}

$data['rows'] = $rows;

echo json_encode($data);