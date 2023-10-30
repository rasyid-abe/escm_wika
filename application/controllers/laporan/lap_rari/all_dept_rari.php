<?php

$this->db->order_by('ppm_dept_name', 'desc');
// $this->db->where_in('ppm_is_integrated', [1,2]);
$plan = $this->Laporan_m->getRari()->result_array();
// echo $this->db->last_query();
// exit();

$ldeptrkap = '';
$ldeptrkp = '';
$sump = 0;
$sumnp = 0;
$realp = 0;
$realnp = 0;

foreach ($plan as $key => $value) {

	if ($value['ppm_type_of_plan'] == "rkap") {

		if ($value['ppm_dept_name'] == $ldeptrkap) {
			$sumnp += $value['ppm_pagu_anggaran'];
			$realnp = $value['total_rfq'];
		}else{
			$sumnp = $value['ppm_pagu_anggaran'];
			$realnp = $value['total_rfq'];
		}

		$rkapdept[$key]['dept_id'] = $value['ppm_dept_id'];
		$rkapdept[$key]['dept'] = $value['ppm_dept_name'];
		$rkapdept[$key]['sum'] = $sumnp;
		$rkapdept[$key]['real'] = $realnp;

		$ldeptrkap = $value['ppm_dept_name'];
	}

	if ($value['ppm_type_of_plan'] == "rkp") {

		if ($value['ppm_dept_name'] == $ldeptrkp) {
			$sump += $value['ppm_pagu_anggaran'];
			$realp = $value['total_rfq'];
		}else{
			$sump = $value['ppm_pagu_anggaran'];
			$realp = $value['total_rfq'];
		}	

		$rkpdept[$key]['dept_id'] = $value['ppm_dept_id'];
		$rkpdept[$key]['dept'] = $value['ppm_dept_name'];
		$rkpdept[$key]['sum'] = $sump;
		$rkpdept[$key]['real'] = $realp;

		$ldeptrkp = $value['ppm_dept_name'];
	}
}

$data = [
		'rkpdept'	=> $rkpdept,
		'rkapdept'	=> $rkapdept,
	];


if (isset($export)) {
	if ($export == "xlsx") {
		$this->load->view('laporan/xlsx_lap_plan_v', $data);
	}else{
		$this->load->view('laporan/pdf_lap_plan_v', $data);
	}
}else{
	$this->template("laporan/lap_rari/all_dept_rari_v","Laporan Ra vs Ri",$data);	
}

 