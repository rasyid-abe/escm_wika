<?php

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$activity_list = array(0=>"Pembuatan Draft RKAP",1=>"Pembuatan Draft RKAP");

$post = $this->input->post();

$input = array();

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat perencanaan pengadaan");
}

$this->form_validation->set_rules("name_inp", "Nama Pengadaan", 'required|max_length['.DEFAULT_MAXLENGTH.']');

if(isset($post['name_inp'])){
  $input['phc_name']=$post['name_inp'];
}

if(isset($post['progress_inp'])){
  $input['phc_status']=$post['progress_inp'];
}

$input['phc_updated_date']=date("Y-m-d H:i:s");


  $input_comment = array();

  $n = 0;

  foreach ($post as $key => $value) {

    if(is_array($value)){

      foreach ($value as $key2 => $value2) { 

        if(isset($post['doc_attachment_inp'][$key2]) && !empty($post['doc_attachment_inp'][$key2])){

          $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
          $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
          $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

          $input_comment[$key2]['phd_id']= (isset($post['doc_id_inp'][$key2])) ? $post['doc_id_inp'][$key2] : "";
          $input_comment[$key2]['phd_desc']=$post['doc_desc_inp'][$key2];
          $input_comment[$key2]['phd_file_name']=$post['doc_attachment_inp'][$key2];

        }

      }

      $n++;

    }

  }

  $error = false;

  if ($this->form_validation->run() == FALSE  || $error){

    $this->renderMessage("error");

  } else {

     $act = $this->Procplan_m->updateHistoryCar($post['id'],$input);

     if($act){

      $last_id = $post['id'];
      $com=$post['progress_inp'];
      $dateopen = $this->input->post('dateopen');

      $this->Procplan_m->insertProgressHistoryCar($last_id,$com,$dateopen);

      $this->Procplan_m->deleteDokumenHistoryCar($last_id);

      foreach ($input_comment as $key => $value) {
        $value['phc_id'] = $last_id;
        unset($value['phd_id']);
        $act = $this->Procplan_m->insertDokumenHistoryCar($value);
      } 

    }

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

    $this->renderMessage("success",site_url("procurement/daftar_history_car"));

  }

