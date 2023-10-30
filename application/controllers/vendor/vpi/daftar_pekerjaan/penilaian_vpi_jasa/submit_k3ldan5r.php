<?php 

 $post= $this->input->post();

  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("nilai_akhir_5r_inp", "Nilai 5R", 'required');
  $this->form_validation->set_rules("nilai_akhir_k3l_inp", "Nilai K3L", 'required');
  $this->form_validation->set_rules("note_inp", "Catatan", 'required'); 
    
  $data['vvh_id'] = $post['vvh_id_inp'];
  $data['vvk_k3l_value'] = floor($post['nilai_akhir_k3l_inp']);
  $data['vvk_5r_value'] = floor($post['nilai_akhir_5r_inp']);
  if (strpos($post['nilai_akhir_k3l_inp'], ',') !== false) {
    $data['vvk_k3l_value'] = str_replace(',', '.', str_replace('.','',$post['nilai_akhir_k3l_inp']));
  }
  if (strpos($post['nilai_akhir_k3l_inp'], ',') !== false) {
    $data['vvk_5r_value'] = str_replace(',', '.', str_replace('.','',$post['nilai_akhir_5r_inp']));
  }
  $data['vvk_note_attach'] = $post["note_attachment_inp"];
  $data['vvk_note'] = $post["note_inp"];

  foreach ($post['ak_id_inp'] as $key2 => $value2) { 

      $this->form_validation->set_rules("ak_id_inp[$key2]", "pertanyaan K3L ke-$n", 'required');
      $this->form_validation->set_rules("answer_k3l_inp[$key2]", "Jawaban K3L ke-$n", 'required');

      $data_k3l[$key2]['vvks_value'] = str_replace(',', '.', str_replace('.','',$post['answer_k3l_inp'][$key2]));
      $data_k3l[$key2]['vvks_pertanyaan_id'] = $value2;
      $data_k3l[$key2]['vvks_type'] = 'k3l';
      $data_k3l[$key2]['vvks_id'] = $post['id_k3l_inp'][$key2];
    
      $n++;
    }

    foreach ($post['ar_id_inp'] as $key2 => $value2) { 

      $this->form_validation->set_rules("ar_id_inp[$key2]", "pertanyaan 5R ke-$n", 'required');
      $this->form_validation->set_rules("answer_5r_inp[$key2]", "Jawaban 5R ke-$n", 'required');

      $data_5r[$key2]['vvks_value'] = str_replace(',', '.', str_replace('.','',$post['answer_5r_inp'][$key2]));
      $data_5r[$key2]['vvks_pertanyaan_id'] = $value2;
      $data_5r[$key2]['vvks_type'] = '5r';
      $data_5r[$key2]['vvks_id'] = $post['id_5r_inp'][$key2];
    
      $n++;
    }
     $input = array_merge($data_k3l, $data_5r);

  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('daftar_pekerjaan','penilaian_vpi',$data['vvh_id'],'jasa','k3ldan5r');


  } else {
    
$this->db->trans_begin();
    
    $this->db->where('vvh_id', $data['vvh_id']);
    $prev_data =  $this->Vendor_m->getVPIK3l5r()->row_array();
    
    if (count($prev_data) > 0) {
      $where = array('vvh_id'=>$data['vvh_id']);
      $this->Vendor_m->UpdateVPIK3l5r($data,$where);
     
      $exists = true;
      //check if score empty
      $this->db->where('vvk_id', $data['vvh_id']);
      $scoreList = $this->db->get('vnd_vpi_k3l_5r_score')->num_rows();
      
      if($scoreList == 0)
      {
        $exists = false;
        $get_id = $data['vvh_id'];
      }

    }else{
      $data['created_datetime'] = date('Y-m-d h:i:s');
      $get_id = $this->Vendor_m->insertVPIK3l5r($data); //insert
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
            $new_array = array("vvks_value"=>$value['vvks_value'],"vvks_pertanyaan_id"=>$value['vvks_pertanyaan_id'],"vvk_id"=> $get_id,"vvks_type" => $value["vvks_type"],"created_datetime"=>date('Y-m-d h:i:s'));
            array_push($InsertdataJawaban, $new_array);
          }
           
          $insertJawaban = $this->Vendor_m->insertVPIK3l5rScore($InsertdataJawaban);
        }else{
           $UpdatedataJawaban = [];
          foreach ($input as $key => $value) {
            $new_array = array("vvks_value"=>$value['vvks_value'],"vvks_pertanyaan_id"=>$value['vvks_pertanyaan_id'],"vvk_id"=> $prev_data['vvk_id'],"vvks_id"=>$value['vvks_id'],"vvks_type" => $value["vvks_type"]);
            array_push($UpdatedataJawaban, $new_array);
          }
         
    

          $updateJawaban = $this->Vendor_m->UpdateVPIK3l5rScore($UpdatedataJawaban);

         
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
