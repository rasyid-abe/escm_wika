<?php

$post = $this->input->post();

$view = 'contract/proses_work_order/proses_work_order_matgis_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$data['id'] = null;

$data['contract_id'] = $contract_id;

$data['pos'] = $position;

$this->data['dir'] = CONTRACT_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","KONTRAK"=>"KONTRAK");

$contract = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $contract['ptm_number'];

//Activity ID WorkOrder Matgis
$activity_id = $this->Settings_m->get_settings_num('_ACT_WO_MATGIS');

// echo $activity_id;
// die();

$totalwo = $this->db->select("COALESCE(SUM(sub_total),0) as total")->where("contract_id",$contract_id)->where("approved_date !=",null)
->join("ctr_wo_header a","a.wo_id=b.wo_id")->get("ctr_wo_item b")->row()->total;
//echo $this->db->last_query(); die;

$data['totalwo'] = $totalwo;

$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();

$this->db->where("job_title","PENGELOLA KONTRAK");

$data['pelaksana_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$data['kontrak'] = $contract;

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$item = $this->Contract_m->getItem("",$contract_id)->result_array();

$data['item'] = $item;

$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = array();

$this->session->set_userdata("rfq_id",$ptm_number);

$this->session->set_userdata("contract_id",$contract_id);

//print_r($activity);
//print_r($view);
//print_r($data['item']);
//die();

$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);
//echo $this->db->last_query(); die;
