<?php 


$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'laporan/detail_lap_kebutuhan_pmcs_v';

$data = array();

$id = $this->uri->segment(4, 0);

$data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($id)->row_array();

if($data['perencanaan']['ppm_type_of_plan'] == "rkp_matgis"){
	$view = 'procurement/perencanaan_pengadaan/view_perencanaan_matgis_v';
	$data['content'] = $this->Workflow_m->getContentByActivity(999)->result_array();
}

$data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

$next_pos = $this->db
->where("pos_id",$data['perencanaan']['ppm_next_pos_id'])
->get("vw_pos")->row_array();

if(!empty($next_pos) && $data['perencanaan']['ppm_status'] != 3){

	$y = $this->Comment_m->getProcurementPlan($id)->result_array();

	$x[] = [
		'comment_date'=>$y[0]['comment_end_date'],
		'comment_end_date'=>null,
		'comment_name'=>null,
		'response'=>null,
		'comments'=>null,
		'position'=>$next_pos['pos_name'],
		'activity_name'=>null
	];
	

	$data["comment_list"][0] = array_merge($x,$y);

} else {

	$data["comment_list"][0] = $this->Comment_m->getProcurementPlan($id)->result_array();

}

$data['anggaran_list'][0] = $this->Comment_m->getAnggaran($id)->result_array();

$data['volume_hist'] = $this->Comment_m->getVolumeHist($id)->result_array();
// echo $this->db->last_query();exit();

$data['project_cost'] = $this->Procplan_m->getProjectCost($id)->result_array();

$data['item'] = $this->Procplan_m->getItem("",$id)->result_array();

$data['desc'] = array(
	0 => "Pembuatan anggaran awal",
	1010 => "Pembuatan Paket Pengadaan No. ",
	1000 => "Revisi Paket Pengadaan No. ",
	1904 => "Pembatalan Paket Pengadaan No. ",
	1040 => "dilanjutkan RFQ No. ",
	1902 => "Pembatalan RFQ No. ",
	2010 => "Selisih nilai hps dan nilai kontrak dengan No. "
);

$data['urlpr'] = site_url('procurement/procurement_tools/monitor_pengadaan/lihat_permintaan')."/";

$data['urlrfq'] = site_url('procurement/procurement_tools/monitor_pengadaan/lihat')."/";

$data['urlctr'] = site_url('contract/monitor/monitor_kontrak/lihat')."/";

$this->template($view,"Detail Kebutuhan PMCS",$data);