<?php 

$this->db->where_not_in("ptm_status", array(1902, 1903, 1904, 1906));
$getdata = $this->Laporan_m->getTender()->result_array();

$total = 0;
$diff = 0;
$hpstot = 0;
$persentase = 0;
$i = 0;

foreach ($getdata as $key => $value) {
	$total += $value['efisiensi'];
	
	if ($value['selisih_persen'] != NULL) {
		$persentase += $value['selisih_persen'];
		$i++;
	}
	// if (!empty($value['total_contract'])) {
		// var_dump($value['hps_total']);
		// $diff += $value['hps'] - $value['total_contract'];
		// $hpstot += $value['hps'];
	// }
}

// $preeff = ($diff/$hpstot)*100;

$data = [
	'efisiensi' => $total,
	'persentase' => $persentase/$i
];

$this->template("laporan/lap_tender/total_rfq_v","Laporan RFQ Total",$data);	
?>