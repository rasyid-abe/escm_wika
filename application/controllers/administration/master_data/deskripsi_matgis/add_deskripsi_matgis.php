<?php

$employee = $this->Administration_m->getLogin();

$position = $this->db->group_start()
->where("LOWER(dept_name)","divisi supply chain management")
->or_where("LOWER(dept_name)","scm")
->group_end()
->where("job_title","PIC USER")
->where("employee_id",$employee['employee_id'])
->get("vw_adm_pos_v1")->row_array();

if(!$position){
	$this->noAccess("Hanya PIC USER SCM yang dapat membuat deskripsi matgis");
}

$data = array(
	'controller_name'=>"administration",
);

$this->template('administration/master_data/deskripsi_matgis/add_deskripsi_matgis_v',"Tambah Deskripsi Matgis",$data);
