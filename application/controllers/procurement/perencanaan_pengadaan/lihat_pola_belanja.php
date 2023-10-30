<?php 
/*
$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'procurement/perencanaan_pengadaan/detail_pola_belanja_v';

$data = array();

$id = $this->uri->segment(5, 0);


$data['pola_belanja'] = $this->Procplan_m->getPolaBelanja($id)->result_array();



$data['item_perencanaan_pmcs'] = $this->Procplan_m->getItemPMCS($id)->result_array();

$data['item_periode_pmcs'] = $this->Procplan_m->getPeriodePengadaanPMCS($id)->result_array();

$data['urlpr'] = site_url('procurement/procurement_tools/monitor_pengadaan/lihat_permintaan')."/";

$data['urlrfq'] = site_url('procurement/procurement_tools/monitor_pengadaan/lihat')."/";

$data['urlctr'] = site_url('contract/monitor/monitor_kontrak/lihat')."/";

$this->template($view,"Detail Pola Belanja",$data);*/

$id = $this->uri->segment(5, 0);

$vd = $this->Procplan_m->getItemPMCS($id)->result_array();

//$period = $vd[0]['periode'];

foreach ($vd as $k => $v) {
	$this->db->order_by("smbd_code");
	$dats[] = $this->Procplan_m->getPeriodePengadaanPMCS("", $v['smbd_code'])->result_array();
	// $tohead[] = $dats[0][0]['vvk_quest_header'];
}

foreach ($dats[0] as $key => $value) {
	$head[] = $value['periode_pengadaan'];
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
		$isi[$y] = $v['smbd_quantity'];
		//$im[$y] = $v['vvk_imp_score'];
	}
	$satis[$key] = $isi;
	//$imp[$key] = $im;
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
	'item' => $vd,
	'period' => $dats,
	//'imp' => $imp,
	'quantity' => $satis,
	//'period' => $period
];

//$view = 'administration/template_vsi/template_kompilasi/lihat_template_kompilasi_v';
$view = 'procurement/perencanaan_pengadaan/detail_pola_belanja_v';

$this->template($view,"Detail Pola Belanja",$data);