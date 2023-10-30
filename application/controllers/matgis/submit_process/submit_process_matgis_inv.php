<?php
$mod='inv';
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

//Start DB mysqli_begin_transaction
$this->db->trans_begin();

$where_data    = array($mod.'_id'=>$id,'cwo_name' => null);
$last_comment  = $this->Global_m->get_data('ctr_inv_comment', $where_data);
$last_activity = $last_comment['cwo_activity'];
$comment_id    = $last_comment['cwo_id'];
$activity_id   = $last_activity;



$this->data['dir'] = 'contract/inv';

$dir = './uploads/' . $this->data['dir'];

$this->session->set_userdata('module', $this->data['dir']);

if(isset($_FILES['userfile'])){
  if($_FILES['userfile']['size']>0){
    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }
    $config['allowed_types'] = '*';
    $config['overwrite']     = false;
    $config['max_size']      = 0;
    $config['upload_path']   = $dir;
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('userfile'))
    {
      $error = array('error' => $this->upload->display_errors());
      $this->setMessage('File Gagal diupload');
      if (!$error) {
        $error = true;
      }
    }
    else
    {
      $error=false;
      $data = array('upload_data' => $this->upload->data());
      $filename=$data['upload_data']['file_name'];
      $dta = array('inv_id' => $id,'category'=>$mod,'description'=>"File Tandatangan",'filename'=>$filename,'status'=>1 );
      $this->db->insert('ctr_inv_doc',$dta);
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
