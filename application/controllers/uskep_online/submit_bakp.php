<?php

$error = true;

$data = $this->input->post();

if ($this->input->post('nomor_bakp') == NULL) {
    $this->setMessage("Form Nomor BAKP harus diisi");
    $error = false;
}
if ($this->input->post('tgl_bakp') == NULL) {
    $this->setMessage("Form Tanggal harus diisi");
    $error = false;
}

$arr_bakp = [];
$arr_bakp['no_rfq'] = $this->input->post('no_rfq');
$arr_bakp['nomor_bakp'] = $this->input->post('nomor_bakp');
$arr_bakp['tgl_bakp'] = $this->input->post('tgl_bakp');
$arr_bakp['nilai_rab'] = $this->input->post('nilrab');
$arr_bakp['hari'] = $this->input->post('hari');
$arr_bakp['tanggal'] = $this->input->post('tanggal');
$arr_bakp['bulan'] = $this->input->post('bulan');
$arr_bakp['tahun'] = $this->input->post('tahun');
$arr_bakp['fultgl'] = $this->input->post('fultgl');
$arr_bakp['tempat'] = $this->input->post('tempat');
$arr_bakp['daftar'] = $this->input->post('daftar');
$arr_bakp['penawaran'] = $this->input->post('penawaran');
$arr_bakp['status21'] = $this->input->post('statlulus');
$arr_bakp['nilai22'] = $this->input->post('nil22');
$arr_bakp['bobot22'] = $this->input->post('bot22');
$arr_bakp['nego23'] = $this->input->post('neg23');
$arr_bakp['effi23'] = $this->input->post('eff23');
$arr_bakp['nilai23'] = $this->input->post('nil23');
$arr_bakp['bobot23'] = $this->input->post('bot23');
$arr_bakp['nilai24'] = $this->input->post('nil24');
$arr_bakp['rank24'] = $this->input->post('ran24');

$arr_bakp['catatan_tbl1'] = $this->input->post('catatan_tbl1');
$arr_bakp['catatan_tbl21'] = $this->input->post('catatan_tbl21');
$arr_bakp['catatan_tbl22'] = $this->input->post('catatan_tbl22');
$arr_bakp['tatatan_tbl24'] = $this->input->post('tatatan_tbl24');
$arr_bakp['ven_win'] = $this->input->post('ven_win');
$arr_bakp['ven_omZ'] = $this->input->post('ven_omZ');
$arr_bakp['uniq_row_note'] = $this->input->post('uniq_row_note');

$this->db->join('ctr_contract_item', 'ctr_contract_item.contract_id = ctr_contract_header.contract_id', 'left');
$data_contract = $this->db->where('ptm_number', $this->input->post('no_rfq'))->get("ctr_contract_header")->row_array();

// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => BUDGET_URL,
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'GET',
//   CURLOPT_POSTFIELDS =>'{
//         "PRNUM": "' . $data_contract["pr_number_sap"] . '",
//         "PRITM": "' . $data_contract["pr_item_sap"] . '",
//         "PRVAL": "' . (int)$data_contract["contract_amount"] . '",
//         "PRCUR": "' . $data_contract["currency"] . '"
//     }',
//   CURLOPT_HTTPHEADER => array(
//     'Content-Type: application/json',
//     'Authorization: Basic ' . base64_encode('WIKA_INT:Initial123'),
//     'x-requested-with: XMLHttpRequest',
//     'x-xhr-logon: accept="iframe"'
//   ),
// ));

// $response = curl_exec($curl);

// $arrays_data = json_decode($response, true);

// curl_close($curl);

// if (isset($arrays_data["DATA"])) {

