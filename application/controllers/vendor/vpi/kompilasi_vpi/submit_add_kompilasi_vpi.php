<?php 

 $post= $this->input->post();

  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("contract_id_inp", "contract ID", 'required');
  $this->form_validation->set_rules("dept_id_inp", "departemen ID", 'required');
  $this->form_validation->set_rules("vendor_id_inp", "vendor ID", 'required');
  $this->form_validation->set_rules("date_inp", "Bulan", 'required');

  $data['vkv_contract_id'] = $post['contract_id_inp'];
  $data['vkv_dept_id'] = $post['dept_id_inp'];
  $data['vkv_vendor_id'] = $post['vendor_id_inp'];
  $data['vkv_date'] = $post['date_inp'];
  $data2['vkvs_target_ketepatan_progress'] = str_replace(',', '.', str_replace('.','',$post['target_ketepatan_progress']));
  $data2['vkvs_bobot_ketepatan_progress'] = str_replace(',', '.', str_replace('.','',$post['bobot_ketepatan_progress']));
  $data2['vkvs_ketepatan_progress_value'] = $post['ketepatan_progress_inp'];
  $data2['vkvs_score_ketepatan_progress'] = str_replace(',', '.', str_replace('.','',$post['score_ketepatan_progress']));
  $data2['vkvs_target_mutu_pekerjaan'] = str_replace(',', '.', str_replace('.','',$post['target_mutu_pekerjaan']));
  $data2['vkvs_bobot_mutu_pekerjaan'] = str_replace(',', '.', str_replace('.','',$post['bobot_mutu_pekerjaan']));
  $data2['vkvs_mutu_personal_value'] = $post['mutu_personal_inp'];
  $data2['vkvs_mutu_pekerjaan_value'] = $post['mutu_pekerjaan_inp'];
  $data2['vkvs_score_mutu_pekerjaan'] = str_replace(',', '.', str_replace('.','',$post['score_mutu_pekerjaan']));
  $data2['vkvs_target_mutu_personal'] = str_replace(',', '.', str_replace('.','',$post['target_mutu_personal']));
  $data2['vkvs_bobot_mutu_personal'] = str_replace(',', '.', str_replace('.','',$post['bobot_mutu_personal']));
  $data2['vkvs_score_mutu_personal'] = str_replace(',', '.', str_replace('.','',$post['score_mutu_personal']));
  $data2['vkvs_target_pelayanan'] = str_replace(',', '.', str_replace('.','',$post['target_pelayanan']));
  $data2['vkvs_bobot_pelayanan'] = str_replace(',', '.', str_replace('.','',$post['bobot_pelayanan']));
  $data2['vkvs_pelayanan_value'] = $post['pelayanan_inp'];
  $data2['vkvs_score_pelayanan'] = str_replace(',', '.', str_replace('.','',$post['score_pelayanan']));
  $data['vkv_total_target'] = str_replace(',', '.', str_replace('.','',$post['total_target']));
  $data['vkv_total_bobot'] = str_replace(',', '.', str_replace('.','',$post['total_bobot']));
  $data['vkv_total_score'] = str_replace(',', '.', str_replace('.','',$post['total_score']));
  $data['vkv_employee_id'] = $userdata["employee_id"];
  $data['vkv_pos_id'] = $userdata["pos_id"];
  $data['created_datetime'] = date('Y-m-d h:i:s');
// echo "<pre>";
//   var_dump($data);
//   var_dump($data2);exit();


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('kompilasi_vpi/add/'.$post['contract_id_inp']);

  } else {
    
$this->db->trans_begin();
	 
   $this->db->select('MAX(vkv_id) as vkv_id');
   $max_id = (intval($this->Vendor_m->getVndKompilasiVPI()->row()->vkv_id) + 1);
   $data2["vkv_id"] = $max_id;
   $insert_header = $this->Vendor_m->InsertVndKompilasiVPI($data);
   $insert_score = $this->Vendor_m->InsertVndKompilasiVPIScore($data2);

  
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

    redirect(site_url("vendor/vpi/kompilasi_vpi"));

  }
