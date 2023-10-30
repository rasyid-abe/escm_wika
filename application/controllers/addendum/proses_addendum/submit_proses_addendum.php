<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];

$last_comment = $this->Comment_m->getAddendum("",$id)->row_array();

$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 3000;

$contract_id = $last_comment['contract_id'];

$ammend_id = $last_comment['ammend_id'];

$contract = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $contract['ptm_number'];

$input = array();

$input_doc = array();

$input_item = array();

$input_prep = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

$plan = $this->Addendum_m->getPerencanaan($ptm_number);

$this->db->trans_begin();

if($last_activity == 3000 || $last_activity == "3000"){

  $input['subject_work'] = $post['subject_work_inp'];
  $input['scope_work'] = $post['scope_work_inp'];
  $input['ammend_description'] = $post['deskripsi_addendum_inp'];
  $input['ammend_reason'] = $post['justifikasi_addendum_inp'];
  $input['contract_type_2'] = $post['jenis_kontrak_inp'];
  $input['contract_amount'] = moneytoint($post['total_alokasi_inp']);
  $input['contract_number'] = $this->Contract_m->getUrut("",$post['jenis_kontrak_inp']);



//=================================================================
  

  $ammend = $this->Addendum_m->getData($ammend_id, "")->row_array();

  $diff = $ammend['contract_amount'] - moneytoint($post['total_alokasi_inp']);

  if ($diff != 0) {

    if ($diff >  $plan['ppm_sisa_anggaran']) {
      $this->setMessage("Total nilai melebihi sisa anggaran. Anggaran tidak cukup");
      if(!$error){
        $error = true;
      }
    
    }else{

      $this->load->model("Procplan_m");

      $plusmin = ($diff < 0) ? "pph_min" : "pph_plus";
      $lasthist = $this->Procplan_m->getHist("", $plan['ppm_id'])->row_array();
      $hist = array(
                'ppm_id' => $plan['ppm_id'],
                'pph_main' => $lasthist['pph_remain'],
                $plusmin => abs($diff),
                'pph_remain' => ($lasthist['pph_remain'] + $diff),
                'pph_date' => date("Y-m-d H:i:s"),
                'pph_desc' => 3000,
                'pph_first' => $contract['contract_number'],
                'pph_mod' => $input['contract_number']
              );

      
      $potong = $this->Procplan_m->updateDataPerencanaanPengadaan($plan['ppm_id'], array('ppm_sisa_anggaran'=>$hist['pph_remain']));
      
      $plan_hist = $this->Procplan_m->insertHist($hist);

      $check_vol = $this->Procplan_m->getVolumeHist("",$plan['ppm_id'])->result_array();
      
      if (count($check_vol) > 0) {

        foreach ($post['item_id'] as $key2 => $value2) { 

          $getVolumeHist = $this->Procplan_m->getVolumeHist($post['item_code'][$value2],$plan['ppm_id'])->row_array();
          
          $items = $this->Addendum_m->getItem("", "", $value2)->row_array();
          $diffs = moneytoint($post['qty'][$value2]) - $items['qty'];
          $plusmins = ($diffs > 0) ? "ppv_minus" : "ppv_plus";

          if ($diffs > $getVolumeHist['ppv_remain']) {
            $this->setMessage("Volume item melebihi sisa kuota volume");
            if(!$error){
              $error = true;
            }

          }else{
            
            $dataVolume = array(
              'ppm_id' => $plan['ppm_id'],
              'ppv_main' => $getVolumeHist['ppv_remain'],
              $plusmins => $diffs,
              'ppv_remain' => ($getVolumeHist['ppv_main'] + $diffs),
              'ppv_activity' => 3000,
              'ppv_no' => $input['contract_number'],
              'ppv_smbd_code' => $post['item_code'][$value2],
              'ppv_unit' => $getVolumeHist['ppv_unit'],
              'ppv_prc' => "ADDENDUM",
              'created_datetime' => date("Y-m-d H:i:s"),
            );

            $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
          }
        }
      }

      foreach ($post['item_id'] as $k => $v) {
        
        $p = moneytoint($post['price'][$v]);
        $q = moneytoint($post['qty'][$v]);

        $item['price'] = $p;
        $item['qty'] = $q;
        $item['sub_total'] = $p*$q; 
        
        $ss = $this->Addendum_m->updateItem($v, $item);
      } 
    }
  }

//=================================================================

  $mulai = $post['tgl_mulai_inp'];
  $akhir = $post['tgl_akhir_inp'];
  $input['start_date'] = $mulai;
  $input['end_date'] = $akhir;
  if(strtotime($akhir) < strtotime($mulai)){
    $this->setMessage("Tanggal berakhir kontrak tidak boleh kurang dari tanggal mulai kontrak");
    if(!$error){
      $error = true;
    }
  }

  $milestone = 0.0;

  if(isset($post['milestone_percent'])){

    foreach ($post['milestone_percent'] as $key => $value) {
      //echo moneytoint($value)."<br/>";
      $milestone += moneytoint($value);
    }

    if($milestone != 100.0) {
      $this->setMessage("Milestone harus 100%");
      if(!$error){
        $error = true;
      }
    }
  }
}

