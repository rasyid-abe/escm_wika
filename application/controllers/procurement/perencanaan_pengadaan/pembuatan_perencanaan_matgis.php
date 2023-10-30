<?php 

$view = 'procurement/perencanaan_pengadaan/form_perencanaan_matgis_v';

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
	$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

$data['pos'] = $position;

$data['edit'] = false;

$data['view'] = false;

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$activity = $this->Procedure_m->getActivity(999)->row_array();

$data['desc_matgis'] = $this->db->where('status',1)->get("adm_desc_matgis")->result_array();

$data['content'] = $this->Workflow_m->getContentByActivity(999)->result_array();

$data['url_submit'] = site_url("procurement/submit_pembuatan_perencanaan_pengadaan");

$data['district_list'] = $this->Administration_m->getDistrict()->result_array();

$data['del_point_list'] = $this->Administration_m->get_divisi_departemen()->result_array();

$data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

 $this->session->unset_userdata("code_group");

$this->template($view,$activity['awa_name'],$data);