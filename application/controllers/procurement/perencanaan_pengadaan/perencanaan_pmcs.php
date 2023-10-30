<?php
  $view = 'procurement/perencanaan_pengadaan/perencanaan_pmcs_v';

	$data['data_pmcs'] = json_encode($this->Procurement_m->get_data_pmcs());
  // $data['syncron'] = $this->Procurement_m->syncron();
  $data = array("edit"=>false,"view"=>true);
  $this->template($view,"Rencana Pengadaaan Proyek (PMCS)", $data);
?>
