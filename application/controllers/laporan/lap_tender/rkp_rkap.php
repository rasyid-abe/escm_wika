<?php 

$this->db->where_not_in("ptm_status", array(1901, 1905));
$this->db->order_by("ptm_dept_name", "desc");
$this->db->order_by("ptm_type_of_plan");
$datarfq = $this->Laporan_m->getTender()->result_array();

$this->db->where_in("ptm_status", array(1901, 1905));
$this->db->order_by("ptm_dept_name", "desc");
$this->db->order_by("ptm_type_of_plan");
$datactr = $this->Laporan_m->getTender()->result_array();


$ctrrkp = 0;
$ctrrkap = 0;
$cldept = "";

foreach ($datactr as $key => $value) {

	if ($cldept == $value['ptm_dept_id']) {
		
		if ($value['ptm_type_of_plan'] == "rkp") {
			$ctrrkp += $value['total_contract'];
		}else{
			$ctrrkap += $value['total_contract'];
		}
		
	}else{

		$ctrrkp = 0;
		$ctrrkap = 0;

		if ($value['ptm_type_of_plan'] == "rkp") {
			$ctrrkp = $value['total_contract'];
		}else{
			$ctrrkap = $value['total_contract'];
		}
	}

	$cldept = $value['ptm_dept_id'];

	$ctr[] = [
		'dept_id' => $value['ptm_dept_id'],
		'dept_name' => $value['ptm_dept_name'],
		'rkp' => ($value['ptm_type_of_plan']=="rkp") ? $value['total_contract'] : 0,
		'sumrkp' => $ctrrkp,
		'rkap' => ($value['ptm_type_of_plan']=="rkap") ? $value['total_contract'] : 0,
		'sumrkap' => $ctrrkap
	];
}


$rfqrkp = 0;
$rfqrkap = 0;
$rldept = "";

foreach ($datarfq as $key => $value) {

	if ($rldept == $value['ptm_dept_id']) {
		
		if ($value['ptm_type_of_plan'] == "rkp") {
			$rfqrkp += $value['hps'];
		}else{
			$rfqrkap += $value['hps'];
		}
		
	}else{

		$rfqrkp = 0;
		$rfqrkap = 0;

		if ($value['ptm_type_of_plan'] == "rkp") {
			$rfqrkp = $value['hps'];
		}else{
			$rfqrkap = $value['hps'];
		}
	}

	$rldept = $value['ptm_dept_id'];

	$rfq[] = [
		'dept_id' => $value['ptm_dept_id'],
		'dept_name' => $value['ptm_dept_name'],
		'rkp' => ($value['ptm_type_of_plan']=="rkp") ? $value['hps'] : 0,
		'sumrkp' => $rfqrkp,
		'rkap' => ($value['ptm_type_of_plan']=="rkap") ? $value['hps'] : 0,
		'sumrkap' => $rfqrkap
	];
}
$data = [
	'contract' => $ctr,
	'rfq' => $rfq
];

$this->template("laporan/lap_tender/rkp_rkap_v","Proyek Dan Non Proyek",$data);	
?>