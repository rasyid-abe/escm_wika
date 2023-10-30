<?php 

$response = [
        'proyek_id' =>  1315,
        'proyek_name' =>  "Penyelidikan tanah/Soil Investigation HSR vol.1962 ttk",
        'proyek_shortname' =>  "Soil Investigasi HSR vol. 1962 ttk",
        'kode_departemen' =>  39,
        'spk_intern_no' =>  "H28B02 *",
        'spk_intern_date' =>  null,
        'spk_extern_no' =>  "0407/DIR/KCIC/01.17",
        'spk_extern_date' =>  "2017-02-10",
        'contract_no' =>  "0053/CA-4/KCIC/22.03.17",
        'contract_date' =>  "2017-03-22",
        'contract_value_idr' =>  "246819981000.0000",
        'sbu_id' => 28,
        'pemberi_kerja_name' => "KERETA CEPAT INDONESIA CHINA, PT",
        'pemberi_kerja_intern' => null,
        'mp_name' =>  "MOCH. ARIFIN",
        'mp_nip' =>  "ES962049",
        'mp_phone' =>  "628159361720",
        'mp_email' =>  "arifin@wikamail.id",
        'job_type' =>  "Penyelidikan Tanah",
        'address' => null,
        'country_id' =>  "ID",
        'province_id' =>  "ID-JB",
        'latitude' =>  "-6.30792300 *",
        'longitude' =>  "107.17208500 *",
        'start_date' => "2017-07-25",
        'finish_date' => "2018-03-31"
	];
        
$this->set_response($response, REST_Controller::HTTP_OK); 

?>