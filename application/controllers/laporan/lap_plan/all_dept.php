<?php

$this->load->model("Procplan_m");

$this->db->order_by('ppm_dept_name', 'desc');
// $this->db->where_in('ppm_is_integrated', [1,2]);
// $plan = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

$plan = $this->Laporan_m->getPlan()->result_array();

$ldeptrkap = '';
$ldeptrkp = '';
$sumnp = 0;
$sump = 0;
foreach ($plan as $key => $value) {

	if ($value['ppm_type_of_plan'] == "rkap") {

		if ($value['ppm_dept_name'] == $ldeptrkap) {
			$sumnp += $value['ppm_pagu_anggaran'];
		}else{
			$sumnp = $value['ppm_pagu_anggaran'];
		}

		$rkapdept[$key]['dept_id'] = $value['ppm_dept_id'];
		$rkapdept[$key]['dept'] = $value['ppm_dept_name'];
		$rkapdept[$key]['sum'] = $sumnp;

		$ldeptrkap = $value['ppm_dept_name'];
	}

	if ($value['ppm_type_of_plan'] == "rkp") {

		if ($value['ppm_dept_name'] == $ldeptrkp) {
			$sump += $value['ppm_pagu_anggaran'];
		}else{
			$sump = $value['ppm_pagu_anggaran'];
		}	

		$rkpdept[$key]['dept_id'] = $value['ppm_dept_id'];
		$rkpdept[$key]['dept'] = $value['ppm_dept_name'];
		$rkpdept[$key]['sum'] = $sump;

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
	$this->template("laporan/lap_plan/all_dept_v","Laporan Analisa Perencanaan",$data);	
}

 