<?php
  $view = 'procurement/perencanaan_pengadaan/drup_v';

	$data['data_matgis'] = json_encode($this->Procurement_m->get_data_matgis());
  $data = array("edit"=>false,"view"=>true);

  $this->db->distinct();
		$this->db->select('coa_id');
		$this->db->select('kode_perkiraan');
		$this->db->select('nama_perkiraan');
		$this->db->join('adm_coa_new', 'adm_coa_new.id = prc_proses_drup.coa_id');
		$drup_data = $this->db->get('prc_proses_drup');

		$this->db->select('(SELECT SUM(prc.volume * prc.harga_satuan) FROM prc_proses_drup prc) AS total', FALSE);
		$total_data = $this->db->get('prc_proses_drup');

		$coa_data = $this->db->get('adm_coa_new');

		$data = array();
		$data['drup_data'] = $drup_data->result_array();
		$data['coa_data'] = $coa_data->result_array();
		$data['total_data'] = $total_data->row_array();
  $this->template($view,"Daftar Rencana Umum Pengadaan (DRUP)",$data);
?>
