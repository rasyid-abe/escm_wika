<?php 
//startcode_hlmifzi
  $view = 'laporan/monitor_dokumen_vendor/daftar_dokumen_vendor_v';

  $data = array(
      'expired' => $expired,
      'jumlah' =>1,

    );

  $this->template($view,"Monitoring Dokumen Vendor",$data);