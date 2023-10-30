<?php 

  $view = 'mandor/daftar_seluruh_mandor_v';

  $data = array(

      'jumlah' =>1,

    );
  $userdata = $this->data['userdata'];

  if ($userdata['job_title'] == 'PENGELOLA VENDOR') {
  	$data['sync_btn'] = true;
  }
  
  $this->template($view,"Daftar Seluruh Mandor",$data);