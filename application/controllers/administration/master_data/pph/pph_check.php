<?php 

if (!empty($pph)) {
	$pph_id = $this->input->get('id');

	if (!empty($pph_id)) {
		$this->db->where('id !=', $pph_id);
	}

	$this->db->where('(status)::integer', 1);
	$pph = str_replace("%20", " ", $pph);
	$this->db->group_start();
	$this->db->where("LOWER(pph_name)",strtolower($pph));
	$this->db->or_where("pph_value",$pph);
	$this->db->group_end();

	$result = $this->db->get('adm_master_pph')->num_rows();
	
	echo json_encode($result);
}


