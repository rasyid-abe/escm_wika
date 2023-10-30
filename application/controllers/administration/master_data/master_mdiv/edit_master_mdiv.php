<?php 

$id = $this->uri->segment(5, 0);

$data = $this->Administration_m->getMasterMdiv(array("amm_id"=>$id))->row_array();

$this->db->order_by("dept_name", "asc");
$dept = $this->Administration_m->get_divisi_departemen()->result_array();

$this->db->order_by("pos_name", "asc");
$posisi = $this->Administration_m->getPos()->result_array();

$this->db->order_by("region_name", "asc");
$reg = $this->Administration_m->getRegion()->result_array();

$data = [
    'controller_name' => "administration/master_data/master_mdiv",
    'dept' => $dept,
    'posisi' => $posisi,
    'region' => $reg,
    'id' => $id,
    'data' => $data
];

$this->template('administration/master_data/master_mdiv/edit_master_mdiv_v',"Ubah MDIV",$data);