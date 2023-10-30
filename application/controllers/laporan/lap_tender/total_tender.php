<?php

$getdata = $this->Laporan_m->getTender()->result_array();
// echo $this->db->last_query();
// exit();

$total = 0;
$sumb = 0;
$sumj = 0;
$summ = 0;
$sumrkp = 0;
$sumrkap = 0;
$diff = 0;
$preeff = 0;
$hpstot = 0;

foreach ($getdata as $key => $value) {
	$total += $value['hps'];
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
 
$data = [
	'total' => $total,
	'total_barang' => $sumb,
	'total_jasa' => $sumj,
	'total_multi' => $summ,
	'total_rkp' => $sumrkp,
	'total_rkap' => $sumrkap,
	'efisiensi' => $diff,
	'preeff' => $preeff
	];

if (isset($export)) {
	if ($export == "xlsx") {
		$this->load->view('laporan/xlsx_lap_plan_v', $data);
	}else{
		$this->load->view('laporan/pdf_lap_plan_v', $data);
	}
}else{
	$this->template("laporan/lap_tender/total_tender_v","Laporan Analisa Pelaksanaan",$data);	
}

