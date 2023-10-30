<?php
$this->session->unset_userdata("contract_id");
$this->session->unset_userdata("ptm_number");
  $view = 'contract/sppm/sppm_wo_matgis_v';
  $data = array();
  $this->template($view,"Pembuatan SPPM",$data);
?>
