<?php

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/detail_tender_pengadaan_v';

$ptm_number = $this->uri->segment(5, 0);

$data['dir'] = $this->data['dir']."/tender";

$data['id'] = $ptm_number;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("LUMPSUM"=>"LUMPSUM","HARGA SATUAN"=>"HARGA SATUAN","RENTAL SERVICE"=>"RENTAL SERVICE");

$tender = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$project_cost = $this->Procrfq_m->getProjectCost($ptm_number)->result_array();

$data['project_cost'] = $project_cost;

$this->db->where("job_title","PELAKSANA PENGADAAN");

$data['pelaksana_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

$data['permintaan'] = $tender;

//header
$data['permintaans'] = $this->Procpr_m->getPRCMain($tender['pr_number'])->row_array();
//risiko
$data['risiko'] = $this->Procpr_m->getPrNilaiRisiko($ptm_number)->result_array();

$data['risiko_detail'] = $this->Procpr_m->getPrRisikoDetail($tender['pr_number'])->result_array();

$data['pr_number'] = $tender['pr_number'];

//skala nilai risiko
$skala_resiko_nilai = $this->db->get('adm_skala_resiko_paket');
$data['skala_resiko_nilai'] = $skala_resiko_nilai->result_array();

//Opportunity
$data['opportunity'] = $this->Procpr_m->getPrOpportunity($ptm_number)->result_array();
// comment
$this->db->where('pr_number', $ptm_number);
$komentar = $this->db->get('prc_comments');

// count thumbs
$thumbs_up = $this->db->where('pr_number', $ptm_number);
$thumbs_up->where('pr_respon', 0);
$thumbs_up = $this->db->get('prc_comments');
$data['thumbs_up'] = $thumbs_up->num_rows();

$thumbs_down = $this->db->where('pr_number', $ptm_number);
$thumbs_down->where('pr_respon', 1);
$thumbs_down = $this->db->get('prc_comments');
$data['thumbs_down'] = $thumbs_down->num_rows();

$comment = $this->db->where('pr_number', $ptm_number);
$comment->where('pr_respon', 2);
$comment = $this->db->get('prc_comments');
$data['comment'] = $comment->num_rows();

$data['doc_type_select'] = $this->db->where('code', $data['permintaan']['ptm_doc_type_sap'])->get('adm_doc_type')->row_array();

$data['komentar'] = $komentar->result_array();
$data['com_num'] = $komentar->num_rows();

$activity_id = $tender['last_status'];

$item_qty = $this->db
  ->select("SUM(tit_quantity) AS tit_quantity")
  ->where("ptm_number", $ptm_number)
  ->get("prc_tender_item")
  ->row_array();

$item_hps = $this->db
  ->select("SUM(tit_hps) AS tit_hps")
  ->where("ptm_number", $ptm_number)
  ->get("prc_tender_item")
  ->row_array();

$data['item_qty'] = $item_qty;
$data['item_hps'] = $item_hps;

$data['activity_id'] = $activity_id;

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$data['awa_id'] = $activity['awa_id'];

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$comment = $this->Comment_m->getProcurementRFQActive($ptm_number)->result_array();

$is_user = false;

$employee = $this->data['userdata'];

foreach ($comment as $key => $value) {
  if($value['user_id'] == $employee['employee_id'] && !$is_user){
    $is_user = true;
  }
}

$data['is_user'] = $is_user;

$data["comment_list"][0] = $comment;

$data['document'] = $this->Procrfq_m->getDokumenRFQ("",$ptm_number)->result_array();

if ($activity_id == "1901"){
  $data['item'] = $this->Procrfq_m->getEvalViewRFQvnd("",$ptm_number)->result_array();
}
else{
  $this->db->select("tit_retention, tit_pr_number, tit_pr_item, tit_delivery_date, tit_acc_assig, tit_cat_tech, tit_pr_type, tit_lampiran,tit_id,tit_code,tit_description,tit_quantity,tit_unit,tit_price,tit_currency,tit_type,tit_ppn,tit_pph, tit_tujuan, tit_incoterm,tit_lokasi_incoterm, tit_hps, tit_sumber_hps, prc_tender_item.pr_number,pr_district_id,pr_district,pr_dept_id,pr_dept_name, ptv_vendor_code, vendor_name");
  $this->db->join("prc_pr_main","prc_pr_main.pr_number=prc_tender_item.pr_number","left");
  $this->db->order_by("tit_code","asc");
  $this->db->order_by("pr_dept_name","asc");
  $data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();
}

$w = $this->db->where("ptm_number",$ptm_number)->get("prc_tender_winner")->result_array();

$winner_weight = [];

foreach ($w as $key => $value) {
  $winner_weight[$value['tit_id']][$value['vendor_id']] = $value;
}

$data['winner_weight'] = $winner_weight;

$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$data['data'] = $this->Procevaltemp_m->getTemplateEvaluasi($data['prep']['evt_id'])->row_array();

$data['detail'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail($data['prep']['evt_id'])->result_array();

if(isset($data['prep']['adm_bid_committee'])){
  $this->session->set_userdata("committee_id",$data['prep']['adm_bid_committee']);
}

$this->db->where("a.active", "Aktif");
$data['mdiv'] = $this->Administration_m->getMasterMdiv()->result_array();

$data['mppp'] = $this->Administration_m->getPosbyJob("MANAJER PERENCANAAN")->result_array();

$data['hps'] = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$data['person'] = $this->Procrfq_m->getPerson("",$ptm_number)->result_array();


$data['vendor'] = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();

$data['bidder_msg'] = $this->Procrfq_m->getMessageRFQ($ptm_number)->result_array();

$data['evaluation'] = $this->Procrfq_m->getEvalViewRFQ("",$ptm_number)->result_array();

$data['eauction_header'] = $this->db->where("ppm_id",$ptm_number)->order_by("id","desc")->get("prc_eauction_header")->result_array();

$data['eauction_hist'] = [];

$data['eauction_item'] = [];

$data['hist_eauction_header'] = $this->db->where("ppm_id",$ptm_number)->order_by("id","desc")->get("prc_eauction_header")->result_array();


if(in_array($activity_id, [1100,1120]) || $activity_id > 1100){

  $eauction_item = $this->db
  ->select("b.vendor_id,vendor_name,a.tgl_bid,a.jumlah_bid,a.qty_bid,a.ppm_id,f.judul,a.id,tit_retention,tit_description,tit_quantity,tit_price,tit_code,history_id")
  ->distinct()
  ->where("a.ppm_id",$ptm_number)
  ->join("vnd_header b","b.vendor_id=a.vendor_id")
  ->join("prc_eauction_header f","f.ppm_id=a.ppm_id")
  ->join("prc_tender_item d","d.tit_id=a.tit_id AND d.ptm_number=f.ppm_id")
  ->order_by("a.tgl_bid","asc")
  ->get("prc_eauction_history_item a")
  ->result_array();

  $e = [];

  foreach ($eauction_item as $key => $value) {
    $e[$value['vendor_id']."-".$value['vendor_name']][$value['history_id']][] = $value;
  }

  $data['eauction_item'] = $e;

  $eauction_hist = $this->db
  ->where("a.ppm_id",$ptm_number)
  ->get("prc_eauction_history a")
  ->result_array();

  $e = [];

  foreach ($eauction_hist as $key => $value) {
    $e[$value['id']] = $value;
  }

  $data['eauction_hist'] = $e;

}
$id_panitia = $data['prep']['adm_bid_committee'];

if(!empty($id_panitia)){
  $this->load->model("Procpanitia_m");
  $data['panitia'] = $this->Procpanitia_m->getPanitia($id_panitia)->row_array();
}

$data['penata_perencana'] = $this->Administration_m->getUserByJob("PENATA PERENCANAAN")->result_array();

$data["metode"] = [
  2 => "Tender Umum",
  1 => "Ternder Terbatas",
  0 => "Penunjukkan Langsung"
];

$data['sampul'] = array(0=>"1 Sampul",1=>"2 Sampul",2=>"2 Tahap");

$data['redirect_back'] = 'procurement/procurement_tools/monitor_pengadaan';

$vnd = $this->Procrfq_m->getVendorStatusRFQ("",$ptm_number)->result_array();

$manager_name = (!empty($tender['ptm_man_emp_id'])) ? $this->db->where("id",$tender['ptm_man_emp_id'])->get("adm_employee")->row()->fullname : "";

$data['manager_name'] = $manager_name;

$data["pilihan_syarat"] = $this->syarat_penunjuk_lgsg("");

$vendor = array();

foreach ($vnd as $key => $value) {
  $vendor[] = $value['pvs_vendor_code'];
}

$data['vendor_status'] = $vnd;

$data['vendor_aanwijzing'] = array();
$data['user_aanwijzing'] = array();
$userdata = $this->data['userdata'];

if(!empty($vendor)){

  $this->load->model("Vendor_m");

  $this->db
  ->select("vendor_id,vendor_name")
  ->distinct()
  ->where_in("(status)::integer",array(5,9))
  ->where("pvs_status >",0)
  ->where_in("vendor_id",$vendor)
  ->join("prc_tender_vendor_status","pvs_vendor_code=vendor_id","left")
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
  ))->order_by("datetime_ac","asc")->get("adm_chat")
->result_array();


foreach ($status_aanwijzing as $key => $value) {
  $data['user_aanwijzing'][$value['name_ac']] = (!empty($value['message_ac'])) ? $value['message_ac'] : "Offline";
}

$nama_user = $userdata['complete_name'];
if(!isset($data['user_aanwijzing'][$nama_user])){
  $data['user_aanwijzing'][$nama_user] = "Offline";
}

$data['tenderRks'] = $this->Procrfq_m->getRksTender($ptm_number)->result_array();

$data['chat_aanwijzing'] = $this->db->where("key_ac","1-".$ptm_number)->get("adm_chat")
->result_array();
$data['chat_eauction'] = $this->db->where("key_ac","2-".$ptm_number)->get("adm_chat")
->result_array();
if($activity_id > 1081 ){

  $data['beritaAcaraAanwijzing'] = '<a href="'.site_url('Procurement/GenerateBeritaAcaraAanwijzing/'.$ptm_number).'" target="_blank"><btn class="btn btn-success">Download</btn></a>';

}
$this->session->set_userdata("uri_string",uri_string());

$this->session->set_userdata("selection_vendor_tender",$vendor);

$this->session->set_userdata("rfq_id",$ptm_number);

//pengumuman pemenang
$nilai_hps = $this->db->where("ptm_number",$ptm_number)->get('vw_prc_tender_hps')->row_array();

$this->db->where('dept_id', $tender['ptm_dept_id']);
$dept = $this->db->get('adm_dept')->row_array();


$this->db->where('tipe_uskep', 'BAKP');
$this->db->where('tipe_plan', $tender['ptm_type_of_plan']);
$this->db->where($nilai_hps["hps_total"].'BETWEEN nilai_rab_start AND nilai_rab_end');

if($tender['ptm_type_of_plan'] == "rkp")
{
	$this->db->where('tipe_proyek', $tender['ptm_tender_project_type']);
}

if($tender['ptm_type_of_plan'] == "rkp_matgis" )
{
	if($tender['ptm_ctr_matgis_type'] == 'p')
	{
		$this->db->where('tipe_kontrak_matgis', 'p');

	} else {
		$this->db->where('tipe_kontrak_matgis', 's');

	}
}

$headerKewenangan = $this->db->get('adm_matriks_kegiatan')->row_array();
$listTtd = array();
$ttdList = array();


if($headerKewenangan != "")
{
	$this->db->where('kegiatan_id', $headerKewenangan['id']);
	$this->db->order_by('order_no', 'asc');


	$ttdList = $this->db->get('adm_matriks_kewenangan_kegiatan')->result_array();
}

if(count($ttdList) > 0 ){
	foreach ($ttdList as $key => $value) {
		# code...
		if(!strpos($value['job_title'],"MANAJER PROYEK"))
		{
			$this->db->where('nm_jabatan', $value['job_title']);
		}

		if($value['job_title'] == "DIREKTUR" && $tender['ptm_type_of_plan'] == "rkp")
		{
			$this->db->where('posisi', 'DIREKTUR OPERASI 1');

		}

		else if($value['job_title'] == "DIREKTUR" && $tender['ptm_type_of_plan'] == "rkp_matgis")
		{
			$this->db->where('posisi', 'DIREKTUR QUALITY HEALTH SAFETY AND ENVIRONTMENT');

		}

		else if($value['job_title'] == "MANAJER" && $tender['ptm_type_of_plan'] == "rkp_matgis")
		{

			//$this->db->where('posisi', 'MANAJER MATERIAL DAN JASA STRATEGIS DIVISI SUPPLY CHAIN MANAGEMENT');
			$this->db->where('nm_biro', 'SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS');

			//SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS
		}

		else if($value['job_title'] == "DIREKTUR" && $tender['ptm_type_of_plan'] == "rkap")
		{
			//$this->db->where('nm_jabatan', 'DIREKTUR');
			$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');

		}

		else if($value['job_title'] == "KEPALA DIVISI" && $tender['ptm_type_of_plan'] == "rkap")
		{
			//$this->db->where('nm_jabatan', 'DIREKTUR');
			$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');

		}


		else if($value['job_title'] == "KEPALA DIVISI" && $value['nm_fungsi_bidang'] == "OPERASI")
		{
				$this->db->like('direksi', 'DIREKTORAT OPERASI');
				$this->db->where('kd_dep', $tender['ptm_dep_code']);

		}


		else if($value['job_title'] == "PIC ANGGARAN")
		{
			$this->db->where('posisi', 'KEPALA DIVISI KEUANGAN');

		}
		else if(strpos($value['job_title'],"MANAJER PROYEK"))
		{
			$this->db->like('nm_jabatan', $value['job_title']);
			$this->db->where('nm_fungsi_bidang', $value['nm_fungsi_bidang']);
			if($value['job_title'] == "MANAJER PROYEK MEGA")
			{
				$this->db->or_where('nm_jabatan', 'MANAJER PROYEK BESAR');

			}

			if($tender['spk_code'] != "")
			{
				$this->db->where('no_spk', $tender['spk_code']);
				$this->db->or_where('no_spk_rangkap', $tender['spk_code']);

			}


		}
		else {
			if($value['is_search_divisi'] == 't')
			{

				$this->db->where('kd_dep', $tender['ptm_dep_code']);

			} else if($value['posisi_user'] != ""){
				$this->db->where('posisi', $value['posisi_user']);

			} else {

				$this->db->where('nm_fungsi_bidang', $value['nm_fungsi_bidang']);

			}

		}

		$this->db->where('status', 'aktif');

		$list = $this->db->get('response_hcis')->result_array();


		$name_list = array();

			foreach ($list as $key_hcis => $hcis) {
				# code...
				$name_list[$key_hcis]['fullname'] = $hcis['nm_peg'];
				$name_list[$key_hcis]['job_title'] = $hcis['nm_jabatan'];
				$name_list[$key_hcis]['nip'] = $hcis['nip'];


			}

		$listTtd[$key]['lists_name'] = $name_list;
				$listTtd[$key]['kategori'] = $value['kategori'];
				$listTtd[$key]['posisi'] = $value['posisi'];

	}
}


$this->db->where('nm_jabatan', "DIREKTUR UTAMA");
$this->db->where('status', 'aktif');
$listDirektur = $this->db->get('response_hcis')->result_array();

$getDataUskep = $this->Procrfq_m->getUskepData($ptm_number)->row_array();
// echo "<pre>";
// print_r($getDataUskep);
// die;
if ($getDataUskep != '') {
    $listPeople = explode(";",$getDataUskep['bakp_kpd_name']);
    $data['ketua_komisi'] = $listPeople[0];
} else {
    $data['ketua_komisi'] = '-';
}
$data['list_direktur'] = $listDirektur;
$data['tender'] = $tender;


//adding document'

if($tender['ptm_status'] >= 1160){
$newDoc = array();
$newDoc[0]['ptd_id'] = 0;
$newDoc[0]['ptm_number'] = $ptm_number;
$newDoc[0]['ptd_category'] = 'SURAT PEMENANG DOC';
$newDoc[0]['ptd_description'] = 'SURAT PEMENANG';
$newDoc[0]['ptd_file_name'] = 'surat_pemenang';
$newDoc[0]['ptd_type'] = 0;

$data['document'] = array_merge($data['document'],$newDoc);
}

if($tender['ptm_status'] >= 1180)
{
	$newDoc = array();
	$newDoc[0]['ptd_id'] = 0;
	$newDoc[0]['ptm_number'] = $ptm_number;
	$newDoc[0]['ptd_category'] = 'SURAT PENUNJUK PENYEDIA DOC';
	$newDoc[0]['ptd_description'] = 'SURAT PENUNJUK PENYEDIA';
	$newDoc[0]['ptd_file_name'] = 'surat_penunjuk';
	$newDoc[0]['ptd_type'] = 0;
	$data['document'] = array_merge($data['document'],$newDoc);

}

$this->template($view,"Detail Pengadaan (".$activity['awa_name'].")",$data);
