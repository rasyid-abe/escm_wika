<?php 
  $get = $this->input->get();
  $view = 'commodity/mat_catalog_sumberdaya/picker_mat_catalog_smbd_v';
  $data = array();
  
  if (isset($get['type'])) {
  	$data['type'] = $get['type'];
  }
  
  $this->load->view($view,$data);
?>