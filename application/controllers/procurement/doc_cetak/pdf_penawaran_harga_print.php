<?php
$view = "procurement/doc_cetak/pdf_penawaran_harga_print_v";

$this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m"));


$get = $this->input->get();
// echo "<pre>";
// print_r($get);
// echo "<br>";
// print_r($_POST);
// die;

$ptm_number =  $id;
$rfq_id =  $id;

if (isset($_POST['id'])) {
	$ptm_number = $_POST['id'];
	$rfq_id =  $_POST['id'];

}

$tender = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();
$data_tender = $this->Procrfq_m->getRFQ($ptm_number)->result_array();

$plan_type = $data_tender[0]['ptm_type_of_plan'];
$req_pres_code = $data_tender[0]['ptm_requester_pos_code'];
$pagu_anggaran = $data_tender[0]['ptm_pagu_anggaran'];

$ppm_id = $this->Procedure_m->get_ppm_id_by_pr($data_tender[0]['pr_number']);
$manager_user = $this->Procedure_m->get_manager_user($ppm_id);

$activity_id = $tender['last_status'];

if ($activity_id == "1901"){
  	$data['item'] = $this->Procrfq_m->getEvalViewRFQvnd("",$ptm_number)->result_array();
}else{
	$this->db->select("tit_id,tit_code,tit_description,tit_quantity,tit_unit,tit_price,tit_currency,tit_type,tit_ppn,tit_pph,prc_tender_item.pr_number,pr_district_id,pr_district,pr_dept_id,pr_dept_name, ptv_vendor_code, vendor_name");

	$this->db->join("prc_pr_main","prc_pr_main.pr_number=prc_tender_item.pr_number","left");

	$this->db->order_by("tit_code","asc");
	$this->db->order_by("pr_dept_name","asc");
   	$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();
}

//$data['vendor_old'] = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();
$data['vendor'] = $this->Procrfq_m->getVendorBidderQualifiedRFQLimit($ptm_number, 10)->result_array();
$data['tender'] = $tender;

$data['name_apropal_1'] = $manager_user['name'];
$data['pos_apropal_1'] = $manager_user['posisi'];
$data['ptm_number'] = $ptm_number;


$getDataUskep = $this->Procrfq_m->getUskepData($ptm_number)->row_array();
if (isset($_POST['cara_pembayaran'])) {
	if ($getDataUskep) {
		$data_update = array(
			//'depkn_payment' => $_POST['kota'],
			//'depkn_payment' => implode(";", $_POST['cara_pembayaran']),
			//'depkn_taxs' => implode(";", $_POST['taxs']),
			//'depkn_other' => implode(";", $_POST['lain']),
			//'depkn_is_generate' => 1
		);
		$this->Procrfq_m->updateDataUskep($ptm_number, $data_update);
		$getDataUskep = $this->Procrfq_m->getUskepData($ptm_number)->row_array();
	}
}

if(isset($_POST['panitia_name']))
{
	$KOTA = "JAKARTA";

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
		$this->Procrfq_m->updateDataUskep($rfq_id, array(
			'depkn_kpd_name' => implode(";", $listPanitia),
			'depkn_kpd_cat' => implode(";", $_POST['panitia_category']),
			'depkn_kpd_as' => implode(";", $_POST['panitia_ketua']),
			'depkn_nip' =>implode(";",$listNip),
			'depkn_is_generate' => 1
		));
		$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();
	} else {

		$this->Procrfq_m->insertDataUskep(array(
			'rfq_number' => $rfq_id,
			'depkn_kpd_name' => implode(";", $listPanitia),
			'depkn_kpd_cat' => implode(";", $_POST['panitia_category']),
			'depkn_kpd_as' => implode(";", $_POST['panitia_ketua']),
			'depkn_nip' =>implode(";",$listNip),
			'depkn_is_generate' => 1

		));
		$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();

	}
}

//cek item klarifikasi
$this->db->where('rfq_no', $ptm_number);
$item_klarifikasi = $this->db->get('prc_tender_item_klarifikasi_penawaran')->result_array();
//insert jika kosong
$item = [];
if(count($item_klarifikasi) > 0)
{
	foreach ($item_klarifikasi as $key => $items) {

		# code...
		$postId = 'item_'.$items['id'];
		$post = $_POST[$postId];
		$item = implode(";",$post);
		$dataUpdateItem['item_value'] = $item;
		$this->db->where('id', $items['id']);
		$this->db->update('prc_tender_item_klarifikasi_penawaran', $dataUpdateItem);


	}

}

