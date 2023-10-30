<?php

$error = true;

$pengadaan = $this->input->post('paketPengadaan');
$proyek = $this->input->post('project');
$no_rfq = $this->input->post('nomor_rfq');
$vendor = $this->input->post('vendor_list');

if ($pengadaan == NULL){
    $this->setMessage("Paket pengadaan harus diisi!");
    $error = false;
}
if ($proyek == NULL) {
    $this->setMessage("Proyek harus diisi!");
    $error = false;
}


// get administrasi
$arr_adm = $arr_poin_adm = $arr_admin = [];
$adm_uniq = $this->input->post('adm_uniq');
if ($adm_uniq == NULL){
    $this->setMessage("Section Administrasi harus diisi dengan benar");
    $error = false;
} else {
    $arr_admin['status_vendor'] = $this->input->post('status_adm_vendor');
    foreach ($adm_uniq as $k => $v) {
        $arr_vendor_adm = [];
        for ($j=0; $j < count($vendor); $j++) {
            $admpil = $this->input->post('adm_pilihan_'.$j.'_'.$v);
            $adp = 0;
            foreach ($admpil as $key => $value) {
                $value != '' ? $adp++ : '';
            }
            if (count($admpil) !== $adp) {
                $this->setMessage("Pilihan Poin Administrasi harus diisi semua.");
                $error = false;
            } else {
                $arr_vendor_adm[] = $this->input->post('adm_pilihan_'.$j.'_'.$v);
            }
        }

        $arr_adm['title'] = $this->input->post('administrasi_poin_'.$v);

        $pointext = $this->input->post('sub_administrasi_poin_text_'.$v);
        $admpt = 0;
        foreach ($pointext as $ak => $av) {
            $av != '' ? $admpt++ : '';
        }
        if (count($pointext) !== $admpt) {
            $this->setMessage("Data Sub Poin Administrasi harus diisi semua.");
            $error = false;
        } else {
            $arr_adm['sub'] = $this->input->post('sub_administrasi_poin_text_'.$v);
        }

        $poinbobot = $this->input->post('sub_administrasi_poin_bobot_'.$v);
        $admpb = 0;
        foreach ($poinbobot as $bk => $bv) {
            $bv != '' ? $admpb++ : '';
        }
        if (count($poinbobot) !== $admpb) {
            $this->setMessage("Data Sub Poin Administrasi Bobot harus diisi semua.");
            $error = false;
        } else {
            $arr_adm['bobot'] = $this->input->post('sub_administrasi_poin_bobot_'.$v);
        }
        $arr_adm['vendor'] = $arr_vendor_adm;

        array_push($arr_poin_adm, $arr_adm);
    }
    $arr_admin['poin'] = $arr_poin_adm;
}

// get teknis
$arr_tek = $arr_poin_tek = $arr_sub_tek = $arr_teknis = [];
$tek_uniq = $this->input->post('tekuniq');
if ($tek_uniq == NULL) {
    $this->setMessage("Section Teknis harus diisi dengan benar");
    $error = false;
} else {
    $arr_teknis['percent_teknis'] = $this->input->post('teknis_percent');
    $arr_teknis['threshold'] = $this->input->post('threshold_tek');
    $arr_teknis['nilai'] = $this->input->post('nilai_tek');
    $arr_teknis['bobot'] = $this->input->post('bobot_tek');
    $arr_teknis['status'] = $this->input->post('status_tek_vendor');

    foreach ($tek_uniq as $ke => $va) {
        $arr_tek['title'] = $this->input->post('teknis_point_'.$va);
        $arr_tek['bobot'] = $this->input->post('teknis_percent_'.$va);

        $vend_imtek = $arr_imtek = [];
        for ($j=0; $j < count($vendor); $j++) {
            $vend_imtek[] = $this->input->post('teknis_head_vend_'.$j.'_'.$va);
        }

        $thvn = 0;
        foreach ($vend_imtek as $e => $l) {
            (($l != '') && ($l > 0)) ? $thvn++ : '';
        }
        if (count($vend_imtek) !== $thvn) {
            $this->setMessage("Form Nilai Teknis harus diisi semua.");
            $error = false;
        } else {
            $arr_tek['input'] = $vend_imtek;
        }

        $arr_h = $arr_has = [];
        for ($aa=0; $aa < count($vendor); $aa++) {
            $arr_h[] = $this->input->post('hasil_poin_'.$aa.'_'.$va);
        }
        // if ($this->input->post('edit_f') == NULL) {
        //     for ($k=0; $k < count($vendor); $k++) {
        //         $arr_h[] = explode(',', $this->input->post('hasil_poin_'.$k)[0])[$ke];
        //     }
        // } else {
        //     for ($k=0; $k < count($vendor); $k++) {
        //         $arr_h[] = $this->input->post('hasil_poin_'.$k)[$ke];
        //     }
        // }
        $arr_tek['hasil'] = $arr_h;

        $puttext = $this->input->post('putusan_text_'.$va);
        $pttex = 0;
        foreach ($puttext as $k => $v) {
            $v != '' ? $pttex++ : '';
        }
        if (count($puttext) !== $pttex) {
            $this->setMessage("Data Sub Judul Teknis harus diisi semua.");
            $error = false;
        } else {
            $arr_sub_tek['sub_poin'] = $this->input->post('putusan_text_'.$va);
        }

        $putbot = $this->input->post('putusan_bobot_'.$va);
        $pubb = 0;
        foreach ($putbot as $k => $v) {
            $v != '' ? $pubb++ : '';
        }
        if (count($putbot) !== $pubb) {
            $this->setMessage("Data Bobot Sub Judul Teknis harus diisi semua.");
            $error = false;
        } else {
            $arr_sub_tek['sub_bobot'] = $this->input->post('putusan_bobot_'.$va);
        }

        $arr_tek['sub'] = $arr_sub_tek;

        array_push($arr_poin_tek, $arr_tek);
    }
    $arr_teknis['poin'] = $arr_poin_tek;
}

