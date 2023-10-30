<?php
  $mod='do';
  include APPPATH.'controllers/shared/declared.php';
  $post = $this->input->post();
  $activity_id=0;

  if($state==0){

    $activity_id = $activity_first;
    $where       = array('sppm_id' => $id);
    $header      = $this->Global_m->get_data('ctr_sppm_header', $where);
    $items       = $this->Global_m->get_data('ctr_sppm_item',$where, 2);

    $where       = array('contract_id'=>$header['contract_id']);
    $contract    = $this->Global_m->get_data('ctr_contract_header', $where);

    $where       = array('wo_id'=>$header['wo_id']);
    $wo          = $this->Global_m->get_data('ctr_wo_header', $where);

    $where       = array('si_id'=>$header['si_id']);
    $si          = $this->Global_m->get_data('ctr_si_header', $where);

    $doc         = null;
    $reff        ='sppm';
    $header['start_date']=date('Y-m-d');
    $header['end_date']=date('Y-m-d');
    $header+=$contract+$wo+$si;


  }else{
    $where       = array('do_id' => $id);
    $header      = $this->Global_m->get_data('ctr_do_header',$where);
    //var_dump($header);die;
    $items       = $this->Global_m->get_data('ctr_do_item', $where, 2);
    $contract_id = $header['contract_id'];
    $where       = array('contract_id'=>$contract_id);
    $contract    = $this->Global_m->get_data('ctr_contract_header', $where);
    $this->db->join('ctr_si_header a', 'a.si_id = ctr_sppm_header.si_id', 'left');
    $where       = array('ctr_sppm_header.sppm_id' => $id);
    $sppm      = $this->Global_m->get_data('ctr_sppm_header', $where);

    //var_dump($contract);die;

    $reff        ='do';
    $dept_code   = $this->Contract_matgis_m->get_dept($header['contract_id'])['dep_code'];
    $spk_list    = $this->Contract_matgis_m->get_spk($dept_code);
    $this->db->where('do_id',$id);
    $doc         = $this->db->get('ctr_do_doc')->result_array();
    //print_r($doc);die;
  }

  $comment_list = $this->Comment_m->getCommentMatgis($id, '', 'do')->result_array();
  $where = array('do_id' => $id, 'cwo_name' => null);
  $last_comment = $this->Global_m->get_data('ctr_do_comment', $where );
  if (!empty($last_comment)) {
    //jika ada comment artinya data edit
    $id          = $last_comment['do_id'];
    $activity_id = $last_comment['cwo_activity'];
  }

  $title     = 'Pekerjaan DO Matgis('.$activity_id.')';
  $sub_title = 'Data DO Matgis';
  $activity_curr=array('activity_id'=>$activity_id);
  $dir = 'matgis/do';
  $data['dir']=$dir;
  $where       = array('wo_id'=>$header['wo_id']);
  $wo          = $this->Global_m->get_data('ctr_wo_header', $where);
  $data['header']       = $header +$contract +$wo +$sppm +$activity_curr;
  // echo "<pre/>";var_dump($data['header']);exit();
  $data['items']        = $items;
  $data['documents']    = $doc;
  $data['comment_list'][0] = $comment_list;
  $data['mod']          = $mod;
  $data['reff']         = $reff;
  $data['state']        = $state;
  $data['id']           = $id;
  $data['vendor_id'] = $this->Global_m->get_data('ctr_do_header', array('do_id' => $id), 1)['vendor_id'];

  $data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();
  $wkf             = $this->Procedure2_m->getResponseList($activity_id);
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
