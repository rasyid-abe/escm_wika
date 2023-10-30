<?php 

$input = json_decode( file_get_contents( 'php://input' ), true );

$error = false;

$project = [
    'kddivisi' => isset($input['kddivisi']) ? $input['kddivisi'] : null,
    'divisiname' => isset($input['divisiname']) ? $input['divisiname'] : null,
    'is_jo' => isset($input['is_jo']) ? $input['is_jo'] : null,
    'kode_spk' => isset($input['kode_spk']) ? $input['kode_spk'] : null,
    'nama_spk' => isset($input['nama_spk']) ? $input['nama_spk'] : null,
    'nama_spk_full' => isset($input['nama_spk_full']) ? $input['nama_spk_full'] : null,
    'lokasi' => isset($input['lokasi']) ? $input['lokasi'] : null,
    'alamatproyek' => isset($input['alamatproyek']) ? $input['alamatproyek'] : null,
    'tgl_mulai' => isset($input['tgl_mulai']) ? $input['tgl_mulai'] : null,
    'tgl_selesai' => isset($input['tgl_selesai']) ? $input['tgl_selesai'] : null,
    'bast1' => isset($input['bast1']) ? $input['bast1'] : null,
    'bast2' => isset($input['bast2']) ? $input['bast2'] : null,
    'omset' => isset($input['omset']) ? $input['omset'] : null,
    'kd_pemilik' => isset($input['kd_pemilik']) ? $input['kd_pemilik'] : null,
    'nm_pemilik' => isset($input['nm_pemilik']) ? $input['nm_pemilik'] : null,
    'sumberdana' => isset($input['sumberdana']) ? $input['sumberdana'] : null,
    'jenisproyek' => isset($input['jenisproyek']) ? $input['jenisproyek'] : null,
    'nip_mp' => isset($input['nip_mp']) ? $input['nip_mp'] : null,
    'manager_proyek' => isset($input['manager_proyek']) ? $input['manager_proyek'] : null,
    'telp_manajer' => isset($input['telp_manajer']) ? $input['telp_manajer'] : null,
    'email_mp' => isset($input['email_mp']) ? $input['email_mp'] : null,
    'iswilayah' => isset($input['iswilayah']) ? $input['iswilayah'] : null,
    'is_pmcs' => isset($input['is_pmcs']) ? $input['is_pmcs'] : null,
    'nomorkontrak' => isset($input['nomorkontrak']) ? $input['nomorkontrak'] : null,
    'sbu' => isset($input['sbu']) ? $input['sbu'] : null,
    'status' => isset($input['status']) ? $input['status'] : null,
    'porsi_wika' => isset($input['porsi_wika']) ? $input['porsi_wika'] : null,
    'jenis_jo' => isset($input['jenis_jo']) ? $input['jenis_jo'] : null,
    //'member' => isset($input['member']) ? (($input['member'] != [] ) ? $input['member'] : null) : null,
    'updated_date' => date("Y-m-d H:i:s"),
    'latitude' => isset($input['latitude']) ? $input['latitude'] : null,
    'longitude' => isset($input['longitude']) ? $input['longitude'] : null
];

if ($project['kode_spk'] == null) {
    $res['kode_spk'] = "Kode SPK harus diisi";
    $error = true;
}
/*
if ($project['longitude'] == null) {
    $res['longitude'] = "Longitude harus diisi";
    $error = true;
}
if ($project['latitude'] == null) {
    $res['latitude'] = "Latitude harus diisi";
    $error = true;
}
*/

if ($error != false) {
    $response   = [
    'status' => FALSE,
        'response'  => 'Gagal',
        'data'      => $res
    ];

    $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); 

}else{

    $insert = $this->Procurementapi_m->insert_project($project);        
    $id['id'] = $insert;
    $result = $id + $project;
    $response   = [
        'status'    => TRUE,
        'response'  => 'Sukses',
        'data'      => $result
    ];
    $this->set_response($response, REST_Controller::HTTP_OK); 
}

?>