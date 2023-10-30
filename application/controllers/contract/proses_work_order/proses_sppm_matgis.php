<?php

$post = $this->input->post();

$view = 'contract/proses_work_order/proses_sppm_matgis_v';

$position = $this->Administration_m->getPosition("PIC USER");
$this->load->model("Procedure_matgis_m");
//$id automatic get from variable cwo_id

//Activity ID WorkOrder Matgis

$activity_id = $this->Settings_m->get_settings_num('_ACT_SPPM_MATGIS_CREATE');

//Last Comment FROM WO if empty last comment
$last_comment = $this->Comment_m->getSIMatgis("",$id)->row_array();

if(empty($last_comment)){
	//Get data from previous Activity
	$last_comment = $this->Comment_m->getWOMatgis("",$id)->row_array();
	$wo_id=$last_comment['wo_id'];
	$data = $this->Contract_m->getDataWOMatgis($wo_id)->row_array();
	$x = $this->Contract_m->getWOMatgisItem("",$wo_id)->result_array(); //item data
}else{
	//Get Data from current activity
	$id = $last_comment['cwo_id'];
	$activity_id=$last_comment['activity'];
	$data=$this->Contract_m->getDataSPPMMatgis($id)->row_array();
	$x = $this->Contract_m->getSPPMMatgisItem("",$id)->result_array(); //item data
}

//echo $this->db->last_query();die;

$contract_id = $data['contract_id'];
$data['id'] = $id; //cwo_id for first time
$data['pos'] = $position;
$this->data['dir'] = CONTRACT_FOLDER;

$wo_number=$this->Procedure_matgis_m->get_data("ctr_wo_header",$wo_id)['wo_number'];
$contract_number=$this->Procedure_matgis_m->get_data("ctr_contract_header",$contract_id)['contract_number'];
//echo $this->db->last_query();die;

//Start Get Pembuatan Activity
$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();
$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$total=0;
//$item = $this->Contract_m->getItem("",$contract_id)->result_array();
$item = $this->Procedure_matgis_m->get_item_wo($wo_id);
//echo $this->db->last_query();die;
$wo_out = 0;
foreach ($x as $key => $value) {
	$data['item_wo'][$value['contract_item_id']] = $value['qty'];
}

$totalwo = $this->db->select("COALESCE(SUM(sub_total),0) as total")->where("contract_id",$contract_id)->where("approved_date !=",null)
->join("ctr_wo_header a","a.wo_id=b.wo_id")->get("ctr_wo_item b")->row()->total;
$data['totalwo'] = $totalwo;
$data['item'] = $item;
$data['contract_number'] = $contract_number;

//Aditional
$data['total'] = $total; //total item
$data['transporter'] = $this->Administration_m->get_transporter();

//echo $total;die;
$this->db->where("job_title","PIC USER");
$data['pic_user'] = $this->Administration_m->getUserRule()->result_array();


$data['last_comment'] = $last_comment;
$data['document'] = $this->Contract_m->getSIDoc("",$id)->result_array();
$data['doc_category'] = $this->Contract_m->getDocType()->result_array();
$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);
$data["comment_list"][0] = $this->Comment_m->getSIMatgis($id)->result_array();
$vendor_id=$data['vendor_id'];
$vendor_info=$this->Contract_m->get_vendor_info($vendor_id)->result()[0];
$data['vendor_info']=$vendor_info;
// $this->session->set_userdata("si_id",$si_id);
//print_r($data);die;
$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);
