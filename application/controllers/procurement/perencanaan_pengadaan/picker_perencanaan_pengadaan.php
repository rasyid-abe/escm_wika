<?php 

	$view = 'procurement/perencanaan_pengadaan/picker_perencanaan_pengadaan_v';
	$data = array();
	$matgis = $this->input->get('matgis');

	if (isset($matgis)) {
		$data['matgis'] = $matgis;
		$data['url'] = site_url('procurement/data_perencanaan_pengadaan/matgis');
	} else {
		$data['url'] = site_url('procurement/data_perencanaan_pengadaan/approved');
	}

	$this->load->view($view,$data);
	
?>