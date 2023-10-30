<?php

  $view = 'administration/master_data/data_crm/data_crm_v';


  $data = array();

  $post = $this->input->post();

  $year = date('Y');

  if(isset($post['periode_inp'])){
      $year = $post['periode_inp'];
  }

  $data_info = array(
      'Tahun' => $year
  );

  $payload_info = json_encode( $data_info );
  $bpmcsrf = $this->Administration_m->sync();
  $result_info = $this->Administration_m->get_data_api_crm($payload_info, $bpmcsrf);

  $value = json_decode($result_info, true);


  $data['getCrm'] = $value != '' ? $value['GetProyekSCMInfoResult']['Data'] : [];
  $data['year'] = $year;

  $data['edit'] = false;
  $data['view'] = true;

  $this->template($view,"Data CRM",$data);
