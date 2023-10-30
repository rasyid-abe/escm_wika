<?php

$this->load->model("Procplan_m");

$this->db->order_by('ac_kode_sub_mata_anggaran');
$coa = $this->db->get("adm_coa")->result_array();

$this->db->order_by('ppm_dept_name', 'desc');
$this->db->where('ppm_type_of_plan', 'rkap');
// $this->db->where('ppm_dept_id', '17');
$this->db->where_in('ppm_is_integrated', [2]);
// $this->db->join('adm_coa', 'vw_prc_plan_main.ppm_sub_mata_anggaran=adm_coa.ac_coa', 'left');
// $this->db->join('project_info', 'project_info.kode_spk=vw_prc_plan_main.ppm_project_id', 'left');
// $plan = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

$plan = $this->Laporan_m->getPlan()->result_array();

// echo $this->db->last_query();
// exit();

$dept = "";
$lb = "";
foreach ($coa as $ck => $cv) {

	if ($cv['ac_beban'] != $lb) {

		$lma = "";
		$sumfour = 0;

		foreach ($coa as $key => $value) {
			
			$dats = [];
			$sum = 0;
			
			if ($cv['ac_beban'] == $value['ac_beban']) {

				if($value['ac_mata_anggaran'] != $lma){

					$lsma = "";
					$sumthree = 0; 

					foreach ($coa as $ky => $val) {

						if($value['ac_mata_anggaran'] == $val['ac_mata_anggaran']){
							
							if ($val['ac_sub_mata_anggaran'] != $lsma) {
							
								$lcoa = "";
								$getcoa = "";
								$sumtwo = 0;
								foreach ($coa as $kc => $vc) {
									
									if($vc['ac_sub_mata_anggaran'] == $val['ac_sub_mata_anggaran']){
										
										if ($vc['ac_nama_coa'] != $lcoa) {

											$pd = [];
											$lcoadept = "";
											$pdept = [];
											$sumone = 0;
											$sumzero = 0;
											$pagu = 0;
											foreach ($plan as $kp => $vp) {

												if ($vp['ac_coa'] == $vc['ac_coa']) {

													if ($vp['ppm_dept_name'] != $lcoadept) {
														
														$dept = $vp['ppm_dept_name'];
														$pagu = $vp['ppm_pagu_anggaran'];

													}else{
														$pagu += $vp['ppm_pagu_anggaran'];

													}
													$pd[] = [
														'dept' => $dept,
														'pagu' => $pagu
													];

													$lcoadept = $vp['ppm_dept_name'];
													$sumone += $vp['ppm_pagu_anggaran'];
												}

											}

											$getcoa[$kc]['data'] = $vc['ac_coa']."  ".$vc['ac_nama_coa'];
											$getcoa[$kc]['dept'] = $pd;
											$getcoa[$kc]['sumone'] = $sumone;


										}
									}
									$lcoa = $vc['ac_sub_mata_anggaran'];
									$sumtwo += $sumone;
								}

								$fromcoa = [
									'sumtwo' => $sumtwo,
									'sma' => $val['ac_sub_mata_anggaran'],
									'coa' => $getcoa,
									'pd' => $pd
								];

								$sumthree += $sumtwo;
								$sma[] = $fromcoa;
							}
						}


						$lsma = $val['ac_sub_mata_anggaran'];
					}

					$fromsma = [
						'sumthree' => $sumthree,
						'ma' => $value['ac_mata_anggaran'],
						'sma' => $sma
					];


					$sumfour += $sumthree;
					$ma[] = $fromsma;
				}
			}

			$lma = $value['ac_mata_anggaran'];
		}

		$fromma = [
			'sumfour' => $sumfour,
			'beban' => $cv['ac_beban'],
			'ma' => $ma
		];

		$beb[] = $fromma;

	}
	$lb = $cv['ac_beban'];
}

// echo "<pre>";
// var_dump($beb);
// exit();


$data['coadata'] = $beb;


if (isset($export)) {
	if ($export == "xlsx") {
		$this->load->view('laporan/xlsx_lap_plan_v', $data);
	}else{
		$this->load->view('laporan/pdf_lap_plan_v', $data);
	}
}else{
	$this->template("laporan/lap_plan/all_coa_v","Laporan Analisa Perencanaan",$data);	
}

 