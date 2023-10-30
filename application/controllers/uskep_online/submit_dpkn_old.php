<?php
$error = true;

$po = $this->input->post();

echo "<pre>";
print_r($po);
die;

$vend = $this->input->post('penawaran_tgl');

$arr_dpkn = [];
$arr_dpkn['no_rfq'] = $this->input->post('rfq_no');
$arr_dpkn['pengadaan'] = $this->input->post('Pengadaan');
$arr_dpkn['proyek'] = $this->input->post('proyek');
$arr_dpkn['tgl_penawaran'] = $this->input->post('penawaran_tgl');

$tglp =  $this->input->post('penawaran_tgl');
$ntglp = 0;
foreach ($tglp as $key => $value) {
    $value != '' ? $ntglp++ : '';
}
if (count($tglp) !== $ntglp) {
    $this->setMessage("Penawaran No. / Tanggal harus diisi semua.");
    $error = false;
} else {
    $arr_dpkn['tgl_penawaran'] = $this->input->post('penawaran_tgl');
}

$kkl =  $this->input->post('klarifikasi_nego');
$nkkl = 0;
foreach ($kkl as $key => $value) {
    $value != '' ? $nkkl++ : '';
}
if (count($kkl) !== $nkkl) {
    $this->setMessage("BA Klarifikasi dan Negosiasi harus diisi semua.");
    $error = false;
} else {
    $arr_dpkn['klarifikasi_nego'] = $this->input->post('klarifikasi_nego');
}


$penawaran = $this->input->post('text_pen');
if ($penawaran != '') {
    $nptex = 0;
    foreach ($penawaran as $k => $v) {
        $v != '' ? $nptex++ : '';
    }
    if (count($penawaran) !== $nptex) {
        $this->setMessage("Data Penawaran harus diisi semua.");
        $error = false;
    } else {
        $arr_poin_pen = $arr_pen =[];
        foreach ($penawaran as $key => $value) {
            $arr_pen['poin'] = $value;
            $arr_pen['pr'] = $this->input->post('pr_pen')[$key];
            $arr_pen['satuan'] = $this->input->post('sat_pen')[$key];
            $arr_pen['volume'] = $this->input->post('vol_pen')[$key];
            $arr_pen['harga_satuan'] = $this->input->post('hrg_sat_pen')[$key];
            $arr_pen['total_harga'] = $this->input->post('harga_pen')[$key];

            $arr_pen_sat = [];
            foreach ($vend as $k => $val) {
                $arr_pen_sat[] = $this->input->post('hrg_sat_pen_vend_'.$k)[$key];
            }
            $arr_pen['vendor_sat'] = $arr_pen_sat;

            $arr_pen_hrg = [];
            foreach ($vend as $k => $val) {
                $arr_pen_hrg[] = $this->input->post('harga_pen_vend_'.$k)[$key];
            }

            $arr_pen['vendor_hrg'] = $arr_pen_hrg;
            array_push($arr_poin_pen, $arr_pen);
        }

        $arr_dpkn['poin_penawaran'] = $arr_poin_pen;
        $arr_dpkn['total_rab'] = $this->input->post('total_rbap');
        $arr_dpkn['total_penawaran_vendor'] = $this->input->post('total_ppen');
    }
} else {
    $this->setMessage("Data Pekerjaan / Spesifikasi (Penawaran) harus diisi.");
    $error = false;
}

$nego = $this->input->post('text_nego');
if ($nego != '') {
    $nneg = 0;
    foreach ($nego as $k => $v) {
        $v != '' ? $nneg++ : '';
    }
    if (count($nego) !== $nneg) {
        $this->setMessage("Data Negosiasi harus diisi semua.");
        $error = false;
    } else {
        $arr_poin_neg = $arr_neg = [];
        foreach ($penawaran as $key => $value) {
            $arr_neg['poin'] = $value;
            $arr_neg['pr'] = $this->input->post('pr_pen')[$key];
            $arr_neg['satuan'] = $this->input->post('sat_pen')[$key];
            $arr_neg['volume'] = $this->input->post('vol_pen')[$key];
            $arr_neg['harga_satuan'] = $this->input->post('hrg_sat_pen')[$key];
            $arr_neg['total_harga'] = $this->input->post('harga_pen')[$key];

            $arr_nego_sat = [];
            foreach ($vend as $k => $val) {
                $arr_nego_sat[] = $this->input->post('hrg_sat_nego_vend_'.$k)[$key];
            }
            $arr_neg['vendor_sat'] = $arr_nego_sat;

            $arr_nego_hrg = [];
            foreach ($vend as $k => $val) {
                $arr_nego_hrg[] = $this->input->post('harga_nego_vend_'.$k)[$key];
            }

            $arr_neg['vendor_hrg'] = $arr_nego_hrg;

            array_push($arr_poin_neg, $arr_neg);
        }

        $arr_dpkn['poin_negosiasi'] = $arr_poin_neg;
        $arr_dpkn['total_negosiai_vendor'] = $this->input->post('total_ppeneg');
    }
} else {
    $this->setMessage("Data Pekerjaan / Spesifikasi (Negosiasi) harus diisi.");
    $error = false;
}

