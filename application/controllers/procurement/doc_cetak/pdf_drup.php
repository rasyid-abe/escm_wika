<?php
$this->load->library('terbilang');
$view = "procurement/doc_cetak/pdf_bakp_v";

$this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));

$rfq_id = $id;

$tender = $this->Procrfq_m->getMonitorRFQ($rfq_id)->row_array();

$prData = $this->Procrfq_m->getPRData($tender['pr_number'])->row_array();
$prDataComent = $this->Procrfq_m->getPRDataComment($tender['pr_number'])->result_array();
$PlainDataComent = $this->Procrfq_m->getPLainComment($prData['ppm_id'])->result_array();
$TenderDataComent = $this->Procrfq_m->getTenderComment($rfq_id)->result_array();
$UserByDepartment = $this->Procrfq_m->getListEmployeByDepartment($tender['ptm_dept_id'])->result_array();

$nama_user_approval = array();
foreach ($prDataComent as $value) {
	if ($value['ppc_name'] != '')
	array_push($nama_user_approval, trim($value['ppc_name'])." - ".trim($value['ppc_position']));
}


foreach ($PlainDataComent as $value) {
	if ($value['comment_name'] != '')
	array_push($nama_user_approval, trim($value['comment_name'])." - ".trim($value['pos_name']));
}

foreach ($TenderDataComent as $value) {
	if ($value['ptc_name'] != '')
	array_push($nama_user_approval, trim($value['ptc_name'])." - ".trim($value['ptc_position']));
}

foreach ($UserByDepartment as $value) {
	if ($value['fullname'] != '')
	array_push($nama_user_approval, trim($value['fullname'])." - ".trim($value['pos_name']));
}


$nama_user_approval = array_unique($nama_user_approval);

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

/*
foreach ($panitia as $value) {
	print_r($value);
	array_push($nama_user_approval, trim($value['fullname'])." - ".trim($value['committee_name']));
}
*/

//$nama_user_approval = array_unique($nama_user_approval);

$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();
$vendor_verifikasi = $this->Procrfq_m->getVendorBidderRFQ($rfq_id)->result_array();


$this->db->where('kegiatan_id', 3);
$listTtd = array();

$ttdList = $this->db->get('adm_matriks_kewenangan_kegiatan')->result_array();

if(count($ttdList) > 0 ){
	foreach ($ttdList as $key => $value) {
		# code...
		$listTtd[$key]['pos_id'] = $value['job_position_id'];
		$list = array();
		$this->db->where('pos_id', $value['job_position_id']);
		$list = $this->db->get('vw_user_employee')->result_array();

		$listTtd[$key]['lists_name'] = $list;

	}
}

//$tender['ptm_status'] = "1141";

$data=array(
	'tender' => $tender,
	'tgl_penetapan_pemenang' => $tgl_penetapan_pemenang,
	'nilai_hps' => $nilai_hps['hps_total'],
	'efesiensi' => $efesiensi,
	'first_price' => $first_price,
	'evaluation' => $eval,
	'panitia' => $panitia,
	'contract_number' => $rfq_id,
	'vendor_verifikasi' => $vendor_verifikasi,
	'ptm_id' => $rfq_id,
	'data_uskep' => $getDataUskep,
	'nama_user_approval' => $nama_user_approval,
	'ttd_list' => $listTtd
);

//print_r($tender);
$this->template($view,"BERITA ACARA KEPUTUSAN PEMENANG",$data);

//$this->load->view($view,$data);
/*
$html = $this->output->get_output();
$this->load->library('dompdf_gen');

$dompdf=new Dompdf\Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("BAKP-".date('YmdHis').'-'.$rfq_id.'.pdf');
*/
