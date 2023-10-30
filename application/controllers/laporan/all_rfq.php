<?php 

/* hlmifzi */

$view = 'laporan/all_rfq_v';
$data = array();

$now = date('Y-m-d');

if (!empty($kode_group) || !empty($fin_class)) {
	if(strlen($kode_group) > 1 ) {
		$level2Commodity = $this->db->where('kode_group', $kode_group)->get('vw_jumlah_belanja')->row_array();
	}
	
	$status_vendor = $this->db->where('status_vendor', $kode_group)->get('vw_kinerja_vendor')->row_array();


	$fin_class_name = $this->db->where(['fin_class'=> $fin_class, 'kode_group' => $kode_group])->get('vw_statistik_vendor')->row_array();
}



switch($isi){
	//kinerja_vendor
	case 'kinerja_vendor':
	$judul = 'Vendor '.$status_vendor['vendor_status']; 
	$judul_pertama = 'Rekap Kinerja Vendor';
	$table = 'vw_vnd_header';
	$data['headTable'] = 'Nama Vendor';
	break;
    //end

	//jumlah belanja filter
	case 'vendor_rfq':
	$judul = 'Catalog '.$level2Commodity['name']; 
	$judul_pertama = 'Rekap Jumlah Belanja';
	$table = 'prc_tender_item as a';
	$data['headTable'] = 'Nomor RFQ';
	$data['namaPenjelasan'] = 'Deskripsi';

	break;
	//end

	//statistik vendor
	case 'vendor_id':
	$judul = 'Catalog '.$fin_class_name['kualifikasi'].' ( Vendor Klasifikasi '. $fin_class_name['klasifikasi'].' ) '; 
	$judul_pertama = 'Rekap Analisa Statistik Vendor';
	$table = 'vw_vnd_bidder_list';
	$data['headTable'] = 'Nama Vendor';
	break;
	//end

 	//kontrak
	case 'k1':
	$judul = 'Kontrak Aktif'; 
	$judul_pertama = 'Rekap Statistik Kontrak';
	$table = 'ctr_contract_header';
	$data['headTable'] = 'Nomor Kontrak';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;

	case 'k2':
	$judul = 'Kontrak Expired < 3 Bulan'; 
	$judul_pertama = 'Rekap Statistik Kontrak';
	$table = 'ctr_contract_header';
	$data['headTable'] = 'Nomor Kontrak';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;

	case 'k3':
	$judul = 'Kontrak Expired < 1 Bulan'; 
	$judul_pertama = 'Rekap Statistik Kontrak';
	$table = 'ctr_contract_header';
	$data['headTable'] = 'Nomor Kontrak';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;

	case 'k4':
	$judul = 'Kontrak Expired'; 
	$judul_pertama = 'Rekap Statistik Kontrak';
	$table = 'ctr_contract_header';
	$data['headTable'] = 'Nomor Kontrak';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;

 		//end kontrak

	//efisiensi pengadaan filter
	case 'Penunjukkan':
	$judul = 'Penunjukkan Langsung'; 
	$judul_pertama = 'Laporan Efisiensi';
	$table = 'prc_tender_prep a';
	$data['headTable'] = 'Nomor RFQ';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;

	case 'Pemilihan':
	$judul = 'Pemilihan Langsung'; 
	$judul_pertama = 'Laporan Efisiensi';
	$table = 'prc_tender_prep a';
	$data['headTable'] = 'Nomor RFQ';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;

	case 'Pelelanganaa':
	$judul = 'Pelelangan'; 
	$judul_pertama = 'Laporan Efisiensi';
	$table = 'prc_tender_prep a';
	$data['headTable'] = 'Nomor RFQ';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;
	case 0:
	$judul = 'Penunjukkan Langsung'; 
	$judul_pertama = 'Rekap Summary Proses Pengadaan';
	$table = 'prc_tender_prep a';
	$data['headTable'] = 'Nomor RFQ';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;
	case 1:
	$judul = 'Pemilihan Langsung'; 
	$judul_pertama = 'Rekap Summary Proses Pengadaan';
	$table = 'prc_tender_prep a';
	$data['headTable'] = 'Nomor RFQ';
	$data['namaPenjelasan'] = 'Deskripsi';
	break;
	case 2:
	$judul = 'Pelelangan'; 
	$judul_pertama = 'Rekap Summary Proses Pengadaan';
	$table = 'prc_tender_prep a';
	$data['headTable'] = 'Nomor RFQ';
	$data['namaPenjelasan'] = 'Deskripsi';
	break; 		

	default:
	echo "No Such Item";
}

