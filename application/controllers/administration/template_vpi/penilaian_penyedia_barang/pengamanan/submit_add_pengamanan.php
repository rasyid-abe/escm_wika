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

    $this->db->select('max(ap_seq) as ap_seq');
    $this->db->where('ap_status', 'A');

    $last_seq = intval($this->Administration_m->getPengamanan("",'barang')->row()->ap_seq) + 1;

  foreach ($post as $key => $value) {

  	foreach ($value as $key2 => $value2) { 
  		$this->form_validation->set_rules("pertanyaan_inp[$key2]", "Pertanyaan ke-#$n", 'required');

  		$input[$key2]['ap_value'] = $post['pertanyaan_inp'][$key2];
  		$input[$key2]['ap_seq'] = $last_seq;
      $input[$key2]['ap_type'] = 'barang';
      	$last_seq = $last_seq+1 /count($post);
  	}

    $n++;

  }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->template_vpi('penilaian_penyedia_barang/pengamanan');

  } else {
    
$this->db->trans_begin();
	
 $data = [];
    foreach ($input as $key => $value) {
    	$new_array = array("ap_value"=>$value['ap_value'],"ap_status"=>"A","ap_seq"=>$value['ap_seq'],"ap_type"=>$value['ap_type'],"created_datetime"=>date('Y-m-d h:i:s'));
    	array_push($data, $new_array);
    }

    $this->Administration_m->addPengamanan($data); 


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

}
