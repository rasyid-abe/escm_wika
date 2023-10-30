<?php 

 $post= $this->input->post();

  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("contract_id_inp", "contract ID", 'required');
  $this->form_validation->set_rules("dept_id_inp", "departemen ID", 'required');
  $this->form_validation->set_rules("vendor_id_inp", "vendor ID", 'required');
  // $this->form_validation->set_rules("no_doc_inp", "No Document", 'required');
  $this->form_validation->set_rules("title_inp", "Judul", 'required');
  $this->form_validation->set_rules("date_inp", "Bulan", 'required');
  $this->form_validation->set_rules("response_inp", "Aksi", 'required');
  $this->form_validation->set_rules("note_inp", "Catatan", 'required');
  $this->form_validation->set_rules("nilai_akhir_inp", "Nilai Akhir", 'required');  

  $where['vpp_contract_id'] = $post['contract_id_inp'];
  $data['vpp_dept_id'] = $post['dept_id_inp'];
  $data['vpp_vendor_id'] = $post['vendor_id_inp'];
  $data['vpp_no_doc'] = null; //$post['no_doc_inp'];
  $data['vpp_title'] = null; //$post['title_inp'];
  $where['vpp_date'] = $post['date_inp'];
  $data['vpp_response'] = $post['response_inp'];
  $data['vpp_note'] = $post['note_inp'];
  $data['vpp_attach'] = $post['note_attachment_inp'];
  $data['vpp_final_score'] = $post['nilai_akhir_inp'];
  $data['vpp_employee_id'] = $userdata["employee_id"];
  $data['vpp_pos_id'] = $userdata["pos_id"];
  $data['created_datetime'] = date('Y-m-d h:i:s');


  // foreach ($post as $key => $value) {

  	foreach ($post['app_id_inp'] as $key2 => $value2) { 

  		$this->form_validation->set_rules("app_id_inp[$key2]", "ID pertanyaan ke-$n", 'required');
      $this->form_validation->set_rules("answer_inp[$key2]", "Jawaban ke-$n", 'required');

      $input[$key2]['vppa_value'] = str_replace(',', '.', str_replace('.','',$post['answer_inp'][$key2]));
      $input[$key2]['vppa_pertanyaan_id'] = $value2;
      $input[$key2]['vppa_id'] = $post['vppa_id_inp'][$key2];
  	
      $n++;
  	}

  // }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('aspek_penilaian_pelayanan/add/'.$post['contract_id_inp']);

  } else {
    
$this->db->trans_begin();
	 

   $update = $this->Vendor_m->UpdateDataPenilaianPelayanan($data,$where);

  $dataJawaban = [];
  foreach ($input as $key => $value) {
    $new_array = array("vppa_value"=>$value['vppa_value'],"vppa_pertanyaan_id"=>$value['vppa_pertanyaan_id'],"vppa_id"=>$value['vppa_id'],"created_datetime"=>date('Y-m-d h:i:s'));
    array_push($dataJawaban, $new_array);
  }

  $insertJawaban = $this->Vendor_m->UpdateJawabanPenilaianPelayanan($dataJawaban);

  
  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal memperbarui data");
    $this->db->trans_rollback();
  }
  else
  {

    $this->setMessage("Sukses memperbarui data");
    $this->db->trans_commit();
    

  }

    redirect(site_url("vendor/vpi/aspek_penilaian_pelayanan"));

  }
