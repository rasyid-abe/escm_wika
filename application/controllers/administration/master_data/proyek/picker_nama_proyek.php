<?php
  $view = 'administration/master_data/proyek/picker_nama_proyek_v';
  $data = array();

  $ch_info = curl_init( CRM_WIKA_INFO );

	$post = $this->input->post();

	$year = date('Y');

	if(isset($post['periode_inp'])){
		$year = $post['periode_inp'];
	}

	$data_info = array(
		'Tahun' => $year
	);

	$payload_info = json_encode( $data_info );

	// $fullPath = dir(getcwd());
    //
	// $cookie_jar = $fullPath->path . '\assets\crmtmp.tmp';
    //
	// $BPMCSRF = isset($_COOKIE['BPMCSRF']) ? $_COOKIE['BPMCSRF'] : '1';
    //
	// curl_setopt($ch_info, CURLOPT_COOKIEFILE, $cookie_jar);
	// curl_setopt($ch_info, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch_info, CURLINFO_HEADER_OUT, true);
	// curl_setopt($ch_info, CURLOPT_POST, true);
	// curl_setopt($ch_info, CURLOPT_POSTFIELDS, $payload_info);
	// curl_setopt($ch_info, CURLOPT_HTTPHEADER, array(
	// 	'Content-Type: application/json',
	// 	'BPMCSRF:'. $this->session->userdata('BPMCSRF'))
	// );
    //
	// $result_info = curl_exec($ch_info);
    //
	// $value = json_decode($result_info, true);
    $bpmcsrf = $this->Administration_m->sync();
    $result_info = $this->Administration_m->get_data_api_crm($payload_info, $bpmcsrf);

    $value = json_decode($result_info, true);
    

	$data['getCrm'] = $value != '' ? $value['GetProyekSCMInfoResult']['Data'] : [];
	$data['year'] = $year;

  $this->load->view($view,$data);
?>
