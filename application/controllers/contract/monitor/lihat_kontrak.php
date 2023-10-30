<?php

$post = $this->input->post();

$view = 'contract/proses_kontrak/lihat_monitor_kontrak_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$contract_id = $this->uri->segment(5, 0);

$data['id'] = $contract_id;

$data['pos'] = $position;

$this->data['dir'] = CONTRACT_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","SPK"=>"SPK","KONTRAK"=>"KONTRAK","PERJANJIAN"=>"PERJANJIAN");

$kontrak = $this->Contract_m->getData($contract_id)->row_array();

$data['is_sap'] = $kontrak['is_sap'];

$data['read'] = true;

$data['item_po'] = $this->db->get_where('ctr_contract_item', ['contract_id' => $kontrak['contract_id']])->row('item_po');

// echo "<pre>";
// print_r($kontrak);
// die;

$ptm_number = $kontrak['ptm_number'];

$this->db->select_sum('subtotal_rab');
$this->db->where('contract_id', $contract_id);
$data['subtotal_rab'] = $this->db->get('vw_smbd_sum_rab')->row_array();

//startcode helmi

$data['currency'] = $this->Administration_m->get_currency()->result_array();

$data['milestone'] = $this->Contract_m->getMilestone("",$contract_id)->result_array();

$data['jaminan'] = $this->Contract_m->getJaminan("",$contract_id)->result_array();

$data['person'] = $this->Contract_m->getPerson("",$contract_id)->result_array();

$data['history_amd'] = $this->Contract_m->getHistoryAmd($ptm_number)->result_array();

$quo_id = array();

$vendor_list = array();
$vendor_qualified = array();
$head = array();
$harga = array();
$total_harga = array();

$data['nilai_kontrak'] = $head;

//end

 $data['total_kontrak'] = $this->db->select('total_ppn')
                             ->join('ctr_contract_header b', 'a.vendor_name = b.vendor_name')
                             ->join('prc_tender_vendor_status c', 'a.ptm_number = c.ptm_number')
                             ->where(array('a.ptm_number'=>$ptm_number, 'b.ptm_number'=>$ptm_number, 'c.ptm_number'=>$ptm_number, 'c.pvs_is_winner'=>1))
                             ->get('vw_prc_quotation_vendor_sum a')
                             ->row_array();

$last_comment = $this->Comment_m->getContract("",$contract_id,"")->row_array();

$activity_id = (!empty($kontrak['status'])) ? $kontrak['status'] : 2000;

$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();

$data['activity_id'] = $activity_id;

$this->db->where("job_title","PENGELOLA KONTRAK");

$data['pelaksana_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$manager_name = (!empty($kontrak['ctr_man_employee'])) ?
$this->db->where("id",$kontrak['ctr_man_employee'])->get("adm_employee")->row()->fullname : "";

$data['manager_name'] = $manager_name;
$data['contract_id'] = $contract_id;


$spe_name = (!empty($kontrak['ctr_spe_employee'])) ?
$this->db->where("id",$kontrak['ctr_spe_employee'])->get("adm_employee")->row()->fullname : "";

$data['specialist_name'] = $spe_name;

$data['kontrak'] = $kontrak;

$eachhps = $this->Procrfq_m->getEachHPS($ptm_number, $kontrak['vendor_id'])->result_array();

$totalhps = 0;

foreach ($eachhps as $kh => $valhps) {
	$qty = $valhps['tit_quantity'];
	$price = $valhps['tit_price'];
	$totalhps += $qty * $price;
}

$hps = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$data['rab'] = ($totalhps == "") ? $hps['hps_sum'] : $totalhps;

// $data['item'] = $this->Contract_m->getItem("",$contract_id)->result_array();
// $data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();
$this->db->order_by('item_code','desc');

$item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
$data['item'] = $item2;

$data['milestone'] = $this->Contract_m->getMilestone("",$contract_id)->result_array();

$data['document'] = $this->Contract_m->getDoc("",$contract_id)->result_array();

$data['doc_category'] = $this->Contract_m->getDocType()->result_array();

$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$data['ptm_number'] = $ptm_number;

$data['tenderManual'] = $this->Procrfq_m->getMonitorRFQManual($ptm_number)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);

// vpi
$this->db->where(array("vendor_id" => $kontrak['vendor_id'], "contract_id" => $kontrak['contract_id']));
$data['vpi_score'] = $this->db->get('vw_vpi_score_per_bulan')->result();

$this->db->where(array("vendor_id" => $kontrak['vendor_id'], "contract_id" => $kontrak['contract_id']));
$data['vpi_score_num'] = $this->db->get('vw_vpi_score_per_bulan')->num_rows();

$this->db->select_sum('vpi_score');
$this->db->where(array("vendor_id" => $kontrak['vendor_id'], "contract_id" => $kontrak['contract_id']));
$data['vpi_score_sum'] = $this->db->get('vw_vpi_score_per_bulan')->row_array();
// vpi-end

$data["comment_list"][0] = $this->Comment_m->getContractActive($ptm_number, "", $kontrak['contract_id'])->result_array();

