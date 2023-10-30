<?php 

$view = 'mandor/lihat_detail_mandor_v';

$vendor_id = $this->uri->segment(4, 0);
switch ($this->uri->segment(3,0)) {
  case 'lihat_detail_vendor':
    $vendor_id = $this->uri->segment(4, 0);
    break;
  
  default:
    $vendor_id = $this->uri->segment(3, 0);
    break;
}


$data['header'] = $this->Vendor_m->getMandor($vendor_id)->row_array();
$data['pic_mandor'] = $this->Vendor_m->getMandorDetail($vendor_id,'vnd_mandor_pic')->result_array();
$data['bidang_mandor'] = $this->Vendor_m->getMandorDetail($vendor_id,'vnd_mandor_bidang')->result_array();
$data['experience_mandor'] = $this->Vendor_m->getMandorDetail($vendor_id,'vnd_mandor_project_experience')->result_array();
$data['jml_ahli_bidang_mandor'] = $this->Vendor_m->getMandorDetail($vendor_id,'vnd_mandor_teknik_qty_ahli_bidang')->result_array();
$data['tools_bidang'] = $this->Vendor_m->getMandorDetail($vendor_id,'vnd_mandor_tools')->result_array();

$data['vmh_id'] = $data['header']['vmh_id'];

//tambahan
$data['bidang'] = $this->db->get_where('adm_master',['status'=> 'Y', 'am_type' => 'bidang_registration_mandor'])->result_array();

$this->template($view,"Profil Mandor",$data);