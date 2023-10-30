<?php
  $mod='po';
  include APPPATH.'controllers/shared/declared.php';
  $post = $this->input->post();
  $activity_id=0;

  if($state==0){
    $activity_id = $activity_first;
    $where       = array('contract_id' => $id);
    $header      = $this->Global_m->get_data('ctr_contract_header', $where);
    $items       = $this->Global_m->get_data('ctr_contract_item',$where, 2);
    $contract    = $header;
    $doc         = null;
    $reff        ='contract';
    $dept_code   = $this->Contract_matgis_m->get_dept($header['contract_id'])['dep_code'];
    $spk_list    = $this->Contract_matgis_m->get_spk($dept_code);
    $header['start_date']=date('Y-m-d');
    $header['end_date']=date('Y-m-d');
  }else{
    $where       = array('wo_id' => $id);
    $header      = $this->Global_m->get_data('ctr_wo_header',$where);
    $items       = $this->Global_m->get_data('ctr_wo_item', $where, 2);
    $contract_id = $header['contract_id'];
    $where=array('contract_id'=>$contract_id);
    $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
    $reff        ='po';
    $dept_code   = $this->Contract_matgis_m->get_dept($header['contract_id'])['dep_code'];
    $spk_list    = $this->Contract_matgis_m->get_spk($dept_code);
    $this->db->where('wo_id',$id);
    $doc         = $this->db->get('ctr_wo_doc')->result_array();
    $where = array('wo_id' => $id, 'cwo_name' => null);
    $last_comment = $this->Global_m->get_data('ctr_wo_comment', $where );
    if (!empty($last_comment)) {
      //jika ada comment artinya data edit
      $id          = $last_comment['wo_id'];
      $activity_id = $last_comment['cwo_activity'];
    }
  }
  $comment_list = $this->Comment_m->getCommentMatgis($id, '', 'wo')->result_array();





  $title     = 'Pekerjaan PO Matgis('.$activity_id.')';
  $sub_title = 'Data PO Matgis';
  $activity_curr=array('activity_id'=>$activity_id);
  $dir = 'matgis/po';
  $data['dir']=$dir;
  $data['header'] = $header + $contract + $activity_curr;
  $data['items']  = $items;
  $data['documents']    = $doc;
  $data['comment_list'][0] = $comment_list;
  $data['spk_list']     = $spk_list;
  $data['mod']          = $mod;
  $data['reff']         = $reff;
  $data['state']        = $state;
  $data['id']           = $id;
  $data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();
  $activity        = $this->Procedure2_m->getActivity($activity_id)->row_array();
  $wkf             = $this->Procedure2_m->getResponseList($activity['awa_id']);
  $data['vendor_id'] = $this->Global_m->get_data('ctr_wo_header', array('wo_id' => $id), 1)['vendor_id'];
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
