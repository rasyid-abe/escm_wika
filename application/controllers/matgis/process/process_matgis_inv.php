<?php

$mod='inv';
include APPPATH.'controllers/shared/declared.php';
$post = $this->input->post();
$activity_id=0;


$where       = array('inv_id' => $id);
$header      = $this->Global_m->get_data('ctr_inv_header',$where);
$items       = $this->Global_m->get_data('ctr_inv_item', $where, 2);
$doc         = $this->Global_m->get_data('ctr_inv_doc',$where,2);
$contract_id = $header['contract_id'];
$where=array('contract_id'=>$contract_id);
$contract    = $this->Global_m->get_data('ctr_contract_header', $where);
$reff     ='inv';
$where=array('vendor_id'=>$header['vendor_id']);
$vendor      = $this->Global_m->get_data('vnd_header', $where,1);

$this->db->where('wo_id',$header['wo_id']);
$header['wo_number']=$this->db->get('ctr_wo_header')->row_array()['wo_number'];
$this->db->where('wo_id',$header['wo_id']);
$header['sj_number']=$this->db->get('ctr_sj_header')->row_array()['sj_number'];

$where = array('inv_id' => $id, 'cwo_name' => null);
$last_comment = $this->Global_m->get_data('ctr_inv_comment', $where,1 );
$comment_list = $this->Comment_m->getCommentMatgis($id, '', 'inv')->result_array();

//echo $this->db->last_query();die;
if (!empty($last_comment)) {
  //jika ada comment artinya data edit
  $id          = $last_comment['inv_id'];
  $activity_id = $last_comment['cwo_activity'];
}

$title     = 'Pengajuan Tagihan';
$sub_title = 'Data Tagihan';
$data['header'] = $header + $contract + $vendor;

//print_r($vendor);die;
$data['items']  = $items;
$data['comment_list'][0] = $comment_list;
$data['mod']          = $mod;
$data['reff']         = $reff;
$data['state']        = $state;
$data['id']           = $id;
$data['activity_id']           = $activity_id;

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$activity        = $this->Procedure2_m->getActivity($activity_id)->row_array();
$wkf             = $this->Procedure2_m->getResponseList($activity['awa_id']);
ksort($wkf);

$data['workflow_list'] = $wkf;
$data['title']         = $title;
$data['sub_title']     = $sub_title;


if($state==2){
  $view = 'contract/matgis/show_matgis_v';
}else{
  $view = 'contract/matgis/process_matgis_v';
}
$this->template($view, $title, $data);
