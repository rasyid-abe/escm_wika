<?php 

$input = $this->input->post();
$project = [
    'proyek_id' => isset($input['proyek_id']) ? $input['proyek_id'] : null, // 1315,
    'proyek_name' => isset($input['proyek_name']) ? $input['proyek_name'] : null, //: "Penyelidikan tanah/Soil Investigation HSR vol.1962 ttk",
    'proyek_shortname' => isset($input['proyek_shortname']) ? $input['proyek_shortname'] : null, //: "Soil Investigasi HSR vol. 1962 ttk",
    'kode_departemen' => isset($input['kode_departemen']) ? $input['kode_departemen'] : null, //: 39,
    'spk_intern_no' => isset($input['spk_intern_no']) ? $input['spk_intern_no'] : null, //: "H28B02",
    'spk_intern_date' => isset($input['spk_intern_date']) ? (($input['spk_intern_date'] != '') ? $input['spk_intern_date'] : null)  : null, //: null,
    'spk_extern_no' => isset($input['spk_extern_no']) ? $input['spk_extern_no'] : null, //: "0407/DIR/KCIC/01.17",
    'spk_extern_date' => isset($input['spk_extern_date']) ? (($input['spk_extern_date'] != '') ? $input['spk_extern_date'] : null)  : null, //: "2017-02-10",
    'contract_no' => isset($input['contract_no']) ? $input['contract_no'] : null, //: "0053/CA-4/KCIC/22.03.17",
    'contract_date' => isset($input['contract_date']) ? $input['contract_date'] : null, //: "2017-03-22",
    'contract_value_idr' => isset($input['contract_value_idr']) ? $input['contract_value_idr'] : null, //: "246819981000.0000",
    'sbu_id' => isset($input['sbu_id']) ? $input['sbu_id'] : null, //28,
    'pemberi_kerja_name' => isset($input['pemberi_kerja_name']) ? $input['pemberi_kerja_name'] : null, //: "KERETA CEPAT INDONESIA CHINA, PT",
    'pemberi_kerja_intern' => isset($input['pemberi_kerja_intern']) ? $input['pemberi_kerja_intern'] : null, // null,
   	'mp_name' => isset($input['mp_name']) ? $input['mp_name'] : null, //: "MOCH. ARIFIN",
    'mp_nip' => isset($input['mp_nip']) ? $input['mp_nip'] : null, //: "ES962049",
    'mp_phone' => isset($input['mp_phone']) ? $input['mp_phone'] : null, //: "628159361720",
    'mp_email' => isset($input['mp_email']) ? $input['mp_email'] : null, //: "arifin@wikamail.id",
    'job_type' => isset($input['job_type']) ? $input['job_type'] : null, //: "Penyelidikan Tanah",
    'address' => isset($input['address']) ? $input['address'] : null, //null,
    'country_id' => isset($input['country_id']) ? $input['country_id'] : null, //: "ID",
    'province_id' => isset($input['province_id']) ? $input['province_id'] : null, //: "ID-JB",
    'latitude' => isset($input['latitude']) ? $input['latitude'] : null, //: "-6.30792300",
    'longitude' => isset($input['longitude']) ? $input['longitude'] : null, //: "107.17208500",
    'start_date' => isset($input['start_date']) ? (($input['start_date'] != '') ? $input['start_date'] : null)  : null, //: "2017-07-25",
    'finish_date' => isset($input['finish_date']) ? (($input['finish_date'] != '') ? $input['finish_date'] : null)  : null, //: "2018-03-31"
    'klasifikasi' => isset($input['klasifikasi_name']) ? (($input['klasifikasi_name'] != '') ? $input['klasifikasi_name'] : null)  : null,
    'kode_spk_sap' => isset($input['profit_center']) ? (($input['profit_center'] != '') ? $input['profit_center'] : null)  : null
    
];

$insert = $this->Procurementapi_m->insert_project($project);		
$id['project_id'] = $insert;
$result = $id + $project;

if ($insert) {
	$response 	= [
		'status'	=> 200,
		'response'	=> 'Success',
		'data' 		=> $result
	];
	$this->set_response($response, REST_Controller::HTTP_OK); 
}else{
	$response 	= [
		'status'	=> 500,
		'response'	=> 'Internal server error',
		'data' 		=> $project
	];
	$this->set_response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR); 
}

?>