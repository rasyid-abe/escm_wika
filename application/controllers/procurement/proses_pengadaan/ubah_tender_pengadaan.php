<?php

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/ubah_tender_pengadaan_v';

$position = $this->Administration_m->getPosition("PIC USER");

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

$data['id'] = $id;

$this->session->set_userdata("works_id",$id);

$data['pos'] = $position;

$this->data['dir'] = PROCUREMENT_TENDER_PENGADAAN_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("LUMPSUM"=>"LUMPSUM","HARGA SATUAN"=>"HARGA SATUAN");

$latest_comment = $this->Comment_m->getProcurementRFQ("",$id)->row_array();

$ptm_number = $latest_comment['tender_id'];

$permintaan = $this->Procrfq_m->getRFQ($ptm_number)->row_array();
$data['is_matgis'] = $this->Procrfq_m->getPRData($permintaan['pr_number'])->row_array();

//header
$data['permintaans'] = $this->Procpr_m->getPRCMain($permintaan['pr_number'])->row_array();

//item
$data['item_sap'] = $this->db->where('ptm_number', $ptm_number)->get('vw_prc_perencanaan_rari')->result_array();

$data['pr_number'] = $permintaan['pr_number'];

$data['tender'] = $permintaan;

$this->db->where('pr_number', $permintaan['pr_number']);
$pr = $this->db->get('prc_pr_main')->row_array();

$data['pr'] = $pr != null ? $pr : [];
$data['doc_type'] = $this->db->get('adm_doc_type')->result_array();

$this->db->select('pr_number');
$this->db->where('ptm_number', $ptm_number);
$getNoPR = $this->db->get('vw_prc_monitor')->row_array();

$data['risiko_detail'] = $this->Procpr_m->getPrRisikoDetail($permintaan['pr_number'])->result_array();
$data['risiko'] = $this->Procpr_m->getPrNilaiRisiko($permintaan['pr_number'])->result_array();

//skala nilai risiko
$skala_resiko_nilai = $this->db->get('adm_skala_resiko_paket');
$data['skala_resiko_nilai'] = $skala_resiko_nilai->result_array();

$data['permintaan_hide'] = $this->Procpr_m->getPR($getNoPR['pr_number'])->row_array();

$data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($data['permintaan_hide']['ppm_id'])->row_array();

$project_cost = $this->Procrfq_m->getProjectCost($ptm_number)->result_array();

$this->db->where("job_title","PELAKSANA PENGADAAN");

