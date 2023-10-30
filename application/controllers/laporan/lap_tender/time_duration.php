<?php 

$this->db->order_by("ptm_dept_name", "desc");
// $this->db->where("ptm_dept_id", 29);
$getdata = $this->Laporan_m->getTender()->result_array();


$ldept = "";
$stat = array(1902, 1903, 1904, 1906);

$fld = 0;

foreach ($getdata as $ky => $val) {

	if ($val['ptm_type_of_plan'] == 'rkap' || $val['ptm_type_of_plan'] == 'rkp_matgis' ) {	
		
		$fail = (in_array($val['ptm_status'], $stat)) ? 1 : 0;

		$listrkap[$val['ptm_dept_id']][] = [
				'dept' => $val['ptm_dept_name'],
				'rfq' => $val['ptm_number'],
				'durasi' => $val['durasi'],
				'fail' => $fail
			];
	}else{

		$fail = (in_array($val['ptm_status'], $stat)) ? 1 : 0;

		$listrkp[$val['ptm_dept_id']][] = [
				'dept' => $val['ptm_dept_name'],
				'rfq' => $val['ptm_number'],
				'durasi' => $val['durasi'],
				'fail' => $fail
			];
	}
}


if (!empty($listrkap)) {
	
	foreach ($listrkap as $k => $v) {
		$fie = 0;
		$dur = 0;
		$i = 0;
		foreach ($v as $key => $value) {
			$fie += $value['fail'];
			$dur += $value['durasi'];
			$i++;
		}
		$rkap[$k]['dept'] = $v[0]['dept'];
		$rkap[$k]['dur'] = $dur/$i;
		$rkap[$k]['total'] = sizeof($v);
		$rkap[$k]['fie'] = $fie;
		$rkap[$k]['colour'] = ($rkap[$k]['dur'] > 14) ? "#ff5959" : "#59aeff";
	}
}else{
	$rkap = NULL;
}

if (!empty($listrkp)) {
	
	foreach ($listrkp as $k => $v) {
		$fie = 0;
		$dur = 0;
		$i = 0;
		foreach ($v as $key => $value) {
			$fie += $value['fail'];
			$dur += $value['durasi'];
			$i++;
		}
		$rkp[$k]['dept'] = $v[0]['dept'];
		$rkp[$k]['dur'] = $dur/$i;
		$rkp[$k]['total'] = sizeof($v);
		$rkp[$k]['fie'] = $fie;
		$rkp[$k]['colour'] = ($rkp[$k]['dur'] > 14) ? "#ff5959" : "#59aeff";
	}
}else{
	$rkp = NULL;
}


$data = [
	'datarkp' => $rkp,
	'datarkap' => $rkap,
	'hrkp' => count($rkp)*45,
	'hrkap' => count($rkap)*45
];

$this->template("laporan/lap_tender/time_duration_v","Waktu Proses (rata-rata)",$data);	
?>