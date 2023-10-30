<?php 

$id = $this->uri->segment(5, 0);

$vd = $this->Administration_m->getVendorVsi("", $id)->result_array();


$period = $vd[0]['periode'];

foreach ($vd as $k => $v) {
	$this->db->order_by("vvk_quest_header");
	$dats[] = $this->Administration_m->getVendorVsiKues("", $v['vvq_id'])->result_array();
	// $tohead[] = $dats[0][0]['vvk_quest_header'];
}

foreach ($dats[0] as $key => $value) {
	$head[] = $value['vvk_quest_header'];
}

$hm = array_unique($head);
foreach ($hm as $key => $value) {
	$headname[] = $value;
}

$isi = [];	
$satis = [];
$im = [];
$imp = [];

foreach ($dats as $key => $value) {
	foreach ($value as $y => $v) {
		$isi[$y] = $v['vvk_satis_score'];
		$im[$y] = $v['vvk_imp_score'];
	}
	$satis[$key] = $isi;
	$imp[$key] = $im;
}

// $total_satis = array_shift($satis);
// $total_imp = array_shift($imp);

// foreach ($total_imp as $key => &$value){
//    $value += array_sum(array_column($imp, $key));

// var_dump($value);
// }    

$data = [
	'header' => $dats[0],
	'th' => array_count_values($head),
	'headname' => $headname,
	'vendor' => $vd,
	'quest' => $dats,
	'imp' => $imp,
	'satis' => $satis,
	'period' => $period
];

$view = 'administration/template_vsi/template_kompilasi/lihat_template_kompilasi_v';

$this->template($view,"Vendor Satisfaction Index",$data);