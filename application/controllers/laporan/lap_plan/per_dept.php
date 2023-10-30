<?php

$this->load->model("Procplan_m");

$this->db->order_by('ac_kode_sub_mata_anggaran');
$coa = $this->db->get("adm_coa")->result_array();

// $this->db->order_by('ppm_dept_name', 'desc');
$this->db->where('ppm_dept_id', $id);
// $this->db->where_in('ppm_is_integrated', [1,2]);
// $this->db->join('project_info', 'project_info.kode_spk=vw_prc_plan_main.ppm_project_id', 'left');
// $this->db->join('adm_coa', 'vw_prc_plan_main.ppm_sub_mata_anggaran=adm_coa.ac_coa', 'left');
// $plan = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

$plan = $this->Laporan_m->getPlan()->result_array();

// echo $this->db->last_query();

$dept = "";
$lb = "";
foreach ($coa as $ck => $cv) {

	if ($cv['ac_beban'] != $lb) {
		
		$lma = "";
		$sumthree = 0;

		foreach ($coa as $key => $value) {
			
			$dats = [];
			$sum = 0;

			if ($cv['ac_beban'] == $value['ac_beban']) {
				
				if($value['ac_mata_anggaran'] != $lma){
					
					$lsma = "";
					// $sma = [];
					$sumtwo = 0;
					foreach ($coa as $ky => $val) {

						if($value['ac_mata_anggaran'] == $val['ac_mata_anggaran']){
							
							if ($val['ac_sub_mata_anggaran'] != $lsma) {

								$lcoa = "";
								$getcoa = "";
								$sumone = 0;
								foreach ($coa as $kc => $vc) {
									
									if($vc['ac_sub_mata_anggaran'] == $val['ac_sub_mata_anggaran']){
										
										if ($vc['ac_nama_coa'] != $lcoa) {

											$sumzero = 0;
											foreach ($plan as $kp => $vp) {
												
												if ($vp['ppm_sub_mata_anggaran'] == $vc['ac_coa'] && $vp['ppm_is_integrated'] == 2) {
													$sumzero += $vp['ppm_pagu_anggaran'];
												}
											}
											$fromzero = [ 
												'sumzero' => $sumzero,
												'coa' => $vc['ac_coa']."  ".$vc['ac_nama_coa']
											];

											$getcoa[] = $fromzero;
											// $sumone += $vc['ppm_pagu_anggaran'];
										}
									}
									$lcoa = $vc['ac_sub_mata_anggaran'];
									$sumone += $sumzero;
								}

								$fromcoa = [
									'sumone' => $sumone,
									'sma' => $val['ac_sub_mata_anggaran'],
									'coa' => $getcoa
								];

								$sumtwo += $sumone;
								$sma[] = $fromcoa;
							}
						}

						$lsma = $val['ac_sub_mata_anggaran'];
					}

					$fromsma = [
						'sumtwo' => $sumtwo,
						'ma' => $value['ac_mata_anggaran'],
						'sma' => $sma,
						'dept' => $plan[0]['ppm_dept_name']	
					];

					$sumthree += $sumtwo;
					$ma[] = $fromsma;
				}
			}
			$lma = $value['ac_mata_anggaran'];
		}

		$fromma = [
			'sumthree' => $sumthree,
			'beban' => $cv['ac_beban'],
			'ma' => $ma
		];

					// echo "<pre>";;
					// var_dump($ma);

		$beb[] = $fromma;

	}

	$lb = $cv['ac_beban'];
}
// echo "string";
// exit();
// echo "<pre>";
// var_dump($ma);
// exit();
$rkp = [];
foreach ($plan as $ky => $val) {
	if ($val['ppm_type_of_plan'] == "rkp" && $val['ppm_is_integrated'] == 1) {
		$rkp[] = $val;
	}
}
// echo "<pre>";
// var_dump($rkp);
// exit();

$data = [
	'coadata' 	=> $beb,
	'rkp'		=> $rkp
];


if (isset($export)) {
	if ($export == "xlsx") {
		$this->load->view('laporan/xlsx_lap_plan_v', $data);
	}else{
		$this->load->view('laporan/pdf_lap_plan_v', $data);
	}
}else{
	$this->template("laporan/lap_plan/detail_per_dept_v","Laporan Analisa Perencanaan",$data);	
}

 