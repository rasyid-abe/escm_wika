<?php
$this->session->unset_userdata("contract_id");
$this->session->unset_userdata("ptm_number");
  $view = 'contract/monitor_matgis/monitor_wo_matgis_v';
  $data = array();
  $this->template($view,"Monitor WO Matgis",$data);
?>
