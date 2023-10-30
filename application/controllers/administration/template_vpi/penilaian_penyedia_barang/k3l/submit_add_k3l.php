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

    $this->db->select('max(ak_seq) as ak_seq');
    $this->db->where('ak_status', 'A');
    // $this->db->group_by('apm_seq');
    $last_seq = intval($this->Administration_m->getK3l("","barang")->row()->ak_seq) + 1;

  foreach ($post as $key => $value) {

  	foreach ($value as $key2 => $value2) { 
  		$this->form_validation->set_rules("pertanyaan_inp[$key2]", "Pertanyaan ke-#$n", 'required');

  		$input[$key2]['ak_value'] = $post['pertanyaan_inp'][$key2];
  		$input[$key2]['ak_seq'] = $last_seq;
      $input[$key2]['ak_type'] = 'barang';
      	$last_seq = $last_seq+1 /count($post);
  	}

    $n++;

  }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->template_vpi('penilaian_penyedia_barang/k3l');

  } else {
    
$this->db->trans_begin();
	
 $data = [];
    foreach ($input as $key => $value) {
    	$new_array = array("ak_value"=>$value['ak_value'],"ak_status"=>"A","ak_seq"=>$value['ak_seq'],"ak_type"=>$value['ak_type'],"created_datetime"=>date('Y-m-d h:i:s'));
    	array_push($data, $new_array);
    }

    $this->Administration_m->addK3l($data); 


  if ($this->db->trans_status() === FALSE)
  {
    $this->db->trans_rollback();
    echo "Gagal memproses data";
  }
  else
  {
    $this->db->trans_commit();
    echo "Sukses memproses data";

  }

    // redirect(site_url("administration/template_vpi/aspek_penilaian_pelayanan"));

  }