//     if ($arrays_data["DATA"][0]["E_STATUS"] != 'OK') {
//         $this->setMessage("EXCED : " . $arrays_data["DATA"][0]["E_EXCED"]);
//         $this->setMessage("AVAIL : " . $arrays_data["DATA"][0]["E_AVAIL"]);
//         $this->setMessage("WBS : " . $arrays_data["DATA"][0]["E_WBS"]);
//         $this->setMessage("PRNUM : " . $arrays_data["DATA"][0]["PRNUM"]);
//         $this->setMessage("PRITM : " . $arrays_data["DATA"][0]["PRITM"]);
//         $this->setMessage("PRVAL : " . number_format($arrays_data["DATA"][0]["PRVAL"]));
//         $this->setMessage("PRCUR : " . $arrays_data["DATA"][0]["PRCUR"]);
//         $this->setMessage("STATUS : " . $arrays_data["DATA"][0]["E_STATUS"]);
//         $this->setMessage("No Data.");
//         $error = false;
//     }

// } else {

//     $this->setMessage("Budget Tidak Tersedia.");
//     $error = false;
// }

$note = $this->input->post('uniq_row_note');
if ($note == NULL) {
    $this->setMessage("Catatan-catatan harus diisi");
    $error = false;
} else {
    $note_poin = $note_sub = [];
    foreach ($note as $key => $value) {
        if ($this->input->post('note_note')[$key] != '') {
            $note_sub['poin'] = $this->input->post('note_note')[$key];
        }
        $note_sub['sub_poin'] = $this->input->post('sub_note_note_'.$note[$key]);

        array_push($note_poin, $note_sub);
    }

    $arr_bakp['note'] = $note_poin;
}

$es = $this->input->post('nm_kew');


$arr_esign = [];
if (!isset($es)) {
    $this->setMessage("E-Sign Kewenangan harus disii.");
    $error = false;
} else {
    $nnes = 0;
    foreach ($es as $key => $value) {
        $value != '' ? $nnes++ : '';
    }

    if (count($es) !== $nnes) {
        $this->setMessage("E-Sign Kewenangan harus disii semua.");
        $error = false;
    } else {
        $nip = $nmkew = $job_title = [];
        foreach ($this->input->post('nm_kew') as $k => $v) {
            $item = explode("_",$v);
            $nip[] = $item[0];
            $nmkew[] = $item[1];
            $job_title[] = $item[2];
        }

        $arr_esign['nm_kew'] = $nmkew;
        $arr_esign['nip'] = $nip;
        $arr_esign['job_title'] = $job_title;
        $arr_esign['kategori'] = $this->input->post('kategori');
        $arr_esign['posisi'] = $this->input->post('posisi');
    }

}

$arr_input = [
    'esign_bakp' => json_encode($arr_esign),
    'data_bakp' => json_encode($arr_bakp),
    'date_updated' => date("Y-m-d H:i:s"),
    'updated_by' => $this->data['userdata']['employee_id'],
];

if ($error) {
    $this->db->where('no_rfq', $this->input->post('no_rfq'));
    if ($this->db->update("uskep_online", $arr_input)) {
        $error = true;
    }
}

$pss = $this->input->post();

if($error){
    // $this->setMessage("Data BAKP Berhasil Disimpan.");
    // $this->setMessage("PRNUM : " . $arrays_data["DATA"][0]["PRNUM"]);
    // $this->setMessage("PRITM : " . $arrays_data["DATA"][0]["PRITM"]);
    // $this->setMessage("PRVAL : " . number_format($arrays_data["DATA"][0]["PRVAL"]));
    // $this->setMessage("PRCUR : " . $arrays_data["DATA"][0]["PRCUR"]);
    // $this->setMessage("STATUS : " . $arrays_data["DATA"][0]["E_STATUS"]);
    // $this->setMessage("WBS : " . $arrays_data["DATA"][0]["E_WBS"]);
    // $this->setMessage("AVAIL : " . $arrays_data["DATA"][0]["E_AVAIL"]);
    // $this->setMessage("EXCED : " . $arrays_data["DATA"][0]["E_EXCED"]);
    if (array_key_exists('is_sap',$pss)) {
        if (array_key_exists('is_cid',$pss)) {
            $this->renderMessage("sucess", site_url("contract/daftar_pekerjaan/edit/" . $pss['is_cid']));
        } else {
            $this->renderMessage("sucess", site_url("contract/manual_sap"));
        }
    } else {
        $this->renderMessage("sucess", site_url("contract/manual"));
    }
} else {
    $this->renderMessage("error");
}
