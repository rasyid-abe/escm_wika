<?php

// echo "<pre>";
// print_r($this->input->post());
// die;

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

// $arr_esign = [];

// if ($this->input->post('name_esign') == NULL && $this->input->post('sebagai_esign') == NULL && $this->input->post('kategori_esign') == NULL) {
//     $this->setMessage("E-Sign harus diisi dengan benar");
//     $error = false;
// } else {
// $arr_esign['nm_kew'] = $this->input->post('nm_kew');
// $arr_esign['fungsi_bidang'] = $this->input->post('fungsi_bidang');
// $arr_esign['job_title'] = $this->input->post('job_title');
// $arr_esign['kategori'] = $this->input->post('kategori');
// $arr_esign['posisi'] = $this->input->post('posisi');
// }
// echo "<pre>";
// print_r($arr_bakp);
// die;
$arr_input = [
    'data_bakp' => json_encode($arr_bakp),
    // 'esign_bakp' => json_encode($arr_esign),
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
    $this->setMessage("Data BAKP berhasil diinput!");
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
