<?php

$mod='si';
include APPPATH.'controllers/shared/declared.php';
$post = $this->input->post();
$activity_id=0;

$transporter=$this->db->get('ctr_vnd_transporter')->result_array();

if($state==0){
  $activity_id = $activity_first;
  $reff        ='wo';
  $where       = array('wo_id' => $id);
  $header      = $this->Global_m->get_data('ctr_wo_header', $where);
  $items       = $this->Global_m->get_data('ctr_wo_item', $where, 2);
  $contract_id = $header['contract_id'];
  $where       = array('contract_id' => $contract_id);
  $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
  $where=array('vendor_id'=>$header['vendor_id']);
  $vendor      = $this->Global_m->get_data('vnd_header', $where,1);
  $header['si_notes']=$header['wo_notes'];
  $doc=null;
  $wo=array();
  //print_r($vendor);die;

}else{
  $where       = array('si_id' => $id);
  $header      = $this->Global_m->get_data('ctr_si_header',$where);
  $items       = $this->Global_m->get_data('ctr_si_item', $where, 2);
  $doc         = $this->Global_m->get_data('ctr_si_doc',$where,2);
  $contract_id = $header['contract_id'];
  $where=array('contract_id'=>$contract_id);
  $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
  $reff        ='si';
  $where=array('vendor_id'=>$header['vendor_id']);
  $vendor      = $this->Global_m->get_data('vnd_header', $where,1);
  $where       = array('wo_id' => $header['wo_id']);
  $wo          = $this->Global_m->get_data('ctr_wo_header', $where);

$where = array('si_id' => $id, 'cwo_name' => null);
  $last_comment = $this->Global_m->get_data('ctr_si_comment', $where );
  if (!empty($last_comment)) {
    //jika ada comment artinya data edit
    $id          = $last_comment['si_id'];
    $activity_id = $last_comment['cwo_activity'];
  }
}
$comment_list = $this->Comment_m->getCommentMatgis($id, '', 'si')->result_array();


$title     = 'Pembuatan Shipping Instruction('.$activity_id.')';
$sub_title = 'Data SI';

$activity_curr=array('activity_id'=>$activity_id);
$dir = 'matgis/si';
$data['dir']=$dir;
// var_dump($header );
// die;
$data['header'] = $header + $contract + $vendor+ $activity_curr+$wo;
$data['items']  = $items;
$data['documents']  = $doc;
$data['comment_list'][0] = $comment_list;
$data['mod']          = $mod;
$data['reff']         = $reff;
$data['state']        = $state;
$data['id']           = $id;
$data['transporter']     = $transporter;
//print_r($transporter);die;
if($state==2){
$activity_id=2040;
}

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();
$activity        = $this->Procedure2_m->getActivity($activity_id)->row_array();
$wkf             = $this->Procedure2_m->getResponseList($activity['awa_id']);
ksort($wkf);
$data['doc_category'] = $this->Contract_matgis_m->get_doc_type()->result_array();
$data['workflow_list'] = $wkf;
$data['title']         = $title;
$data['sub_title']     = $sub_title;

if($state==2){
  $view = 'contract/matgis/show_matgis_v';
}else{
  $view = 'contract/matgis/process_matgis_v';
}
$this->template($view, $title, $data);
