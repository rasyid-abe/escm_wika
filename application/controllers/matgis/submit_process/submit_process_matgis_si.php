<?php
$mod='si';
include APPPATH.'controllers/shared/declared.php';
$post = $this->input->post();
$reff            = $post['reff'];
$error           = false;
$comment_id      = 0;
$last_comment    = array();
$userdata        = $this->Administration_m->getLogin();
$last_activity   = null;
$inserted_id     = 0;
$contract_id     = $post['contract_id'];
$where           = array('contract_id'=>$contract_id);
$contract        = $this->Global_m->get_data('ctr_contract_header', $where);
$contract_doc    = $this->Global_m->get_data('ctr_contract_doc', $where);
$matgis          = $this->Contract_matgis_m->get_dept($contract_id);
$dept_id         = $matgis['dept_id'];
$dept_code       = $matgis['dep_code'];
$dept_name       = $matgis['dept_name'];
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


$transporter_id =$post['transporter_id'];
$nomor_kontrak_transporter=$post['nomor_kontrak_transporter'];
$no_kontrak=$post['no_kontrak'];
$transporter_name="";
//Start DB mysqli_begin_transaction
$this->db->trans_begin();


if($state==0){
  $activity_id = $activity_first;
}else{
  if(!$transporter_id==null){
    $kontrak_trans=$no_kontrak;
    $transporter_id=$transporter_id;
    $transporter_name=$this->db->where('vendor_id',$post['transporter_id'])->get('vnd_header')->row_array()['vendor_name'];
  }else{
    $kontrak_trans=$nomor_kontrak_transporter;
    $transporter_name="";
    $transporter_id=0;
  }
  $where_data    = array('si_id'=>$id,'cwo_name' => null);
  $last_comment  = $this->Global_m->get_data('ctr_si_comment', $where_data);
  $last_activity = $last_comment['cwo_activity'];
  $comment_id    = $last_comment['cwo_id'];
  $activity_id   = $last_activity;
}

if( $state==1 || $state==0){
  $inputs = array(
    'si_number'       => strtoupper($post['si_number']),
    'creator_employee' => $userdata['id'],
    'creator_pos'      => $userdata['pos_name'],
    'contract_id'      => $contract['contract_id'],
    'vendor_id'        => $contract['vendor_id'],
    'created_date'     => date('Y-m-d H:i:s'),
    'status'           => $activity_id,
    'vendor_name'         => $contract['vendor_name'],
    'si_date'             => $post['si_date'],
    'transporter_id'      => $transporter_id,
    'transporter_name'    => $transporter_name,
    'transporter_address' => $post['transporter_address'],
    'transporter_pic'     => $post['transporter_pic'],
    'vendor_pic'          => $post['vendor_pic'],
    'delivery_name'       => $post['delivery_name'],
    'delivery_address'    => $post['delivery_address'],
    'delivery_pic'        => $post['delivery_pic'],
    'delivery_date'       => $post['delivery_date'],
    'email_transporter'   => $post['email_transporter'],
    'currency'            => $contract['currency'],
    'wo_id'               => $wo_id,
    'nomor_kontrak_transporter'=>isset($kontrak_trans)?$kontrak_trans:""
  );
  if($state==0){
    if($this->number_exist('ctr_si_header',$post['si_number'])){
      $this->setMessage('SI Number sudah ada');
      $error = true;
    }
  }
  if($state==0){
    $this->Global_m->insert_table('ctr_si_header', $inputs);
    $id = $this->db->insert_id();
  }else{
    $this->Global_m->update_table('ctr_si_header',$inputs,$id);
  }
  if($state==0){
    $this->Procedure_matgis_m->duplicate_item_wo_to_si($wo_id, $id);
  }


  for ($i=0; $i <=5 ; $i++) {
    if(!empty($post['doc_attachment_inp'][$i]) || $post['doc_attachment_inp'][$i]!==""){
      $data = array(
        'category' => $post['doc_category_inp'][$i],
        'filename' => $post['doc_attachment_inp'][$i],
        'description'=> $post['doc_desc_inp'][$i],
        'si_id'=>$id
      );
      if($state==0){
        $this->db->insert('ctr_si_doc',$data);
      }else{
        if(isset($post['doc_id_inp'][$i])){
          $this->db->where('doc_id',$post['doc_id_inp'][$i]);
          $this->db->get('ctr_si_doc')->result_array();
          $this->Global_m->update_table('ctr_si_doc',$data,$post['doc_id_inp'][$i]);
        }else{
          $this->db->insert('ctr_si_doc',$data);
        }
      }
    }else{
      //check deleted file
      if(isset($post['doc_id_inp'][$i])){
        $this->db->where('doc_id',$post['doc_id_inp'][$i]);
        $this->db->delete('ctr_si_doc');
      }
    }
  }
}
if($state!==2){

  $qry='SELECT SUM("qty")*sum("price") AS "total_item" FROM "ctr_wo_item" WHERE "wo_id" = '.$id;
  $total_item = $this->db->query($qry)->row()->total_item;
  $this->Procedure_matgis_m->ctr_comment_complete(
    $total_item,
    $mod,
    $id,
    $activity_id,
    $response,
    $comment, '',
    $comment_id,
    $contract_id,
    $userdata,
    $wo_id,
    $dept_id);
  }
  if (!$error) {
    if ($this->db->trans_status() === false) {
      $this->setMessage('Gagal mengubah data');
      $this->db->trans_rollback();
    } else {
      $this->setMessage('Sukses mengubah data');
      $this->db->trans_commit();
    }
    $this->renderMessage('success', site_url('contract/work_order_matgis/task_lists_matgis'));
  } else {
    $this->db->trans_rollback();
    $this->renderMessage('error');
  }
