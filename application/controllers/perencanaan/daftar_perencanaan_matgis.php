<?php

$view = 'perencanaan/pmcs/rencana_pengadaan_matgis_v';

$data = array();
$this->db->select('DISTINCT(kddivisi) kddivisi, divisiname');
$where = "kddivisi is  NOT NULL AND kddivisi != 'C'";
$this->db->where($where);
$data['divisi'] = $this->db->get('project_info')->result_array();

// $this->db->select('DISTINCT(dep_code) kddivisi, dept_name divisiname');
// $this->db->order_by('dept_name', 'asc');
// $data['divisi'] = $this->db->get('adm_dept')->result_array();

$this->template($view, "RENCANA PENGADAAN MATGIS", $data);
?>
