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
  $this->form_validation->set_rules("apm_id_inp", "pertanyaan ID", 'required');
  $this->form_validation->set_rules("answer_inp", "Nilai", 'required');    

  $where['vpm_contract_id'] = $post['contract_id_inp'];
  $where['vpm_dept_id'] = $post['dept_id_inp'];
  $data['vpm_vendor_id'] = $post['vendor_id_inp'];
  $data['vpm_no_doc'] = null; //$post['no_doc_inp'];
  $data['vpm_title'] = null; //$post['title_inp'];
  $where['vpm_date'] = $post['date_inp'];
  $data['vpm_response'] = $post['response_inp'];
  $data['vpm_note'] = $post['note_inp'];
  $data['vpm_attach'] = $post['note_attachment_inp'];
  $data['vpm_employee_id'] = $userdata["employee_id"];
  $data['vpm_pos_id'] = $userdata["pos_id"];
  $data['vpm_apm_id'] = $post['apm_id_inp'];
  $data['vpm_answer'] =  str_replace(',', '.', str_replace('.','',$post["answer_inp"]));
  $data['created_datetime'] = date('Y-m-d h:i:s');

  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('aspek_penilaian_mutu/add/'.$post['contract_id_inp']);

  } else {
    
$this->db->trans_begin();

   $result = $this->Vendor_m->UpdateDataPenilaianMutu($data,$where); //update

  
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

    redirect(site_url("vendor/vpi/aspek_penilaian_mutu"));

  }
