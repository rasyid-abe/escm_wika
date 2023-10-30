<?php

$totalplan = 0;
$totalrkp = 0;
$totalrkap = 0;

$plan = $this->Laporan_m->getPlan()->result_array();

$getdata = $this->Laporan_m->getTender()->result_array();


$totalrari = 0;
$sumb = 0;
$sumj = 0;
$summ = 0;
$sumrkp = 0;
$sumrkap = 0;
$diff = 0;
$preeff = 0;
$hpstot = 0;

foreach ($getdata as $key => $value) {
	$totalrari += $value['hps'];
	if ($value['type'] == "B") {
		$sumb += $value['hps'];
	}
	else if ($value['type'] == "J") {
		$sumj += $value['hps'];
	}
	else if ($value['type'] == "M" || $value['type'] == "") {
		$summ += $value['hps'];
	}

	if ($value['ptm_type_of_plan'] == "rkp" || $value['ptm_type_of_plan'] == "rkp_matgis") {
		$sumrkp += $value['hps'];
	}else if($value['ptm_type_of_plan'] == "rkap" || $value['ptm_type_of_plan'] == ""){
		$sumrkap += $value['hps'];
	}

	if (!empty($value['total_contract'])) {
		// var_dump($value['hps']);
		$diff += $value['hps'] - $value['total_contract'];
		$hpstot += $value['hps'];

	}
}
// var_dump($diff);
// var_dump($hpstot);

$preeff = ($diff/$hpstot)*100;
 

foreach ($plan as $key => $value) {
	
	$totalplan += $value['ppm_pagu_anggaran'];
	
	if ($value['ppm_type_of_plan'] == "rkap") {

		$totalrkap += $value['ppm_pagu_anggaran'];	}

	if ($value['ppm_type_of_plan'] == "rkp") {

		$totalrkp += $value['ppm_pagu_anggaran'];
	}
}

$data = [
		'totalplan' 	=> $totalplan,
		'totalrkap'	=> $totalrkap,
		'totalrkp'	=> $totalrkp,
		'totalrari' => $totalrari,
		'total_barang' => $sumb,
		'total_jasa' => $sumj,
		'efisiensi' => $diff,
		'preeff' => $preeff,
		'total_multi' => $summ,
		'total_barang' => $sumb,
		'total_jasa' => $sumj,
		'total_rkp' => $sumrkp,
		'total_rkap' => $sumrkap,
	];


if (isset($export)) {
	if ($export == "xlsx") {
		$this->load->view('laporan/xlsx_lap_plan_v', $data);
	}else{
		$this->load->view('laporan/pdf_lap_plan_v', $data);
	}
}else{
	$this->template("laporan/lap_rari/total_rari_v","Laporan Ra vs Ri",$data);	
}

 