<?php 

  $view = 'procurement/privy_penilaian/get_request_sign_v';

  $data = array();

  $rfqNo = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);
  $privyId = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

  
//get user privy

  $data['id'] = $rfqNo;
  $data['privy'] = $privyId;


  $this->template($view,"E-sign Form",$data);