<?php

	$view = 'procurement/perencanaan_pengadaan/picker_perencanaan_pengadaan_sap_v';
	$data = array();

	$data['url'] = site_url('procurement/data_perencanaan_pengadaan/sap_nonproyek');

	$this->load->view($view,$data);

?>
