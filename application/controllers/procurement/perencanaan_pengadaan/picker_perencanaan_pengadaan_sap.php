<?php 

	$view = 'procurement/perencanaan_pengadaan/picker_perencanaan_pengadaan_sap_v';
	$data = array();

	$userdata = $this->data['userdata'];
	
	if($userdata['type_proyek'] == 'Matgis') {
		$data['url'] = site_url('procurement/data_perencanaan_pengadaan/sap_matgis');
	} else {
		$data['url'] = site_url('procurement/data_perencanaan_pengadaan/sap');
	}
	
	$this->load->view($view,$data);
	
?>