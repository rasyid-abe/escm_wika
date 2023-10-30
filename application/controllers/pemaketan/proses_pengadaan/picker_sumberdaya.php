<?php 
  $view = 'pemaketan/matgis/picker_sumberdaya_v';
  $data = array();
  $spk_code = $this->input->get('spk_code');
  if (isset($spk_code)) {
	  $data['spk_code'] = $spk_code;
  }
  $this->load->view($view,$data);
?>
