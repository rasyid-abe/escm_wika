<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "DESC";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";

$tgl_awal       = $this->session->userdata("tgl_awal");
$tgl_akhir      = $this->session->userdata("tgl_akhir");
$vendor_nameEx    = $this->session->userdata("vendor_name");
$vendor_name = str_replace("%20", " ",$vendor_nameEx );

$Active       = isset($get['Active']) ? $get['Active'] : "" ;
$Inactive     = isset($get['Inactive']) ? "0" : "" ;
$Suspended    = isset($get['Suspended']) ? $get['Suspended'] : "" ;
$Blacklist    = isset($get['Blacklist']) ? $get['Blacklist'] : "" ;
$Suplier      = isset($get['Suplier']) ? $get['Suplier'] : "" ;
$Vendor       = isset($get['Vendor']) ? $get['Vendor'] : "" ;
$Mandor       = isset($get['Mandor']) ? $get['Mandor'] : "" ;
$Subkon       = isset($get['Subkon']) ? $get['Subkon'] : "" ;
$Pegawai      = isset($get['Pegawai']) ? $get['Pegawai'] : "" ;
$Kecil        = isset($get['Kecil']) ? $get['Kecil'] : "" ;
$Menengah     = isset($get['Menengah']) ? $get['Menengah'] : "" ;
$Besar        = isset($get['Besar']) ? $get['Besar'] : "" ;


if (!empty($Active) || !empty($Inactive) || !empty($Suspended) || !empty($Blacklist) ) {
  $groupingstat = TRUE;
}

if (!empty($Suplier) || !empty($Vendor) || !empty($Mandor) || !empty($Subkon) || !empty($Pegawai) ) {
  $groupingtype = TRUE;
}
if (!empty($Kecil) || !empty($Menengah) || !empty($Besar) ) {
  $groupingfinn = TRUE; 
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

if (isset($groupingstat) ) {
  $this->db->group_start();  
}

if (!empty($Active)) {
  $this->db->or_where('status',$Active);
}

if (!empty($get['Inactive'])) {
  $this->db->or_where('status',$Inactive);
}

if (!empty($Suspended)) {
  $this->db->or_where('status',$Suspended);
}

if (!empty($Blacklist)) {
  $this->db->or_where('status',$Blacklist);
}

if (isset($groupingstat) ) {
  $this->db->group_end();  
}
if (isset($groupingtype) ) {
  $this->db->group_start();  
}

if (!empty($Suplier)) {
  $this->db->or_where('cot_jenis',$Suplier);
}

if (!empty($Vendor)) {
  $this->db->or_where('cot_jenis',$Vendor);
}

if (!empty($Mandor)) {
  $this->db->or_where('cot_jenis',$Mandor);
}

if (!empty($Subkon)) {
  $this->db->or_where('cot_jenis',$Subkon);
}

if (!empty($Pegawai)) {
  $this->db->or_where('cot_jenis',$Pegawai);
}

if (isset($groupingtype) ) {
  $this->db->group_end();  
}

if (isset($groupingfinn) ) {
  $this->db->group_start();  
}
if (!empty($Kecil)) {
  $this->db->or_where('fin_class_name',$Kecil);
}

if (!empty($Menengah)) {
  $this->db->or_where('fin_class_name',$Menengah);
}

if (!empty($Besar)) {
  $this->db->or_where('fin_class_name',$Besar);
}
if (isset($groupingfinn) ) {
  $this->db->group_end();  
}


$data['total'] = $this->Vendor_m->getVendorStatus()->num_rows();

/////////////////////////////////////////////////////////////Data /////////////////////////////////////////////////////////


if (!empty($vendor_name)) {
  $this->db->like("LOWER(vendor_name)",$vendor_name);
}

if (!empty($tgl_awal)) {
  $this->db->where('vc_start_date >=', $tgl_awal);
}
if (!empty($tgl_akhir)) {
  $this->db->where('vc_start_date <=', $tgl_akhir);
}

if (isset($groupingstat)) {
  $this->db->group_start();  
}

if (!empty($Active)) {
  $this->db->or_where('status',$Active);
}

if (!empty($get['Inactive'])) {
  $this->db->or_where('status',$Inactive);
}

if (!empty($Suspended)) {
  $this->db->or_where('status',$Suspended);
}

if (!empty($Blacklist)) {
  $this->db->or_where('status',$Blacklist);
}

if (isset($groupingstat) ) {
  $this->db->group_end();  
}
if (isset($groupingtype)) {
  $this->db->group_start();  
}

if (!empty($Suplier)) {
  $this->db->or_where('cot_jenis',$Suplier);
}

if (!empty($Vendor)) {
  $this->db->or_where('cot_jenis',$Vendor);
}

if (!empty($Mandor)) {
  $this->db->or_where('cot_jenis',$Mandor);
}

if (!empty($Subkon)) {
  $this->db->or_where('cot_jenis',$Subkon);
}

if (!empty($Pegawai)) {
  $this->db->or_where('cot_jenis',$Pegawai);
}

if (isset($groupingtype) ) {
  $this->db->group_end();  
}

if (isset($groupingfinn) ) {
  $this->db->group_start();  
}
if (!empty($Kecil)) {
  $this->db->or_where('fin_class_name',$Kecil);
}

if (!empty($Menengah)) {
  $this->db->or_where('fin_class_name',$Menengah);
}

if (!empty($Besar)) {
  $this->db->or_where('fin_class_name',$Besar);
}
if (isset($groupingfinn) ) {
  $this->db->group_end();  
}


$rows = $this->Vendor_m->getVendorStatus()->result_array();

$sess['klasifikasi'] = $this->db->last_query();

$sess['tgl_awal'] = $tgl_awal;
$sess['tgl_akhir'] = $tgl_akhir;
$this->session->set_userdata($sess);



foreach ($rows as $key => $value) {
  // $now = date("Y-m-d");
  $rows[$key]['vc_start_date'] = !empty($value['vc_start_date']) ? date("Y-m-d",strtotime($value['vc_start_date'])) : "-" ;
  $rows[$key]['doc'] = '<a href="'.site_url("log/download_attachment/activation/hasil/".$rows[$key]['survey_result']).'" target="_blank">'.$rows[$key]['survey_result'].'</a>';

  //////////////////// aktif kontrak 3 tahun ///////////////////////////
  // $rows[$key]['end_date'] = !empty($value['end_date']) ? "<label class='label label-success'>Aktif ".date("Y-m-d",strtotime($value['end_date']))."</label>" : "<label class='label label-danger'>Pasif</label>" ;
  // $d1 = new DateTime($now);
  // $d2 = new DateTime($value['end_date']);
  // $numberDays = $d1->diff($d2)->m + ($d1->diff($d2)->y*12);
  // if ($numberDays > 36 && strtotime($domisiliDate) < strtotime($now) ){
  //   $rows[$key]['end_date'] = "<label class='label label-danger'>Pasif</label>" ;
  // } else {

  // }
  // /////////////////////aktif kontrak >3 tahun ////////////////////////////
  
}

$data['rows'] = $rows;

echo json_encode($data);