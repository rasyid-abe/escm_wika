<?php
$this->load->library('terbilang');
$view = "procurement/doc_cetak/pdf_bakp_print_v";

$this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));

$rfq_id = $id;

if (isset($_POST['id'])) {
	$rfq_id = $_POST['id'];
}

$ptm_number = $rfq_id;

$tender = $this->Procrfq_m->getMonitorRFQ($rfq_id)->row_array();

//$contract = $this->Contract_m->getMonitorByPtm($rfq_id)->row_array();

$tgl_penetapan_pemenang = $tender['ptm_completed_date'];

$nilai_hps = $this->db->where("ptm_number",$rfq_id)->get('vw_prc_tender_hps')->row_array();

$efesiensi = $nilai_hps['hps_total'] - $tender['total_contract'];

if ($efesiensi <= 0) {
	$efesiensi = 0;
}

$eval = $this->Procrfq_m->getEvalViewRFQ("",$rfq_id)->result_array();

$first_price = array();

$this->db->distinct()->select("ptv_vendor_code");
$history = $this->Procrfq_m->getVendorQuoHistRFQ($tender['vendor_id'],$rfq_id)->result_array();

foreach ($history as $key => $value) {
	if(!isset($first_price[$value['ptv_vendor_code']])){
		$this->db->distinct()->select("total,total_ppn")->order_by("pqm_created_date","asc");
		$dat = $this->Procrfq_m->getVendorQuoHistRFQ($value['ptv_vendor_code'],$rfq_id)->row_array();
		$first_price[$value['ptv_vendor_code']] = array(
			"total"=>$dat['total'],
			"total_ppn"=>$dat['total_ppn'],
			);
	}
}

$data['first_price'] = $first_price;

$panitia = $this->Procpanitia_m->getPanitiaAnggota($tender['adm_bid_committee'])->result_array();

$vendor_verifikasi = $this->Procrfq_m->getVendorBidderRFQ($rfq_id)->result_array();

$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();
$listPanitia = [];
$listNip = [];

if (isset($_POST['kota'])) {

if(isset($_POST['panitia_name']))
{
	foreach ($_POST['panitia_name'] as $key => $value) {
		# code...
		$item = explode("_",$value);
		$listPanitia[$key] = $item[1]." - ".$item[2];
		$listNip[$key] = $item[0];

		if($value == $_POST['panitia_name'][$key+1])
		{
			$this->setMessage("Simpan DEPKN GAGAL, Nama Komisi ada yang sama !");
			redirect(site_url("procurement/pdf_penawaran_harga/".$ptm_number));
		}

	}


	if ($getDataUskep) {
		$data_update = array(
			'bakp_city' => $_POST['kota'],
			'bakp_catatan' => implode(";", $_POST['catatan']),
			'bakp_kpd_name' => implode(";", $listPanitia),
			'bakp_kpd_cat' => implode(";", $_POST['panitia_category']),
			'bakp_kpd_as' => implode(";", $_POST['panitia_ketua']),
			'bakp_catatan_penawran' => implode(";", $_POST['catatan_penawran']),
			'bakp_nip' =>implode(";",$listNip)
		);


		$this->Procrfq_m->updateDataUskep($rfq_id, $data_update);
		$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();
	} else {


		$this->Procrfq_m->insertDataUskep(array(
			'rfq_number' => $rfq_id,
			'bakp_city' => $_POST['kota'],
			'bakp_catatan' => implode(";", $_POST['catatan']),
			'bakp_kpd_name' => implode(";", $listPanitia),
			'bakp_kpd_cat' => implode(";", $_POST['panitia_category']),
			'bakp_kpd_as' => implode(";", $_POST['panitia_ketua']),
			'bakp_catatan_penawran' => implode(";", $_POST['catatan_penawran']),
			'bakp_nip' =>implode(";",$listNip)

		));
		$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();

	}
}


}

//$this->db->where('divisi', $tender['ptm_dept_id']);
$this->db->where('tipe_uskep', 'BAKP');
$this->db->where($nilai_hps["hps_total"].' BETWEEN nilai_rab_start AND nilai_rab_end');
$this->db->where('tipe_proyek', $tender['ptm_tender_project_type']);


$headerKewenangan = $this->db->get('adm_matriks_kegiatan')->row_array();


$data=array(
	'tender' => $tender,
	'tgl_penetapan_pemenang' => $tgl_penetapan_pemenang,
	'nilai_hps' => $nilai_hps['hps_total'],
	'efesiensi' => $efesiensi,
	'first_price' => $first_price,
	'evaluation' => $eval,
	'panitia' => $panitia,
	'contract_number' => $rfq_id,
	'kota' => $getDataUskep['bakp_city'],
	'catatan' => explode(";", $getDataUskep['bakp_catatan']),
	'panitia_category' => explode(";", $getDataUskep['bakp_kpd_cat']),
	'panitia_ketua' => explode(";", $getDataUskep['bakp_kpd_as']),
	'panitia_name' => explode(";", $getDataUskep['bakp_kpd_name']),
	'panitia_category_d' => explode(";", $getDataUskep['depkn_kpd_cat']),
	'panitia_ketua_d' => explode(";", $getDataUskep['depkn_kpd_as']),
	'panitia_name_d' => explode(";", $getDataUskep['depkn_kpd_name']),
	'bakp_catatan_penawran' => explode(";", $getDataUskep['bakp_catatan_penawran']),
	'vendor_verifikasi' => $vendor_verifikasi,
	'data_uskep' => $getDataUskep,
	'ptm_id' => $rfq_id,
	'header_kewenangan' => $headerKewenangan,
);

//print_r($tender);

// PENILAIAN

$tgl_penetapan_pemenang = $tender['ptm_completed_date'];

