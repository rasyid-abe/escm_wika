<?php
$this->load->library('terbilang');
$view = "procurement/doc_cetak/pdf_penilaian_v";

$this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));

$rfq_id = $id;

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


$vendor_verifikasi = $this->Procrfq_m->getVendorBidderRFQ2($rfq_id)->result_array();

$evaluation_method = $this->Procrfq_m->getEvalMethod($tender['evt_id'])->row_array();
$evaluation_method_details = $this->Procrfq_m->getEvalMethodDetails($tender['evt_id'],"1")->result_array();

$getDataUskep = $this->Procrfq_m->getUskepData($rfq_id)->row_array();


$prData = $this->Procrfq_m->getPRData($tender['pr_number'])->row_array();
$prDataComent = $this->Procrfq_m->getPRDataComment($tender['pr_number'])->result_array();
$PlainDataComent = $this->Procrfq_m->getPLainComment($prData['ppm_id'])->result_array();
$TenderDataComent = $this->Procrfq_m->getTenderComment($rfq_id)->result_array();
$UserByDepartment = $this->Procrfq_m->getListEmployeByDepartment($tender['ptm_dept_id'])->result_array();

$nama_user_approval = array();
//project info
$this->db->where('kode_spk', $tender['spk_code']);
$projectInfo = $this->db->get('project_info')->row_array();
$tipeProject = $projectInfo == null ? "BESAR" : $projectInfo['tipe_proyek'];

$tender['ptm_type_of_plan']  = $tender['ptm_type_of_plan'] == 'sap' ? 'rkp' : $tender['ptm_type_of_plan'];

//$this->db->where('divisi', $tender['ptm_dept_id']);
$this->db->where('tipe_uskep', 'BAKP');
$this->db->where('tipe_plan', $tender['ptm_type_of_plan']);


$this->db->where($nilai_hps["hps_total"].'BETWEEN nilai_rab_start AND nilai_rab_end');

if($tender['ptm_type_of_plan'] == "rkp")
{
	$this->db->where('tipe_proyek', $tipeProject);
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


//get penilaian sign
$this->db->where('tipe_uskep', 'PENILAIAN');
$this->db->where('tipe_plan', $tender['ptm_type_of_plan']);

if($tender['ptm_type_of_plan'] == "rkp")
{
	$this->db->where('komisi', $headerKewenangan['komisi']);
}

$headerKewenangan = $this->db->get('adm_matriks_kegiatan')->row_array();


if($headerKewenangan != "")
{
	$this->db->where('kegiatan_id', $headerKewenangan['id']);
	$this->db->order_by('order_no', 'asc');


	$ttdList = $this->db->get('adm_matriks_kewenangan_kegiatan')->result_array();


}



if(count($ttdList) > 0 ){
	foreach ($ttdList as $key => $value) {
		# code...

		if($value['job_title'] == "KEPALA SEKSI" && $tender['ptm_type_of_plan'] == "rkp")
		{
			$this->db->like('nm_jabatan', $value['job_title']);
			$this->db->where('nm_fungsi_bidang', $value['nm_fungsi_bidang']);

		} else {
			$this->db->where('nm_jabatan', $value['job_title']);

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

			else if($value['job_title'] == "MANAJER" && $tender['ptm_type_of_plan'] == "rkp")
			{

				$this->db->where('nm_direktorat', 'DIVISI SUPPLY CHAIN MANAGEMENT');
				//$this->db->where('kd_dep', $tender['ptm_dep_code']);
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


			else if($value['job_title'] == "PIC ANGGARAN")
			{
				$this->db->where('posisi', 'KEPALA DIVISI KEUANGAN');

			}
			else if(strpos($value['job_title'],"MANAJER PROYEK"))
			{
				$this->db->where('no_spk', $tender['spk_code']);

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

		}



		$this->db->where('status', 'aktif');
		$this->db->order_by('nm_peg', 'asc');

		$list = $this->db->get('response_hcis')->result_array();


		$name_list = array();

			foreach ($list as $key_hcis => $hcis) {
				# code...
				$name_list[$key_hcis]['fullname'] = $hcis['nm_peg'];
				$name_list[$key_hcis]['job_title'] = $hcis['nm_jabatan'];

			}

		$listTtd['lists_name'] = $name_list;





	}
}

$pr_tipe_pengadaan = 'proyek';
$pr_cat_management = 1;
$pr_jns_pengadaan = 'non-oa';
$pr_nilai_pengadaan = 'kecil';

$this->db->where('tipe_proyek', $pr_tipe_pengadaan);
$this->db->where('is_category_management', $pr_cat_management);
$this->db->where('tipe_kontrak', $pr_jns_pengadaan);
$this->db->where('nilai', $pr_nilai_pengadaan);
$this->db->where('tipe_dokumen', 'dsp');
$listTtd = $this->db->get('vw_response_hcis')->result_array();

// echo "<pre>";
// print_r($max);
// die;

foreach ($listTtd as $value) {
	array_push($nama_user_approval, $value['nm_peg'].'-'.$value['nm_jabatan']);
}

$nama_user_approval = array_unique($nama_user_approval);

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
	'data_uskep' => $getDataUskep,
	'nama_user_approval' => $nama_user_approval,
);

$this->template($view,"PENILAIAN",$data);
