<?php 

//cek project id/kode spk yg ada
$this->db->select('ppm_project_id');
$check_spk = $this->db->get('prc_plan_main')->result_array();

$ppm_project_id = array();
foreach ($check_spk as $key => $value) {
	foreach ($value as $key => $value) {
		if (!empty($value)) {
			$ppm_project_id[] = $value;
		}
	}
}

if (count($ppm_project_id) == 0) {
	$ppm_project_id[] = "";
}
//mengambil data integrasi dari table prc_plan_integrasi
$this->db->select('spk_code,project_name,dept_code,dept_name,periode_locking');
$this->db->group_by('spk_code,project_name,dept_code,dept_name,periode_locking');
$this->db->where_not_in('spk_code', $ppm_project_id);
$get_data = $this->db->get('prc_plan_integrasi')->result_array();


if (count($get_data) > 0) {
	$n = 1;
	foreach ($get_data as $key => $value) {
	$this->db->trans_begin();
	//get district and dept data
	$this->db->select('district_id,district_name,dept_id');
	$this->db->where('dep_code', $value['dept_code']);
	$district = $this->db->get('adm_dept')->row_array();

	//get planner data
	$this->db->select('complete_name,pos_name,pos_id,employee_id');
	$this->db->where(array('dept_id'=>$district['dept_id']));
	$this->db->group_start();
	$this->db->like('job_title', "PIC USER");
	$this->db->or_like('pos_name', "STAFF");
	$this->db->group_end();
	$planner_data = $this->db->get('user_login_rule')->row_array();

	//get CoA
	$this->db->distinct();
	$this->db->select('coa_code,coa_name');
	$this->db->where('spk_code', $value['spk_code']);
	$coa_data = $this->db->get('prc_plan_integrasi')->result_array();

		//get coa code
		if (count($coa_data) > 1) {
			$coa_code = array();
			foreach ($coa_data as $key => $value_code) {
				$coa_code[] = $value_code['coa_code'];
			}
			$coa_code = implode(' , ', $coa_code);
		}else{
			foreach ($coa_data as $key => $value_code) {
				$coa_code = $value_code['coa_code'];
			}
		}

		//get coa name
		if (count($coa_data) > 1) {
			$coa_name = array();
			foreach ($coa_data as $key => $value_name) {
				$coa_name[] = $value_name['coa_name'];
			}
			$coa_name = implode(' , ', $coa_name);
		}else{
			foreach ($coa_data as $key => $value_name) {
				$coa_name = $value_name['coa_name'];
			}
		}

	//get sum of total column as anggaran
	$this->db->select_sum('total');
	$this->db->where('spk_code', $value['spk_code']);
	$anggaran = $this->db->get('prc_plan_integrasi')->row_array();

	$periode_locking = $value['periode_locking'];
	$periode_locking = str_replace('-', '', date("Y-m-d", strtotime($periode_locking)));
	// echo str_replace('-', '', date("Y-m-d", strtotime($periode_locking)));
	// exit();

	$data = array(
		'ppm_subject_of_work' => $value['spk_code']."/".$value['project_name'],
		'ppm_scope_of_work' => $value['spk_code']."/".$value['project_name']." - ".$value['dept_code']."/".$value['dept_name'],
		'ppm_district_id' => $district['district_id'],
		'ppm_district_name' => $district['district_name'],
		'ppm_dept_id' => $district['dept_id'],
		'ppm_dept_name' => $value['dept_name'],
		'ppm_planner' => $planner_data['complete_name'],
		'ppm_planner_pos_code' => $planner_data['pos_id'],
		'ppm_planner_pos_name' => $planner_data['pos_name'],
		'ppm_status' => 3,
		'ppm_mata_anggaran' => $value['dept_code'],
		'ppm_nama_mata_anggaran' => $value['dept_name'],
		'ppm_sub_mata_anggaran' => $coa_code,
		'ppm_nama_sub_mata_anggaran' => $coa_name,
		'ppm_pagu_anggaran' => str_replace(',', "", number_format($anggaran['total'],0)),
		'ppm_renc_kebutuhan' => $periode_locking,
		'ppm_renc_pelaksanaan' => $periode_locking,
		'ppm_sisa_anggaran' => str_replace(',', "", number_format($anggaran['total'],0)),
		'ppm_currency' => 'IDR',
		'ppm_created_date' => date("Y-m-d H:i:s"),
		'ppm_planner_id' => $planner_data['employee_id'],
		'ppm_type_of_plan' => 'rkp',
		'ppm_project_name' => $value['project_name'],
		'ppm_project_id' => $value['spk_code'],
		'ppm_next_pos_id' => 212,
		'ppm_is_integrated' => 1
		);

	// echo "<pre>";
	// var_dump($data);
	// echo "</pre>";
	// exit();
	$insert_perencanaan = $this->db->insert('prc_plan_main', $data);

			if ($insert_perencanaan >= 1) {

				$last_id = $this->db->insert_id();
				//insert anggaran histori
				 $hist = array(
		            'ppm_id' => $last_id,
		            'pph_plus' => str_replace(',', "", number_format($anggaran['total'],0)),
		            'pph_remain' => str_replace(',', "", number_format($anggaran['total'],0)),
		            'pph_date' => date("Y-m-d H:i:s"),
		            'pph_desc' => 0
		            );

		    	$plan_hist = $this->Procplan_m->insertHist($hist);
		    	//end of insert anggaran histori

		    	//insert volume histori
		    	$this->db->select_sum('smbd_quantity');
		    	$this->db->select('concat(group_smbd_code,smbd_code) as smbd_code,unit');
		    	$this->db->where('spk_code', $value['spk_code']);
		    	$this->db->group_by('concat(group_smbd_code,smbd_code),unit');
		    	$main_volume = $this->db->get('prc_plan_integrasi')->result_array();

		    	foreach ($main_volume as $key => $vol_hist) {
			    		$volume_hist = array(
			            'ppm_id' => $last_id,
			            'ppv_main' => $vol_hist['smbd_quantity'],
			            'ppv_smbd_code' => $vol_hist['smbd_code'],
			            'ppv_unit' => $vol_hist['unit'],
			            'ppv_plus' => 0,
			            'ppv_remain' => $vol_hist['smbd_quantity'],
			            'created_datetime' => date("Y-m-d H:i:s"),
			            'ppv_activity' => 0,
			            'ppv_prc' => 'RKP/RKAP'
			            );

			    	$plan_hist = $this->Procplan_m->insertVolumeHist($volume_hist);
		    	}
				 
		    	//end of insert volume histori

		    	//insert comment perencanaan
				$last_id = $last_id;
				$com = "simpan dan kirim";
				$response = 'Simpan dan Kirim';
				$activity = 'Approval Perencanaan (Generated by System)';
				$dateopen = date("Y-m-d H:i:s");
				$next_pos_id = 212;
				
				$this->Comment_m->insertProcurementPlan($last_id,$com,$response,$activity,$dateopen,$next_pos_id);

				sleep(5);
				//get PIC ANGGARAN position
				$this->db->select('pos_id,pos_name,complete_name');
				$this->db->where('job_title', "PIC ANGGARAN");
				$keuangan = $this->db->get('user_login_rule')->row_array();

				$input['ppm_id'] = $last_id;
				$input['comments'] = "Setuju";
				$input['activity'] = 'Pembuatan Draft Perencanaan (Generated by System)';
				$input['comment_date'] = date("Y-m-d H:i:s");
				$input['comment_end_date'] = date("Y-m-d H:i:s");
				$input['comment_name'] = $keuangan['complete_name'];
				$input['response'] = 'Setuju';
				$input['pos_id'] = $keuangan['pos_id'];
				$input['pos_name'] = $keuangan['pos_name'];
				$input['next_pos_id'] = 212;

				$this->db->insert("prc_plan_comment",$input);
				//end of insert comment perencanaan

				if ($this->db->trans_status() === FALSE)
				  {
				    echo json_encode("Gagal menambahkan data pada row ke-".$n);
				    $this->db->trans_rollback();
				    exit();
				  }
				  else
				  {
				    // $this->setMessage("Sukses menambah data");
				    $this->db->trans_commit();
				  }
				  $n++;
			}
	
	}
	echo json_encode("Berhasil membuat perencanaan baru");
} else {
	echo json_encode("Data baru tidak ditemukan");
}






