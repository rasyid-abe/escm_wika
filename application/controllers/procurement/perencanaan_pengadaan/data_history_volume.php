<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "asc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ppm_id";

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

$volume_awal = (isset($get['volume_awal']) && !empty($get['volume_awal'])) ? $get['volume_awal'] : "";

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER((ppv_main)::text)",$search);
  $this->db->or_like("LOWER((ppv_remain)::text)",$search);
  $this->db->or_like("LOWER((ppv_plus)::text)",$search);
  $this->db->or_like("LOWER((ppv_minus)::text)",$search);
  $this->db->or_like("LOWER((ppv_created_datetime)::text)",$search);
  $this->db->or_like("LOWER((ppv_number)::text)",$search);
  $this->db->or_like("LOWER((ppv_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((group_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((smbd_name)::text)",$search);
  $this->db->or_like("LOWER((ppv_unit)::text)",$search);
  $this->db->or_like("LOWER((status)::text)",$search);
  $this->db->or_like("LOWER((ppv_prc)::text)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if (!empty($volume_awal)) {
  $this->db->where('ppv_activity', "0");
}

$data['total'] = $this->Comment_m->getVolumeHist($id)->num_rows();

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER((ppv_main)::text)",$search);
  $this->db->or_like("LOWER((ppv_remain)::text)",$search);
  $this->db->or_like("LOWER((ppv_plus)::text)",$search);
  $this->db->or_like("LOWER((ppv_minus)::text)",$search);
  $this->db->or_like("LOWER((ppv_created_datetime)::text)",$search);
  $this->db->or_like("LOWER((ppv_number)::text)",$search);
  $this->db->or_like("LOWER((ppv_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((group_smbd_code)::text)",$search);
  $this->db->or_like("LOWER((smbd_name)::text)",$search);
  $this->db->or_like("LOWER((ppv_unit)::text)",$search);
  $this->db->or_like("LOWER((status)::text)",$search);
  $this->db->or_like("LOWER((ppv_prc)::text)",$search);
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if (!empty($volume_awal)) {
 $this->db->where('ppv_activity', "0");
}

$rows = $this->Comment_m->getVolumeHist($id)->result_array();
$no = 1;
foreach ($rows as $key => $value) {
  $rows[$key]['no'] = $no;
  $rows[$key]["ppv_remain"] = inttomoney($rows[$key]["ppv_remain"]+0);
  $rows[$key]["ppv_main"] = inttomoney($rows[$key]["ppv_main"]+0);
  $rows[$key]["ppv_plus"] = inttomoney($rows[$key]["ppv_plus"]+0);
  $rows[$key]["ppv_minus"] = inttomoney($rows[$key]["ppv_minus"]+0);

  if ($rows[$key]['ppv_prc'] == 'PR') {
     $rows[$key]["status"] = $rows[$key]["status"]." <a href='".site_url('procurement/procurement_tools/monitor_pengadaan/lihat_permintaan/').$rows[$key]['ppv_no']."' target='_blank'>".$rows[$key]['ppv_no']."</a>";
  }elseif ($rows[$key]['ppv_prc'] == 'RFQ') {
      $rows[$key]["status"] = $rows[$key]["status"]." <a href='".site_url('procurement/procurement_tools/monitor_pengadaan/lihat/').$rows[$key]['ppv_no']."' target='_blank'>".$rows[$key]['ppv_no']."</a>";
  }elseif ($rows[$key]['ppv_prc'] == 'CTR') {
     $rows[$key]["status"] = $rows[$key]["status"]." <a href='".site_url('contract/monitor/monitor_kontrak/lihat/').$rows[$key]['ppv_no']."' target='_blank'>".$rows[$key]['ppv_no']."</a>";
  }else{
     $rows[$key]["status"] = $rows[$key]["status"];
  }
   
   $no++;

}


$data['rows'] = $rows;

echo json_encode($data);