$data['judula'] = 'Jumlah Data '.$judul;
$judul_atas = $judul_pertama.' / '.$judul;
if ($isi == 'vendor_rfq') {
	if(strlen($kode_group) == 14){
		$kodegroup_level_2 = substr($kode_group, 0,4);
	} elseif (strlen($kode_group) == 15) {
		$kodegroup_level_2 = substr($kode_group, 0,5);
	} elseif (strlen($kode_group) == 16) {
		$kodegroup_level_2 = substr($kode_group, 0,6);
	} elseif (strlen($kode_group < 14)) {
		$kodegroup_level_2 = $kode_group;
	}

	if(!empty($fin_class) || !empty($tgl_akhir)) {
		$query = $this->db
		->distinct()
		->select('a.ptm_number,prc_tender_main.ptm_subject_of_work as penjelasan')
		->like('tit_code', $kodegroup_level_2)
		->join('prc_tender_main', 'prc_tender_main.ptm_number = a.ptm_number', 'left')
		->where('ptm_completed_date is NOT NULL', NULL, FALSE)
		->where('ptm_completed_date >', $fin_class)
		->where('ptm_completed_date <', $tgl_akhir)
		->get($table)->result_array();		
	} else {
		$query = $this->db
		->distinct()
		->select('a.ptm_number, prc_tender_main.ptm_subject_of_work as penjelasan')
		->like('tit_code', $kodegroup_level_2)
		->join('prc_tender_main', 'prc_tender_main.ptm_number = a.ptm_number', 'left')
		->where('ptm_completed_date is NOT NULL', NULL, FALSE)
		->where('ptm_status','1901')
		->get($table)->result_array();
	}

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> RFQ';
	$data['rfq'] = $query;
	$data['tipe'] = 'rfq';

} elseif ($isi == 'vendor_id') {

	$query = $this->db
	->where(['code_group' => $kode_group,'fin_class' => $fin_class])
	->select("vendor_name AS ptm_number, vendor_id")->get($table)->result_array();

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> Vendor';
	$data['rfq'] = $query;
	$data['tipe'] = 'vendor_id';

} elseif ($isi == 'kinerja_vendor') {
	if ($kode_group == 9) {
		$query = $this->db->select("vendor_name AS ptm_number,vendor_id")->where('status',9)->get($table)->result_array();
	} elseif($kode_group == -3) {
		$query = $this->db->select("vendor_name AS ptm_number,vendor_id")->where('status',-3)->get($table)->result_array();
	} elseif($kode_group == 5) {
		$query = $this->db->select("vendor_name AS ptm_number,vendor_id")->where('status',5)->get($table)->result_array();
	}

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> Vendor';
	$data['rfq'] = $query;
	$data['tipe'] = 'vendor_id';
	/*Kontrak*/   
}  elseif ($isi == 'k1') {
	$where = [2901,2902,2903];
	$query = $this->db
	->select("contract_number AS ptm_number,contract_id,subject_work as penjelasan")
	->where_in('status',$where)
	->get($table)->result_array();

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> Contract';
	$data['rfq'] = $query;
	$data['tipe'] = 'contract';
} elseif ($isi == 'k2') {
	$query = $this->db->query('
		select ptm_number AS ptm_number,contract_id,subject_work as penjelasan 
		from `ctr_contract_header` where `end_date` > now() and (timestampdiff(MONTH,end_date,now())) > -3  
		')->result_array();

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> Contract';
	$data['rfq'] = $query;
	$data['tipe'] = 'contract';
} elseif ($isi == 'k3') {
	$query = $this->db->query('
		select ptm_number AS ptm_number,contract_id, subject_work as penjelasan
		from `ctr_contract_header` where `end_date` > now() and (timestampdiff(MONTH,end_date,now())) > -1  
		')->result_array();

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> Contract';
	$data['rfq'] = $query;
	$data['tipe'] = 'contract';
} elseif ($isi == 'k4') {
	$where = [2901,2902,2903];
	$query = $this->db->select("contract_number AS ptm_number,contract_id,subject_work as penjelasan")->where('end_date <', $now)->where_not_in('status',$where)->get($table)->result_array();

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> Contract';
	$data['rfq'] = $query;
	$data['tipe'] = 'contract';
 //end

} elseif ($isi == 'Penunjukkan') {
	if(!empty($fin_class) || !empty($tgl_akhir)) {
		$query = $this->db->query('
			SELECT
			a.ptm_number as ptm_number,
			a.ptm_subject_of_work as penjelasan,
			ptm_completed_date,
			b.ptp_tender_method 
			FROM
			( SELECT ptm_completed_date, ptm_pagu_anggaran, ptm_number, ptm_subject_of_work FROM prc_tender_main WHERE ptm_completed_date IS NOT NULL AND ptm_completed_date >= "'.$fin_class.'" AND ptm_completed_date <= "'.$tgl_akhir.'" ) a
			JOIN prc_tender_prep b ON a.ptm_number = b.ptm_number 
			WHERE
			b.ptp_tender_method = '.$kode_group.'

			')->result_array();
	} else {
		$query = $this->db->query('
			SELECT
			a.ptm_number as ptm_number,
			a.ptm_subject_of_work as penjelasan,
			ptm_completed_date,
			b.ptp_tender_method 
			FROM
			( SELECT ptm_completed_date, ptm_pagu_anggaran, ptm_number, ptm_subject_of_work FROM prc_tender_main WHERE ptm_completed_date IS NOT NULL ) a
			JOIN prc_tender_prep b ON a.ptm_number = b.ptm_number 
			WHERE
			b.ptp_tender_method = 0
			
			')->result_array();

	}

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> RFQ';
	$data['rfq'] = $query;
	$data['tipe'] = 'lain-lain';

} elseif ($isi == 'Pemilihan') {
	if(!empty($fin_class) || !empty($tgl_akhir)) {
		$query = $this->db->query('
			SELECT
			a.ptm_number as ptm_number,
			a.ptm_subject_of_work as penjelasan,
			ptm_completed_date,
			b.ptp_tender_method 
			FROM
			( SELECT ptm_completed_date, ptm_pagu_anggaran, ptm_number, ptm_subject_of_work FROM prc_tender_main WHERE ptm_completed_date IS NOT NULL AND ptm_completed_date >= "'.$fin_class.'" AND ptm_completed_date <= "'.$tgl_akhir.'" ) a
			JOIN prc_tender_prep b ON a.ptm_number = b.ptm_number 
			WHERE
			b.ptp_tender_method = '.$kode_group.'

			')->result_array();
	} else {
		$query = $this->db->query('
			SELECT
			a.ptm_number as ptm_number,
			a.ptm_subject_of_work as penjelasan,
			ptm_completed_date,
			b.ptp_tender_method 
			FROM
			( SELECT ptm_completed_date, ptm_pagu_anggaran, ptm_number, ptm_subject_of_work FROM prc_tender_main WHERE ptm_completed_date IS NOT NULL ) a
			JOIN prc_tender_prep b ON a.ptm_number = b.ptm_number 
			WHERE
			b.ptp_tender_method = 1
			
			')->result_array();

	}


	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label>  RFQ ';
	$data['rfq'] = $query;
	$data['tipe'] = 'lain-lain';
} elseif ($isi == 'Pelelanganaa') {


	if(!empty($fin_class) || !empty($tgl_akhir)) {
		$query = $this->db->query('
			SELECT
			a.ptm_number as ptm_number,
			a.ptm_subject_of_work as penjelasan,
			ptm_completed_date,
			b.ptp_tender_method 
			FROM
			( SELECT ptm_completed_date, ptm_pagu_anggaran, ptm_number, ptm_subject_of_work FROM prc_tender_main WHERE ptm_completed_date IS NOT NULL AND ptm_completed_date >= "'.$fin_class.'" AND ptm_completed_date <= "'.$tgl_akhir.'" ) a
			JOIN prc_tender_prep b ON a.ptm_number = b.ptm_number 
			WHERE
			b.ptp_tender_method = '.$kode_group.'

			')->result_array();
	} else {
		$query = $this->db->query('
			SELECT
			a.ptm_number as ptm_number,
			a.ptm_subject_of_work as penjelasan,
			ptm_completed_date,
			b.ptp_tender_method 
			FROM
			( SELECT ptm_completed_date, ptm_pagu_anggaran, ptm_number, ptm_subject_of_work FROM prc_tender_main WHERE ptm_completed_date IS NOT NULL ) a
			JOIN prc_tender_prep b ON a.ptm_number = b.ptm_number 
			WHERE
			b.ptp_tender_method = 2
			
			')->result_array();

	}


	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> RFQ';
	$data['rfq'] = $query;
	$data['tipe'] = 'lain-lain';

} elseif ($isi == 0) {

	if(!empty($kode_group) || !empty($fin_class)) {
		$query = $this->db
		->distinct()
		->select('a.ptm_number,b.ptm_subject_of_work as penjelasan')
		->join('prc_tender_main b', 'b.ptm_number = a.ptm_number', 'left')
		->where('ptp_tender_method', 0)
		->where('b.ptm_completed_date is NOT NULL', NULL, FALSE)
		->where('b.ptm_completed_date >', $kode_group)
		->where('b.ptm_completed_date <', $fin_class)	
		->get($table)->result_array();


	} else {
		$query = $this->db
		->select('a.ptm_number,b.ptm_subject_of_work as penjelasan')
		->join('prc_tender_main b', 'b.ptm_number = a.ptm_number', 'left')
		->where('ptp_tender_method', 0)
		->get($table)->result_array();

	}

	

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> RFQ';
	$data['rfq'] = $query;
	$data['tipe'] = 'lain-lain';

} elseif ($isi == 1) {

	if(!empty($kode_group) || !empty($fin_class)) {
		$query = $this->db
		->distinct()
		->select('a.ptm_number,b.ptm_subject_of_work as penjelasan')
		->join('prc_tender_main b', 'b.ptm_number = a.ptm_number', 'left')
		->where('ptp_tender_method', 1)
		->where('b.ptm_completed_date is NOT NULL', NULL, FALSE)
		->where('b.ptm_completed_date >', $kode_group)
		->where('b.ptm_completed_date <', $fin_class)	
		->get($table)->result_array();


	} else {
		$query = $this->db
		->select('a.ptm_number,b.ptm_subject_of_work as penjelasan')
		->join('prc_tender_main b', 'b.ptm_number = a.ptm_number', 'left')
		->where('ptp_tender_method', 1)
		->get($table)->result_array();

	}


	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> RFQ';
	$data['rfq'] = $query;
	$data['tipe'] = 'lain-lain';
} elseif ($isi == 2) {

	if(!empty($kode_group) || !empty($fin_class)) {
		$query = $this->db
		->distinct()
		->select('a.ptm_number,b.ptm_subject_of_work as penjelasan')
		->join('prc_tender_main b', 'b.ptm_number = a.ptm_number', 'left')
		->where('ptp_tender_method', 2)
		->where('b.ptm_completed_date is NOT NULL', NULL, FALSE)
		->where('b.ptm_completed_date >', $kode_group)
		->where('b.ptm_completed_date <', $fin_class)	
		->get($table)->result_array();


	} else {
		$query = $this->db
		->select('a.ptm_number,b.ptm_subject_of_work as penjelasan')
		->join('prc_tender_main b', 'b.ptm_number = a.ptm_number', 'left')
		->where('ptp_tender_method', 2)
		->get($table)->result_array();

	}

	$data['jumlah'] = '&nbsp;&nbsp;<label class="btn btn-xs btn-primary">'.count($query).'</label> RFQ';
	$data['rfq'] = $query;
	$data['tipe'] = 'lain-lain';
}

$this->template($view,$judul_atas,$data);
?>