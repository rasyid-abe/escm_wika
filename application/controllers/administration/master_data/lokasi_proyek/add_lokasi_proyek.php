<?php

$this->db->order_by("dept_name", "asc");
$dept = $this->Administration_m->get_divisi_departemen()->result_array();

$this->db->order_by("pos_name", "asc");
$posisi = $this->Administration_m->getPos()->result_array();

$this->db->order_by("region_name", "asc");
$reg = $this->Administration_m->getRegion()->result_array();

$data = [
	'controller_name' => "administration/master_data/lokasi_proyek",
	'dept' => $dept,
	'posisi' => $posisi,
	'region' => $reg
];

$data['tipe_list'] = array("MDIV");
$this->template('administration/master_data/lokasi_proyek/add_lokasi_proyek_v',"Tambah Lokasi Proyek",$data);
  