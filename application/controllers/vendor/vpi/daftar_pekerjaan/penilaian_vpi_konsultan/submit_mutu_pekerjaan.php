<?php 

 $post= $this->input->post();

  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("contract_id_inp", "Contract ID", 'required');
  $this->form_validation->set_rules("dept_id_inp", "Departemen ID", 'required');
  $this->form_validation->set_rules("vendor_id_inp", "Vendor ID", 'required');
  $this->form_validation->set_rules("date_inp", "Bulan", 'required');
  $this->form_validation->set_rules("note_inp", "Catatan", 'required');
  $this->form_validation->set_rules("ahm_id_inp", "pertanyaan ID", 'required');
  $this->form_validation->set_rules("answer_inp", "Nilai", 'required');    

  $data['vpm_contract_id'] = $post['contract_id_inp'];
  $data['vpm_dept_id'] = $post['dept_id_inp'];
  $data['vpm_vendor_id'] = $post['vendor_id_inp'];
  $data['vpm_date'] = $post['date_inp'];
  $data['vvh_id'] = $post['vvh_id_inp'];
  $data['vpm_note'] = $post['note_inp'];
  $data['vpm_attach'] = $post['note_attachment_inp'];
  $data['vpm_employee_id'] = $userdata["employee_id"];
  $data['vpm_pos_id'] = $userdata["pos_id"];
  $data['vpm_ahm_id'] = $post['ahm_id_inp'];
  $data['vpm_answer'] = str_replace(',', '.', str_replace('.','',$post["answer_inp"]));
  $data['created_datetime'] = date('Y-m-d h:i:s');


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('daftar_pekerjaan','penilaian_vpi',$data['vvh_id'],'konsultan','mutu_pekerjaan');

  } else {
    
$this->db->trans_begin();
    
    $this->db->where('vvh_id', $data['vvh_id']);
    $prev_data =  $this->Vendor_m->getDataPenilaianMutu()->row_array();
    if (count($prev_data) > 0) {
      $where = array('vvh_id'=>$data['vvh_id']);
      $this->Vendor_m->UpdateDataPenilaianMutu($data,$where);
    }else{
      $get_id = $this->Vendor_m->insertDataPenilaianMutu($data); //insert
    }

  
  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
  }
  else
  {

    $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
    

  }

    redirect(site_url("vendor/vpi/daftar_pekerjaan/penilaian_vpi/".$data['vvh_id']));

  }