$input_doc = array();

$input_milestone = array();

$n = 0;

$this->form_validation->set_rules("id", 'ID', 'required');

foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules($key."[".$key2."]", '', '');

      if(isset($post['doc_id_inp'][$key2])){
        $input_doc[$key2]['doc_id'] = $post['doc_id_inp'][$key2];
      }

      if(isset($post['doc_category_inp'][$key2])){
        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['category']= $post['doc_category_inp'][$key2];
      }
      if(isset($post['doc_desc_inp'][$key2])){
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $input_doc[$key2]['description']= $post['doc_desc_inp'][$key2];
      }
      if(isset($post['doc_attachment_inp'][$key2])){
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['filename']= $post['doc_attachment_inp'][$key2];
      }

      if(isset($post['doc_vendor_inp'][$key2])){
        $this->form_validation->set_rules("doc_vendor_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $input_doc[$key2]['publish']= $post['doc_vendor_inp'][$key2];
      }

      if(isset($post['milestone_percent'][$key2])){

        $this->form_validation->set_rules("milestone_percent[$key2]", "Bobot Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("milestone_desc[$key2]", "Jumlah Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $this->form_validation->set_rules("milestone_date[$key2]", "Tanggal Milestone #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        
        if(!empty($post['milestone_id'][$key2])){
          $input_milestone[$key2]['milestone_id']=$post['milestone_id'][$key2];
        }

        $input_milestone[$key2]['percentage']=moneytoint($post['milestone_percent'][$key2]);
        $input_milestone[$key2]['description']=$post['milestone_desc'][$key2];
        $input_milestone[$key2]['target_date']=$post['milestone_date'][$key2];

      }

    }

    $n++;

  }

}


if ($this->form_validation->run() == FALSE || $error){

  $this->renderMessage("error");

  //$this->ubah_tender_pengadaan();

} else {

    if(!empty($input)){

      $act = $this->Addendum_m->updateData($ammend_id,$input);

    } else {

      $act = true;

    }


    $complete_comment = 1;

    if($act){

      if(!empty($input_doc)){

        $deleted = array();

        foreach ($input_doc as $key => $value) {
          $value['ammend_id'] = $ammend_id;
          $id = (isset($value['doc_id'])) ? $value['doc_id'] : "";
          $act = $this->Addendum_m->replaceDoc($id,$value);
          if($act){
            $deleted[] = $act;
          }
        }

        $this->Addendum_m->deleteIfNotExistDoc($ammend_id,$deleted);

      }

      if(!empty($input_milestone)){

        $deleted = array();

        foreach ($input_milestone as $key => $value) {
          $value['ammend_id'] = $ammend_id;
          $act = $this->Addendum_m->replaceMilestone($key,$value);
          if($act){
            $deleted[] = $act;
          }
        }

        $this->Addendum_m->deleteIfNotExistMilestone($ammend_id,$deleted);

      }

/*
      if($last_activity == 3000){

      //COPY ITEM

        $prc = $this->db->where("ptm_number",$ptm_number)->get("vw_prc_monitor")->row_array();

        $vendor_id = $prc['vendor_id'];

        $this->db->where("vendor_id",$vendor_id);

        $quo_item = $this->Procrfq_m->getViewVendorQuoComRFQ("","",$ptm_number)->result_array();

        foreach ($quo_item as $key => $value) {

         $list_qty = array($value['pqi_quantity'],$value['pqi_quantity']);

         $inp = array(
          "tit_id"=>$value['tit_id'],
          "ammend_id"=>$ammend_id,
          "item_code"=>$value['tit_code'],
          "short_description"=>$value['short_description'],
          "long_description"=>$value['long_description'],
          "price"=>$value['pqi_price'],
          "qty"=>$value['pqi_quantity'],
          "min_qty"=>min($list_qty),
          "max_qty"=>max($list_qty),
          "uom"=>$value['tit_unit'],
          );
         $act = $this->Addendum_m->insertItem($inp);

       }

     }

     */

     $response = $post['status_inp'][0];

     $com = $post['comment_inp'][0];

     $return = $this->Procedure3_m->ctr_ammend_comment_complete($ptm_number,$userdata['complete_name'],$last_activity,$response,$com,"",$last_comment['comment_id'],$contract_id,$ammend_id,$userdata['employee_id'], $plan['ppm_type_of_plan']);
// var_dump($return);
// exit();
     if(!empty($return['nextactivity'])){

       $comment = $this->Comment_m->insertAddendum($ammend_id,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$contract_id);

     }

     if(!empty($return['message'])){
      $this->setMessage($return['message']);
      if(!$error){
        $error = true;
      }
    }

  }

  if(!$error){
    if ($this->db->trans_status() === FALSE)
    {
      $this->setMessage("Gagal mengubah data");
      $this->db->trans_rollback();
    }
    else
    {
      $this->setMessage("Sukses mengubah data");
      $this->db->trans_commit();
    }
    $this->renderMessage("success",site_url("contract/daftar_pekerjaan"));
  } else {
    $this->renderMessage("error");
  }

}
