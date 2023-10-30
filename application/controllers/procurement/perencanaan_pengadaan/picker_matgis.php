<?php 
$view = 'procurement/perencanaan_pengadaan/picker_matgis_v';
$data = array('spk_code'=>null,'last_item_code'=>null);
$spk_code = $this->input->get('spk_code');
if (isset($spk_code)) {
	$data['spk_code'] = $spk_code;
}
$last_item_code = $this->input->get('last_item_code');
if (isset($last_item_code)) {
	$data['last_item_code'] = $last_item_code;
}
$this->load->view($view,$data);
?>