<?php 

$userdata = $this->data['userdata'];

$data = array();

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

// $manajer_user = $this->Administration_m->getPosition("MANAJER USER");

// $kepala_anggaran = $this->Administration_m->getPosition("KEPALA ANGGARAN");

$this->db->where('ppm_next_pos_id', $userdata['pos_id'])->where("ppm_id",$id);
// $this->db->join('prc_plan_comment b', 'b.ppm_id = a.ppm_id', 'left');
$plan = $this->db->get('prc_plan_main a')->row_array();

// if($manajer_user){
// 	$this->data['workflow_list'] = array(3=>"Setuju",4=>"Revisi");
// } else if($kepala_anggaran){
// 	$this->data['workflow_list'] = array(3=>"Setuju",4=>"Revisi");
// } 
if (!empty($plan)) {
	$this->data['workflow_list'] = array(2=>"Setuju",4=>"Revisi");
} else {
	$this->noAccess("Anda tidak dapat mengelola approval perencanaan pengadaan");
	// $this->noAccess("Hanya VP USER & KEPALA ANGGARAN yang dapat mengelola approval perencanaan pengadaan");
}

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'procurement/perencanaan_pengadaan/approval_perencanaan_pengadaan_v';

$data['id'] = $id;

$data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($id)->row_array();

if(in_array($data['perencanaan']['ppm_status'], array(3))){
	$this->noAccess("Perencanaan tidak dapat diapprove");
}

if(in_array($data['perencanaan']['ppm_status'], array(0,4))){
	 redirect(site_url('procurement/perencanaan_pengadaan/update_daftar_perencanaan/ubah/'.$id));
}

$judul = "Rekapitulasi Perencanaan Pengadaan";

if($data['perencanaan']['ppm_type_of_plan'] == "rkp_matgis"){

	$activity = $this->Procedure_m->getActivity(999)->row_array();

	$data['item'] = $this->Procplan_m->getItem("",$id)->result_array();

	$data['content'] = $this->Workflow_m->getContentByActivity(999)->result_array();

	$view = 'procurement/perencanaan_pengadaan/form_perencanaan_matgis_v';

	$data['url_submit'] = site_url("procurement/submit_approval_perencanaan_pengadaan");

	$data['edit'] = false;

	$data['view'] = true;

}

$data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

$data["comment_list"][0] = $this->Comment_m->getProcurementPlan($id)->result_array();

$this->template($view,$judul,$data);