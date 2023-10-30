<?php

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$userdata = $this->data['userdata'];

/*$officer = $this->Administration_m->getPosition();

$pos = array();

foreach ($officer as $key => $value) {
  $pos[] = $value['pos_id'];
}
*/

$dept = $userdata['dept_id'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "desc";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "ppc_start_date";

if($field_order == "pr_number"){
  // $field_order = "A.pr_number";
  $field_order = "pr_number";
}


if(!empty($userdata['pos_id'])){
  $this->db->where("ppc_pos_code",$userdata['pos_id'],false);

} else {
  // $this->db->where("A.pr_number","");
  $this->db->where("pr_number","");
}


if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pr_number)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(jenis_pengadaan)",$search);
  $this->db->or_like("LOWER(awa_name)",$search);
  $this->db->or_like("LOWER(waktu)",$search);
  $this->db->group_end();
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("pr_status",1);
}

$this->db->select("ppc_id");
$this->db->where(array("pr_status"=>1012, "pr_buyer_id"=>$userdata['employee_id']));
$data['total'] = $this->Procpr_m->getViewPekerjaanPR($id)->num_rows();

if(!empty($userdata['pos_id'])){
  $this->db->where("ppc_pos_code",$userdata['pos_id'],false)->where("ppc_activity !=",1028);
} else {
  // $this->db->where("A.pr_number","");
  $this->db->where("pr_number","");
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(pr_number)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(jenis_pengadaan)",$search);
  $this->db->or_like("LOWER(awa_name)",$search);
  $this->db->or_like("LOWER(waktu)",$search);
  $this->db->group_end();
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  // $this->db->limit($limit,$offset);
}

if(!empty($filtering) && $filtering == "approval"){
  $this->db->where("pr_status",1);
}

$this->db->select("ppc_id,pr_number,pr_requester_name,pr_subject_of_work,jenis_pengadaan,awa_name as activity,waktu");

$this->db->where(array("pr_status"=>1012, "pr_buyer_id"=>$userdata['employee_id']));
$rows = $this->Procpr_m->getViewPekerjaanPR($id)->result_array();

$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {

}

$data['rows'] = $rows;
// echo $this->db->last_query();
echo json_encode($data);