// $data['cara_pembayaran'] = explode(";", $getDataUskep['depkn_payment']);
// $data['taxs'] = explode(";", $getDataUskep['depkn_taxs']);
// $data['lain'] = explode(";", $getDataUskep['depkn_other']);

$getDataUskep = $this->Procrfq_m->getUskepData($ptm_number)->row_array();
$data['data_uskep'] = $getDataUskep;



$menyetujui_name = array();
$menyetujui_posisi = array();
$mengetahui_name = array();
$mengetahui_posisi = array();
$diusulkan_name = array();
$diusulkan_posisi = array();

if ($getDataUskep) {
	$depkn_kpd_name = explode(";", $getDataUskep['depkn_kpd_name']);
	$depkn_kpd_cat = explode(";", $getDataUskep['depkn_kpd_cat']);
	$depkn_kpd_as = explode(";", $getDataUskep['depkn_kpd_as']);
	$par = 0;
	foreach ($depkn_kpd_name as $value) {

		$nama_array = explode(" - ", $value);

		if ($depkn_kpd_cat[$par] == "Menyetujui") {

			array_push($menyetujui_name, $nama_array[0]);
			if (count($nama_array) > 1) {
				array_push($menyetujui_posisi, $nama_array[1]);
			} else {
				array_push($menyetujui_posisi, "");
			}

		} else if ($depkn_kpd_cat[$par] == "Mengetahui") {

			array_push($mengetahui_name, $nama_array[0]);
			if (count($nama_array) > 1) {
				array_push($mengetahui_posisi, $nama_array[1]);
			} else {
				array_push($mengetahui_posisi, "");
			}

		} else if ($depkn_kpd_cat[$par] == "Mengusulkan") {

			array_push($diusulkan_name, $nama_array[0]);
			if (count($nama_array) > 1) {
				array_push($diusulkan_posisi, $nama_array[1]);
			} else {
				array_push($diusulkan_posisi, "");
			}

		}




		$par += 1;
	}
}

$data['menyetujui_name'] = $menyetujui_name;
$data['menyetujui_posisi'] = $menyetujui_posisi;
$data['mengetahui_name'] = $mengetahui_name;
$data['mengetahui_posisi'] = $mengetahui_posisi;
$data['diusulkan_name'] = $diusulkan_name;
$data['diusulkan_posisi'] = $diusulkan_posisi;
$data['item_klarifikasi'] = $item_klarifikasi;
$data['panitia_name'] = explode(";", $getDataUskep['depkn_kpd_cat']);
$data['panitia_category'] = explode(";", $getDataUskep['depkn_kpd_as']);
$data['panitia_ketua'] = explode(";", $getDataUskep['depkn_kpd_name']);



$this->setMessage("Simpan DEPKN Berhasil, Silahkan lanjutkan Penilaian !");
redirect(site_url("procurement/pdf_penilaian/".$ptm_number));

// $this->load->view($view, $data);


// $html = $this->output->get_output();
// //$this->load->library('dompdf_gen');

// $dompdf=new Dompdf\Dompdf();
// $dompdf->set_paper('a3', 'landscape');
// $dompdf->set_option('isHtml5ParserEnabled', true);
// $dompdf->set_option('isRemoteEnabled', true);
// $dompdf->set_option("isPhpEnabled", true);

// $dompdf->load_html($html);
// $dompdf->render();
// //$dompdf->stream("DEPKN-".date('YmdHis').'-'.$ptm_number.'.pdf');


// $filename = "DEPKN-".date('YmdHis').'-'.$ptm_number.'.pdf';
// $output = $dompdf->output();
// file_put_contents('uploads/'.$filename, $output);

// $data_update = array(
// 	'filename_depkn' =>$filename,
// 	'is_generate'=>1,
// );
// $this->Procrfq_m->updateDataUskep($ptm_number, $data_update);


// $full_url = base_url()."uploads/".$filename;
// redirect($full_url);
