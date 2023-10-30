<?php
	
	$data['pr_number'] = $this->input->post('pr_number');
	$data['employee_from'] = $this->data['userdata']['complete_name'];
	$employee_to = $this->input->post('employee_to');

	if (is_array($employee_to)) {
		$employee_tos = implode(' , ', $employee_to);
	}else{
		$employee_tos = $employee_to;
	}

	$data['employee_to'] = $employee_tos;

	$employee_cc = $this->input->post('employee_cc');
	if (is_array($employee_cc)) {
		$employee_ccs = implode(' , ', $employee_cc);
	}
	$data['employee_cc'] = $employee_ccs;
	$data['pesan'] = $this->input->post('pesan');
	$data['date'] = date("d F Y H:i:s");
	$data['status'] = 0;

	if (!empty($_FILES['attach']['name'])) {
		 $upload           = $this->Procpr_m->do_upload('attach');
	     $data['attach']  = $upload;

	}

	$submit = $this->Procpr_m->submit_chat_pr($data);
	if ($submit >= 1) {
		$title = "Pesan $data[pr_number]";
		$msg = "Ada pesan untuk Anda di message $data[pr_number]. <br> 
				Silahkan buka <a href='".site_url('procurement/procurement_tools/monitor_pengadaan')."'>Monitor pengadaan</a> dibagian daftar pengadaan atau <a href='".site_url('procurement/daftar_pekerjaan')."'>Daftar pengadaan</a> dibagian Daftar Pekerjaan RFQ-Undangan";
				
		if (is_array($employee_to)) {
			foreach ($employee_to as $key => $value) {
				$email_employee_to = $this->db->select('email')->where('complete_name',trim($value,' '))->get('vw_user_access')->row_array();
				$this->sendEmail($email_employee_to['email'],$title,$msg);

			}
			
		}elseif(!empty($employee_to)){

			$email_employee_to = $this->db->select('email')->where('complete_name',trim($employee_to,' '))->get('vw_user_access')->row_array();
			$this->sendEmail($email_employee_to['email'],$title,$msg);

		}

		if (is_array($employee_cc) and !empty($employee_cc)) {
			foreach ($employee_cc as $key => $value) {
				$email_employee_cc = $this->db->select('email')->where('complete_name',trim($value,' '))->get('vw_user_access')->row_array();
				$this->sendEmail($email_employee_cc['email'],$title,$msg);
			}
			
		}elseif(!empty($employee_cc)){

			$email_employee_cc = $this->db->select('email')->where('complete_name',trim($employee_cc,' '))->get('vw_user_access')->row_array();
			$this->sendEmail($email_employee_cc['email'],$title,$msg);

		}
		
		// foreach ($employee_cc as $key => $value) {
		// 	$this->sendEmail($value,$title,$msg);
		// }
		ob_clean();
		echo "success";
	}else{
		ob_clean();
		echo "error";
	}

?>