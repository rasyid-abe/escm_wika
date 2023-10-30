<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/pembatalan_paket_v';

$pr_number =  $this->uri->segment(3, 0);

$data['id'] = $pr_number;

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();

$data['district_list'] = $this->Administration_m->getDistrict()->result_array();

$data['permintaan'] = $this->Procpr_m->getPR($pr_number)->row_array();

$data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($data['permintaan']['ppm_id'])->row_array();

$activity_id = $data['permintaan']['pr_status'];

$data['activity_id'] = $activity_id;

$activity = $this->Procedure_m->getActivity($data['permintaan']['pr_status'])->row_array();

// $content_id = ($activity_id == "1040") ? 1011 : $activity_id;

$data['content'] = $this->Workflow_m->getContentByActivity(1011)->result_array();
$data['workflow_list'] = $this->Procedure_m->getResponseList(1011);
$data["comment_list"][0] = $this->Comment_m->getProcurementPRActive($pr_number)->result_array();
$data['document'] = $this->Procpr_m->getDokumenPR("",$pr_number)->result_array();
$data['item'] = $this->Procpr_m->getItemPR("",$pr_number)->result_array();
$data['controller_name'] = "procurement";
$data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$this->load->view($view,$data);