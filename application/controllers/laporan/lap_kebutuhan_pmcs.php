<?php 

  $view = 'laporan/lap_kebutuhan_pmcs_v';

  $this->session->unset_userdata("vendor_name");
  $data = array();

  $this->template($view,"Laporan Kebutuhan PMCS",$data);