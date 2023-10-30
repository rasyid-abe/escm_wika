<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "DESC";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

$tgl_awal           = $this->session->userdata("tgl_awal");
$tgl_akhir          = $this->session->userdata("tgl_akhir");
$tgl_survei_awal    = $this->session->userdata("tgl_survei_awal");
$tgl_survei_akhir   = $this->session->userdata("tgl_survei_akhir");
$vendor_nameEx      = $this->session->userdata("vendor_name");
$vendor_name = str_replace("%20", " ",$vendor_nameEx );

// var_dump($tgl_survei_awal);
// die();

$Active       = isset($get['Active']) ? $get['Active'] : "" ;
// $Inactive     = isset($get['Inactive']) ? "0" : "" ;
$Suspended    = isset($get['Suspended']) ? $get['Suspended'] : "" ;
$Blacklist    = isset($get['Blacklist']) ? $get['Blacklist'] : "" ;

///////filter
if (!empty($vendor_name)) {
  $this->db->like("LOWER(vendor_name)",$vendor_name);
}

if (!empty($tgl_awal)) {
  $this->db->where('vc_start_date >=', $tgl_awal);
}
if (!empty($tgl_akhir)) {
  $this->db->where('vc_start_date <=', $tgl_akhir);
}

if (!empty($tgl_survei_awal)) {
  $this->db->where('survey_date >=', $tgl_survei_awal);
}
if (!empty($tgl_survei_akhir)) {
  $this->db->where('survey_date <=', $tgl_survei_akhir);
}

if (!empty($Active)) {
  $this->db->or_where('status',$Active);
}

if (!empty($Suspended)) {
  $this->db->or_where('status',$Suspended);
}

if (!empty($Blacklist)) {
  $this->db->or_where('status',$Blacklist);
}
$this->db->where('status !=', '0');

$data['total'] = $this->Vendor_m->getVendorStatus()->num_rows();
/////////////////////////////////////////////////////////////Data /////////////////////////////////////////////////////////

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

///////filter
if (!empty($vendor_name)) {
  $this->db->like("LOWER(vendor_name)",$vendor_name);
}

if (!empty($tgl_awal)) {
  $this->db->where('vc_start_date >=', $tgl_awal);
}
if (!empty($tgl_akhir)) {
  $this->db->where('vc_start_date <=', $tgl_akhir);
}

if (!empty($tgl_survei_awal)) {
  $this->db->where('survey_date >=', $tgl_survei_awal);
}
if (!empty($tgl_survei_akhir)) {
  $this->db->where('survey_date <=', $tgl_survei_akhir);
}

if (!empty($Active)) {
  $this->db->where('status',$Active);
}

if (!empty($Suspended)) {
  $this->db->or_where('status',$Suspended);
}

if (!empty($Blacklist)) {
  $this->db->or_where('status',$Blacklist);
}
		$this->db->where('status !=', '0');


$rows = $this->Vendor_m->getVendorStatus()->result_array();
// var_dump($this->db->last_query());
// die();
$sess['statvendQ'] = $this->db->last_query();
$sess['tgl_awal'] = $tgl_awal;
$sess['tgl_akhir'] = $tgl_akhir;
$sess['tgl_survei_awal'] = $tgl_survei_awal;
$sess['tgl_survei_akhir'] = $tgl_survei_akhir;
$this->session->set_userdata($sess);

foreach ($rows as $key => $value) {
  $now = date("Y-m-d");
  $rows[$key]['vc_start_date'] = !empty($value['vc_start_date']) ? date("Y-m-d",strtotime($value['vc_start_date'])) : "-" ;
  $rows[$key]['survey_date'] = !empty($value['survey_date']) ? date("Y-m-d",strtotime($value['survey_date'])) : "-" ;
  //////////////////// aktif kontrak 3 tahun ///////////////////////////
  $rows[$key]['end_date'] = !empty($value['end_date']) ? "<label class='label label-success'>Aktif ".date("Y-m-d",strtotime($value['end_date']))."</label>" : "<label class='label label-danger'>Pasif</label>" ;
  $d1 = new DateTime($now);
  $d2 = new DateTime($value['end_date']);
  $numberDays = $d1->diff($d2)->m + ($d1->diff($d2)->y*12);
  if ($numberDays > 36 && strtotime($domisiliDate) < strtotime($now) ){
    $rows[$key]['end_date'] = "<label class='label label-danger'>Pasif</label>" ;
  } else {

  }
  /////////////////////aktif kontrak >3 tahun ////////////////////////////
  
}

$data['rows'] = $rows;

echo json_encode($data);