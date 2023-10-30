<?php

// NOTE: Aplikasi untuk SPPM
// Revised 01-12-2018 07:36
// Develop By Jody Aryono
// --------------------------------------------


//Call module
$this->load->model('Procedure_matgis_m');
//Declaration
$error = false;
$post = $this->input->post();



//Get variable from adm_settings
$act_create=$this->Settings_m->get_settings_num('_ACT_SPPM_MATGIS_CREATE');
$act_cancel=$this->Settings_m->get_settings_num('_ACT_SPPM_MATGIS_CANCEL');
$act_active=$this->Settings_m->get_settings_num('_ACT_SPPM_MATGIS_ACTIVE');



$userdata = $this->Administration_m->getLogin();

$id = $post['id'];
$wo_id=$post['wo_id'];
$sppm_id = isset($post['sppm_id'])?$post['sppm_id']:"";
$filename=(!empty($post['filename'])) ? $post['filename'] : "";
$last_comment = array();



//Retrieve Data
//$items = $this->Contract_m->getWOMatgisItem("",$wo_id)->result();


//Check Data
if(!empty($sppm_id)){
  $last_comment = $this->Comment_m->getSPPMMatgis("",$sppm_id)->row_array();
}
$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : $act_create;
$position = $this->Administration_m->getPosition("PIC USER");

$this->db->trans_begin();

//Array Data Header
$input = array(
  "sppm_number"=>$post["sppm_number"],
  "creator_employee"=>$userdata["employee_id"],
  "creator_pos"=>$userdata["pos_id"],
  "contract_id"=>$post["contract_id"],
  "vendor_id"=>$post["vendor_id"],
  "sppm_date"=>$post["sppm_date"],
  "created_date"=>date("d-m-Y H:i:s"),
  "sppm_notes"=>$post["sppm_notes"],
  "wo_id"=>$post["wo_id"],
  "tgl_expected_delivery"=>$post["sppm_request_date"],
  "sppm_title"=>$post["sppm_title"],
  "status"=>$last_activity,
);



if(!empty($sppm_id)){
  $this->Global_m->update_table("ctr_sppm_header",$input,$sppm_id);
} else {
  $this->Global_m->insert_table("ctr_sppm_header",$input);
  $sppm_id = $this->db->insert_id();
}


$items=$post['item'];
foreach ($items as $key => $value) {
  $qty = $post['qty_wo'][$key];
  //echo $key."=>".$value." Qty:".$qty.PHP_EOL;
  $dt=$this->Procedure_matgis_m->get_data("ctr_wo_item",$key);
    $sub_total = (1+(($dt['ppn']+$dt['pph'])/100))*($dt['price']*$qty);
  $arrItem = array(
    "sppm_id"=>$sppm_id,
    "contract_item_id"=>$dt["contract_item_id"],
    "item_code"=>$dt["item_code"],
    "short_description"=>$dt["short_description"],
    "long_description"=>$dt["long_description"],
    "price"=>$dt["price"],
    "qty"=>$qty,
    "uom"=>$dt["uom"],
    "sub_total"=>$sub_total,
    "ppn"=>$dt["ppn"],
    "pph"=>$dt["pph"],
    "wo_item_id"=>$key
  );
  $this->Global_m->insert_table("ctr_sppm_item",$arrItem);
}


