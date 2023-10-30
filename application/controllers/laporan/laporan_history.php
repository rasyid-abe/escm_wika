<?php 

$view = 'laporan/laporan_history_katalog_v';

$data = [];
$pricereport = [];
$dats = [];
$cm = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

$price = $this->Laporan_m->getPriceKatalog()->result_array();

foreach ($price as $key => $value) {
	$this->db->where("date_part('year', updated_datetime) = date_part('year', CURRENT_DATE)");
	$pricehist = $this->Laporan_m->getHistoryKatalog($value['mat_catalog_code'])->result_array();
	
	$pricereport[$key]['price'] = $price[$key];
	$pricereport[$key]['hist'] = $pricehist;
}


foreach ($pricereport as $key => $value) {

	if (empty($value['hist'])) {
		$pricereport[$key]['updated'][0]['code'] = $pricereport[$key]['price']['mat_catalog_code'];
		$pricereport[$key]['updated'][0]['desc'] = $pricereport[$key]['price']['long_description'];
		$pricereport[$key]['updated'][0]['date'] = date('Y')."-01-01 00:00:00";
		$pricereport[$key]['updated'][0]['cost'] = $pricereport[$key]['price']['total_cost'];
		$pricereport[$key]['updated'][0]['month'] = 1;
	}
	$lastm = "";	
	
	for ($i=0; $i < count($value['hist']) ; $i++) { 
	
		$dt = strtotime($pricereport[$key]['hist'][$i]['updated_datetime']);
		$month = (int)date("m",$dt);
		
		if ($lastm != $month) {
			$pricereport[$key]['updated'][$i]['code'] = $pricereport[$key]['price']['mat_catalog_code'];
			$pricereport[$key]['updated'][$i]['desc'] = $pricereport[$key]['price']['long_description'];
			$pricereport[$key]['updated'][$i]['date'] = $pricereport[$key]['hist'][$i]['updated_datetime'];
			$pricereport[$key]['updated'][$i]['cost'] = $pricereport[$key]['hist'][$i]['total_cost'];
			$pricereport[$key]['updated'][$i]['month'] = $month;
			
		}
		$lastm = $month;
	}
}

$itsyou = [];
$itsme = []; 

foreach ($pricereport as $yk => $yv) {
	
	$i = 1;
	unset($itsyou);
	
	foreach ($yv['updated'] as $k => $v) {
		
		if ( $i <= count($yv['updated'])) {
			
			$itsyou[] = [
				'name'	=> $cm[$k],
				'y' 	=> (int)$v['cost']
			];	
		}
				
		$i++;
	}

	$itsme[] = [
		'name' => $yv['updated'][0]['desc'],
		'data' => $itsyou
	];


	$i++;
}

$datsu = json_encode($itsme);

$data['dats'] = $datsu;
$data['item'] = json_encode($pricereport);

$this->template($view,"Laporan History Katalog",$data);

?>