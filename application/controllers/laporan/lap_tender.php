<?php

$rfq = [];
$ctr = [];

$this->load->model("Procrfq_m");
	
$this->db->where_not_in("ptm_status", [1902, 1903, 1906]);
$rfqdata = $this->Procrfq_m->getMonitorRFQ()->result_array();

echo "<pre>";

foreach ($rfqdata as $ky => $val) {

	if ($val['ptm_status'] == "1901" || $val['ptm_status'] == "1905") {
		
		$ctr[] = $val;
	}else{
		$rfq[] = $val;
	}
}


var_dump($rfq);



exit();

$data = [
		'total' 	=> $total,
		'totalrkap'	=> $totalrkap,
		'totalrkp'	=> $totalrkp,
		'rkpdept'	=> $rkpdept,
		'rkapdept'	=> $rkapdept,
		'plandept'	=> $plandept,
		'perma'		=> array_values($prm),
		'perm'		=> $perm,	
		'persma'	=> array_values($prsm),
		'persm'		=> $persm,
		'prc'		=> array_values($prc),
		'perc'		=> $perc	
	];


if (isset($export)) {
	if ($export == "xlsx") {
		$this->load->view('laporan/xlsx_lap_plan_v', $data);
	}else{
		$this->load->view('laporan/pdf_lap_plan_v', $data);
	}
}else{
	$this->template("laporan/lap_plan_v","Laporan Analisa Perencanaan",$data);	
}

 