<?php
$this->load->library('terbilang');
$view = "procurement/doc_cetak/pdf_penilaian_print_v";

$this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));

$rfq_id =  $id;
if (isset($_POST['id'])) {
	$rfq_id = $_POST['id'];
}


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

$evaluation_method = $this->Procrfq_m->getEvalMethod($tender['evt_id'])->row_array();
$evaluation_method_details = $this->Procrfq_m->getEvalMethodDetails($tender['evt_id'])->result_array();

$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();
// echo "<pre>";
// print_r($_POST);
// die;

if (isset($_POST['kelengkapan'])) {
	if ($getDataUskep) {
		$data_update = array(
			'penilaian_kelengkapan' => implode(";", $_POST['kelengkapan']),
			'penilaian_kesesuaian' => implode(";", $_POST['kesesuaian']),
			'penilaian_boq' => implode(";", $_POST['kesesuaian_boq']),
			'penilaian_ttd' => $_POST['penilaian_ttd'],
			'penilaian_is_generate' => 1
		);
		$this->Procrfq_m->updateDataUskep($rfq_id, $data_update);
		$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();
	} else {
		$data_update = array(
			'penilaian_kelengkapan' => implode(";", $_POST['kelengkapan']),
			'penilaian_kesesuaian' => implode(";", $_POST['kesesuaian']),
			'penilaian_boq' => implode(";", $_POST['kesesuaian_boq']),
			'penilaian_ttd' => $_POST['penilaian_ttd'],
			'penilaian_is_generate' => 1,
			'rfq_number' =>$rfq_id
		);

		$this->db->insert('prc_tender_uskep_online', $data_update);

	}
}

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
	'evaluation_method' => $evaluation_method,
	'evaluation_method_details' => $evaluation_method_details,
	'kelengkapan' => explode(";", $getDataUskep['penilaian_kelengkapan']),
	'kesesuaian' => explode(";", $getDataUskep['penilaian_kesesuaian']),
	'penilaian_ttd' => $getDataUskep['penilaian_ttd'],
	'data_uskep' => $getDataUskep,
);

$this->setMessage("Simpan DSP Berhasil, lanjutkan Generate BAKP !");
  redirect(site_url("procurement/pdf_bakp/".$rfq_id));
//print_r($tender);

// $this->load->view($view,$data);




// $html = $this->output->get_output();


// //$this->load->library('dompdf_gen');

// $dompdf=new Dompdf\Dompdf();
// $dompdf->set_paper('a4');
// $dompdf->set_option('isHtml5ParserEnabled', true);
// $dompdf->set_option('isRemoteEnabled', true);
// $dompdf->set_option("isPhpEnabled", true);

// $dompdf->load_html($html);
// $dompdf->render();

// $filename = "SISTEMPENILAIAN-".date('YmdHis').'-'.$rfq_id.'.pdf';
// $output = $dompdf->output();
// file_put_contents('uploads/'.$filename, $output);

// $data_update = array(
// 	'filename_penilaian' =>$filename
// );

// $this->Procrfq_m->updateDataUskep($rfq_id, $data_update);

// $full_url = base_url()."uploads/".$filename;
// redirect($full_url);
//$dompdf->stream("SISTEMPENILAIAN-".date('YmdHis').'-'.$rfq_id.'.pdf');
