<?php
$mod='skbdn';
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
$contract_amount = $contract['contract_amount'];
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
$matgis          = $this->Contract_matgis_m->get_dept($contract_id);
$dept_id         = $matgis['dept_id'];
$dept_code       = $matgis['dep_code'];
$dept_name       = $matgis['dept_name'];
//Start DB mysqli_begin_transaction
if($state==3){
  $this->db->trans_begin();
  $activity_id = 2037;
  //Standard Header
  $inputs = array(
    'status'           => $activity_id,
    'ctr_skbdn_no'       => $post['skbdn_number'],
    'ctr_skbdn_penerbit' => isset($post['skbdn_penerbit']) ? $post['skbdn_penerbit'] : '',
    'ctr_skbdn_tanggal_terbit'=>$post['ctr_skbdn_tanggal_terbit']
  );
  $datecheck = isset($_POST['ctr_skbdn_tanggal_terbit']) ? $_POST['ctr_skbdn_tanggal_terbit'] : null;
  if ($datecheck !== null) {
    $inputs = $inputs + array('ctr_skbdn_tanggal_terbit' => $post['ctr_skbdn_tanggal_terbit']);
  }
  if($this->number_exist('ctr_wo_header',$post['skbdn_number'])){
    $this->setMessage('SKBDN Number sudah ada');
    $error = true;
  }
  $this->Global_m->update_table('ctr_wo_header', $inputs, $wo_id);
  $where_data    = array('wo_id'=>$id,'cwo_name' => null);
  $last_comment  = $this->Global_m->get_data('ctr_wo_comment', $where_data);
  $last_activity = $last_comment['cwo_activity'];
  $comment_id    = $last_comment['cwo_id'];
  $activity_id   = $last_activity;

  $items = isset($post['item']) ? $post['item'] : null;
  if ($items) { //check if there's item selected
    //begin foeach items
    //referensi action sebelum nya
    $add_items = array();
    foreach ($items as $key => $value) {
      $qty         = $post['qty_data'][$key];
      $where       = array($reff.'_item_id' => $key);
      $dt          = $this->Global_m->get_data('ctr_wo_item', $where);

      $sub_total   = (1 + (($dt['ppn'] + $dt['pph']) / 100)) * ($dt['price'] * $qty);
      $input_items = array(
        $mod . '_id'        => $id,
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

    }//end foeach items
  }
  $dh = array('wo_total' => $total_item);
  $this->Global_m->update_table('ctr_wo_header', $dh, $id);
  //validasi Total WO dan Kontrak
  $this->data['dir'] = 'contract/skbdn';
  $dir = './uploads/' . $this->data['dir'];
  $this->session->set_userdata('module', $this->data['dir']);

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
    $this->renderMessage('error');
  }
