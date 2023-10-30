<?php
	$view = 'uskep_online/edit_dpkn_sap_v';

	$row = $this->db->get_where('uskep_online', ['no_rfq' => $rfqcode])->row_array();
	$r_dpkn = json_decode($row['data_dpkn']);

	$data = array();

	$this->db->order_by("vendor_id", "asc");
	$data['bidderList'] = $this->db->get('vnd_header')->result_array();

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


	$data['tipe_proyek'] = $r_dpkn->tipe_proyek;
	$data['catmanagement'] = $r_dpkn->catmanagement;
	$data['jnspengadaan'] = $r_dpkn->jnspengadaan;
	$data['nilai'] = $r_dpkn->nilai;

	$data['rfq'] = $rfqcode;
	$data['mtd'] = $row['metode_pengadaan'];
	$data['winner'] = $row['win_type'];
	$data['projects'] = $this->db->get_where('prc_plan_main', ['ppm_is_sap' => 1])->result_array();

	$staf = array('STAF DEPARTEMEN','STAF PROYEK','STAFF');
	$this->db->where_not_in('nm_jabatan', $staf);
	$this->db->where('status', 'aktif');
	$data['hcis_list'] = $this->db->get('response_hcis')->result_array();

	$data['val_esign'] = json_decode($row['esign_dpkn']);

	$items = $this->db->get_where('prc_plan_item', ['ppm_id' => $spkk])->result_array();
	$data['items'] = $items;

	if ($cid != '-') {
		$data['cid'] = $cid;
	}

	$this->template($view,"USKEP ONLINE",$data);
?>
