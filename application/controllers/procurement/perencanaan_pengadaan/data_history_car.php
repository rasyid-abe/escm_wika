<?php

$get = $this->input->get();

$userdata = $this->data['userdata'];

$filtering = $this->uri->segment(3, 0);

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "a.phc_id";


// echo "line 55\n";
if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(a.phc_id)",$search);
  $this->db->or_like("LOWER(a.phc_name)",$search);
  $this->db->or_like("LOWER(a.hcp_activity)",$search);
  $this->db->or_like("LOWER(d.dept_name)",$search);
  $this->db->or_like("LOWER(a.phc_type)",$search);
  $this->db->or_like("LOWER(a.phc_user_update)",$search);
  $this->db->group_end();
}

$data['total'] = $this->Procplan_m->getHistoryCar()->num_rows();

if(!empty($id)){
  $this->db->where("phc_id",$id);
}

// echo "line 55\n";
if(!empty($search)){
  $this->db->group_start();
  $this->db->or_like("LOWER(a.phc_id)",$search);
  $this->db->or_like("LOWER(a.phc_name)",$search);
  $this->db->or_like("LOWER(a.hcp_activity)",$search);
  $this->db->or_like("LOWER(d.dept_name)",$search);
  $this->db->or_like("LOWER(a.phc_type)",$search);
  $this->db->or_like("LOWER(a.phc_user_update)",$search);
  $this->db->group_end();
}


if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}
// $this->db->distinct();
// $this->db->select('a.*');
// $this->db->join('prc_plan_comment b', 'b.ppm_id = a.ppm_id');
$rows = $this->Procplan_m->getHistoryCar()->result_array();

$selection = $this->data['selection_perencanaan_pengadaan'];

$status = array(0=>"Simpan Sementara",1=>"Belum Disetujui",2=>"Telah Disetujui User",3=>"Telah Disetujui Kepala Anggaran",4=>"Revisi");

foreach ($rows as $key => $value) {
  if(!empty($selection) && in_array($value['phc_id'], $selection)){
    $rows[$key]['checkbox'] = true;
  }
  $rows[$key]["phc_created_date"] = date(DEFAULT_FORMAT_DATETIME,strtotime($rows[$key]['phc_created_date']));
  //$rows[$key]["phc_nominal"] = inttomoney($rows[$key]["phc_nominal"]);
};
$data['rows'] = $rows;  
echo json_encode($data);
// echo $this->db->last_query();