$klar = $this->input->post('poin_klarifikasi');
if ($klar != '') {
    $nklar = 0;
    foreach ($klar as $k => $v) {
        $v != '' ? $nklar++ : '';
    }
    if (count($klar) !== $nklar) {
        $this->setMessage("Data Klarifikasi harus diisi semua.");
        $error = false;
    } else {
        $arr_poin_klar = $arr_klar = [];
        foreach ($klar as $i => $v) {
            $arr_klar['poin'] = $v;
            // $arr_klar['rabp'] = $this->input->post('klar_rabp')[$i];

            $arr_klar_vend = $klar_2= [];
            foreach ($vend as $j => $va) {
                $arr_klar_vend[] = $this->input->post('klar_per_vend'.$j)[$i];

            }

            $arr_klar['vendor'] = $arr_klar_vend;
            array_push($arr_poin_klar, $arr_klar);
        }

        $arr_dpkn['klarifikasi'] = $arr_poin_klar;
    }
} else {
    $this->setMessage("Data Klarifikasi harus diisi.");
    $error = false;
}

if ($this->input->post('note') != '') {
    $arr_dpkn['catatan'] = $this->input->post('note');
} else {
    $arr_dpkn['catatan'] = [];
}

$arr_dpkn['keg_id'] = $this->input->post('keg_id');
$arr_dpkn['tipe_plan'] = $this->input->post('tipe_plan');
$arr_dpkn['komisi_'] = $this->input->post('komisi_');
$arr_dpkn['tipe_proyek'] = $this->input->post('tipe_proyek');


$es = $this->input->post('nm_kew');
$nnes = 0;
foreach ($es as $key => $value) {
    $value != '' ? $nnes++ : '';
}
if (count($es) !== $nnes) {
    $this->setMessage("E-Sign Kewenangan harus disii semua.");
    $error = false;
} else {

    $anip = [];
    foreach ($this->input->post('nm_kew') as $k => $v) {
        $anip[] = $this->db->get_where('response_hcis', ['nm_peg' => $v])->row('nip');
    }

    $arr_esign = [];
    $arr_esign['keg_id'] = $this->input->post('keg_id');
    $arr_esign['nm_kew'] = $this->input->post('nm_kew');
    $arr_esign['nip'] = $anip;
    $arr_esign['fungsi_bidang'] = $this->input->post('fungsi_bidang');
    $arr_esign['job_title'] = $this->input->post('job_title');
    $arr_esign['kategori'] = $this->input->post('kategori');
    $arr_esign['posisi'] = $this->input->post('posisi');
}

$sap = 0;
if (array_key_exists('is_sap',$po)) {
    $sap = 1;
}
$pss = $this->input->post();


if ($error) {
    $proyek = $this->input->post('proyek');
    $pengadaan = trim($po['pengadaan']);
    $vendor = $this->input->post('vendor_list');
    $rfq = $this->input->post('rfq_no');
    $rab =  $this->input->post('total_rbap');
    $send = [$proyek, $pengadaan, $rfq, $vendor, $arr_dpkn['total_negosiai_vendor']];

    $arr_input = [
        'paket_pengadaan' => $po['pengadaan'],
        'proyek' => $po['proj_name'],
        'no_rfq' => $po['rfq_no'],
        'vendor' => json_encode($po['vendor_list']),
        'data_dpkn' => json_encode($arr_dpkn),
        'esign_dpkn' => json_encode($arr_esign),
        'date_created' => date("Y-m-d H:i:s"),
        'created_by' => $this->data['userdata']['employee_id'],
        'updated_by' => $this->data['userdata']['employee_id'],
        'win_type' => $po['twin'],
        'is_sap' => $sap,
        'metode_pengadaan' => isset($po['metode_pengadaan']) ? $po['metode_pengadaan'] : '',
    ];

    if (!array_key_exists('edit_f',$pss)) {
        if ($this->db->insert("uskep_online", $arr_input)) {
            $error = true;
        }
    } else {
        $this->db->where('no_rfq', $po['rfq_no']);
        if ($this->db->update("uskep_online", $arr_input)) {
            $error = true;
        }
    }
}


if($error){
    if (array_key_exists('edit_f',$pss)) {
        $this->setMessage("Data DEPKN berhasil diubah!");
        if (array_key_exists('is_sap',$pss)) {
            $this->renderMessage("sucess", site_url("uskep_online_sap/dsp/?data=".json_encode($send)));
        } else {
            $this->renderMessage("sucess", site_url("contract/manual"));
        }
    } else {
        $this->setMessage("Data DEPKN berhasil diinput!");
        if (array_key_exists('is_sap',$pss)) {
            $this->renderMessage("sucess", site_url("uskep_online_sap/dsp/?data=".json_encode($send)));
        } else {
            $this->renderMessage("sucess", site_url("uskep_online/dsp/?data=".json_encode($send)));
        }
    }
} else {
    $this->renderMessage("error");
}
