<?php 
  $view = 'kontrak/amandemen_v';
  $data = array();
  
  $data['monitor_kontrak_data'] = $this->Contract_m->getMonitorAmandemen()->result();

  $this->template($view,"Monitor Kontrak Amandemen",$data);
?>