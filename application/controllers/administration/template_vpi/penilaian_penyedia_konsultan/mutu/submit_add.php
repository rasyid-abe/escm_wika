<?php 

$position = $this->Administration_m->getPosition("ADMIN");

if (!$position) {
  echo "hanya ADMIN yang bisa menambah data";
  exit();
}

 $post= $this->input->post();

  $input=array();

  $n = 1;

  $userdata = $this->data['userdata'];

    $this->db->select('max(ahm_seq) as ahm_seq');
    $this->db->where('ahm_status', 'A');

    $last_seq = intval($this->Administration_m->getHasilMutuPekerjaan("","konsultan")->row()->ahm_seq);

    
  foreach ($post as $key => $value) {

    foreach ($value as $key2 => $value2) { 
      $this->form_validation->set_rules("category_inp[$key2]", "Kategori Nilai Ke-#$n", 'required');
      $this->form_validation->set_rules("note_inp[$key2]", "Penjelasan Ke-#$n", 'required');

      $input[$key2]['ahm_category'] = $post['category_inp'][$key2];
      $input[$key2]['ahm_note'] = $post['note_inp'][$key2];
      $input[$key2]['ahm_seq'] = $last_seq == 0 ? 1 : $last_seq;
      $last_seq = $last_seq+1 /count($post);
      $input[$key2]['ahm_type'] = 'konsultan';

    }

    $n++;

  }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->template_vpi('penilaian_penyedia_konsultan/hasil_mutu_pekerjaan');

  } else {
    
$this->db->trans_begin();
  
 $data = [];

    foreach ($input as $key => $value) {
      $new_array = array("ahm_category"=>$value['ahm_category'],"ahm_note"=>$value['ahm_note'],"ahm_seq"=>$value['ahm_seq'],"ahm_type"=>$value['ahm_type'],"ahm_status"=>"A","created_datetime"=>date('Y-m-d h:i:s'));
      array_push($data, $new_array);
    }

    $this->Administration_m->addHasilMutuPekerjaan($data); 


  if ($this->db->trans_status() === FALSE)
  {
    // $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
    echo "Gagal memproses data";
  }
  else
  {

    // $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
    echo "Sukses memproses data";

  }

    // redirect(site_url("administration/template_vpi/aspek_penilaian_pelayanan"));

  }



