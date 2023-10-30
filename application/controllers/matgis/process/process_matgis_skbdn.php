<?php

  $mod='skbdn';
  include APPPATH.'controllers/shared/declared.php';
  $post = $this->input->post();
  $activity_id=0;

  $where       = array('wo_id' => $id);
  $header      = $this->Global_m->get_data('ctr_wo_header', $where);
  $items       = $this->Global_m->get_data('ctr_wo_item',$where, 2);
  $contract    = $header;

  if($state==0){
    $activity_id=2037;
    $reff        ='wo';
    $contract_id = $header['contract_id'];
    $where=array('contract_id'=>$contract_id);
    $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
    $doc=null;
  }else{
    $this->db->where('wo_id',$id);
    $this->db->where('category','SKBDN');
    $doc         = $this->db->get("ctr_wo_doc")->result_array();
    $where       = array('wo_id' => $id);
    $contract_id = $header['contract_id'];
    $where=array('contract_id'=>$contract_id);
    $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
    $reff        ='wo';
  }

  $comment_list = $this->Comment_m->getCommentMatgis($id, '', 'wo')->result_array();
  $where = array('wo_id' => $id, 'cwo_name' => null);
  $last_comment = $this->Global_m->get_data('ctr_wo_comment', $where );
  if (!empty($last_comment)) {
    //jika ada comment artinya data edit
    $id          = $last_comment['wo_id'];
    $activity_id = $last_comment['cwo_activity'];
  }
  $title     = 'SKBDN('.$activity_id.')';
  $sub_title = 'Data SKBDN';

  $activity_curr=array('activity_id'=>$activity_id);
  $dir = 'matgis/po';
  $data['dir']=$dir;
  $data['header'] = $header + $contract + $activity_curr;
  $data['items']  = $items;
  $data['documents']    = $doc;
  $data['comment_list'][0] = $comment_list;
  $data['mod']          = $mod;
  $data['reff']         = $reff;
  $data['state']        = $state;
  $data['id']           = $id;
  $data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();
  $activity        = $this->Procedure2_m->getActivity($activity_id)->row_array();
  $wkf             = $this->Procedure2_m->getResponseList($activity['awa_id']);
  ksort($wkf);
  $this->db->where('name','SKBDN');
  $cat=$this->db->get('ctr_doc_matgis_type')->result_array();

  $data['doc_category'] = $cat;
  $data['workflow_list'] = $wkf;
  $data['title']         = $title;
  $data['sub_title']     = $sub_title;

  if($state==2){
    $view = 'contract/matgis/show_matgis_v';

  }else{
  $view = 'contract/matgis/process_matgis_v';
  }
  $this->template($view, $title, $data);
