<?php

// NOTE: Aplikasi untuk Shipment Instruction
// Revised 01-12-2018 07:36
// Develop By Jody Aryono
// --------------------------------------------


//Call module
$this->load->model('Procedure_matgis_m');

//Declaration
$error = false;

//Get variable from adm_settings
$act_create=$this->Settings_m->get_settings_num('_ACT_SI_MATGIS_CREATE');
$act_cancel=$this->Settings_m->get_settings_num('_ACT_SI_MATGIS_CANCEL');
$act_active=$this->Settings_m->get_settings_num('_ACT_SI_MATGIS_ACTIVE');

$post = $this->input->post();

$userdata = $this->Administration_m->getLogin();

$id = $post['id'];
$wo_id=$post['wo_id'];
$si_id = isset($post['si_id'])?$post['si_id']:"";
$filename=(!empty($post['filename'])) ? $post['filename'] : "";
$last_comment = array();

//Retrieve Data
//$items = $this->Contract_m->getWOMatgisItem("",$wo_id)->result();


//Check Data
if(!empty($si_id)){
  $last_comment = $this->Comment_m->getSIMatgis("",$si_id)->row_array();
}
$last_activity = (!empty($last_comment)) ? $last_comment['activity'] : $act_create;
$position = $this->Administration_m->getPosition("PIC USER");

$this->db->trans_begin();

//Array Data Header
$input = array(
  "creator_employee"=>$userdata["employee_id"],
  "creator_pos"=>$userdata["pos_id"],
  "contract_id"=>$post["contract_id"],
  "vendor_id"=>$post["vendor_id"],
  "vendor_name"=>$post["vendor_name"],
  "currency"=>(isset($post["currency"]))?$post["currency"]:"",
  "created_date"=>date("d-m-Y H:i:s"),
  "status"=>$last_activity,
  "si_number"=>$post["si_number"],
  "delivery_address"=>$post["delivery_address"],
  "wo_id"=>$post["wo_id"],
  "si_notes"=>$post["si_notes"],
  "vendor_pic"=>$post["vendor_pic"],
  "delivery_name"=>$post["delivery_name"],
  "delivery_pic"=>$post["delivery_pic"],
  "si_date"=>$post["si_date"],
  "nama_barang"=>$post["nama_barang"],
  "transporter_id"=>$post["transporter_id"],
  "transporter_name"=>$this->Procedure_matgis_m->get_data("vnd_header",$post["transporter_id"])['vendor_name'],
  "transporter_pic"=>$post["transporter_pic"],
  "transporter_address"=>$post["transporter_address"],
  "vendor_address"=>$post["vendor_address"],
  "delivery_date"=>$post["delivery_date"],
);



if(!empty($si_id)){
  $this->Global_m->update_table("ctr_si_header",$input,$si_id);
} else {

  $this->Global_m->insert_table("ctr_si_header",$input);

  $si_id = $this->db->insert_id();
  //Insert ctr_si_item
  $this->Procedure_matgis_m->duplicate_item_wo_to_si($wo_id,$si_id);

  //insert doc
  if($filename!==""){
    $file_data = array(
      'si_id' =>$si_id,
      'category'=>"Shipping Instruction",
      'filename'=>$filename,
      'status'=>1,
      'description'=>'upload shipping instruction' );
  }

  $this->Global_m->insert_table("ctr_si_doc",$file_data);
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
  "cwo_response"=>$this->Procedure_matgis_m->get_data("adm_wkf_response",$response)['awr_name'],
  "cwo_comment"=>$comment,
  //"cwo_attachment"=>$post["cwo_attachment"],
  "cwo_user"=>$userdata["id"],
  "contract_id"=>$post["contract_id"],
  "si_id"=>$si_id,
);

$this->Global_m->insert_table("ctr_si_comment",$comment_arr);
$comment_id = $this->db->insert_id();

//
$rsp_simpan=$this->Settings_m->get_settings_num('_RSP_SI_SIMPAN_LANJUT');
$rsp_draft=$this->Settings_m->get_settings_num('_RSP_SI_SIMPAN_DRAFT');
$rsp_batal=$this->Settings_m->get_settings_num('_RSP_SI_BATAL');
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
    "si_id"=>$si_id,
  );
  $comment_id = $this->db->insert_id();
  $si_header = array('status' => $act_active);
  //Update Header SI Matgis dengan status Active;
  $this->Procedure_matgis_m->update_header($si_header,"ctr_si_header",$si_id);
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
    "si_id"=>$si_id,
  );
  $comment_id = $this->db->insert_id();
  $si_header = array('status' => $act_create);
  //Update Header SI Matgis dengan status Active;
  $this->Procedure_matgis_m->update_header($si_header,"ctr_si_header",$si_id);

}else{
  //rsp_batal
  //inactive ctr_si_comment
  $this->Procedure_matgis_m->set_active_comment_rec("ctr_si_header",$si_id,0);
  //inactive ctr_si_item
  $this->Procedure_matgis_m->set_active_item_rec("ctr_si_header",$si_id,0);
  //inactive ctr_si_header
  $this->Procedure_matgis_m->set_active_header_rec("ctr_si_header",$si_id,0);
}
$this->Global_m->insert_table("ctr_si_comment",$comment_arr);

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
