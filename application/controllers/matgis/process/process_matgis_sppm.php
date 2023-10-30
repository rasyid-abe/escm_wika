<?php
$mod='sppm';
include APPPATH.'controllers/shared/declared.php';
$post = $this->input->post();

$transporter=$this->db->get('ctr_vnd_transporter')->result_array();
$activity_id=0;
if($state==0){
  $activity_id = $activity_first;
  $where       = array('si_id' => $id);
  $header      = $this->Global_m->get_data('ctr_si_header', $where,1);
  $items       = $this->Global_m->get_data('ctr_si_item', $where, 2);
  $contract_id = $header['contract_id'];
  $where       = array('contract_id' => $contract_id);
  $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
  $where=array('vendor_id'=>$header['vendor_id']);
  $vendor      = $this->Global_m->get_data('vnd_header', $where,1);
  $header['sppm_notes']=$header['si_notes'];
  $doc=null;
  $this->db->where(array('wo_id'=>$header['wo_id']));
  $header['wo_number'] =$this->db->get('ctr_wo_header')->row_array()['wo_number'];
  $reff="si";
}else{
  $where       = array('sppm_id' => $id);
  $header      = $this->Global_m->get_data('ctr_sppm_header',$where);
  $items       = $this->Global_m->get_data('ctr_sppm_item', $where, 2);
  $this->db->where('sppm_id',$id);
  $this->db->where('filename is not null');
  $doc         = $this->db->get('ctr_sppm_doc')->result_array();
  $contract_id = $header['contract_id'];
  $where=array('contract_id'=>$contract_id);
  $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
  $where=array('vendor_id'=>$header['vendor_id']);
  $vendor      = $this->Global_m->get_data('vnd_header', $where,1);
  $this->db->where(array('wo_id'=>$header['wo_id']));
  $header['wo_number'] =$this->db->get('ctr_wo_header')->row_array()['wo_number'];
  $reff     ='sppm';

$where = array('sppm_id' => $id, 'cwo_name' => null);
  $last_comment = $this->Global_m->get_data('ctr_sppm_comment', $where );
  //echo $this->db->last_query();die;
  if (!empty($last_comment)) {
    //jika ada comment artinya data edit
    $id          = $last_comment[$reff.'_id'];
    $activity_id = $last_comment['cwo_activity'];
  }
}
$comment_list = $this->Comment_m->getCommentMatgis($id, '', 'sppm')->result_array();




$this->db->where('awa_id',$activity_id);
$judul=$this->db->get('adm_wkf_activity')->row()->awa_name;


$title     = $judul.'('.$activity_id.')';
$sub_title = 'Data SPPM';

$activity_curr=array('activity_id'=>$activity_id);
$dir = 'matgis/sppm';
$data['dir']=$dir;
$data['header'] = $header + $contract + $vendor+ $activity_curr;
$data['items']  = $items;
$data['comment_list'][0] = $comment_list;
$data['mod']          = $mod;
$data['reff']         = $reff;
$data['state']        = $state;
$data['id']           = $id;
$data['documents'] = $doc;
$data['transporter']     = $transporter;
if($state==2){
  $activity_id=2053;
}

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();
$activity        = $this->Procedure2_m->getActivity($activity_id)->row_array();
$wkf             = $this->Procedure2_m->getResponseList($activity['awa_id']);
ksort($wkf);
$data['doc_category'] = $this->Contract_matgis_m->get_doc_type()->result_array();
$data['workflow_list'] = $wkf;
$data['title']         = $title;
$data['vendor_id'] = $this->Global_m->get_data('ctr_sppm_header', array('sppm_id' => $id), 1)['vendor_id'];
$data['sub_title']     = $sub_title;

if($state==2){
  $view = 'contract/matgis/show_matgis_v';
}else{
  $view = 'contract/matgis/process_matgis_v';
}
$this->template($view, $title, $data);