$data["end_date_1"] = $this->Comment_m->getEndDate($ptm_number, ['2010'], $kontrak['contract_id'])->row_array();
$data["end_date_2"] = $this->Comment_m->getEndDate($ptm_number, ['2027'], $kontrak['contract_id'])->row_array();
$data["end_date_3"] = $this->Comment_m->getEndDate($ptm_number, ['2030'], $kontrak['contract_id'])->row_array();
$data["end_date_4"] = $this->Comment_m->getEndDate($ptm_number, ['2901'], $kontrak['contract_id'])->row_array();
$data["end_date_5"] = $this->Comment_m->getEndDate($ptm_number, ['2903'], $kontrak['contract_id'])->row_array();

// vsi-start
$periode = '1';
$year = '2021';

$getVSIVendorList = $this->db->get('vw_vsi_vendor_list');
$getPeriode = $this->db->get('vw_get_periode_vsi');
$getYear = $this->db->get('vw_year_list');

$data['rows'] = $getVSIVendorList->result_array();
$data['periode'] = $getYear->result_array();
$data['year'] = $getYear->result_array();
$data['vsi_summary'] = $this->Vendor_m->get_vsi_summary($periode,$year);

$data['label_pertanyaan_kepuasan'] = $this->Vendor_m->get_pertanyaan_label(1,$periode,$year);
$data['label_pertanyaan_kepentingan'] = $this->Vendor_m->get_pertanyaan_label(2,$periode,$year);

$data['data_asset_line_kepuasan'] = $this->Vendor_m->get_asset_line_chart(1,$periode,$year);
$data['data_asset_line_kepentingan'] = $this->Vendor_m->get_asset_line_chart(2,$periode,$year);
$data['data_scatter_chart'] = $this->Vendor_m->get_dataset_scatter_chart($periode,$year);

$data['data_satisfication_map'] = $this->Vendor_m->get_satisfacation_map($periode,$year);
$data['score_rows'] = $this->Vendor_m->get_vsi_vendor_score($periode,$year);
// vsi-end

// hlmifzi
$data['penilaian']= $this->db->get('adm_question_kpi_vendor')->result_array();

// comment
$this->db->where('cad_contract_id', $kontrak['contract_id']);
$komentar = $this->db->get('ctr_comment_all_div');

// count thumbs
$thumbs_up = $this->db->where('cad_contract_id', $kontrak['contract_id']);
$thumbs_up->where('cad_respon', 0);
$thumbs_up = $this->db->get('ctr_comment_all_div');
$data['thumbs_up'] = $thumbs_up->num_rows();

$thumbs_down = $this->db->where('cad_contract_id', $kontrak['contract_id']);
$thumbs_down->where('cad_respon', 1);
$thumbs_down = $this->db->get('ctr_comment_all_div');
$data['thumbs_down'] = $thumbs_down->num_rows();

$comment = $this->db->where('cad_contract_id', $kontrak['contract_id']);
$comment->where('cad_respon', 2);
$comment = $this->db->get('ctr_comment_all_div');
$data['comment'] = $comment->num_rows();

$data['komentar'] = $komentar->result_array();
$data['com_num'] = $komentar->num_rows();

// vsi
$vd = $this->Administration_m->getVendorVsi("", "", $kontrak['vendor_id'])->result_array();

$headname = [];
$dats = [];
$isi = [];
$satis = [];
$im = [];
$imp = [];
$period = [];

if (!empty($vd)) {
  $period = $vd[0]['periode'];
  foreach ($vd as $k => $v) {
    $this->db->order_by("vvk_quest_header");
    $dats[] = $this->Administration_m->getVendorVsiKues("", $v['vvq_id'])->result_array();
  }

  foreach ($dats[0] as $key => $value) {
    $head[] = $value['vvk_quest_header'];
  }

  $hm = array_unique($head);

  foreach ($hm as $key => $value) {
    $headname[] = $value;
  }

  foreach ($dats as $key => $value) {
    foreach ($value as $y => $v) {
      $isi[$y] = $v['vvk_satis_score'];
      $im[$y] = $v['vvk_imp_score'];
    }
    $satis[$key] = $isi;
    $imp[$key] = $im;
  }
  $data['header'] = $dats[0];
}

$data['th'] = array_count_values($head);
$data['headname'] = $headname;
$data['vendor'] = $vd;
$data['quest'] = $dats;
$data['imp'] = $imp;
$data['satis'] = $satis;
$data['period'] = $period;
// vsi-end

// uskep_online start
$proj = explode('/', $kontrak['subject_work']);
$data['mptm_n'] = $ptm_number;
$data['mspk_n'] = $proj;

$uskep = $this->db->get_where('uskep_online', [
    'no_rfq' => $ptm_number,
    'is_sap' => 1,
    'created_by' => $this->Administration_m->getLogin()['employee_id']
])->row_array();

if ($uskep != NULL) {

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
    $data['aitem'] = [];
    $data['mtode'] = '';
}

// $data['pl'] = $pl;
$data['is_sap'] = 1;
$data['doc_type'] = $this->db->get('adm_doc_type')->result_array();
$data['tax_code'] = $this->db->get('adm_tax_code')->result_array();


$data['history_amd'] = $this->Contract_m->getHistoryAmd($ptm_number, $kontrak['contract_number'])->result_array();

$data['history_amd_num'] = $this->Contract_m->getHistoryAmd($ptm_number, $kontrak['contract_number'])->num_rows();

$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA");

$this->session->set_userdata("rfq_id",$ptm_number);

$this->session->set_userdata("contract_id",$contract_id);
// echo "<pre>";
// print_r($data['kontrak']);
// die;
$this->template($view,"Detail Kontrak (".$activity['awa_name'].")",$data);
