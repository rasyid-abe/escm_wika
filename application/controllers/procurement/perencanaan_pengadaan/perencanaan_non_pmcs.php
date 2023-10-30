<?php
  $view = 'procurement/perencanaan_pengadaan/perencanaan_non_pmcs_v';

	$data['data_matgis'] = json_encode($this->Procurement_m->get_data_matgis());
  $data = array("edit"=>false,"view"=>true);
  $this->template($view,"Perencanaan Pengadaan Non PMCS",$data);
?>
