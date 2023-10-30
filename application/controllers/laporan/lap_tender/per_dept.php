<?php 

$this->db->where_not_in("ptm_status", array(1902, 1903, 1904, 1906));
$getdata = $this->Laporan_m->getTender($id)->result_array();

$total = 0;
$diff = 0;
$preeff = 0;
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
	// 	$diff += $value['hps'] - $value['total_contract'];
	// 	$hpstot += $value['hps'];

	// }
}

$dept = $this->db->where("dept_id", $id)->get("adm_dept")->row_array();

// $preeff = ($diff/$hpstot)*100;
 
$data = [
	'id' => $id,
	'dept_name' => $dept['dept_name'],	
	'efisiensi' => $total,
	'persentase' => ($persentase != 0) ? $persentase/$i : 0
];

$this->template("laporan/lap_tender/per_dept_v","Detail RFQ Per Departemen",$data);	
?>