//insert doc
if($filename!==""){
  $file_data = array(
    'sppm_id' =>$sppm_id,
    'category'=>"SPPM",
    'filename'=>$filename,
    'status'=>1,
    'description'=>'File SPPM' );
    $this->Global_m->insert_table("ctr_sppm_doc",$file_data);
  }



  $userdata = $this->Administration_m->getLogin();
  $response = $post['status_inp'][0];
  $comment  = $post['comment_inp'][0];


  //print_r($userdata);die;

  //Insert ctr_si_comment
  $comment_arr = array(
    "wo_id"=>$post["wo_id"],
    "cwo_pos_code"=>(!empty($pos_code)) ? $pos_code : $userdata['pos_id'],
    "cwo_position"=>(!empty($position)) ? $position : $userdata['pos_name'],
    "cwo_name"=>(!empty($user_name)) ? $pos_name : $userdata['user_name'],
    "cwo_activity"=>$last_activity,
    "cwo_start_date"=>date("Y-m-d H:i:s"),
    "cwo_end_date"=>date("Y-m-d H:i:s"),
    "cwo_response"=>$this->Procedure_matgis_m->get_data("adm_wkf_response",$response)['awr_name'],
    "cwo_comment"=>$comment,
    //"cwo_attachment"=>$post["cwo_attachment"],
    "cwo_user"=>$userdata["id"],
    "contract_id"=>$post["contract_id"],
    "sppm_id"=>$sppm_id,
  );

  $this->Global_m->insert_table("ctr_sppm_comment",$comment_arr);
  $comment_id = $this->db->insert_id();

  //
  $rsp_simpan=$this->Settings_m->get_settings_num('_RSP_SPPM_SIMPAN_LANJUT');
  $rsp_draft=$this->Settings_m->get_settings_num('_RSP_SPPM_SIMPAN_DRAFT');
  $rsp_batal=$this->Settings_m->get_settings_num('_RSP_SPPM_BATAL');
  //echo $this->db->last_query();die;

  //Check apakah ada Next $activity
  if($response==$rsp_simpan){ //Simpan dan Lanjut
    //Logic jika simpan dan lanjut next activity Adalah SI Active
    $comment_arr = array(
      "wo_id"=>$post["wo_id"],
      "cwo_pos_code"=>(!empty($pos_code)) ? $pos_code : $userdata['pos_id'],
      "cwo_position"=>$position,
      "cwo_name"=>(!empty($pos_name)) ? $pos_name : $userdata['user_name'],
      "cwo_activity"=>$act_active,
      "cwo_start_date"=>date("Y-m-d H:i:s"),
      "cwo_response"=>$this->Procedure_matgis_m->get_data("adm_wkf_response",$response)['awr_name'],
      "cwo_comment"=>$comment,
      //"cwo_attachment"=>$post["cwo_attachment"],
      "cwo_user"=>$userdata["id"],
      "contract_id"=>$post["contract_id"],
      "sppm_id"=>$sppm_id,
    );
    $comment_id = $this->db->insert_id();
    $sppm_header = array('status' => $act_active);
    //Update Header SI Matgis dengan status Active;
    $this->Procedure_matgis_m->update_header($sppm_header,"ctr_sppm_header",$sppm_id);
  }elseif($response==$rsp_draft){ //Simpan dan draft
    //Logic jika simpan dan draft next activity Adalah Pembuatan SI
    $comment_arr = array(
      "wo_id"=>$post["wo_id"],
      "cwo_pos_code"=>(!empty($pos_code)) ? $pos_code : $userdata['pos_id'],
      "cwo_position"=>(!empty($pos_name)) ? $pos_name : $userdata['pos_name'],
      "cwo_activity"=>$act_create,
      "cwo_start_date"=>date("Y-m-d H:i:s"),
      "cwo_response"=>"",
      "cwo_comment"=>"",
      //"cwo_attachment"=>$post["cwo_attachment"],
      "cwo_user"=>NULL,
      "contract_id"=>$post["contract_id"],
      "sppm_id"=>$sppm_id,
    );
    $comment_id = $this->db->insert_id();
    $sppm_header = array('status' => $act_create);
    //Update Header SI Matgis dengan status Active;
    $this->Procedure_matgis_m->update_header($sppm_header,"ctr_sppm_header",$sppm_id);

  }else{
    //rsp_batal
    //inactive ctr_si_comment
    $this->Procedure_matgis_m->set_active_comment_rec("ctr_sppm_header",$sppm_id,0);
    //inactive ctr_si_item
    $this->Procedure_matgis_m->set_active_item_rec("ctr_sppm_header",$sppm_id,0);
    //inactive ctr_si_header
    $this->Procedure_matgis_m->set_active_header_rec("ctr_sppm_header",$sppm_id,0);
  }
  $this->Global_m->insert_table("ctr_sppm_comment",$comment_arr);

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
      $this->renderMessage("success",site_url("contract/work_order_matgis/daftar_pekerjaan_matgis"));
    }
  } else {
    $this->renderMessage("error");
  }
