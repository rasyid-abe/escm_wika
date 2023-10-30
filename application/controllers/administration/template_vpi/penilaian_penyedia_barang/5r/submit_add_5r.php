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

    $this->db->select('max(ar_seq) as ar_seq');
    $this->db->where('ar_status', 'A');
    // $this->db->group_by('apm_seq');
    $last_seq = intval($this->Administration_m->get5r("","barang")->row()->ar_seq) + 1;

  foreach ($post as $key => $value) {

  	foreach ($value as $key2 => $value2) { 
  		$this->form_validation->set_rules("pertanyaan_inp[$key2]", "Pertanyaan ke-#$n", 'required');

  		$input[$key2]['ar_value'] = $post['pertanyaan_inp'][$key2];
  		$input[$key2]['ar_seq'] = $last_seq;
      	$last_seq = $last_seq+1 /count($post);
      $input[$key2]['ar_type'] = 'barang';
  	}

    $n++;

  }


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->template_vpi('penilaian_penyedia_barang/5r');

  } else {
    
$this->db->trans_begin();
	
 $data = [];
    foreach ($input as $key => $value) {
    	$new_array = array("ar_value"=>$value['ar_value'],"ar_status"=>"A","ar_seq"=>$value['ar_seq'],"ar_type"=>$value['ar_type'],"created_datetime"=>date('Y-m-d h:i:s'));
    	array_push($data, $new_array);
    }

    $this->Administration_m->add5r($data); 


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
