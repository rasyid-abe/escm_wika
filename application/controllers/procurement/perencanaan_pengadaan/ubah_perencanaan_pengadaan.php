<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
	$this->noAccess("Hanya PIC USER yang dapat mengelola perencanaan pengadaan");
}

$data['pos'] = $position;

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'procurement/perencanaan_pengadaan/edit_perencanaan_pengadaan_v';

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['desc_matgis'] = $this->db->where('status',1)->get("adm_desc_matgis")->result_array();

$data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($id)->row_array();

if(!in_array($data['perencanaan']['ppm_status'], array(0,4))){
	$this->noAccess("Pengadaan sedang diproses tidak dapat diubah");
} else if(
	$data['perencanaan']['ppm_district_id'] != $userdata['district_id'] ||
	$data['perencanaan']['ppm_dept_id'] != $userdata['dept_id']
){
	$this->noAccess("Anda tidak berhak mengubah perencanaan user lain");
}

$judul = "Ubah Perencanaan Pengadaan";

if($data['perencanaan']['ppm_type_of_plan'] == "rkp_matgis"){

	$activity = $this->Procedure_m->getActivity(999)->row_array();

	$data['item'] = $this->Procplan_m->getItem("",$id)->result_array();

	$data['content'] = $this->Workflow_m->getContentByActivity(999)->result_array();

	$view = 'procurement/perencanaan_pengadaan/form_perencanaan_matgis_v';

	$data['url_submit'] = site_url("procurement/submit_ubah_perencanaan_pengadaan");

	$data['edit'] = true;

	$data['view'] = false;

}

$data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

$data["comment_list"][0] = $this->Comment_m->getProcurementPlan($id)->result_array();

$this->template($view,$judul,$data);