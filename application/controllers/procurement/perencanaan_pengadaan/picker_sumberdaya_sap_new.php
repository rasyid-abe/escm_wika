<?php
  $view = 'procurement/perencanaan_pengadaan/picker_sumberdaya_sap_new_v';
  $data = array();
  $spk_code = $this->input->get('spk_code');
  if (isset($spk_code)) {
	  $data['spk_code'] = $spk_code;
  }
  $this->load->view($view,$data);
?>