if ($efesiensi <= 0) {
	$efesiensi = 0;
}

$first_price = array();

$this->db->distinct()->select("ptv_vendor_code");
$history = $this->Procrfq_m->getVendorQuoHistRFQ($tender['vendor_id'],$rfq_id)->result_array();

foreach ($history as $key => $value) {
	if(!isset($first_price[$value['ptv_vendor_code']])){
		$this->db->distinct()->select("total,total_ppn")->order_by("pqm_created_date","asc");
		$dat = $this->Procrfq_m->getVendorQuoHistRFQ($value['ptv_vendor_code'],$rfq_id)->row_array();
		$first_price[$value['ptv_vendor_code']] = array(
			"total"=>$dat['total'],
			"total_ppn"=>$dat['total_ppn'],
			);
	}
}

$data['first_price'] = $first_price;

$panitia = $this->Procpanitia_m->getPanitiaAnggota($tender['adm_bid_committee'])->result_array();

$vendor_verifikasi = $this->Procrfq_m->getVendorBidderRFQ2($rfq_id)->result_array();

$evaluation_method = $this->Procrfq_m->getEvalMethod($tender['evt_id'])->row_array();
$evaluation_method_details = $this->Procrfq_m->getEvalMethodDetails($tender['evt_id'])->result_array();

if (isset($_POST['kelengkapan'])) {
	if ($getDataUskep) {
		$data_update = array(
			'penilaian_kelengkapan' => implode(";", $_POST['kelengkapan']),
			'penilaian_kesesuaian' => implode(";", $_POST['kesesuaian']),
			'penilaian_boq' => implode(";", $_POST['kesesuaian_boq']),
			'penilaian_ttd' => $_POST['penilaian_ttd'],
		);
		$this->Procrfq_m->updateDataUskep($rfq_id, $data_update);
		$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();
	}
}

// DEPKN

$data_tender = $this->Procrfq_m->getRFQ($ptm_number)->result_array();

$plan_type = $data_tender[0]['ptm_type_of_plan'];
$req_pres_code = $data_tender[0]['ptm_requester_pos_code'];
$pagu_anggaran = $data_tender[0]['ptm_pagu_anggaran'];

$ppm_id = $this->Procedure_m->get_ppm_id_by_pr($data_tender[0]['pr_number']);
$manager_user = $this->Procedure_m->get_manager_user($ppm_id);

$activity_id = $tender['last_status'];
$items = [];

if ($activity_id == "1901"){
  	$items = $this->Procrfq_m->getEvalViewRFQvnd("",$ptm_number)->result_array();
}else{
	$this->db->select("tit_id,tit_code,tit_description,tit_quantity,tit_unit,tit_price,tit_currency,tit_type,tit_ppn,tit_pph,prc_tender_item.pr_number,pr_district_id,pr_district,pr_dept_id,pr_dept_name, ptv_vendor_code, vendor_name");

	$this->db->join("prc_pr_main","prc_pr_main.pr_number=prc_tender_item.pr_number","left");

	$this->db->order_by("tit_code","asc");
	$this->db->order_by("pr_dept_name","asc");
   	$items = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();
}

//cek item klarifikasi
$this->db->where('rfq_no', $ptm_number);
$item_klarifikasi = $this->db->get('prc_tender_item_klarifikasi_penawaran')->result_array();

$dataPenilaianDepkn=array(
	'evaluation_method' => $evaluation_method,
	'evaluation_method_details' => $evaluation_method_details,
	'kelengkapan' => explode(";", $getDataUskep['penilaian_kelengkapan']),
	'kesesuaian' => explode(";", $getDataUskep['penilaian_kesesuaian']),
	'penilaian_ttd' => $getDataUskep['penilaian_ttd'],
	'vendor' =>  $this->Procrfq_m->getVendorBidderQualifiedRFQLimit($ptm_number, 10)->result_array(),
	'name_apropal_1' =>  $manager_user['name'],
	'pos_apropal_1' =>  $manager_user['posisi'],
	'ptm_number' =>  $ptm_number,
	'item' => $items,
	'item_klarifikasi'  =>$item_klarifikasi
);

$data = array_merge($data,$dataPenilaianDepkn);
//$data = array_merge($data,$dataDepkn);


$this->load->view($view,$data);
//$this->template($view,"Generate PDF BAKP",$data);


$html = $this->output->get_output();
//$this->load->library('dompdf_gen');

// print_r($html);
// exit;

$dompdf= new Dompdf\Dompdf();
$dompdf->set_paper('a4');
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->set_option("isPhpEnabled", true);
$dompdf->load_html($html);
$dompdf->render();
//$dompdf->stream("BAKP-".date('YmdHis').'-'.$rfq_id.'.pdf');
$filename = "USKEP-".date('YmdHis').'-'.$rfq_id.'.pdf';
$output = $dompdf->output();
file_put_contents('uploads/'.$filename, $output);

$data_update = array(
	'filename' =>$filename,
	'is_generate'=>1,
);
$this->Procrfq_m->updateDataUskep($rfq_id, $data_update);

// $name_doc = "BAKP";
$full_url = base_url()."uploads/".$filename;


// $full_url_upload = base_url()."index.php/procurement/privyupload/".$rfq_id.'/'.$filename;
redirect($full_url);

//echo json_encode(array("message" => "PDF BAKP Berhasil Di Generete Dan Diupload Ke Privy", "url_file_mentah" => "https://escm.scmwika.com/uploads/".$filename));

// echo "<br><br><center><b>File PDF $name_doc Berhasil Dibuat</b></center><br><br>".
// "<center><a target='_blank' href = '$full_url'> Preview PDF  </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a target='_blank' href = '$full_url_upload'>Upload To Privy </a></center>";

exit;
