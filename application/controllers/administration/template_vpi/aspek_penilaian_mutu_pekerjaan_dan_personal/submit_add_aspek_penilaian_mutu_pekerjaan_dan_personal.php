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

    $this->db->select('max(apm_seq) as apm_seq');
    $this->db->where('apm_status', 'A');
    // $this->db->group_by('apm_seq');
    $last_seq = intval($this->Administration_m->getAspekPenilaianMutu()->row()->apm_seq);

    
  foreach ($post as $key => $value) {

  	foreach ($value as $key2 => $value2) { 
  		$this->form_validation->set_rules("category_inp[$key2]", "Kategori Nilai Ke-#$n", 'required');
      $this->form_validation->set_rules("note_inp[$key2]", "Penjelasan Ke-#$n", 'required');

  		$input[$key2]['apm_category'] = $post['category_inp'][$key2];
      $input[$key2]['apm_note'] = $post['note_inp'][$key2];
      $input[$key2]['apm_seq'] = $last_seq;
      $last_seq = $last_seq+1 /count($post);

  	}

    $n++;

  }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->template_vpi('aspek_penilaian_mutu_pekerjaan_dan_personal');

  } else {
    
$this->db->trans_begin();
	
 $data = [];

    foreach ($input as $key => $value) {
    	$new_array = array("apm_category"=>$value['apm_category'],"apm_note"=>$value['apm_note'],"apm_seq"=>$value['apm_seq'],"apm_status"=>"A","created_datetime"=>date('Y-m-d h:i:s'));
    	array_push($data, $new_array);
    }

    $this->Administration_m->addAspekPenilaianMutu($data); 


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
