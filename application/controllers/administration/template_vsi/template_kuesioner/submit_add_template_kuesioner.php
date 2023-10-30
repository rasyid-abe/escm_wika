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

    $this->db->select('max(atk_seq) as atk_seq');
    $this->db->where('atk_status', 'Aktif');
    // $this->db->group_by('atk_seq');
    $last_seq = intval($this->Administration_m->getTemplateKuesioner()->row()->atk_seq);

    
  foreach ($post as $key => $value) {

  	foreach ($value as $key2 => $value2) { 
  		$this->form_validation->set_rules("name_inp[$key2]", "Template Nilai Ke-#$n", 'required');

  		$input[$key2]['atk_name'] = $post['name_inp'][$key2];
      $input[$key2]['atk_seq'] = $last_seq;
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
    	$new_array = array("atk_name"=>$value['atk_name'],"atk_seq"=>$value['atk_seq'],"atk_status"=>"Non Aktif","created_datetime"=>date('Y-m-d h:i:s'));
    	array_push($data, $new_array);
    }

    $this->Administration_m->addTemplateKuesioner($data); 


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
