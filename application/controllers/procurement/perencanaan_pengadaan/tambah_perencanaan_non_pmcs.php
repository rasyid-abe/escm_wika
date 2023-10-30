<?php
  $view = 'procurement/perencanaan_pengadaan/tambah_perencanaan_non_pmcs_v';

	$data['actionPostMatgis'] = site_url()."/procurement/perencanaan_pengadaan/submit_data_perencanaan_non_pmcs";

  $data['curr'] = $this->Procurement_m->get_curr();
	$data['emp'] = $this->Procurement_m->get_employee();
	$data['item_matgis'] = $this->Procurement_m->get_item_matgis();

	$data['master_matgis'] = $this->Procurement_m->get_matgis();

  $this->template($view,"Tambah Data Perencanaan Pengadaan Non PMCS", $data);
?>
