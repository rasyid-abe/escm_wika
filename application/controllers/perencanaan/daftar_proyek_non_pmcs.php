<?php

	$view = 'perencanaan/daftar_proyek_non_pmcs_v';

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

	$fullPath = dir(getcwd());

	$cookie_jar = $fullPath->path . '\assets\crmtmp.tmp';

	$BPMCSRF = isset($_COOKIE['BPMCSRF']) ? $_COOKIE['BPMCSRF'] : '1';

	curl_setopt($ch_info, CURLOPT_COOKIEFILE, $cookie_jar);
	curl_setopt($ch_info, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch_info, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch_info, CURLOPT_POST, true);
	curl_setopt($ch_info, CURLOPT_POSTFIELDS, $payload_info);
	curl_setopt($ch_info, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'BPMCSRF:'. $BPMCSRF)
	);

	$result_info = curl_exec($ch_info);

	$value = json_decode($result_info, true);

	// $data['getCrm'] = $value['GetProyekSCMInfoResult']['Data'];
	$data['year'] = $year;

	$data['edit'] = false;
	$data['view'] = true;

  	$this->template($view, "Pembuatan Proyek (Non PMCS)", $data);
?>
