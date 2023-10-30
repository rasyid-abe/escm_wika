<?php
$mod='po';
include APPPATH.'controllers/shared/declared.php';
$post = $this->input->post();

//var_dump($post);die;
$reff            = $post['reff'];
$error           = false;
$comment_id      = 0;
$last_comment    = array();
$userdata        = $this->session->userdata();
$last_activity   = null;
$inserted_id     = 0;
$contract_id     = $post['contract_id'];
$where           = array('contract_id'=>$contract_id);
$contract        = $this->Global_m->get_data('ctr_contract_header', $where);
$contract_doc    = $this->Global_m->get_data('ctr_contract_doc', $where);
$contract_amount = $contract['contract_amount'];
$total_alokasi_inp = $post['total_alokasi_inp'];
$total_item      = 0;
$wo_id           = $post['wo_id'];
$response        = $post['status_inp'][0];
$comment         = $post['comment_inp'][0];
$inputs          = null;
$input_items     = null;
$add_inputs      = null;
$items           = null;
$state           = $post['state'];
$reff            = $post['reff'];
$id              = $post['id'];
//var_dump($userdata);die;

$this->db->trans_begin();

if($state==0){
  $activity_id = $activity_first;
}else{
  $where_data    = array('wo_id'=>$id,'cwo_name' => null);
  $last_comment  = $this->Global_m->get_data('ctr_wo_comment', $where_data);
  $last_activity = $last_comment['cwo_activity'];
  $comment_id    = $last_comment['cwo_id'];
  $activity_id   = $last_activity;
}


if( $state==1 || $state==0){
  //Standard Header
  $inputs = array(
    'wo_number'       => strtoupper($post['po_number']),
    'creator_employee' => $userdata['id'],
    'creator_pos'      => $userdata['pos_name'],
    'contract_id'      => $contract['contract_id'],
    'vendor_id'        => $contract['vendor_id'],
    'created_date'     => date('Y-m-d H:i:s'),
    'wo_notes'         => $post['po_notes'],
    'status'           => $activity_id,
    'vendor_name'        => $contract['vendor_name'],
    'start_date'         => $post['tgl_mulai_inp'],
    'end_date'           => $post['tgl_akhir_inp'],
    'spk_number'         => $post['spk_number'],
    'spk_name'           => $post['name_spk'],
    'ctr_amount'         => $contract['contract_amount'],
    'ctr_doc'            => $contract_doc['filename'],
    'currency'           => $contract['currency'],
    'dept_id'            => $dept_id,
    'dept_code'          => $dept_code

  );
  $datecheck = isset($_POST['ctr_skbdn_tanggal_terbit']) ? $_POST['ctr_skbdn_tanggal_terbit'] : null;
  if ($datecheck !== null) {
    $add_inputs =  array('ctr_skbdn_tanggal_terbit' => $post['ctr_skbdn_tanggal_terbit']);
  }
  if($state==0){
    if($this->number_exist('ctr_wo_header',$post['po_number'])){
      $this->setMessage('PO Number sudah ada');
      $error = true;
    }
  }

  if($total_alokasi_inp==0){
    $this->setMessage('Harus mengisi salah satu detail input');
    $error = true;
  }
  if($state==0){
    $this->Global_m->insert_table('ctr_wo_header', $inputs);
    $id = $this->db->insert_id();
  }else{
    $this->Global_m->update_table('ctr_wo_header',$inputs,$id);
  }

  //update comment
  //COmment Handle



  //print_r($activity_id);die;

  $items = isset($post['item']) ? $post['item'] : null;
  if ($items) { //check if there's item selected
    //begin foeach items
    //referensi action sebelum nya
    $add_items = array();
    foreach ($items as $key => $value) {
      $qty         = $post['qty_data'][$key];
      if($state==0){
        $where       = array($reff.'_item_id' => $key);
        $dt          = $this->Global_m->get_data('ctr_contract_item', $where);
      }else{
        $where       = array('wo_item_id' => $key);
        $dt          = $this->Global_m->get_data('ctr_wo_item', $where);
      }
      $sub_total   = (1 + (($dt['ppn'] + $dt['pph']) / 100)) * ($dt['price'] * $qty);
      $input_items = array(
        'wo_id'             => $id,
        'contract_item_id'  => $dt['contract_item_id'],
        'item_code'         => $dt['item_code'],
        'short_description' => $dt['short_description'],
        'long_description'  => $dt['long_description'],
        'price'             => $dt['price'],
        'qty'               => $qty,
        'uom'               => $dt['uom'],
        'sub_total'         => $sub_total,
        'ppn'               => $dt['ppn'],
        'pph'               => $dt['pph']
      );
      $input_items += $add_items;
      $total_item += $sub_total;

      if ($state == 1) {
        $this->Global_m->update_table('ctr_wo_item',$input_items, $key);
      } elseif ($state == 0) {
        $this->Global_m->insert_table('ctr_wo_item',$input_items);
      }
    }//end foeach items
  }
  for ($i=0; $i <=5 ; $i++) {
    if(!empty($post['doc_attachment_inp'][$i]!=="")){
      $data = array(
        'category' => $post['doc_category_inp'][$i],
        'filename' => $post['doc_attachment_inp'][$i],
        'description'=> $post['doc_desc_inp'][$i],
        'wo_id'=>$id
      );
      if($state==0){
        $this->db->insert('ctr_wo_doc',$data);
      }else{
        $this->Global_m->update_table('ctr_wo_doc',$data,$post['doc_id_inp'][$i]);
      }
    }
  }
}



