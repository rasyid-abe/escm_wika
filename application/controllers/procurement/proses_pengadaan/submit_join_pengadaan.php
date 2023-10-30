<?php

$post = $this->input->post();

$id = $post['id'];

$last_comment = $this->Comment_m->getProcurementPR("",$id)->row_array();

$pr_number = $last_comment['tender_id'];

$tender = $this->Procpr_m->getPR()->row_array();

$input = array();

$userdata = $this->data['userdata'];

// $employee = $this->Administration_m->getEmployeeJoin($post['pelaksana'])->row_array();
// $buyername = $this->db->select("*")->where(array("id"=>$post['pelaksana']))->get("adm_employee")->row_array();
$requester = $this->Administration_m->getPosition("PIC USER", $userdata['employee_id']);

$ptmjoin = $this->Procrfq_m->getUrutRFQ();

$group = (isset($this->data['selection_group'])) ? $this->data['selection_group'] : 0;

$cekpr = (isset($this->data['selection_pr'])) ? $this->data['selection_pr'] : 0;

$getpr = str_replace("_", ".", $cekpr);

if(!empty($getpr)){

  $joinedpr = "";
  $joineddept = "";
  foreach ($getpr as $key => $value) {
    $prr = $this->Procpr_m->getPR($value)->row_array();
    $joineddept .= $prr['pr_dept_name'].";";
    $joinedpr .= $prr['pr_number'].";";
  }


  $this->db->where_in('pr_number', $getpr);
  $this->db->where(array('pr_buyer_id'=>$userdata['employee_id']));
  $plan = $this->db->get("prc_pr_main")->result_array();

  if($plan != NULL){
    foreach ($plan as $ok => $vvv) {
      $typeplan = $vvv['pr_type_of_plan'];
    }
  }else{
    $this->db->where(array('pr_buyer_id'=>$userdata['employee_id']));
    $newplan = $this->db->get("prc_pr_main")->result_array();
    foreach ($newplan as $ko => $vals) {
      $typeplan = $vals['pr_type_of_plan'];
    }
  }

  foreach ($post as $key => $value) {
    if(is_array($value)){
      foreach ($value as $key2 => $value2) { 
        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

        $input_doc[$key2]['ppd_category']=(isset($post['doc_category_inp'][$key2])) ? $post['doc_category_inp'][$key2] : "";
        $input_doc[$key2]['ppd_description']=(isset($post['doc_desc_inp'][$key2])) ? $post['doc_desc_inp'][$key2] : "";
        $input_doc[$key2]['ppd_file_name']=(isset($post['doc_attachment_inp'][$key2])) ? $post['doc_attachment_inp'][$key2] : "";
      }
    }
  }

  $response = $post['status_inp'][0];
  $com = $post['comment_inp'][0];
  $attachment = '';

  $error = false;

  if (count($getpr) > 1) {
    $this->form_validation->set_rules("nama_pekerjaan", "Nama Pekerjaan", 'required');
    $this->form_validation->set_rules("deskripsi_pekerjaan", "Deskripsi Pekerjaan", 'required');

  }else{
    if($prr['pr_number'] != $pr_number){
      $this->setMessage("No. Paket Pengadaan yang diceklis harus sama dengan No. Paket Pengadaan pada Headline");
      $error = true;    
    }
  }

  // if(count($group) > 1){  
    // $this->setMessage("Paket yang ingin digabung harus dalam kode grup yang sama");
    // $error = true;
  // }

  //input tender main
  $joinmain = array(
    'ptm_number' => $ptmjoin,
    'ptm_requester_name' => $userdata['complete_name'],
    'ptm_requester_id' => $requester['employee_id'],
    'ptm_requester_pos_code' => $requester['pos_id'],
    'ptm_requester_pos_name' => $requester['pos_name'],
    'ptm_subject_of_work' => $post['nama_pekerjaan'],
    'ptm_scope_of_work' => $post['deskripsi_pekerjaan'],
    'ptm_buyer' => $userdata['complete_name'],
    'ptm_buyer_id' => $userdata['employee_id'],
    'ptm_buyer_pos_code' => $userdata['pos_id'],
    'ptm_buyer_pos_name' => $userdata['pos_name'],
    'ptm_status' => 1040,
    'ptm_dept_id' => $userdata['dept_id'],
    'ptm_dept_name' => $userdata['dept_name'],
    'ptm_tender_id' => 0,
    'ptm_created_date' => date("Y-m-d H:i:s"),
    'pr_number' => $joinedpr,
    'isjoin' => 1,
    'ptm_dept' => $joineddept,
    'ptm_type_of_plan' => $typeplan,
    'ptm_packet' => "Join Paket Pengadaan"
  );

  $preps = array("ptp_id" => 0, 'ptm_number' => $ptmjoin);

  if ($this->form_validation->run() == FALSE || $error ){

    $this->renderMessage("error");

  } else {

    $this->db->trans_begin();

    $act = true;

  if(count($getpr) > 1 ){ //execute join

    //insert data rfq main
    $tender = $this->Procrfq_m->insertDataRFQ($joinmain);
    
    //input item rfq
    foreach ($getpr as $key => $prnum) {

      // var_dump($prnum);
      $getitem = $this->Procpr_m->getItemPR("", $prnum)->result_array();

      foreach ($getitem as $keys => $values) {

        $joinitem['tit_code'] = $values['ppi_code'];
        $joinitem['ptm_number'] = $ptmjoin;
        $joinitem['tit_description'] = $values['ppi_description'];
        $joinitem['tit_quantity'] = $values['ppi_quantity'];
        $joinitem['tit_unit'] = $values['ppi_unit'];
        $joinitem['tit_price'] = $values['ppi_price'];
        $joinitem['tit_currency'] = $values['ppi_currency'];
        $joinitem['tit_type'] = $values['ppi_type'];
        $joinitem['tit_ppn'] = $values['ppi_ppn'];
        $joinitem['tit_pph'] = $values['ppi_pph'] != null ? $values['ppi_pph'] : 0;
        $joinitem['pr_number'] = $prnum;
		    $joinitem['tit_tujuan'] = $values['ppi_pr_tujuan'];;
        
        $item = $this->Procrfq_m->insertItemRFQ($joinitem);

      }

      //add flag rfq number on pr_main
      $flag = $this->Procpr_m->updateDataPR($prnum, array("joinrfq"=>$ptmjoin, "isjoin"=>1, "pr_status"=>1040));

      foreach ($input_doc as $key => $value) {
        if(!empty($value['ppd_file_name'])){
          $value['pr_number'] = $prnum;
          $act = $this->Procpr_m->insertDokumenPR($value);
        }
      }

      //update anggaran
      $hist = array(
        'pph_desc' => 1040,
        'pph_mod' => $ptmjoin
      );
      $plan_hist = $this->Procplan_m->updateHist($prnum, $hist);
      
      //pr comment selesai
      $comm = $this->Comment_m->getProcurementPR($prnum, "")->row_array();
      $comment = $this->Procedure_m->prc_pr_comment_complete($prnum,$userdata['complete_name'],$comm['activity'],$response,$com,$attachment,$comm['comment_id'],0,$userdata['employee_id'],"",$typeplan, 1, "",$comm['comment_id']);
    }

    //input prep rfq
    $prep = $this->Procrfq_m->insertPrepRFQ($preps);

    //input comment rfq baru
    $comment = $this->Comment_m->insertProcurementRFQ($ptmjoin,1040,"","","",$userdata['pos_id'],$userdata['pos_name']);
  } 

  else { //lanjut ke rfq biasa

    foreach ($getpr as $key => $prnum) {     

      $this->db->select('*');
      $this->db->from('prc_pr_main');
      $this->db->where('pr_number', $prnum);
      $isSwakelola = $this->db->get()->row_array();

      $perencanaan = $this->Procplan_m->getPerencanaanPengadaan($prr['ppm_id'])->row_array();
      
      $return = $this->Procedure_m->prc_pr_comment_complete($prnum,$userdata['complete_name'],$last_comment['activity'],$response,$com,$attachment,$last_comment['comment_id'],0,$userdata['employee_id'],$isSwakelola['isSwakelola'],$perencanaan['ppm_type_of_plan'], "", "", $last_comment['comment_id']);
      
      $commentrfq = $this->Comment_m->insertProcurementRFQ($return['newnumber'],$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname']);
      //insert history
      $hist = array(
        'pph_desc' => $return['nextactivity'],
        'pph_mod' => $return['newnumber']
      );
      //update history anggaran
      $plan_hist = $this->Procplan_m->updateHist($prnum, $hist);
    }
  }

  if ($this->db->trans_status() === FALSE) {
    $this->setMessage("Gagal mengubah data");
    $this->db->trans_rollback();
  }

  else {
    $this->setMessage("Sukses mengubah data");
    $this->db->trans_commit();
  }

  $this->renderMessage("success",site_url("procurement/daftar_pekerjaan"));

} 


} else {
  $this->setMessage("PR wajib dipilih");
  $this->renderMessage("error");
}