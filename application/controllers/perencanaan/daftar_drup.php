<?php

  $view = 'perencanaan/daftar_drup_v';

  $data = array();

  $data['data_matgis'] = json_encode($this->Procurement_m->get_data_matgis());

  // $this->db->distinct();
  // $this->db->select('coa_id');
  // $this->db->select('kode_perkiraan');
  // $this->db->select('nama_perkiraan');
  // $this->db->join('adm_coa_new', 'adm_coa_new.id = prc_proses_drup.coa_id');
  // $drup_data = $this->db->get('prc_proses_drup');

  $this->db->select('DISTINCT(kddivisi) kddivisi, divisiname');
  $where = "kddivisi is  NOT NULL";
  $this->db->where($where);
  $data['divisi'] = $this->db->get('project_info')->result_array();

  $this->db->select('(SELECT SUM(prc.volume * prc.harga_satuan) FROM prc_proses_drup prc) AS total', FALSE);
  $total_data = $this->db->get('prc_proses_drup');

  // $data['drup_data'] = $drup_data->result_array();
  $data['total_data'] = $total_data->row_array();

  $this->template($view, "Pembuatan Daftar Rencana Umum Pengadaan (DRUP)", $data);
?>
