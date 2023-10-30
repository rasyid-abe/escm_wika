<?php 
//startcode_hlmifzi
  $view = 'laporan/lap_klasifikasi_vendor_v';

  $this->session->unset_userdata("vendor_name");
  $data = array(

      'jumlah' =>1,

    );

  $this->template($view,"Laporan Klasifikasi Vendor",$data);