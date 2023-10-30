<?php 

 $post= $this->input->post();

  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("contract_id_inp", "Contract ID", 'required');
  $this->form_validation->set_rules("dept_id_inp", "Departemen ID", 'required');
  $this->form_validation->set_rules("vendor_id_inp", "Vendor ID", 'required');
  // $this->form_validation->set_rules("no_doc_inp", "No Document", 'required');
  // $this->form_validation->set_rules("title_inp", "Judul", 'required');
  $this->form_validation->set_rules("date_inp", "Bulan", 'required');
  $this->form_validation->set_rules("response_inp", "Aksi", 'required');
  $this->form_validation->set_rules("note_inp", "Catatan", 'required');
  $this->form_validation->set_rules("nilai_akhir_inp", "Nilai Akhir", 'required');
  $this->form_validation->set_rules("nilai_attachment_inp", "Lampiran Time Schedule", 'required'); 

  $where['vpkp_contract_id'] = $post['contract_id_inp'];
  $data['vpkp_dept_id'] = $post['dept_id_inp'];
  $where['vpkp_vendor_id'] = $post['vendor_id_inp'];
  $data['vpkp_no_doc'] = null; //$post['no_doc_inp'];
  $data['vpkp_title'] = null; //$post['title_inp'];
  $where['vpkp_date'] = $post['date_inp'];
  $data['vpkp_response'] = $post['response_inp'];
  $data['vpkp_note'] = $post['note_inp'];
  $data['vpkp_attach'] = $post['note_attachment_inp'];
  $data['vpkp_employee_id'] = $userdata["employee_id"];
  $data['vpkp_pos_id'] = $userdata["pos_id"];
  $data['vpkp_value_attach'] = $post['nilai_attachment_inp'];
  $data['vpkp_value'] = str_replace(',', '.', str_replace('.','',$post["nilai_akhir_inp"]));
  $data['created_datetime'] = date('Y-m-d h:i:s');



  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('aspek_penilaian_ketepatan_progress/add/'.$post['contract_id_inp']);

  } else {
    
$this->db->trans_begin();

   $get_id = $this->Vendor_m->updateDataPenilaianKetepatanProgress($data,$where); 

  
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

    redirect(site_url("vendor/vpi/aspek_penilaian_ketepatan_progress"));

  }