// get harga
$arr_harga = [];
$arr_harga['percent_harga'] = $this->input->post('percent_harga');

$nhps = $this->input->post('nilai_hps');
if ($nhps == '') {
    $this->setMessage("Form Nilai HPS harus diisi.");
    $error = false;
} else {
    $arr_harga['nilai_hps'] = $this->input->post('nilai_hps');
}

$arr_harga['nilai'] = $this->input->post('nilnil_vend');
$arr_harga['bobot'] = $this->input->post('botbot_vend');

$nfinal = $this->input->post('nego_final_vend');
$nfinn = 0;
foreach ($nfinal as $k => $v) {
    $v != '' ? $nfinn++ : '';
}
if (count($nfinal) !== $nfinn) {
    $this->setMessage("Form Harga Negosiasi Final harus diisi Semua.");
    $error = false;
} else {
    $arr_harga['harga_nego'] = $this->input->post('nego_final_vend');
}

$arr_harga['deviasi'] = $this->input->post('defdef_vend');
$arr_harga['evaluasi'] = $this->input->post('evaeva_vend');
$arr_harga['peringkat'] = $this->input->post('rankrank_vend');


$arr_dsp = [];
$arr_dsp['no_rfq'] = $no_rfq;
$arr_dsp['proyek'] = $proyek;
$arr_dsp['administrasi'] = $arr_admin;
$arr_dsp['teknis'] = $arr_teknis;
$arr_dsp['harga'] = $arr_harga;

$arr_dsp['tipe_plan'] = $this->input->post('tipe_plan');
$arr_dsp['komisi_'] = $this->input->post('komisi_');

// echo "<pre>";
// print_r($arr_dsp);
// die;

$arr_esign = [];
if ($this->input->post('nm_kew') == '') {
    $this->setMessage("Nama E-Sign harus dipilih.");
    $error = false;
} else {
    $arr_esign['kegiatan_id'] = $this->input->post('keg_id');
    $arr_esign['nama'] = $this->input->post('nm_kew');
    $arr_esign['nip'] = $this->input->post('nipemploy');
    $arr_esign['hp'] = $this->input->post('hpemploy');
    $arr_esign['fun_bidang'] = $this->input->post('fun_bidang');
    $arr_esign['job_title'] = $this->input->post('job_title');
    $arr_esign['tempat'] = $this->input->post('tempat');
    $arr_esign['tanggal'] = $this->input->post('tanggal_ttd');
}

$send = [$proyek, $pengadaan, $vendor, $no_rfq];

$pss = $this->input->post();
$sap = 0;
$proyekk = $this->db->get_where('project_info', ['kode_spk' => $proyek])->row('nama_spk');
if (array_key_exists('is_sap',$pss)) {
    $sap = 1;
    $proyekk = $this->db->get_where('prc_plan_main', ['ppm_project_id' => $proyek])->row('ppm_subject_of_work');
}
$arr_input = [
    'paket_pengadaan' => $pengadaan,
    'proyek' => $proyekk,
    'no_rfq' => $no_rfq,
    'vendor' => json_encode($vendor),
    'data_dsp' => json_encode($arr_dsp),
    'esign_dsp' => json_encode($arr_esign),
    'date_created' => date("Y-m-d H:i:s"),
    'created_by' => $this->data['userdata']['employee_id'],
    'win_type' => $this->input->post('twin'),
    'is_sap' => $sap,
    'metode_pengadaan' => isset($pss['metode_pengadaan']) ? $pss['metode_pengadaan'] : '',
];

// echo "<pre>";
// print_r($arr_input);
// die;


if ($error) {
    if (!array_key_exists('edit_f',$pss)) {
        if ($this->db->insert("uskep_online", $arr_input)) {
            $error = true;
        }
    } else {
        $this->db->where('no_rfq', $no_rfq);
        if ($this->db->update("uskep_online", $arr_input)) {
            $error = true;
        }
    }
}

// echo "<pre>";
// print_r($pss);
// die;

if($error){
    if (array_key_exists('edit_f',$pss)) {
        $this->setMessage("Data DSP berhasil diubah!");
        if (array_key_exists('is_sap',$pss)) {
            $this->renderMessage("sucess", site_url("uskep_online_sap/dpkn/?data=".json_encode($send)));
        } else {
            $this->renderMessage("sucess", site_url("contract/manual"));
        }
    } else {
        $this->setMessage("Data DSP berhasil diinput!");
        if (array_key_exists('is_sap',$pss)) {
            $this->renderMessage("sucess", site_url("uskep_online_sap/dpkn/?data=".json_encode($send)));
        } else {
            $this->renderMessage("sucess", site_url("uskep_online/dpkn/?data=".json_encode($send)));
        }
    }
} else {
    $this->renderMessage("error");
}
