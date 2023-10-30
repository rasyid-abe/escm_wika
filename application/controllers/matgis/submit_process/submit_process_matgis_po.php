<?php
$mod='po';
include APPPATH.'controllers/shared/declared.php';
$post = $this->input->post();

//var_dump($post);die;
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
    if(!empty($post['doc_attachment_inp'][$i]) || $post['doc_attachment_inp'][$i]!==""){
      $data = array(
        'category' => $post['doc_category_inp'][$i],
        'filename' => $post['doc_attachment_inp'][$i],
        'description'=> $post['doc_desc_inp'][$i],
        'wo_id'=>$id
      );
      if($state==0){
        $this->db->insert('ctr_wo_doc',$data);
      }else{
        if(isset($post['doc_id_inp'][$i])){
          $this->db->where('doc_id',$post['doc_id_inp'][$i]);
          $this->db->get('ctr_wo_doc')->result_array();
          $this->Global_m->update_table('ctr_wo_doc',$data,$post['doc_id_inp'][$i]);
        }else{
          $this->db->insert('ctr_wo_doc',$data);
        }
      }
    }else{
      //check deleted file
      if(isset($post['doc_id_inp'][$i])){
        $this->db->where('doc_id',$post['doc_id_inp'][$i]);
        $this->db->delete('ctr_wo_doc');
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