if($state!==2){
  $qry='SELECT SUM("qty")*sum("price") AS "total_item" FROM "ctr_wo_item" WHERE "wo_id" = '.$id;
  $total_item = $this->db->query($qry)->row()->total_item;
  $nextPosCode  = "";
  $nextPosName  = "";
  $lastPosCode  = "";
  $lastPosName  = "";
  $nextActivity = 0;
  $activity_ins=0;
  $pos_id       = 0;
  $pos_name     = "";
  $w_response=array("awr_id"=>$response);
  $response_text = $this->Global_m->get_data("adm_wkf_response", $w_response)["awr_name"];
  switch (strtoupper($response_text)) {
    case "VENDOR SETUJU PO":
    $activity_ins = 2037; //Pembuatan SKBDN
    $dta=$this->db->query('SELECT DISTINCT * FROM ctr_wo_comment WHERE wo_id='.$id.' AND cwo_activity=2031')->row_array();
    //echo $this->db->last_query();die;
    //Next Activity
    $pos_id=$dta['cwo_pos_code'];
    $pos_name=$dta['cwo_position'];
    //echo "data";
    //print_r($dta);die;
    break;
    case "VENDOR TOLAK PO":
    $activity_ins = 2034;//Tolak PO - Batal
    $where=array('wo_id'=>$id,'cwo_activity'=>2031);
    $dta=$this->db->where($where)->get('ctr_wo_comment')->row_array();
    $pos_id=$dta['cwo_pos_code'];
    $pos_name=$dta['cwo_position'];
    break;
  }
//var_dump($userdata);die;
  if($state==3 || $state==0 || $state==1){
    $comment_arr = array(
      "cwo_response"   => $response_text,
      "cwo_name"       => $userdata['login_id'],
      "cwo_end_date"   => date("Y-m-d H:i:s"),
      "cwo_comment"    => $comment,
      //"cwo_attachment" => $attachment,
      "cwo_user"       => $userdata['userid'],
    );
    $activity_id  = $last_comment['cwo_activity'];
    $lastPosName  = $last_comment['cwo_position'];
    $lastPosCode  = $last_comment['cwo_pos_code'];
    $nextPosCode  = $lastPosCode;
    $nextPosName  = $lastPosName;
    $comment_id=$last_comment['cwo_id'];
    $this->Global_m->update_table("ctr_wo_comment", $comment_arr, $comment_id);
    //echo $this->db->last_query();die;
  }
}

//Next Activity
if($state==0 || $state==3){
  $comment_arr = array(
    "wo_id"          => $id,
    "cwo_pos_code"   => $pos_id,
    "cwo_position"   => $pos_name,
    "cwo_name"       => null,
    "cwo_activity"   => $activity_ins, //next activity
    "cwo_start_date" => date("Y-m-d H:i:s"),
    "contract_id"    => (int)$contract_id,
    "wo_id"          => $wo_id
  );
  $this->Global_m->insert_table("ctr_wo_comment", $comment_arr);
  if ($activity_ins == $activity_cancel) {
    $data = array('status' => $activity_ins, 'active' => 0);
    $this->Global_m->update_table("ctr_wo_header", $data, $id);
  }else{
    $data = array('status' => $activity_ins,'current_approver_id'=>$pos_id,'current_approver_pos'=>$pos_name);
    $this->Global_m->update_table("ctr_wo_header", $data, $id);
  }
}

if (!$error) {
  if ($this->db->trans_status() === false) {
    $this->setMessage('Gagal mengubah data');
    $this->db->trans_rollback();
  } else {
    $this->setMessage('Sukses mengubah data');
    $this->db->trans_commit();
  }
  $this->renderMessage('success', site_url('kontrak'));
} else {
  $this->db->trans_rollback();
  $this->renderMessage('error');
}
