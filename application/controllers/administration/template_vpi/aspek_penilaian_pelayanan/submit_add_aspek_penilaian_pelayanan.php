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

    $this->db->select('max(app_seq) as app_seq');
    $this->db->where('app_status', 'A');
    // $this->db->group_by('apm_seq');
    $last_seq = intval($this->Administration_m->getAspekPenilaianPelayanan()->row()->app_seq) + 1;

  foreach ($post as $key => $value) {

  	foreach ($value as $key2 => $value2) { 
  		$this->form_validation->set_rules("pertanyaan_inp[$key2]", "Pertanyaan ke-#$n", 'required');

  		$input[$key2]['app_value'] = $post['pertanyaan_inp'][$key2];
  		$input[$key2]['app_seq'] = $last_seq;
      	$last_seq = $last_seq+1 /count($post);
  	}

    $n++;

  }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->template_vpi('aspek_penilaian_pelayanan');

  } else {
    
$this->db->trans_begin();
	
 $data = [];
    foreach ($input as $key => $value) {
    	$new_array = array("app_value"=>$value['app_value'],"app_status"=>"A","app_seq"=>$value['app_seq'],"created_datetime"=>date('Y-m-d h:i:s'));
    	array_push($data, $new_array);
    }

    $this->Administration_m->addAspekPenilaianPelayanan($data); 


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
