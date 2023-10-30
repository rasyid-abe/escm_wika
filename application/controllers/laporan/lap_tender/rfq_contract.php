<?php

$getdata = $this->Laporan_m->getTender()->result_array();

$ctrsum = 0;
$prcsum = 0;
$ctrsumb = 0;
$ctrsumj = 0;
$prcsumb = 0;
$prcsumj = 0;

foreach ($getdata as $key => $value) {
	
	if ($value['ptm_status'] == 1901 || $value['ptm_status'] == 1905) {
		
		$ctrsum += $value['total_contract'];

		if ($value['type'] == "B" || $value['type'] == "M") {
			$ctrsumb += $value['total_contract'];
		}
		else if ($value['type'] == "J") {
			$ctrsumj += $value['total_contract'];
		}
	}else {
		
		$prcsum += $value['hps'];

		if ($value['type'] == "B" || $value['type'] == "M") {
			$prcsumb += $value['hps'];
		}
		else if ($value['type'] == "J") {
			$prcsumj += $value['hps'];
		}
	}
}

$data = [
	'ctrsum' => $ctrsum,
	'prcsum' => $prcsum,
	'ctrsumb' => $ctrsumb,
	'ctrsumj' => $ctrsumj,
	'prcsumb' => $prcsumb,
	'prcsumj' => $prcsumj
];

$this->template("laporan/lap_tender/rfq_contract_v","Jumlah RFQ dan Kontrak",$data);	
?>