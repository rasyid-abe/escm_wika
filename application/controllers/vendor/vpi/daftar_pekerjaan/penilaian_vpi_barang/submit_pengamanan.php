<?php 

 $post= $this->input->post();

  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

  // $this->form_validation->set_rules("nilai_akhir_inp", "Nilai Pengamanan", 'required');
  $this->form_validation->set_rules("note_inp", "Catatan", 'required');
  $string = explode('_',$post['radio_nilai']);

  $data['vvh_id'] = $post['vvh_id_inp'];
  $data['vvp_value'] = $string[0];
  // if (strpos($post['nilai_akhir_inp'], ',') !== false) {
  //   $data['vvp_value'] = str_replace(',', '.', str_replace('.','',$post['nilai_akhir_inp']));
  // }
  $data['vvp_note_attach'] = $post["note_attachment_inp"];
  $data['vvp_note'] = $post["note_inp"];

  $input[0]['vvps_value'] =$string[0];
  $input[0]['vvps_pertanyaan_id'] = $value2;
  $input[0]['vvps_id'] = $string[1];

  // foreach ($post['ap_id_inp'] as $key2 => $value2) { 

  //     $this->form_validation->set_rules("ap_id_inp[$key2]", "pertanyaan Pengamanan ke-$n", 'required');
  //     $this->form_validation->set_rules("answer_inp[$key2]", "Jawaban Pengamanan ke-$n", 'required');

  //     $input[$key2]['vvps_value'] = str_replace(',', '.', str_replace('.','',$post['answer_inp'][$key2]));
  //     $input[$key2]['vvps_pertanyaan_id'] = $value2;
  //     $input[$key2]['vvps_id'] = $post['id_inp'][$key2] == "" ? null : $post['id_inp'][$key2];
    
  //     $n++;
  // }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');
    
    $this->vpi('daftar_pekerjaan','penilaian_vpi',$data['vvh_id'],'barang','pengamanan');


  } else {
    
$this->db->trans_begin();
    
    $this->db->where('vvh_id', $data['vvh_id']);
    $prev_data =  $this->Vendor_m->getVPIPengamanan()->row_array();

    if (count($prev_data) > 0) {
      $where = array('vvh_id'=>$data['vvh_id']);
      $this->Vendor_m->UpdateVPIPengamanan($data,$where);
      $exists = true;
    }else{
      $data['created_datetime'] = date('Y-m-d h:i:s');
      $get_id = $this->Vendor_m->insertVPIPengamanan($data); //insert
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
            $new_array = array("vvps_value"=>$value['vvps_value'],"vvps_pertanyaan_id"=>$value['vvps_pertanyaan_id'],"vvp_id"=> $get_id,"created_datetime"=>date('Y-m-d h:i:s'));
            array_push($InsertdataJawaban, $new_array);
          }
          $insertJawaban = $this->Vendor_m->insertVPIPengamananScore($InsertdataJawaban);
        }else{
           $UpdatedataJawaban = [];
          foreach ($input as $key => $value) {
            $new_array = array("vvps_value"=>$value['vvps_value'],"vvps_pertanyaan_id"=>$value['vvps_pertanyaan_id'],"vvp_id"=> $prev_data['vvp_id'],"vvps_id"=>$value['vvps_id']);
            array_push($UpdatedataJawaban, $new_array);
          }
          $updateJawaban = $this->Vendor_m->UpdateVPIPengamananScore($UpdatedataJawaban);
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
