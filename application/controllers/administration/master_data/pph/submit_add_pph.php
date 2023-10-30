<?php 

$post = $this->input->post();

// var_dump($post);
	
	if (!empty($pph_id)) {
		$this->db->where('id !=', $pph_id);
	}
	$this->db->group_start();
	$this->db->like("LOWER(pph_name)",$post['pph_name_inp']);
	$this->db->or_like("pph_value",$post['pph_value_inp']);
	$this->db->group_end();

	$check = $this->db->get('adm_master_pph')->num_rows();

	$data = array(
		'pph_name' => $post['pph_name_inp'],
		'pph_value' => $post['pph_value_inp'],
		'status' => 1,
		'updated_datetime' => date("Y-m-d H:i:s"),
	);

	if ($check < 1) {
		$insert = $this->db->insert('adm_master_pph', $data);

		if($insert){
		$this->setMessage("Berhasil menambah data master pph");
		}

		redirect(site_url('administration/master_data/pph'));
	}else{
		$this->setMessage("Nama dan/atau nilai pph sudah ada");

		redirect(site_url('administration/master_data/pph/tambah'));

	}

	

