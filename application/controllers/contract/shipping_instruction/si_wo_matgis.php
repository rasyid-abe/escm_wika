<?php
$this->session->unset_userdata("contract_id");
$this->session->unset_userdata("ptm_number");
  $view = 'contract/shipping_instruction/si_wo_matgis_v';
  $data = array();
  $this->template($view,"Pembuatan Shipping Instruction",$data);
?>
