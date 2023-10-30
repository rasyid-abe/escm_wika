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

// haqim
$this->form_validation->set_rules("jenis_rencana", "Jenis Rencana Pengadaan", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("nama_proyek", "Nama Proyek", 'max_length['.DEFAULT_MAXLENGTH.']');
// end

$this->form_validation->set_rules("nama_rencana_pekerjaan_inp", "Nama Program", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("deskripsi_rencana_pekerjaan_inp", "Deskripsi Rencana Pekerjaan", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');
// haqim

if(isset($post['jenis_rencana'])){
  $input['ppm_type_of_plan'] = $post['jenis_rencana'];
}
if(isset($post['nama_proyek'])){
  $input['ppm_project_name'] = !empty($post['nama_proyek']) ? $post['nama_proyek'] : null;
}
if(isset($post['proyek_id'])){
  $input['ppm_project_id'] = !empty($post['proyek_id']) ? $post['proyek_id'] : null;
}
// end

//$this->form_validation->set_rules("mata_anggaran_code_inp", "Mata Anggaran", 'required|max_length['.DEFAULT_MAXLENGTH.']');
//$this->form_validation->set_rules("mata_uang_inp", "lang:currency", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("pagu_anggaran_inp", "Pagu Anggaran", 'required|max_length['.DEFAULT_MAXLENGTH.']');

if($post['jenis_rencana'] != "rkp_matgis"){

  $this->form_validation->set_rules("rencana_kebutuhan_month_inp", " Rencana Kebutuhan", 'required|max_length['.DEFAULT_MAXLENGTH.']');
  $this->form_validation->set_rules("rencana_pelaksanaan_kebutuhan_month_inp", " Rencana Pelaksanaan Kebutuhan", 'required|max_length['.DEFAULT_MAXLENGTH.']');

}

if(isset($post['nama_rencana_pekerjaan_inp'])){
  $input['ppm_subject_of_work']=$post['nama_rencana_pekerjaan_inp'];
}

if(isset($post['deskripsi_rencana_pekerjaan_inp'])){
  $input['ppm_scope_of_work']=$post['deskripsi_rencana_pekerjaan_inp'];
}

if(isset($post['mata_anggaran_code_inp'])){
  $input['ppm_mata_anggaran'] = (isset($post['mata_anggaran_code_inp'])) ? $post['mata_anggaran_code_inp'] : null;
}

if(isset($post['mata_anggaran_label_inp'])){
  $input['ppm_nama_mata_anggaran'] = (isset($post['mata_anggaran_label_inp'])) ? $post['mata_anggaran_label_inp'] : null;
}

if(isset($post['sub_mata_anggaran_code_inp'])){
  $input['ppm_sub_mata_anggaran'] = (isset($post['sub_mata_anggaran_code_inp'])) ? $post['sub_mata_anggaran_code_inp'] : null;
}

if(isset($post['sub_mata_anggaran_label_inp'])){
  $input['ppm_nama_sub_mata_anggaran'] = (isset($post['sub_mata_anggaran_label_inp'])) ? $post['sub_mata_anggaran_label_inp'] : null;
}

if(isset($post['mata_uang_inp'])){
  $input['ppm_currency']=$post['mata_uang_inp'];
}

if(isset($post['pagu_anggaran_inp'])){
  $input['ppm_pagu_anggaran']=$post['pagu_anggaran_inp'];
}

if(isset($post['pagu_anggaran_inp'])){
  $input['ppm_sisa_anggaran']=$post['pagu_anggaran_inp'];
}

$input['ppm_renc_kebutuhan'] = (isset($post['rencana_kebutuhan_year_inp']) && isset($post['rencana_kebutuhan_month_inp'])) ? $post['rencana_kebutuhan_year_inp'].$post['rencana_kebutuhan_month_inp'] : null;

$input['ppm_renc_pelaksanaan'] = (isset($post['rencana_pelaksanaan_kebutuhan_year_inp']) && isset($post['rencana_pelaksanaan_kebutuhan_month_inp'])) ? $post['rencana_pelaksanaan_kebutuhan_year_inp'].$post['rencana_pelaksanaan_kebutuhan_month_inp'] : null;

if(isset($post['status_inp'][0])){
  $status=$post['status_inp'][0];
  $input['ppm_status'] = $status;
}

//haqim
if(!empty($position)){
  $input['ppm_district_id']=$position['district_id'];
  $input['ppm_district_name']=$position['district_name'];
  $input['ppm_dept_id']=$position['dept_id'];
  $input['ppm_dept_name']=$position['dept_name'];
  $input['ppm_planner_pos_code']=$position['pos_id'];
  $input['ppm_planner_pos_name']=$position['pos_name'];
  }
//end

  $input_item = array();

  $input_comment = array();

  $n = 0;

  foreach ($post as $key => $value) {

    if(is_array($value)){

      foreach ($value as $key2 => $value2) { 

        if(isset($post['doc_attachment_inp'][$key2]) && !empty($post['doc_attachment_inp'][$key2])){

          $this->form_validation->set_rules("doc_category_inp[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');
          $this->form_validation->set_rules("doc_desc_inp[$key2]", "lang:description #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']');
          $this->form_validation->set_rules("doc_attachment_inp[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

          $input_comment[$key2]['ppd_id']= (isset($post['doc_id_inp'][$key2])) ? $post['doc_id_inp'][$key2] : "";
          $input_comment[$key2]['ppd_category']=$post['doc_category_inp'][$key2];;
          $input_comment[$key2]['ppd_description']=$post['doc_desc_inp'][$key2];
          $input_comment[$key2]['ppd_file_name']=$post['doc_attachment_inp'][$key2];

        }

        if(isset($post['item_jumlah'][$key2]) && !empty($post['item_jumlah'][$key2])){

          $this->form_validation->set_rules("item_kode[$key2]", "lang:code #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

          $this->form_validation->set_rules("item_jumlah[$key2]", "Jumlah #$key2", 'max_length['.DEFAULT_MAXLENGTH_TEXT.']|numeric');

          $this->form_validation->set_rules("item_satuan[$key2]", "lang:attachment #$key2", 'max_length['.DEFAULT_MAXLENGTH.']');

          $this->form_validation->set_rules("item_harga_satuan[$key2]", "Harga #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');

          $this->form_validation->set_rules("item_subtotal[$key2]", "Subtotal #$key2", 'max_length['.DEFAULT_MAXLENGTH.']|numeric');

          $input_item[$key2]['ppi_id']= (isset($post['item_id'][$key2])) ? $post['item_id'][$key2] : "";

          $input_item[$key2]['ppi_code'] = $post['item_kode'][$key2];

          $input_item[$key2]['ppi_item_desc'] = $post['item_deskripsi'][$key2];

          $input_item[$key2]['ppi_jumlah'] = $post['item_jumlah'][$key2];

          $input_item[$key2]['ppi_item_type'] = $post['item_tipe'][$key2];

          $input_item[$key2]['ppi_satuan'] = $post['item_satuan'][$key2];

          $input_item[$key2]['ppi_harga'] = $post['item_harga_satuan'][$key2];

        }

      }

      $n++;

    }

  }

  $error = false;

if(!empty($input['ppm_renc_pelaksanaan']) 
  && !empty($input['ppm_renc_kebutuhan']) 
  && $input['ppm_renc_pelaksanaan'] > $input['ppm_renc_kebutuhan']){

    $this->setMessage("Waktu rencana pelaksanaan tidak boleh lebih dari rencana kebutuhan");

    if(!$error){

      $error = true;

    }

  }

  if($input['ppm_pagu_anggaran'] < 1){

    $this->setMessage("Pagu anggaran tidak boleh nol");

    if(!$error){

      $error = true;

    }

  }


  if ($this->form_validation->run() == FALSE  || $error){

    $this->renderMessage("error");

  } else {

    $next_jobtitle = $this->Procedure_m->getNextJobTitlePlan($userdata['pos_id'],'',$post['jenis_rencana']);

    $next_pos_id = $status == '1' ? ($next_jobtitle != null ? $next_jobtitle : 212) : $userdata['pos_id'];

    if(empty($next_pos_id)){

      $this->setMessage("Hirarki atasan ".$userdata['pos_name']." tidak ditemukan");

      $this->renderMessage("error");

    } else {

     $this->db->trans_begin();

     $input['ppm_next_pos_id'] = $next_pos_id;

     $act = $this->Procplan_m->updateDataPerencanaanPengadaan($post['id'],$input);

     if($act){

      $last_id = $post['id'];

      $com=$post['comment_inp'][0];
  //hlmifzi
      $dateopen = $this->input->post('dateopen');

    //$status = $post['status_inp'][0];

    // $activity = $activity_list[$status];
      if($post['jenis_rencana'] == "rkp_matgis"){
        $activity = "Pembuatan Draft RKP Material Strategis";
      } else {
        $activity = "Pembuatan Draft ".strtoupper($post['jenis_rencana']);
      }

      $wkf = $this->data['workflow_list'];

      $response = $wkf[$status];

//hlmifzi
      $this->Comment_m->insertProcurementPlan($last_id,$com,$response,$activity,$dateopen,$next_pos_id);

      $this->Procplan_m->deleteDokumenPerencanaan($last_id);
      $this->Procplan_m->deleteItem($last_id);

      foreach ($input_comment as $key => $value) {
        $value['ppm_id'] = $last_id;
        unset($value['ppd_id']);
        $act = $this->Procplan_m->insertDokumenPerencanaan($value);
      } 

      foreach ($input_item as $key => $value) {
        $value['ppm_id'] = $last_id;
        unset($value['ppi_id']);
        $act = $this->Procplan_m->insertItem($value);
      } 

    //haqim mail drp send
      if ($status == '1') {
        $this->Procedure_m->prc_plan_comment_complete($last_id,$input['ppm_dept_name'],$input['ppm_planner_pos_name'],$input['ppm_planner_pos_code'],"PEMBUATAN PERENCANAAN PENGADAAN ".strtoupper($post['nama_rencana_pekerjaan_inp']),$next_pos_id); 
      }
    //end

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

    $this->renderMessage("success",site_url("procurement/daftar_pekerjaan"));

  }

}