<?php 

 $post= $this->input->post();
// echo "<pre>";
//  var_dump($post);exit();
  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("vvh_id_inp", "ID Penilaian Header", 'required');

  $data['vvh_id'] = $post['vvh_id_inp'];
  $data['vk_target_total'] = $post['target_total'];
  $data['vk_bobot_total'] = $post['bobot_total'];
  $data['vk_score_total'] = $post['score_total'];
  if (strpos($data['vk_target_total'], ',')) {
   $data['vk_target_total'] = str_replace(',', '.', str_replace('.','',$data['vk_target_total']));
  }
  if (strpos($data['vk_bobot_total'], ',')) {
   $data['vk_bobot_total'] = str_replace(',', '.', str_replace('.','',$data['vk_bobot_total']));
  }
  if (strpos($data['vk_score_total'], ',')) {
   $data['vk_score_total'] = str_replace(',', '.', str_replace('.','',$data['vk_score_total']));
  }
  $data['vk_response'] = $post['response_inp'];
  $data['vk_note_attach'] = $post['note_attachment_inp'];
  $data['vk_note'] = $post['note_inp'];
  $data['vk_employee_id'] = $userdata["employee_id"];
  $data['vk_pos_id'] = $userdata["pos_id"];


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('daftar_pekerjaan/penilaian_vpi/'+$data['vvh_id']);

  } else {
    
$this->db->trans_begin();
	 
   $this->db->where('vvh_id', $data['vvh_id']);
   $prev_data =  $this->Vendor_m->getVPIKompilasi()->row_array();

    if (count($prev_data) > 0) {
      $where = array('vvh_id'=>$data['vvh_id']);
      $this->Vendor_m->UpdateVPIKompilasi($data,$where);
      $exists = true;
    }else{
      $data['created_datetime'] = date('Y-m-d h:i:s');
      $get_id = $this->Vendor_m->insertVPIKompilasi($data); //insert
      $exists = false;
    }
  
  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
  }
  else
  {

    // $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
     $this->db->trans_begin();

    $kompilasi_score = [];

    if (!$exists) {

      $ketepatan_progress = array("vk_id"=>$get_id,"vks_parameter"=>"ketepatan_progress","vks_score"=> $post['score_ketepatan_progress'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $ketepatan_progress);

      $hasil_mutu_pekerjaan = array("vk_id"=>$get_id,"vks_parameter"=>"mutu_pekerjaan","vks_score"=> $post['score_mutu_pekerjaan'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $hasil_mutu_pekerjaan);

      $hasil_mutu_personal = array("vk_id"=>$get_id,"vks_parameter"=>"mutu_personal","vks_score"=> $post['score_mutu_personal'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $hasil_mutu_personal);
      
      $score_pelayanan = array("vk_id"=>$get_id,"vks_parameter"=>"pelayanan","vks_score"=> $post['score_pelayanan'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $score_pelayanan);

      $this->Vendor_m->insertVPIKompilasiScore($kompilasi_score);

    }else{
      
      $ketepatan_progress = array("vks_id"=>$post['ketepatan_progress_id'],"vk_id"=>$prev_data['vk_id'],"vks_parameter"=>"ketepatan_progress","vks_score"=> $post['score_ketepatan_progress'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $ketepatan_progress);

      $hasil_mutu_pekerjaan = array("vks_id"=>$post['mutu_pekerjaan_id'],"vk_id"=>$prev_data['vk_id'],"vks_parameter"=>"mutu_pekerjaan","vks_score"=> $post['score_mutu_pekerjaan'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $hasil_mutu_pekerjaan);

      $hasil_mutu_personal = array("vks_id"=>$post['mutu_personal_id'],"vk_id"=>$prev_data['vk_id'],"vks_parameter"=>"mutu_personal","vks_score"=> $post['score_mutu_personal'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $hasil_mutu_personal);
      
      $score_pelayanan = array("vks_id"=>$post['pelayanan_id'],"vk_id"=>$prev_data['vk_id'],"vks_parameter"=>"pelayanan","vks_score"=> $post['score_pelayanan'],"created_datetime"=>date('Y-m-d h:i:s'));
      array_push($kompilasi_score, $score_pelayanan);

      $this->Vendor_m->updateVPIKompilasiScore($kompilasi_score);

    }
  if ($this->db->trans_status() === FALSE)
            {
              $this->setMessage("Gagal memproses data");
              $this->db->trans_rollback();
            }
            else{
              $this->setMessage("Sukses memproses data");
              $this->db->trans_commit();
            }
    }

    redirect(site_url("vendor/vpi/daftar_pekerjaan"));

  }
