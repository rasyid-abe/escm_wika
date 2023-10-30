<?php

$view = 'contract/proses_kontrak/manual_kontrak_edit_v';
$data = array();
// $this->template($view,"Daftar Kontrak",$data);

$ccc = $this->db->get_where('ctr_contract_comment', ['ccc_id' => $param])->row_array();
$cch = $this->db->get_where('ctr_contract_header', ['contract_id' => $ccc['contract_id']])->row_array();
$cci = $this->db->get_where('ctr_contract_item', ['contract_id' => $ccc['contract_id']])->result_array();
// echo "<pre>";
// print_r($cci);
// die;
$data['tender'] = $this->Procrfq_m->getMonitorRFQ($cch['ptm_number'])->row_array();
$data['tenderManual'] = $this->Procrfq_m->getMonitorRFQManual($cch['ptm_number'])->row_array();
$uskep = $this->db->get_where('uskep_online', [
    'no_rfq' => $cch['ptm_number'],
    'is_sap' => 1,
    'created_by' => $this->Administration_m->getLogin()['employee_id']
])->row_array();

$data['aitem'] = $cci;

$data['uskep_fill'] = 0;
if ($uskep != NULL) {
    $data['uskep_fill'] = 1;

    $data['win_type'] = $uskep['win_type'];

    $rr = '';
    if ($uskep['data_dsp'] != '') {
        $aa = json_decode($uskep['data_dsp']);
        $rr = array_search(1, $aa->harga->peringkat);
        $vd = json_decode($uskep['vendor'])[$rr];
        $vr = $this->db->get_where('vnd_header', ['vendor_id' => $vd])->row('fin_class');

        if ($vr == "K") {
            $kl = "Kecil";
        } elseif ($vr == "M") {
            $kl = "Menengah";
        } elseif ($vr == "B") {
            $kl = "Besar";
        }

        $lak = $this->db->get_where('prc_plan_main', ['ppm_project_id' => $aa->proyek])->row_array();
    }


    $kl = "";
    if ($uskep['dsp_status_esign'] != NULL) {
        $data['dsp_status_esign'] = $uskep['dsp_status_esign'];
    } else {
        $data['dsp_status_esign'] = '';
    }

    if ($uskep['dpkn_status_esign'] != NULL) {
        $s_dpkn = [];
        $s_dpkn_total = 0;
        foreach (json_decode($uskep['dpkn_status_esign'])->recipients as $k => $v) {
            if ($v->activities->status == 'SIGN_DOCUMENT') {
                $s_dpkn_total++;
                $s_dpkn[] = 'PROGRESS';
            } else {
                $s_dpkn[] = 'DONE';
            }
        }
        $sts_dpkn = count($s_dpkn) == $s_dpkn_total ? 'done' : 'progress';
        $data['dpkn_status_esign'] = [$s_dpkn, $sts_dpkn];
    } else {
        $data['dpkn_status_esign'] = '';
    }

    if ($uskep['bakp_status_esign'] != NULL) {
        $s_bakp = [];
        $s_bakp_total = 0;
        foreach (json_decode($uskep['bakp_status_esign'])->recipients as $k => $v) {
            if ($v->activities->status == 'SIGN_DOCUMENT') {
                $s_bakp_total++;
                $s_bakp[] = 'PROGRESS';
            } else {
                $s_bakp[] = 'DONE';
            }
        }
        $sts_bakp = count($s_bakp) == $s_bakp_total ? 'done' : 'progress';
        $data['bakp_status_esign'] = [$s_bakp, $sts_bakp];



    } else {
        $data['bakp_status_esign'] = '';
    }

    $data['dsp'] = $uskep['data_dsp'];
    $data['dpkn'] = $uskep['data_dpkn'];
    $data['bakp'] = $uskep['data_bakp'];
    $data['rfq'] = $uskep['no_rfq'];
    $data['dsp_filename'] = $uskep['dsp_filename'];
    $data['dpkn_filename'] = $uskep['dpkn_filename'];
    $data['bakp_filename'] = $uskep['bakp_filename'];

    $bb = json_decode($uskep['data_dpkn']);

    if ($uskep['data_bakp'] != '') {
        $cc = json_decode($uskep['data_bakp']);

        if ($cc != '') {
            $idxr = array_search(1, $cc->rank24);
        }

        $arr_header = [
            'nilai_kontrak' => (int)str_replace(".", "", $cc->ven_omZ[0]),
            'rfq_number' => $uskep['no_rfq'],
            'paket_pengadaan' => $uskep['paket_pengadaan'],
            'vendor' => json_decode($uskep['vendor'])[$rr],
            'klasifikasi' => $kl,
            'nilai_rab' => $bb->total_rab,
            'project' => $lak['ppm_subject_of_work'],
            'win' => $uskep['win_type'] > 1 ? "Multiple Winner" : "Single Winner",
            'spk_code' => $aa->proyek,
            'ppm_id' => $lak['ppm_id'],
        ];


        $data['ahead'] = $arr_header;

        // echo "<pre>";
        // print_r($bb->poin_penawaran);
        // die;

        // auto items
        $itmss = [];
        foreach ($bb->poin_penawaran as $ex => $ax) {

            $d = $this->db->get_where('prc_plan_item', ['ppis_pr_number' => $ax->pr])->row_array();

            $iii = $this->db->get_where('prc_plan_item', ['ppi_code' => $d['ppi_code']])->row_array();
            array_push($iii,$ax->volume);
            array_push($iii,$bb->poin_negosiasi[$ex]->vendor_sat[$idxr]);
            array_push($iii,(int)str_replace(".", "", $aa->harga->nilai_hps));
            $itmss[] = $iii;
        }

        $data['aitem'] = $itmss;
    }

    $data['mtode'] = $uskep['metode_pengadaan'];

    $data['is_upload'] = '1';
    if ($uskep['data_dpkn'] == '0') {
        $data['is_upload'] = '0';
    }

} else {
    $data['win_type'] = '';
    $data['is_upload'] = '';
    $data['dsp'] = '';
    $data['dpkn'] = '';
    $data['bakp'] = '';
    $data['rfq'] = '';
    $data['dsp_filename'] = '';
    $data['dpkn_filename'] = '';
    $data['bakp_filename'] = '';
    $data['dsp_status_esign'] = '';
    $data['dpkn_status_esign'] = '';
    $data['bakp_status_esign'] = '';
    $data['ahead'] = [];
    $data['mtode'] = '';

    // auto items
    $itmss = [];
    foreach ($cci as $ex => $ax) {

        $d = $this->db->get_where('prc_plan_item', ['ppis_pr_number' => $ax['pr_number_sap']])->row_array();

        $iii = $this->db->get_where('prc_plan_item', ['ppi_code' => $d['ppi_code']])->row_array();
        array_push($iii,(float)$ax['qty']);
        array_push($iii,(float)$ax['price']);
        array_push($iii,(float)$ax['hps']);
        $itmss[] = $iii;
    }

    $data['aitem'] = $itmss;
}

$data['is_sap'] = 1;
$data['doc_type'] = $this->db->get('adm_doc_type')->result_array();
$data['tax_code'] = $this->db->get('adm_tax_code')->result_array();


$data['kontrak'] = $cch;

$eachhps = $this->Procrfq_m->getEachHPS($cch['ptm_number'], $cch['vendor_id'])->result_array();

$totalhps = 0;

foreach ($eachhps as $kh => $valhps) {
	$qty = $valhps['tit_quantity'];
	$price = $valhps['tit_price'];
	$totalhps += $qty * $price;
}

$hps = $this->Procrfq_m->getHPSRFQ($cch['ptm_number'])->row_array();

$data['rab'] = ($totalhps == "") ? $hps['hps_sum'] : $totalhps;

$data['cid'] = $ccc['ccc_id'];

$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA","ASSET"=>"ASSET");
$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();

$data['is_sap'] = 1;
$data['is_edit'] = 1;
$data['doc_type'] = $this->db->get('adm_doc_type')->result_array();
$data['tax_code'] = $this->db->get('adm_tax_code')->result_array();
$this->template($view,"Edit Kontrak Manual",$data);
