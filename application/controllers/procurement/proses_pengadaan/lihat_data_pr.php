<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(4, 0);

$listpr = $this->uri->segment(3);

$userdata = $this->data['userdata'];

$dept = $this->Administration_m->getDeptUser();

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 100;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "a.pr_number";

$joined = $this->Procpr_m->getPR($listpr)->row_array();

if(!empty($search)){
  $this->db->group_start();
  $this->db->where(array("a.pr_number" => null));
  $this->db->or_like("LOWER(pr_subject_of_work)",$search);
  $this->db->or_like("LOWER(pr_requester_name)",$search);
  $this->db->or_like("LOWER(pr_dept_name)",$search);
//  $this->db->or_like("nilai",$search);
  $this->db->or_like("LOWER(a.status)",$search);
  // $this->db->or_like("LOWER(a.pr_number)",$search);
  $this->db->or_like("b.ppi_code",$search);

  $this->db->group_end(); 
}
if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

if($joined['joinrfq'] == NULL){
    $this->db->where(array("pr_status"=> 1012, "pr_buyer_id"=>$joined['pr_buyer_id']));
   $rows = $this->Procpr_m->getJoinPR($id, "")->result_array();
}else{
  $this->db->where(array("pr_status"=> 1040, "joinrfq"=>$joined['joinrfq']));
  $rows = $this->Procpr_m->getJoinPR("", $joined['joinrfq'])->result_array();
}

$selection = $this->data['selection_permintaan_pengadaan'];

$status = array(1=>"Belum Disetujui",2=>"Telah Disetujui",3=>"Ditolak");

foreach ($rows as $key => $value) {
  $rows[$key]['nilai'] = inttomoney($rows[$key]['nilai']);
    $rows[$key]['detail'] = "<div style='color: red'><a href='".site_url()."/procurement/detail_join/".$rows[$key]['pr_number']. "' class = '.btn-warning' target='_blank'> Lihat detail </a></div>";

}


$data['rows'] = $rows;

echo json_encode($data);
// echo $this->db->last_query();