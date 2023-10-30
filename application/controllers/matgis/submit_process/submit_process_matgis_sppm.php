<?php
$mod='sppm';
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
$si_id           =0;
$id              = $post['id'];
$activity_id     = $post['activity_id'];

//Start DB mysqli_begin_transaction
$this->db->trans_begin();

if($state==0){
  $activity_id = $activity_first;
}else{
  //update comment
  //COmment Handle
  $where_data    = array('sppm_id'=>$id,'cwo_name' => null);
  $last_comment  = $this->Global_m->get_data('ctr_sppm_comment', $where_data);
  $last_activity = $last_comment['cwo_activity'];
  $comment_id    = $last_comment['cwo_id'];
  $activity_id   = $last_activity;
}
if( $state==1 || $state==0){
  //Standard Header

  $inputs = array(
    'sppm_number'       => strtoupper($post['sppm_number']),
    'creator_employee' => $userdata['id'],
    'creator_pos'      => $userdata['pos_name'],
    'contract_id'      => $contract['contract_id'],
    'vendor_id'        => $contract['vendor_id'],
    'created_date'     => date('Y-m-d H:i:s'),
    'status'           => $activity_id,
    'sppm_date'        => $post['sppm_date'],
    'tgl_expected_delivery'           => date_db($post['sppm_request_date']),
    'sppm_title'       => $post['sppm_title'],
    'wo_id'            => $wo_id,
  );


  if($state==0){
    $inputs=$inputs+array('si_id'=>$id);
    if($this->number_exist('ctr_sppm_header',$post['sppm_number'])){
      $this->setMessage('SPPM Number sudah ada');
      $error = true;
    }
    $this->Global_m->insert_table('ctr_sppm_header', $inputs);
    $id = $this->db->insert_id();
  }else{
    $this->Global_m->update_table('ctr_sppm_header',$inputs,$id);
  }

  $items = isset($post['item']) ? $post['item'] : null;
  if ($items) { //check if there's item selected
    //begin foeach items
    //referensi action sebelum nya
    $add_items = array();
    foreach ($items as $key => $value) {
      $qty         = $post['qty_data'][$key];
      if($state==0){
        $where       = array($reff.'_item_id' => $key);
        $dt          = $this->Global_m->get_data('ctr_'.$reff.'_item', $where);
      }else{
        $where       = array($mod.'_item_id' => $key);
        $dt          = $this->Global_m->get_data('ctr_'.$reff.'_item', $where);
      }
      if($post['qty_max'][$key]<$qty){
        $this->setMessage('Volume yg dimasukan harus lebih kecil atau sama dengan volume Maximum');
        $error = true;
      }

      $sub_total   = (1 + (($dt['ppn'] + $dt['pph']) / 100)) * ($dt['price'] * $qty);
      $input_items = array(
        'sppm_id'           => $id,
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

      if ($state ==1 ) {
        $this->Global_m->update_table('ctr_sppm_item',$input_items, $key);
      } elseif ($state == 0) {
        $this->Global_m->insert_table('ctr_sppm_item',$input_items);
      }
    }//end foeach items
  }
  for ($i=0; $i <=5 ; $i++) {
    if(!empty($post['doc_attachment_inp'][$i]) || $post['doc_attachment_inp'][$i]!==""){
      $data = array(
        'category' => $post['doc_category_inp'][$i],
        'filename' => $post['doc_attachment_inp'][$i],
        'description'=> $post['doc_desc_inp'][$i],
        'sppm_id'=>$id
      );
      if($state==0){
        $this->db->insert('ctr_sppm_doc',$data);
      }else{
        if(isset($post['doc_id_inp'][$i])){
          $this->db->where('doc_id',$post['doc_id_inp'][$i]);
          $this->db->get('ctr_wo_doc')->result_array();
          $this->Global_m->update_table('ctr_sppm_doc',$data,$post['doc_id_inp'][$i]);
        }else{
          $this->db->insert('ctr_sppm_doc',$data);
        }
      }
    }else{
      //check deleted file
      if(isset($post['doc_id_inp'][$i])){
        $this->db->where('doc_id',$post['doc_id_inp'][$i]);
        $this->db->delete('ctr_sppm_doc');
      }
    }
  }
}

if($state!==2){

  $qry='SELECT SUM("qty")*sum("price") AS "total_item" FROM "ctr_wo_item" WHERE "wo_id" = '.$id;
  $total_item = $this->db->query($qry)->row()->total_item;
  $sppm_id=$id;
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
    $dept_id,
    $sppm_id);

    if ($state!==0){
      $this->db->where('sppm_id',$id);
      $si_id=$this->db->get('ctr_sppm_header')->row()->si_id;
      $this->db->where('si_id',$si_id);
      $sum_si=$this->db->get('vw_sum_si')->row()->total_qty;
      $this->db->where('si_id',$si_id);
      $this->db->select_sum('total_qty');
      $sum_sppm=$this->db->get('vw_sum_sppm')->row()->total_qty;

      if($sum_si==$sum_sppm){
        //CLose SI sehingga tidak bisa buat sppm baru
        //dengan close comment terakhir
        $comment_arr = array(
          "cwo_response"   => "Auto Closed By System",
          "cwo_name"       => $userdata['user_name'],
          "cwo_end_date"   => date("Y-m-d H:i:s"),
          "cwo_comment"    => "SI Closed",
          "cwo_user"       => $userdata["id"]
        );
        $this->db->where('si_id',$si_id);
        $this->db->where('cwo_name',null);
        $this->db->where('cwo_activity',2042);
        $comment_id=$this->db->get('ctr_si_comment')->row_array()['cwo_id'];

        $this->Global_m->update_table("ctr_si_comment", $comment_arr, $comment_id);
      }
      //mendapatkan si_id untuk di cek apakah sudah total
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
    $this->renderMessage('success', site_url('contract/work_order_matgis/task_lists_matgis'));
  } else {
    $this->db->trans_rollback();
    $this->renderMessage('error');
  }
