<?php 

$post = $this->input->post();

if(!empty($post)){

	$employee = $this->Administration_m->getLogin();

	$id = $this->security->xss_clean($post['id']);

	$input = array(
		'status'=>$this->security->xss_clean($post['status_inp'])
	);

	$update = $this->db->where('id', $id)->update('adm_desc_matgis', $input);

	if($update){

		$this->setMessage("Berhasil mengubah deskripsi matgis");

		$position = $this->db
		->group_start()
		->where("LOWER(dept_name)","supply chain management")
		->or_where("LOWER(dept_name)","scm")
		->group_end()
		->where("job_title","MANAJER USER")
		->where("employee_id",$employee['employee_id'])
		->get("vw_adm_pos_v1")
		->row_array();

		if($position){

			$g = $this->db->where('id', $id)->get('adm_desc_matgis')->row_array();

			$get_employee_email = $this->db
			->select("adm_employee.email")
			->distinct()
			->join("user_login_rule",
				"user_login_rule.employee_id=adm_employee.id","left")
			->where("adm_employee.status",1)
			->where("user_login_rule.job_title","PIC USER")
			->where("adm_employee.email !=",null)
			->get("adm_employee")
			->result_array();

			$get_employee_name = $this->db
			->select("user_login_rule.complete_name")
			->distinct()
			->join("user_login_rule",
				"user_login_rule.employee_id=adm_employee.id","left")
			->where("adm_employee.status",1)
			->where("user_login_rule.job_title","PIC USER")
			->where("adm_employee.email !=",null)
			->get("adm_employee")
			->result_array();

			$s = "ditolak";

			if($input['status'] == 1){

				$s = "disetujui";

			}

			$a = "Pengadaan material strategis ".$g['label']." : ".$g['desc']." telah ".$s;

			$msg = "Dengan hormat,
			<br/>
			<br/>
			Bersama ini disampaikan bahwa pengadaan material strategis <strong>".$g['label']."</strong> : ".$g['desc']." telah ".$s;

			//dimatikan karena tidak diperlukan untuk proses

			// foreach ($get_employee_name as $key => $value) {

			// 	$q = [
			// 		"rfq_number"=>"",
			// 		"employee_from"=>$employee['complete_name'],
			// 		"employee_to"=>$value['complete_name'],
			// 		"status"=>0,
			// 		"pesan"=>$a,
			// 		"date"=>date("d M Y H:i:s")
			// 	];

			// 	$this->db->insert("prc_chat_rfq",$q);

			// }

			foreach ($get_employee_email as $key => $value) {

				$email = $this->sendEmail($value['email'],
					"Pemberitahuan Material Strategis ".$g['label'],$msg);

			}
			
		}

	}

}

redirect(site_url('administration/master_data/deskripsi_matgis'));