<?php 

$data = array(
	'controller_name'=>"administration",
);

$data['data'] = $this->db->where('id', $id)->get('adm_desc_matgis')->row_array();
$data['id'] = $id;

$employee = $this->Administration_m->getLogin();

if($data['data']['status'] == 2){

	$position = $this->db->group_start()
	->where("LOWER(dept_name)","divisi supply chain management")
	->or_where("LOWER(dept_name)","supply chain management")
	->group_end()
	->where("job_title","MANAJER USER")
	->where("employee_id",$employee['employee_id'])
	->get("vw_adm_pos_v1")
	->row_array();

	if(!$position){

		$this->noAccess("Hanya MANAJER USER SCM yang dapat approval deskripsi matgis");
		
	}

} else if($data['data']['status'] == 3){

	$this->noAccess("Deskripsi matgis tidak dapat diubah karena ditolak");

} else {

	$position = $this->db->group_start()
	->where("LOWER(dept_name)","divisi supply chain management")
	->or_where("LOWER(dept_name)","supply chain management")
	->group_end()
	->where("job_title","PIC USER")
	->where("employee_id",$employee['employee_id'])
	->get("vw_adm_pos_v1")
	->row_array();

	if(!$position){

		$this->noAccess("Hanya PIC USER SCM yang dapat mengubah deskripsi matgis");

	}

}


$this->template('administration/master_data/deskripsi_matgis/edit_deskripsi_matgis_v',"Ubah Deskripsi Matgis",$data);