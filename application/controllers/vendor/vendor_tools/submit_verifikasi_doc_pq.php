<?php 

$input = $this->input->post();
// var_dump($input);exit();
$user = $this->data['userdata'];

$response = array(-1 => "Revisi", 2 => "Setuju");

$activity_name = $input["status_inp"][0] == -1 ? "Revisi dokumen PQ/Tambahan" : "Dokumen PQ/Tambahan telah disetujui";

$vendor_com = [
  "vdpc_position" => $user['pos_id'],
  "vdp_id" => $input['id'],
  "vdpc_pos_name" => $user['pos_name'],
  "vdpc_name" => $user['complete_name'],
  "vdpc_activity" => $activity_name,
  "vdpc_start_date" => date("Y-m-d H:i:s"),
  "vdpc_end_date" => date("Y-m-d H:i:s"),
  "vdpc_response" => $response[$input["status_inp"][0]],
  "vdpc_comment" => $input["comment_inp"][0],
  // "vdpc_attachment" ,
  // "vdpc_next_pos_code" ,
  // "vdpc_next_pos_name" ,
  // "vdpc_activity_code" int4,
];

$this->db->trans_begin();
$dataUpdateHeader = array(
	"vdp_status" => $input["status_inp"][0],
	"vdp_she_main" => $input["SHE"][0] ? $input["SHE"] : '',
	"approved_datetime" => date('Y-m-d H:i:s')
);

$act = $this->Vendor_m->updatePqHeader($input['id'], $dataUpdateHeader);

$doc_pt = [];

	// $no=0;
	// foreach ($input["SHE"] as $key => $value) {
	// 	$doc_pt[$no]['vdp_she'] = $value;
	// 	$no++;
	// }

	$no2=0;
	foreach ($input['vdpd_id'] as $key => $value) {
		$doc_pt[$no2]['vdpd_id'] = $value;
		$no2++;
	}

	foreach ($doc_pt as $key => $value) {
		$dataUpdateDetailPQ['vdp_she'] = $value["vdp_she"];
		$act2 = $this->Vendor_m->updateDocPqDetail($value['vdpd_id'], $dataUpdateDetailPQ);
	}

if ($act) {
	$com = $this->Comment_m->insertDocPQ($vendor_com);
}

$getVendorId = $this->Vendor_m->getDocPq($input['id'])->row()->vendor_id;
$getEmailVendor = $this->Vendor_m->getVendor($getVendorId)->row()->email_address;


if($com){	
	if ($this->db->trans_status() === FALSE){
		$this->setMessage("Gagal mengubah data");
		$this->db->trans_rollback();
	}else{
		$this->setMessage("Berhasil mengubah data");
		$this->db->trans_commit();

		$msg = "Dengan hormat,
		<br/>
		<br/>
		Bersama ini kami informasikan bahwa ".COMPANY_NAME." telah menyetujui dokumen-dokumen PQ/tambahan yang disubmit oleh perusahaan Anda.
		<br/>
		Jika akun Anda masih baru atau belum aktif, akun Anda sedang dalam proses persetujuan untuk diaktivasi. Mohon tunggu pemberitahuan berikutnya dari kami melalui email untuk proses selanjutnya.
		<br/>
		<br/>
		Terimakasih,
		<br/>
		".COMPANY_NAME;

		$email = $this->sendEmail($getEmailVendor,"Pemberitahuan Aktivasi Vendor eSCM".COMPANY_NAME,$msg);
	}
}

redirect(site_url('vendor/daftar_pekerjaan'));