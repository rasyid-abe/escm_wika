<?php

// $this->load->model("Procplan_m");

$this->db->order_by('ac_kode_sub_mata_anggaran');
$coa = $this->db->get("adm_coa")->result_array();

$this->db->order_by('ppm_dept_name', 'desc');
// $this->db->where('ppm_type_of_plan', 'rkap');
// $this->db->where('ppm_dept_id', '17');
$this->db->where('ppm_is_integrated', 2);
$plan = $this->Laporan_m->getRari()->result_array();
// $this->db->join('adm_coa', 'ppm_sub_mata_anggaran=adm_coa.ac_coa', 'left');
// $this->db->join('project_info', 'project_info.kode_spk=ppm_project_id', 'left');
// $plan = $this->Laporan_m->get_rari()->result_array();
// $plan = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

// echo $this->db->last_query();
// exit();

$dept = "";
$lb = "";

foreach ($coa as $ck => $cv) {
	
	if($cv['ac_beban'] != $lb){

		$lma = "";
		$sumfour = 0;
		$foursum = 0;
		foreach ($coa as $key => $value) {
			
			$dats = [];
			$sum = 0;

			if($cv['ac_beban'] == $value['ac_beban']){

				if($value['ac_mata_anggaran'] != $lma){
					
					$lsma = "";
					$sma = [];
					$sumthree = 0;
					$threesum = 0;
					foreach ($coa as $ky => $val) {

						if($value['ac_mata_anggaran'] == $val['ac_mata_anggaran']){
							
							if ($val['ac_sub_mata_anggaran'] != $lsma) {

								$lcoa = "";
								$getcoa = "";
								$sumtwo = 0;
								$twosum = 0;
								foreach ($coa as $kc => $vc) {
									
									if($vc['ac_sub_mata_anggaran'] == $val['ac_sub_mata_anggaran']){
										
										if ($vc['ac_nama_coa'] != $lcoa) {

											$pd = [];
											$lcoadept = "";
											$pdept = [];
											$sumone = 0;
											$sumzero = 0;
											$onesum = 0;
											$zerosum = 0;
											$pagu = 0;
											$real = 0;
											foreach ($plan as $kp => $vp) {

												if ($vp['ac_coa'] == $vc['ac_coa']) {

													if ($vp['ppm_dept_name'] != $lcoadept) {
														
														$dept = $vp['ppm_dept_name'];
														$pagu = $vp['ppm_pagu_anggaran'];
														$real = $vp['total_rfq'];

													}else{
														$pagu += $vp['ppm_pagu_anggaran'];
														$real = $vp['total_rfq'];
													}
													$pd[] = [
														'dept' => $dept,
														'pagu' => $pagu,
														'real' => $real
													];

													$lcoadept = $vp['ppm_dept_name'];
													$sumone += $vp['ppm_pagu_anggaran'];
													$onesum += $vp['total_rfq'];
												}

											}

											$getcoa[$kc]['data'] = $vc['ac_coa']."  ".$vc['ac_nama_coa'];
											$getcoa[$kc]['dept'] = $pd;
											$getcoa[$kc]['sumone'] = $sumone;
											$getcoa[$kc]['onesum'] = $onesum;


										}
									}
									$lcoa = $vc['ac_sub_mata_anggaran'];
									$sumtwo += $sumone;
									$twosum += $onesum;
								}

								$fromcoa = [
									'sumtwo' => $sumtwo,
									'twosum' => $twosum,
									'sma' => $val['ac_sub_mata_anggaran'],
									'coa' => $getcoa,
									'pd' => $pd
								];

								$threesum += $twosum;
								$sumthree += $sumtwo;
								$sma[] = $fromcoa;
							}
						}

						$lsma = $val['ac_sub_mata_anggaran'];
					}

					$fromsma = [
						'sumthree' => $sumthree,
						'threesum' => $threesum,
						'ma' => $value['ac_mata_anggaran'],
						'sma' => $sma
					];

					$foursum += $threesum;
					$sumfour += $sumthree;
					$ma[] = $fromsma;
				}
			}

			$lma = $value['ac_mata_anggaran'];
		}

		$fromma = [
			'sumfour' => $sumfour,
			'foursum' => $foursum,
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
	$this->template("laporan/lap_rari/all_coa_rari_v","Laporan Analisa Perencanaan",$data);	
}
