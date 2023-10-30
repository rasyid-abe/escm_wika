<?php

  $view = 'perencanaan/pembuatan_proyek_non_pmcs_v';

  $this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

  $post = $this->input->post();

  $userdata = $this->data['userdata'];

  $data = array();

  $position = $this->Administration_m->getPosition();

  // if(!$position){
  //   $this->noAccess("Hanya PIC USER yang dapat membuat perencanaan pengadaan");
  // }

  $data['pos'] = $position;

  $id = "";

  $aksi = "tambah";

  $this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

  $data['doc_list'][0] = array();

    if(!empty($post)){

    foreach ($post['doc_category_inp'] as $key => $value) {
      $data['doc_list'][$key]['doc_category_inp'] = $post['doc_category_inp'][$key];
      $data['doc_list'][$key]['doc_desc_inp'] = $post['doc_desc_inp'][$key];
      $data['doc_list'][$key]['attachment_inp'] = $post['doc_attachment_inp'][$key];
    }

  }

  $this->template($view, "Pembuatan Proyek (Non PMCS)", $data);

?>
