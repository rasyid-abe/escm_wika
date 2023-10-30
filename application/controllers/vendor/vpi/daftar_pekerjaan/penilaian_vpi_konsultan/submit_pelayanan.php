<?php 

 $post= $this->input->post();
//  echo "<pre>";
// var_dump($post);exit();
  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("nilai_akhir_inp", "Nilai Pelayanan", 'required');
  $this->form_validation->set_rules("note_inp", "Catatan", 'required'); 
    
  $data['vvh_id'] = $post['vvh_id_inp'];
  $data['vpp_value'] = $post['nilai_akhir_inp'];
  if (strpos($post['nilai_akhir_inp'], ',') !== false) {
    $data['vpp_value'] = str_replace(',', '.', str_replace('.','',$post['nilai_akhir_inp']));
  }
  $data['vpp_note_attach'] = $post["note_attachment_inp"];
  $data['vpp_note'] = $post["note_inp"];

  foreach ($post['app_id_inp'] as $key2 => $value2) { 

      $this->form_validation->set_rules("app_id_inp[$key2]", "pertanyaan Pelayanan ke-$n", 'required');
      $this->form_validation->set_rules("answer_inp[$key2]", "Jawaban Pelayanan ke-$n", 'required');

      $input[$key2]['vppa_value'] = str_replace(',', '.', str_replace('.','',$post['answer_inp'][$key2]));
      $input[$key2]['vppa_pertanyaan_id'] = $value2;
      $input[$key2]['vppa_id'] = $post['id_inp'][$key2] == "" ? null : $post['id_inp'][$key2];
    
      $n++;
    }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('daftar_pekerjaan','penilaian_vpi',$data['vvh_id'],'konsultan','pelayanan');


  } else {
    
$this->db->trans_begin();
    
    $this->db->where('vvh_id', $data['vvh_id']);
    $prev_data =  $this->Vendor_m->getVPIPelayanan()->row_array();

    if (count($prev_data) > 0) {
      $where = array('vvh_id'=>$data['vvh_id']);
      $this->Vendor_m->UpdateVPIPelayanan($data,$where);
      $exists = true;
    }else{
      $data['created_datetime'] = date('Y-m-d h:i:s');
      $get_id = $this->Vendor_m->insertVPIPelayanan($data); //insert
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
        
        if ($exists == false) {
          $InsertdataJawaban = [];
          foreach ($input as $key => $value) {
            $new_array = array("vppa_value"=>$value['vppa_value'],"vppa_pertanyaan_id"=>$value['vppa_pertanyaan_id'],"vpp_id"=> $get_id,"created_datetime"=>date('Y-m-d h:i:s'));
            array_push($InsertdataJawaban, $new_array);
          }
          $insertJawaban = $this->Vendor_m->insertVPIPelayananScore($InsertdataJawaban);
        }else{
           $UpdatedataJawaban = [];
          foreach ($input as $key => $value) {
            $new_array = array("vppa_value"=>$value['vppa_value'],"vppa_pertanyaan_id"=>$value['vppa_pertanyaan_id'],"vpp_id"=> $prev_data['vpp_id'],"vppa_id"=>$value['vppa_id']);
            array_push($UpdatedataJawaban, $new_array);
          }
          $updateJawaban = $this->Vendor_m->UpdateVPIPelayananScore($UpdatedataJawaban);
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

    redirect(site_url("vendor/vpi/daftar_pekerjaan/penilaian_vpi/".$data['vvh_id']));

  }
