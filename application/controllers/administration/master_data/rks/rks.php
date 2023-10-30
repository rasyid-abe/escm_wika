<?php

  $view = 'administration/master_data/rks/rks_v';
  $this->db->select('header_main');
	$this->db->distinct();
	$this->db->where('header_main !=', NULL);
	$rks_header = $this->db->get('adm_rks');

	$this->db->select('header_sub');
	$this->db->distinct();
	$this->db->where('header_sub !=', NULL);
	$rks_header_sub = $this->db->get('adm_rks');

	$this->db->where('description !=', NULL);
	$rks_data = $this->db->get('adm_rks');

  $this->db->where('header_main !=', NULL);
	$header = $this->db->get('adm_rks');

  $data['rks_data'] = $rks_data->result_array();
	$data['rks_header'] = $rks_header->result_array();
	$data['rks_header_sub'] = $rks_header_sub->result_array();
	$data['row'] = $rks_data->row_array();
  $data['header'] = $header->num_rows();

  $this->template($view,"RKS", $data);
