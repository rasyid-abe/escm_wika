<?php
$view = "procurement/doc_cetak/pdf_penawaran_harga_v";

$this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m"));

$get = $this->input->get();

$ptm_number = $id;
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
$data['data_uskep'] = $getDataUskep;

$menyetujui_name = array();
$menyetujui_posisi = array();
$mengetahui_name = array();
$mengetahui_posisi = array();
$diusulkan_name = array();
$diusulkan_posisi = array();

//cek item klarifikasi
$this->db->where('rfq_no', $ptm_number);
$item_klarifikasi = $this->db->get('prc_tender_item_klarifikasi_penawaran')->result_array();
//insert jika kosong

if(count($item_klarifikasi) == 0)
{
	$masterItem = $this->db->get('adm_item_klarifikasi')->result_array();
	foreach ($masterItem as $key => $value) {

		# code...
		$object['rfq_no'] = $ptm_number;
		$object['item_name'] = $value['item_klarifikasi'];
		$object['item_id'] = $value['id'];


		$this->db->insert('prc_tender_item_klarifikasi_penawaran', $object);

	}

	//cek item klarifikasi
	$this->db->where('rfq_no', $ptm_number);
	$item_klarifikasi = $this->db->get('prc_tender_item_klarifikasi_penawaran')->result_array();

}

$pr_tipe_pengadaan = 'proyek';
$pr_cat_management = 1;
$pr_jns_pengadaan = 'non-oa';
$pr_nilai_pengadaan = 'kecil';
$tipe_doc = 'depkn';

$this->db->where('tipe_proyek', $pr_tipe_pengadaan);
$this->db->where('is_category_management', $pr_cat_management);
$this->db->where('tipe_kontrak', $pr_jns_pengadaan);
$this->db->where('nilai', $pr_nilai_pengadaan);
$this->db->where('tipe_dokumen', $tipe_doc);
$this->db->select('max(order_no)');
$max = $this->db->get('vw_response_hcis')->row_array();

$depkn_ttd = [];
for ($i=1; $i <= (int)$max['max']; $i++) {
    $this->db->where('tipe_proyek', $pr_tipe_pengadaan);
    $this->db->where('is_category_management', $pr_cat_management);
    $this->db->where('tipe_kontrak', $pr_jns_pengadaan);
    $this->db->where('nilai', $pr_nilai_pengadaan);
    $this->db->where('order_no', $i);
    $this->db->where('tipe_dokumen', $tipe_doc);
    $depkn_ttd[] = $this->db->get('vw_response_hcis')->result_array();
}

// echo "<pre>";
// print_r($depkn_ttd);
// die;

$listTtd = [];

if ($getDataUskep) {

	$bakp_kpd_name = explode(";", $getDataUskep['bakp_kpd_name']);
	$bakp_kpd_cat = explode(";", $getDataUskep['bakp_kpd_cat']);
	$bakp_kpd_as = explode(";", $getDataUskep['bakp_kpd_as']);
	$par = 0;


	foreach ($bakp_kpd_name as $value) {

		$nama_array = explode(" - ", $value);


		if ($bakp_kpd_cat[$par] == "Menyetujui") {

			array_push($menyetujui_name, $nama_array[0]);
			if (count($nama_array) > 1) {
				array_push($menyetujui_posisi, $nama_array[1]);
			} else {
				array_push($menyetujui_posisi, "");
			}

		} else if ($bakp_kpd_cat[$par] == "Mengetahui") {

			array_push($mengetahui_name, $nama_array[0]);
			if (count($nama_array) > 1) {
				array_push($mengetahui_posisi, $nama_array[1]);
			} else {
				array_push($mengetahui_posisi, "");
			}

		} else if ($bakp_kpd_cat[$par] == "Mengusulkan") {

			array_push($diusulkan_name, $nama_array[0]);
			if (count($nama_array) > 1) {
				array_push($diusulkan_posisi, $nama_array[1]);
			} else {
				array_push($diusulkan_posisi, "");
			}

		}




		$par += 1;
	}
} else {
$rfq_id = $id;

$nilai_hps = $this->db->where("ptm_number",$rfq_id)->get('vw_prc_tender_hps')->row_array();

$efesiensi = $nilai_hps['hps_total'] - $tender['total_contract'];

	//project info
$this->db->where('kode_spk', $tender['spk_code']);
$projectInfo = $this->db->get('project_info')->row_array();
$tipeProject = $projectInfo == null ? "BESAR" : $projectInfo['tipe_proyek'];

$ptm_type_of_plan = $tender['ptm_type_of_plan'];

$tender['ptm_type_of_plan']  = $tender['ptm_type_of_plan'] == 'sap' ? 'rkp' : $tender['ptm_type_of_plan'];

$this->db->where('dept_id', $tender['ptm_dept_id']);
$dept = $this->db->get('adm_dept')->row_array();


//$this->db->where('divisi', $tender['ptm_dept_id']);
$this->db->where('tipe_uskep', 'BAKP');
$this->db->where('tipe_plan', $tender['ptm_type_of_plan']);



// if($tender['ptm_type_of_plan'] == "rkp_matgis")
// {
// $this->db->where('tipe_uskep', 'BAKP');
// }


$this->db->where($nilai_hps["hps_total"].' BETWEEN nilai_rab_start AND nilai_rab_end');
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
			if($value['nm_fungsi_bidang'] != "")
			{
			$this->db->where('nm_fungsi_bidang', $value['nm_fungsi_bidang']);

			}
			if($value['job_title'] == "MANAJER PROYEK MEGA")
			{
				$this->db->or_where('nm_jabatan', 'MANAJER PROYEK BESAR');

			}

			if($tender['spk_code'] != "")
			{
				if($ptm_type_of_plan != "sap")
				{
					$this->db->where('no_spk', $tender['spk_code']);
					$this->db->or_where('no_spk_rangkap', $tender['spk_code']);
				}


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

		//$this->db->where('direktorat', $dept['direktorat']);



		// if($value['is_search_divisi'] == 't')
		// {

		// 	$this->db->where('kd_dep', $tender['ptm_dep_code']);

		// }
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

$title = "";
if($headerKewenangan['tipe_plan'] == "rkp")
{
$title = "Komisi Pengadaan ".$headerKewenangan['komisi']." (".$tender['ptm_tender_project_type'].")";
} else if($headerKewenangan['tipe_plan'] == "rkp_matgis")
{
	$title = "Komisi Pengadaan Matgis ".$headerKewenangan['komisi'];

} else {
	$title = "Komisi Pengadaan Non Proyek ".$headerKewenangan['komisi'];

}

//count yang sudah sign privy
$this->db->where('rfq_no', $rfq_id);
$countHasSign = $this->db->get('prc_tender_privy_sign');

}


$data['menyetujui_name'] = $menyetujui_name;
$data['menyetujui_posisi'] = $menyetujui_posisi;
$data['mengetahui_name'] = $mengetahui_name;
$data['mengetahui_posisi'] = $mengetahui_posisi;
$data['diusulkan_name'] = $diusulkan_name;
$data['diusulkan_posisi'] = $diusulkan_posisi;
$data['item_klarifikasi'] = $item_klarifikasi;
$data['ttd_list'] = $listTtd;

$data['depkn_ttd'] = $depkn_ttd;


//$this->load->view($view, $data);
$this->template($view,"DEPKN FORM",$data);

/*
$html = $this->output->get_output();
$this->load->library('dompdf_gen');

$dompdf=new Dompdf\Dompdf();
$dompdf->set_paper('a3', 'landscape');
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("PENAWARAN-".date('YmdHis').'-'.$ptm_number.'.pdf');
*/
