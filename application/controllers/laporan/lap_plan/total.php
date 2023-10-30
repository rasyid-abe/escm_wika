<?php

$this->load->model("Procplan_m");

$total = 0;
$totalrkp = 0;
$totalrkap = 0;

// $this->db->where_in('ppm_is_integrated', [1,2]);
// $this->db->join('adm_coa', 'ppm_sub_mata_anggaran=ac_coa', 'left');
// $plan = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

$plan = $this->Laporan_m->getPlan()->result_array();
// echo $this->db->last_query();
// exit();

foreach ($plan as $key => $value) {
	
	$total += $value['ppm_pagu_anggaran'];
	
	if ($value['ppm_type_of_plan'] == "rkap") {

		$totalrkap += $value['ppm_pagu_anggaran'];	}

	if ($value['ppm_type_of_plan'] == "rkp") {

		$totalrkp += $value['ppm_pagu_anggaran'];
	}
}

$data = [
		'total' 	=> $total,
		'totalrkap'	=> $totalrkap,
		'totalrkp'	=> $totalrkp
	];


if (isset($export)) {
	if ($export == "xlsx") {
		$this->load->view('laporan/xlsx_lap_plan_v', $data);
	}else{
		$this->load->view('laporan/pdf_lap_plan_v', $data);
	}
}else{
	$this->template("laporan/lap_plan/total_v","Laporan Analisa Perencanaan",$data);	
}

 