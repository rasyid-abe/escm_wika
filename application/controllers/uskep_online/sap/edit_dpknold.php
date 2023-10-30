<?php
	$view = 'uskep_online/edit_dpkn_sap_v';

	$row = $this->db->get_where('uskep_online', ['no_rfq' => $rfqcode])->row_array();
	$r_dsp = json_decode($row['data_dsp']);
	$r_dpkn = json_decode($row['data_dpkn']);
	$r_bakp = json_decode($row['data_bakp']);

	$data = array();

	$arr_data = [];
	$arr_data['kode_spk'] = $r_dpkn->proyek;
	$arr_data['pengadaan'] = $row['paket_pengadaan'];
	$arr_data['rfq'] = $rfqcode;
	$arr_data['proyek'] = $row['proyek'];
	$arr_data['code_proyek'] = $r_dpkn->proyek;

	$vendor = [];
	foreach (json_decode($row['vendor']) as $key => $value) {
		$vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
		array_push($vendor, $vend);
	}

	$arr_data['vendor'] = $vendor;
	$arr_data['span'] = 2 * count($vendor);

	$spkk = $this->db->get_where('prc_plan_main', ['ppm_project_id' => $r_dpkn->proyek])->row('ppm_id');
	$data['ppm_id'] = $spkk;
	$data['import'] = $arr_data;

	//dpkn
	$data['tgl_penawaran'] = $r_dpkn->tgl_penawaran;
	$data['klarifikasi_nego'] = $r_dpkn->klarifikasi_nego;
	$data['poin_penawaran'] = $r_dpkn->poin_penawaran;
	$data['poin_negosiasi'] = $r_dpkn->poin_negosiasi;
	$data['total_rab'] = $r_dpkn->total_rab;
	$data['total_penawaran_vendor'] = $r_dpkn->total_penawaran_vendor;
	$data['total_negosiai_vendor'] = $r_dpkn->total_negosiai_vendor;
	$data['klarifikasi'] = $r_dpkn->klarifikasi;
	$data['catatan'] = $r_dpkn->catatan;

	$tipePlan = $r_dpkn->tipe_plan;
	$tipeProyek = $r_dpkn->tipe_proyek;
	$komisi = $r_dpkn->komisi_;
	$spk = $rfqcode;

	$data['tipePlan'] = $tipePlan;
	$data['tipeProyek'] = $tipeProyek;
	$data['komisi'] = $komisi;

	$id = $this->db->get_where('adm_matriks_kegiatan', [
		'tipe_plan' => $tipePlan,
		'tipe_proyek' => $tipeProyek,
		'tipe_uskep' => 'BAKP',
		'komisi' => $komisi
	])->row('id');

	$data['keg_id'] = $id;

	$this->db->order_by('order_no', 'asc');
	$datas = $this->db->get_where('adm_matriks_kewenangan_kegiatan', [
		'kegiatan_id' => $id
	])->result();

	$arr = $res = [];
	foreach ($datas as $k => $v) {
		$arr['job_title'] = $v->job_title;
		$arr['nm_fungsi_bidang'] = $v->nm_fungsi_bidang;
		$arr['posisi'] = $v->posisi;
		$arr['kategori'] = $v->kategori;

		if(!strpos($v->job_title,"MANAJER PROYEK")) {
			$this->db->where('nm_jabatan', $v->job_title);
		}

		if ($v->job_title == "DIREKTUR" && $tipePlan == "rkp") {
			$this->db->where('posisi', 'DIREKTUR OPERASI 1');
		} else if($v->job_title == "DIREKTUR" && $tipePlan == "rkp_matgis") {
			$this->db->where('posisi', 'DIREKTUR QUALITY HEALTH SAFETY AND ENVIRONTMENT');
		} else if($v->job_title == "MANAJER" && $tipePlan == "rkp_matgis") {
			$this->db->where('nm_biro', 'SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS');
			//SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS
		} else if($v->job_title == "DIREKTUR" && $tipePlan == "rkap") {
			$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');
		} else if($v->job_title == "KEPALA DIVISI" && $tipePlan == "rkap") {
			$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');
		} else if($v->job_title == "KEPALA DIVISI" && $v->nm_fungsi_bidang == "OPERASI") {
			$this->db->like('direksi', 'DIREKTORAT OPERASI');
		} else if($v->job_title == "PIC ANGGARAN") {
			$this->db->where('posisi', 'KEPALA DIVISI KEUANGAN');
		} else if(strpos($v->job_title,"MANAJER PROYEK")) {
			if ($v->job_title == 'MANAJER PROYEK MEGA') {
				$this->db->like('nm_jabatan', 'MANAJER PROYEK BESAR');
			} else {
				$this->db->like('nm_jabatan', $v->job_title);
			}
			$this->db->where('nm_fungsi_bidang', $v->nm_fungsi_bidang);
			if ($spk != "") {
				$this->db->where('no_spk', $spk);
				$this->db->or_where('no_spk_rangkap', $spk);
			}
		}
		$this->db->where('status', 'aktif');
		$nm = $this->db->get('response_hcis')->result();

		$arr['nama'] = [];
		foreach ($nm as $i => $e) {
			$arr['nama'][] = $e->nm_peg;
		}

		array_push($res, $arr);
	}

	$data['esign'] = [$res, $arr];
	$data['val_esign'] = json_decode($row['esign_dpkn']);

	$items = $this->db->get_where('prc_plan_item', ['ppm_id' => $spkk])->result_array();
	$data['items'] = $items;

	if ($cid != '-') {
		$data['cid'] = $cid;
	}

	// echo "<pre>";
	// print_r($data);
	// die;
	$this->template($view,"USKEP ONLINE",$data);
?>