$data['pelaksana_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

$data['last_comment'] = $latest_comment;

$data['permintaan'] = $permintaan;

$data['doc_type_select'] = $this->db->where('code', $data['permintaan']['ptm_doc_type_sap'])->get('adm_doc_type')->row_array();

$data['project_cost'] = $project_cost;

$district_id = $permintaan['ptm_district_id'];

if(empty($district_id)){
    $district_id = $this->data['userdata']['district_id'];
}

$data['district_id'] = $district_id;

$this->session->set_userdata("selection_district",$district_id);

$activity_id = (!empty($latest_comment['activity'])) ? $latest_comment['activity'] : 1001;

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$this->session->set_userdata("activity_id",$activity_id);

$data['awa_id'] = $activity['awa_id'];

$data['activity_id'] = $activity_id;

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = $this->Comment_m->getProcurementRFQActive($ptm_number)->result_array();

$data['document'] = $this->Procrfq_m->getDokumenRFQ("",$ptm_number)->result_array();

$this->db->where('ptm_number', $ptm_number);

$docPemenang = $this->db->get('vw_prc_doc_pemenang')->result_array();

if(count($docPemenang) > 0)
{
    $data['document'] = array_merge($data['document'],$docPemenang);
    $data['document'] = array_values($data['document']);
}

$this->db->select("tit_retention,tit_lampiran,tit_id,tit_code,tit_description,tit_quantity,tit_unit,tit_price,tit_currency,tit_type,tit_ppn,tit_pph,tit_tujuan,prc_tender_item.pr_number,tit_incoterm,tit_lokasi_incoterm,tit_hps,tit_sumber_hps,COALESCE(pr_district_id, ptm_district_id) as pr_district_id, COALESCE(pr_district, ptm_district_name::text) as pr_district, COALESCE(pr_dept_id, ptm_dept_id) as pr_dept_id, COALESCE(pr_dept_name, ptm_dept_name) as pr_dept_name, tit_pr_number, tit_pr_item, tit_delivery_date, tit_pr_type, tit_cat_tech, tit_acc_assig");

$this->db->join("prc_pr_main","prc_pr_main.pr_number=prc_tender_item.pr_number","left");

$this->db->join('prc_tender_main', 'prc_tender_main.ptm_number = prc_tender_item.ptm_number', 'left');

$this->db->order_by("pr_number","asc");

$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

$submitted_item = $this->Procrfq_m->getSubmittedItemRFQ($ptm_number)->result_array();

if (count($submitted_item) > 0) {

    $data['submitted_item'] = array();
    foreach ($submitted_item as $key => $value) {
        $data['submitted_item'][$value['tit_id']]['total_percent'] = 0;
    }

    foreach ($submitted_item as $key => $value) {
        $data['submitted_item'][$value['tit_id']][$value['vendor_id']]['percentage'] = $value["percentage"];
        $data['submitted_item'][$value['tit_id']]['total_percent'] += $value["percentage"];
        $data['submitted_item'][$value['tit_id']][$value['vendor_id']]['weight'] = $value["weight"];
    }

}


$this->db->where("a.active", "Aktif");
$data['mdiv'] = $this->Administration_m->getMasterMdiv()->result_array();

$data['mppp'] = $this->Administration_m->getPosbyJob("MANAJER PERENCANAAN")->result_array();

$pecah = [];

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$data['data'] = $this->Procevaltemp_m->getTemplateEvaluasi($data['prep']['evt_id'])->row_array();

$where_admin = array('evt_id' => $data['prep']['evt_id'], 'etd_mode' => '0');

$data['detail'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail2($where_admin)->result_array();



$max_admin = 0;

foreach ($data['detail'] as $key => $admin) {
    $max_admin = $max_admin + (int)$admin['etd_weight'];
}

$data['max_admin'] = $max_admin;

$where_teknis = array('evt_id' => $data['prep']['evt_id'], 'etd_mode' => '1');
$data['detail_teknis'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail2($where_teknis)->result_array();

$max_teknis = 0;
foreach ($data['detail_teknis'] as $key => $teknis) {
    $max_teknis = $max_teknis + (int)$teknis['etd_weight'];
}
$data['max_teknis'] = $max_teknis;

$data["periodes"] = [
    7 => "7 Hari Kalender",
    14 => "14 Hari Kalender",
    30 => "30 Hari Kalender",
];

$manager_name = (!empty($permintaan['ptm_man_emp_id'])) ? $this->db->where("id",$permintaan['ptm_man_emp_id'])->get("adm_employee")->row()->fullname : "-";

$data['manager_name'] = $manager_name;

$winner = $data['permintaan']['ptm_winner'];

if ($winner == 1) {
    $wins = [
        "clascheck" => "iradio_square-green mustCheckWinner checked",
        "clascheck2" => "iradio_square-green mustCheckWinner2",
        "disable" => "disabled",
        "check" => "checked",
        "check2" => ""
    ];
} elseif ($winner == 2) {
    $wins = [
        "clascheck" => "iradio_square-green mustCheckWinner",
        "clascheck2" => "iradio_square-green mustCheckWinner2 checked",
        "disable" => "disabled",
        "check" => "",
        "check2" => "checked"
    ];
}else{
    $wins = [
        "clascheck" => "iradio_square-green mustCheckWinner",
        "clascheck2" => "iradio_square-green mustCheckWinner2",
        "disable" => "",
        "check" => "",
        "check2" => ""
    ];
}

$data['winner'] = $wins;

$pemb_dok_pen = $data['prep']['ptp_doc_open_date'];

if($activity_id == 1090 && strtotime($pemb_dok_pen) > time()){
    $this->setMessage("Belum saatnya pembukaan dokumen penawaran");
    redirect(site_url("procurement/daftar_pekerjaan"));
}

if(!empty($data['prep'])){

    if($activity_id == 1090){
        $prebid = strtotime($data['prep']['ptp_prebid_date']);
        if($prebid > time()){
            $this->noAccess("Belum saatnya pembukaan penawaran.");
        }
    }

    if($activity_id == 1000){
        $bid = strtotime($data['prep']['ptp_quot_opening_date']);
        if($bid > time()){
            $this->noAccess("Belum saatnya evaluasi penawaran.");
        }
    }

    if($activity_id == 1114){
        $aanwijzing2 = strtotime($data['prep']['ptp_tgl_aanwijzing2']);
        if($aanwijzing2 > time()){
            $this->noAccess("Belum saatnya aanwijzing tahap 2.");
        }
    }

}

$data['hist_eauction_header'] = $this->db->where("ppm_id",$ptm_number)->order_by("id","desc")->get("prc_eauction_header")->result_array();

$data['eauction_hist'] = [];

$data['eauction_item'] = [];

if(in_array($activity_id, [1100,1120]) || $activity_id > 1100){

    $eauction_item = $this->db
    ->select("b.vendor_id,vendor_name,a.tgl_bid,a.jumlah_bid,a.qty_bid,a.ppm_id,f.judul,a.id,tit_description,tit_quantity,tit_price,tit_code,history_id")
    ->distinct()
    ->where("a.ppm_id",$ptm_number)
    ->join("vnd_header b","b.vendor_id=a.vendor_id")
    ->join("prc_eauction_header f","f.id=a.eauction_id")
    ->join("prc_tender_item d","d.tit_id=a.tit_id AND d.ptm_number=f.ppm_id")
    ->order_by("a.tgl_bid","asc")
    ->order_by("tit_description","asc")
    ->order_by("tit_code","asc")
    ->get("prc_eauction_history_item a")
    ->result_array();

    $e = [];

    foreach ($eauction_item as $key => $value) {
        $e[$value['vendor_id']."-".$value['vendor_name']][$value['history_id']][] = $value;
    }

    $data['eauction_item'] = $e;

    $eauction_hist = $this->db
    ->select("a.*,f.judul")
    ->join("prc_eauction_header f","f.id=a.eauction_id")
    ->where("a.ppm_id",$ptm_number)
    ->get("prc_eauction_history a")
    ->result_array();

    $e = [];

    foreach ($eauction_hist as $key => $value) {
        $e[$value['id']] = $value;
    }

    $data['eauction_hist'] = $e;

}

$data['panitia'] = array();

$this->db->where("job_title","MANAJER PENGADAAN");

$data['manajer_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

$this->session->set_userdata("committee_id", NULL);

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$vnd = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();
$temp = array();
foreach ($vnd as $key => $value) {
    $temp[$value['vendor_id']] = $value;
}

$data['evaluation'] = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

$data['penata_perencana'] = $this->Administration_m->getUserByJob("PENATA PERENCANAAN")->result_array();

$data["metode"] = [
    2 => "Tender Umum",
    1 => "Ternder Terbatas",
    0 => "Penunjukkan Langsung"
];

$data["pilihan_syarat"] = $this->syarat_penunjuk_lgsg("");

$data['sampul'] = array(0=>"1 Sampul",1=>"2 Sampul",2=>"2 Tahap");

$vnd = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

$this->session->unset_userdata("selection_vendor_tender");

$vendor = array();

foreach ($vnd as $key => $value) {
    if($value['pvs_status'] > 0 || $value['pvs_status'] < 0 ){
        $vendor[] = $value['pvs_vendor_code'];
    } else {
        unset($temp[$value['pvs_vendor_code']]);
    }
}

$data['vendor_status'] = $vnd;
$data['vendor'] = $temp;
$data['vendor_aanwijzing'] = array();
$data['user_aanwijzing'] = array();
$userdata = $this->data['userdata'];

if(!empty($vendor)){

    $this->load->model("Vendor_m");

    $this->db
    ->select("vw_vnd_bidder_list.vendor_id,vendor_name")
    ->distinct()
    ->where_in("(status)::integer",array(5,9))
    ->where("pvs_status >",0)
    ->where_in("vw_vnd_bidder_list.vendor_id",$vendor)
    ->join("prc_tender_vendor_status","pvs_vendor_code=vw_vnd_bidder_list.vendor_id","left")
    ->join("z_bidder_status","lkp_id=pvs_status","left");

    $vendor_aanwijzing = $this->Vendor_m->getBidderList()->result_array();

    $data['vendor_aanwijzing'] = $vendor_aanwijzing;

    foreach ($vendor_aanwijzing as $key => $value) {
        $data['user_aanwijzing'][$value['vendor_name']] = "Offline";
    }

    $this->session->set_userdata("selection_vendor_tender",$vendor);

}

$status_aanwijzing = $this->db->where(array(
    "key_ac"=>"0-".$ptm_number,
))->where("name_ac !=","Admin")
->order_by("datetime_ac","asc")
->get("adm_chat")
->result_array();


foreach ($status_aanwijzing as $key => $value) {
    $data['user_aanwijzing'][$value['name_ac']] = (!empty($value['message_ac'])) ? $value['message_ac'] : "Offline";
}

$nama_user = $userdata['complete_name'];
if(!isset($data['user_aanwijzing'][$nama_user])){
    $data['user_aanwijzing'][$nama_user] = "Offline";
}

$data['chat_aanwijzing'] = $this->db->where("key_ac","1-".$ptm_number)->get("adm_chat")
->result_array();
$data['chat_eauction'] = $this->db->where("key_ac","2-".$ptm_number)->get("adm_chat")
->result_array();

$eauction_header = $this->db->where("ppm_id",$ptm_number)->where("status",1)->get("prc_eauction_header")->row_array();

$data['eauction_header'] = $eauction_header;

$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();

$data['person'] = $this->Procrfq_m->getPerson("",$ptm_number)->result_array();

$this->db->where('is_locked', '0');
$data['adm_user'] = $this->db->get('adm_user')->result_array();

$data['dari'] = (isset($eauction_header['tanggal_mulai'])) ?  strtotime($eauction_header["tanggal_mulai"]) : 0;

$data['sampai'] = (isset($eauction_header['tanggal_berakhir'])) ?  strtotime($eauction_header["tanggal_berakhir"]) : 0;

$eauction_detail = $this->db->where("ppm_id",$ptm_number)->get("prc_eauction_item")->result_array();

foreach ($eauction_detail as $key => $value) {
    $data['eauction_detail'][$value['tit_id']] = $value['value_min'];
}

$data['dataHeaderRKS'] = $this->Procrfq_m->getHeaderRKS()->result();

$data['tenderRks'] = $this->Procrfq_m->getRksTender($ptm_number)->result_array();

// echo "<pre>";
// print_r($data['prep']);
// die;

$this->session->set_userdata("rfq_id",$ptm_number);

$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);
