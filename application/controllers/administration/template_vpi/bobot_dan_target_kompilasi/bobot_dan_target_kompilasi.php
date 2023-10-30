<?php 

  $view = 'administration/template_vpi/bobot_dan_target_kompilasi/bobot_dan_target_kompilasi_v';

  $data = array();

  $get_data = $this->Administration_m->getTargetdanBobotKompilasiVPI()->result_array();
  $data['current_data'] = [];
  $arrayNew = array();

  foreach ($get_data as $key => $value) {
  	$arrayNew[$value['abt_indicator']] = array('abt_value' => str_replace('.', ',', $value['abt_value'])); 
  }
  array_push($data['current_data'] , $arrayNew);
  
$this->template($view,"Bobot dan Target Kompilasi",$data);
