<?php

$error = false;

$post = $this->input->post();

$id = $post['id'];
$res = $post['status_inp'];
$userdata = $this->data['userdata'];

$this->db->trans_begin();
//start code hlmifzi
$progress = $this->db->select("a.invoice_id,a.invoice_status,a.acc_invoice,d.contract_amount,b.progress_percentage,b.progress_description,b.po_id,ctr_spe_pos,a.vendor_id,a.vendor_name,a.contract_id,d.contract_number,a.invoice_notes,a.creator_employee")
->where("a.po_id",$id)
->join("ctr_invoice_header a","a.po_id=b.po_id")
->join("ctr_contract_header d","a.contract_id=d.contract_id")
->join("prc_tender_main e","e.ptm_number=d.ptm_number")
->get("ctr_po_progress_header b")->row_array();
//end

$input = array(
  "bastp_status"=>99,
  "current_approver_pos"=>null,
  "current_approver_id"=>null,
);

$posname = "";
$posid = null;

/*
if(!empty($res)){

  switch ($progress['invoice_status']) {

    case 1:

    $title = "MANAJER BAST";
    $bastp_status = 2;

    break;

    case 2:

    $title = "";
    $bastp_status =null ;


    default:
    $title = "";
    $bastp_status = null;
    break;

  }
*/ //hirarki old


  if(!empty($res)){

    switch ($progress['invoice_status']) {

      case 1:

      $title = "";
      $bastp_status =null ;

      break;

      default:
      $title = "";
      $bastp_status = null;
      break;

    }


  if(!empty($title)){

    $pos = $this->db->select("pos_id")
    ->where(array(
      "district_id"=>$userdata['district_id'],
      "dept_id"=>$userdata['dept_id'],
      "job_title"=>$title,
    ))->get("adm_pos")
    ->row_array();

    if(empty($pos)){

      $pos = $this->db->select("pos_id")
      ->where(array(
        "district_id"=>$userdata['district_id'],
        "job_title"=>$title,
      ))->get("adm_pos")
      ->row_array();

    }

    $posid = $pos['pos_id'];

  }

  $input = array(
    "current_approver_pos"=>$posid,
    "current_approver_id"=>null,
    "invoice_status"=>$bastp_status
  );
//hlmifzi

  $input['approved_date'] = date("Y-m-d H:i:s");

} else {

$invoice_status = 99;

$input = array("current_approver_pos"=>null,"current_approver_id"=>null,"invoice_status"=>$invoice_status);


}

if(empty($progress['acc_invoice'])){
  $input["request_invoice"] = $post['pay_old_inp'];
  $input["acc_invoice"] = $post['jml_dibayar_inp'];
  $input["denda_invoice"] = $post['denda_inp'];
}
//end


//input lampiran hlmifzi
$input_comment = array();

$n = 0;
$last_id = $progress['invoice_id'];
foreach ($post as $key => $value) {

  if(is_array($value)){

    foreach ($value as $key2 => $value2) { 

      if(isset($post['doc_attachment_inp'][$key2]) && !empty($post['doc_attachment_inp'][$key2])){

        $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
        $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
        $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

        $input_comment[$key2]['category']=$post['doc_category_inp'][$key2];;
        $input_comment[$key2]['description']=$post['doc_desc_inp'][$key2];
        $input_comment[$key2]['filename']=$post['doc_attachment_inp'][$key2];
        $input_comment[$key2]['invoice_id'] = $last_id;
        $input_comment[$key2]['status']=1;
      }

    }

    $n++;

  }

}


foreach ($input_comment as $key => $value) {

 /* var_dump($input_comment);
  exit();*/
   $act =  $this->db->insert('ctr_invoice_doc',$input_comment[$key]);
}



//end

$this->db->where("po_id",$id)->update("ctr_invoice_header",$input);

$progress_latest = $this->db
->where(array("po_id"=>$id,"progress_percentage"=>100))
->get("ctr_po_progress_header")->row_array();

$progress_id = $progress_latest['progress_id'];

$input = array(
  "progress_id"=>$progress_id,
  "comment_name"=>$userdata['complete_name'],
  "comment_date"=>date("Y-m-d H:i:s"),
  "comments"=>$post['komentar_inp'],
  "comment_type"=>0,
  "user_id"=>$userdata['employee_id'],
  "comment_activity"=> (!empty($res)) ? "Setuju" : "Revisi",
);

$this->db->insert("ctr_po_progress_comment",$input);

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

