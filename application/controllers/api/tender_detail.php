<?php

$ptm_number = $this->uri->segment(3, 0);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];

$tender = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$activity_id = $tender['last_status'];

$item_sumberdaya = array();

$activity_data = $this->db->select("ptc_id as comment_id,
ptm_number as tender_id,
ptc_start_date as comment_date,
ptc_end_date as comment_end_date,
ptc_name as comment_name,
ptc_response as response,
ptc_comment as comments,
ptc_activity as activity,
ptc_position as position,
ptc_end_date as end_date,
ptc_attachment as attachment,
(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=ptc_activity) as activity_name,
ptc_user as user_id");
$activity_data = $this->db->where("ptm_number", $ptm_number );
$activity_data = $this->db->order_by("ptc_id","asc");
$activity_data = $this->db->get("prc_tender_comment")->result_array();
$headline_data = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();
$item_sumberdaya_data = $this->Procrfq_m->getEvalViewRFQvnd("", $ptm_number)->result_array();

$headline = array(
    'no_tender' => $headline_data['ptm_number'],
    'divisi' => $headline_data['ptm_requester_pos_name'],
    'kode_spk' => $headline_data['ptm_subject_of_work'],
    'nama_paket' => $headline_data['ptm_packet'],
    'nama_proyek' => $headline_data['ptm_project_name'],
    'tipe_pengadaan' => $headline_data['ptm_tender_project_type'],
    'jenis_kontrak' => $headline_data['ptm_contract_type'],
    'pengumuman_tender' => isset($headline_data['ptp_padi_umkm']) ? $headline_data['ptp_padi_umkm'] : '',
    'panitia_pengadaan' => isset($headline_data['ptp_tim_panitia']) ? $headline_data['ptp_tim_panitia'] : '',
    'buyer' => $headline_data['ptm_buyer'],
    'tanggal_pembuatan' => $headline_data['ptm_created_date'],
    'mata_uang' => $headline_data['ptm_currency'],
    'nilai_anggaran' => $headline_data['ptm_pagu_anggaran'],
    'nilai_hps' => $headline_data['ptm_sisa_anggaran'],
    'e_auction' => $headline_data['ptp_eauction'],
    'preferensi' => isset($headline_data['ptp_preferensi_umkm']) ? $headline_data['ptp_preferensi_umkm'] : '',
    'tipe_pemenang' => $headline_data['ptm_winner'] == '2' ? 'Multiple Winner' : 'Single Winner',
);
foreach ($item_sumberdaya_data as $k => $v) {
    $item_sumberdaya[$k]['kode_sda'] = $v['tit_code'];
    $item_sumberdaya[$k]['nama_sumberdaya'] = $v['tit_description'];
    $item_sumberdaya[$k]['volume'] = (int)$v['tit_quantity'];
    $item_sumberdaya[$k]['satuan'] = $v['tit_unit'];
    $item_sumberdaya[$k]['hrg_satuan_rab'] = (float)$v['tit_price'];
    $item_sumberdaya[$k]['sub_total_rab'] = (float)$v['tit_price'] * (int)$v['tit_quantity'];
    $item_sumberdaya[$k]['icoterm'] = $v['tit_incoterm'];
    $item_sumberdaya[$k]['lokasi_icoterm'] = $v['tit_lokasi_incoterm'];
    $item_sumberdaya[$k]['hps'] = (float)$v['tit_hps'];
    $item_sumberdaya[$k]['subtotal_hps'] = (float)$v['tit_hps'] * (int)$v['tit_quantity'];
    $item_sumberdaya[$k]['submer_hps'] = $v['tit_sumber_hps'];
    $item_sumberdaya[$k]['lampiran'] = $protocol . $domainName . "/log/download_attachment/procurement/tender/" . $v['tit_lampiran'];
}

$document_data = $this->Procrfq_m->getDokumenRFQ("", $ptm_number)->result_array();
$document = array();
foreach ($document_data as $k => $v) {
    $document[$k]['ptd_id'] = $v['ptd_id'];
    $document[$k]['ptm_number'] = $v['ptm_number'];
    $document[$k]['ptd_category'] = $v['ptd_category'];
    $document[$k]['ptd_description'] = $v['ptd_description'];
    $document[$k]['ptd_file_name'] = $v['ptd_file_name'];
    $document[$k]['url_lampiran'] = $protocol . $domainName . "/log/download_attachment/procurement/tender/" . $v['ptd_file_name'];
    $document[$k]['ptd_type'] = $v['ptd_type'];
}

$data['headline'] = $headline;
$data['item'] = $item_sumberdaya;

$data['detail_item'] = $this->Procpr_m->getPrRisikoDetail($tender['pr_number'])->result_array();

$data['document'] = $document;

$prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();
$metode_pengadaan = $this->Procevaltemp_m->getTemplateEvaluasi($prep['evt_id'])->row_array();

switch ($prep['ptp_tender_method']) {
    case '0':
        $met_peng = "Penunjukkan Langsung";
        break;
    case '1':
        $met_peng = "Tender Terbatas";
        break;
    case '2':
        $met_peng = "Tender Umum";
        break;
}

switch ($metode_pengadaan['evt_type']) {
    case '0':
        $eval_type = "Sistem Nilai";
        break;
    case '1':
        $eval_type = "Penilaian Biaya Selama Umur Ekonomis";
        break;
    case '2':
        $eval_type = "Harga Terendah";
        break;
}

$data['metode_pengadaan'] = array(
    "metode_pengadaan" => $met_peng,
    "evaluasi" => $eval_type,
    "evaluasi_administrasi" => "Sistem Gugur",
    "evaluasi_teknis" => $metode_pengadaan['evt_tech_weight'],
    "passing_grade" => $metode_pengadaan['evt_passing_grade'],
    "evaluasi_harga" => $metode_pengadaan['evt_price_weight']
);

$data['jadwal_pengadaan'] = array(
    "periode_tender" => $prep['ptp_tender_priod'],
    "pembukaan_pendaftaran" => !empty($prep["ptp_reg_opening_date"]) ? $prep["ptp_reg_opening_date"] : date("Y-m-d H:i:s"),
    "penutupan_pendaftaran" => $prep['ptp_reg_closing_date'],
    "aanwijzing" => $prep['ptp_prebid_date'],
    "mulai_kirim_penawaran" => isset($prep["ptp_quot_opening_date"])  ? $prep["ptp_quot_opening_date"] : date("Y-m-d H:i:s"),
    "akhir_kirim_penawaran" => $prep['ptp_quot_closing_date'],
    "pembukaan_dok_penawaran" => $prep['ptp_doc_open_date'],
    "negosiasi" => $prep['ptp_quot_closing_date'],
    "uskep" => $prep['ptp_quot_closing_date'],
    "pengumuman" => $prep['ptp_quot_closing_date'],
    "sanggahan" => $prep['ptp_quot_closing_date'],
    "penunjukan" => $prep['ptp_quot_closing_date']
);


$data['history_negosiasi'] = $this->Procrfq_m->getMessageRFQnego($ptm_number, "1140")->result_array();

$data['person'] = $this->Procpr_m->getPerson($tender['ptm_number']);

$tender_data = $this->Procrfq_m->getVendorBidderRFQ($tender['ptm_number'])->result_array();

$vendor_selected = array();
foreach ($tender_data as $k => $v) {
    $vendor_selected[$k]["id"] = $v["pvs_vendor_code"];
    $vendor_selected[$k]["ptm_number"] = $v["ptm_number"];
    $vendor_selected[$k]["nama_vendor"] = $v["vendor_name"];
    $vendor_selected[$k]["kontrak_aktif"] = isset($v["total_kontrak"]) ? $v["total_kontrak"] : "";
    $vendor_selected[$k]["tender_berjalan"] = isset($v["total_tender"]) ? $v["total_tender"] : "";
    $vendor_selected[$k]["lokasi"] = isset($v["address_city"]) ? $v["address_city"] : "";
    $vendor_selected[$k]["klasifikasi_vendor"] = $v["fin_class"];
    $vendor_selected[$k]["status"] = $v["pvs_status"];
}
$data['vendor_selected'] = $vendor_selected;

$evaluasi_administrasi = array();
foreach ($tender_data as $k => $v) {
    $evaluasi_administrasi[$k]["id"] = $v["pvs_vendor_code"];
    $evaluasi_administrasi[$k]["ptm_number"] = $v["ptm_number"];
    $evaluasi_administrasi[$k]["nama_vendor"] = $v["vendor_name"];
    $evaluasi_administrasi[$k]["kontrak_aktif"] = isset($v["total_kontrak"]) ? $v["total_kontrak"] : "";
    $evaluasi_administrasi[$k]["tender_berjalan"] = isset($v["total_tender"]) ? $v["total_tender"] : "";
    $evaluasi_administrasi[$k]["lokasi"] = isset($v["address_city"]) ? $v["address_city"] : "";
    $evaluasi_administrasi[$k]["klasifikasi_vendor"] = $v["fin_class"];
    $evaluasi_administrasi[$k]["status"] = $v["pvs_status"];
}

$data['evaluasi_administrasi'] = $evaluasi_administrasi;

$eval_data = $this->Procrfq_m->getEvalViewRFQ("", $ptm_number)->result_array();

$first_price = array();
$showButtonUskep = false;
$this->db->distinct()->select("ptv_vendor_code");
$history = $this->Procrfq_m->getVendorQuoHistRFQ("", $ptm_number)->result_array();

foreach ($history as $key => $value) {
    if (!isset($first_price[$value['ptv_vendor_code']])) {
        $this->db->distinct()->select("total,total_ppn")->order_by("pqm_created_date", "asc");
        $dat = $this->Procrfq_m->getVendorQuoHistRFQ($value['ptv_vendor_code'], $ptm_number)->row_array();
        $first_price[$value['ptv_vendor_code']] = array(
            "total" => $dat['total'],
            "total_ppn" => $dat['total_ppn'],
        );
        $showButtonUskep = true;
    }
}

// $data['first_price'] = $first_price;

$eval = array();
foreach ($eval_data as $k => $v) {
    //teknis
    $eval[$k]['nilai_total'] = $v['total'];
    $eval[$k]['nama_vendor'] = $v['vendor_name'] . " " . (isset($v['pqm_type']) ? "(Type " . $v['pqm_type'] . ")" : '');
    $eval[$k]['administrasi'] = $v['adm'];
    $eval[$k]['bobot'] = $v['pte_technical_weight'];
    $eval[$k]['nilai'] = $v['pte_technical_value'];
    $eval[$k]['minimum'] = $v['pte_passing_grade'];
    $eval[$k]['hasil'] = $v['pass'];
    $eval[$k]['catatan'] = $v['pte_technical_remark'];
    //harga
    $eval[$k]['bobot'] = $v['pte_price_weight'];
    $eval[$k]['nilai'] = $v['pte_price_value'];
    $eval[$k]['hasil'] = $v['pass_price'];
    $eval[$k]['catatan'] = $v['pte_price_remark'];
    $eval[$k]['penawaran'] = isset($first_price[$v['ptv_vendor_code']]['total_ppn']) ? $first_price[$v['ptv_vendor_code']]['total_ppn'] : $v['amount'];
    $eval[$k]['setelah_nego'] = isset($first_price[$v['ptv_vendor_code']]['total_ppn']) ? $v['amount'] : 0;
}

$data['evaluasi_teknis_harga'] = $eval;

$penawaran_vendor = $this->db->where("ptm_number", $ptm_number);
$penawaran_vendor = $this->db->order_by("pqm_id", "asc");
$penawaran_vendor = $this->db->get("vw_prc_quo_vnd_hist")->result_array();

$data['history_penawaran_vendor'] = $penawaran_vendor;

$data['periode_sanggahan'] = array(
    "lama_sanggahan" => (!empty($prep['ptp_denial_period'])) ? $prep['ptp_denial_period'] . " Hari" : "Tidak Ada",
    "mulai_sanggahan" => (!empty($prep['ptp_denial_period_start'])) ? date("Y-m-d H:i:s", strtotime($prep['ptp_denial_period_start'])) : "",
    "selesai_sanggahan" => (!empty($prep['ptp_denial_period_end'])) ? date("Y-m-d H:i:s", strtotime($prep['ptp_denial_period_end'])) : ""
);

$history_sanggahan = $this->Procrfq_m->getClaimRFQ($ptm_number)->result_array();
foreach ($history_sanggahan as $key => $value) {
    $history_sanggahan[$key]['pcl_created_date'] = date("Y-m-d H:i:s", strtotime($history_sanggahan[$key]['pcl_created_date']));
    $history_sanggahan[$key]['current_approver_pos_name'] = $this->Administration_m->getPos($history_sanggahan[$key]['current_approver_pos'])->row()->pos_name;
}
$data['history_sanggahan'] = $history_sanggahan;

$data['penetapan_pelaksana_pekerjaan'] = array(
    "url" => site_url('vendor/daftar_vendor/lihat_detail_vendor/' . $tender['vendor_id']),
    "vendor_name" => $tender["vendor_name"]
);

//risiko
$data['risiko'] = $this->Procpr_m->getPrRisiko($tender['pr_number'])->result_array();

$data['daftar_rks'] = $this->Procrfq_m->getRksTender($ptm_number)->result_array();
$data['activity'] = $activity_data;

if ($data) {
    $this->response([
        'status' => true,
        'data' => $data,
    ], REST_Controller::HTTP_OK);
} else {
    $this->response([
        'status' => false,
        'message' => 'No data were found'
    ], REST_Controller::HTTP_NOT_FOUND);
}
