<?php

$post = $this->input->post();

$last_id = $post['id'];

$input = array();

$key2 = 0;

$position = $this->Administration_m->getPosition("APPROVAL TIKET");

if(!$position){
  $this->noAccess("Hanya APPROVAL TIKET yang dapat mengelola approval permintaan tiket");
}

$userdata = $this->data['userdata'];

$this->form_validation->set_rules("status_inp[$key2]", "lang:status #$key2", 'required');
$this->form_validation->set_rules("lang:comment #$key2", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');


$status = $post['status_inp'][$key2];

$wkf = array(2=>"Setuju",4=>"Revisi");

$activity_list = array(2=>"Permintaan Disetujui",4=>"Permintaan Direvisi");

$response = $wkf[$status];

$activity = $activity_list[$status];

$com = $post['comment_inp'][0];

$attachment = '';

$input['tpm_status']=$status;

$input['tpm_status_activity']=$status;

$input_comment = array();


if($status == 2 ){
  $input['tpm_approved_date'] = date("Y-m-d H:i:s");
  $input['tpm_approved_pos_code'] = $userdata['pos_id'];
  $input['tpm_approved_pos_name'] = $userdata['pos_name'];
  $input['tpm_status_name'] = 'Telah Disetujui Pusat';
} else { 
  $input['tpm_status_name'] = 'Revisi';
}	


/*
print_r($post);

print_r($input);

print_r($input_comment);

exit();
*/

if ($this->form_validation->run() == FALSE){

  $this->renderMessage("error");


} else {

  $this->db->trans_begin();

  $act = $this->Tikplan_m->updateDataPT($last_id,$input);  


  if($act){

    $this->Comment_m->insertTiketPlan($last_id,$com,$response,$attachment,$activity);

  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
  }

  $this->renderMessage("success",site_url("tiket/permintaan_tiket/rekapitulasi_permintaan_tiket"));

}
