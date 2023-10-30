<?php
	$view = 'uskep_online/edit_dsp_sap_v';

	$data = array();

	$r = $this->db->get_where('uskep_online', ['no_rfq' => $rfqcode])->row_array();
	$dsp = json_decode($r['data_dsp']);
	$vendor = json_decode($r['vendor']);

	$data['edit'] = 1;
	$data['winner'] = $r['win_type'];
	$data['span'] = count($vendor);

	$data['pengadaan'] = $r['paket_pengadaan'];
	$data['no_rfq'] = $r['no_rfq'];
	$data['proyek'] = $dsp->proyek;
	$data['mtd'] = $r['metode_pengadaan'];

	$data['alpha'] = range('A', 'Z');

	$vvend = [];
	foreach ($vendor as $k => $v) {
		$this->db->where('vendor_id', $v);
		$vvend[] = $this->db->get('vnd_header')->row_array();
	}

	$data['vend'] = $vvend;
	$data['adm_status'] = $dsp->administrasi->status_vendor;
	$data['adm_poin'] = $dsp->administrasi->item_adm;
	$data['adm_bobot'] = $dsp->administrasi->bobot;
	$data['adm_vendor'] = $dsp->administrasi->vendor;

	$data['percent_teknis'] = $dsp->teknis->percent_teknis;
	$data['threshold'] = $dsp->teknis->threshold;
	$data['nilai'] = $dsp->teknis->nilai;
	$data['bobot'] = $dsp->teknis->bobot;
	$data['status'] = $dsp->teknis->status;
	$data['tek_poin'] = $dsp->teknis->poin;
	$data['idScore'] = $dsp->teknis->idScore;

	$data['percent_harga'] = $dsp->harga->percent_harga;
	$data['nilai_hps'] = $dsp->harga->nilai_hps;
	$data['nilai_hrg'] = $dsp->harga->nilai;
	$data['bobot_hrg'] = $dsp->harga->bobot;
	$data['harga_nego'] = $dsp->harga->harga_nego;
	$data['deviasi'] = $dsp->harga->deviasi;
	$data['evaluasi'] = $dsp->harga->evaluasi;
	$data['peringkat'] = $dsp->harga->peringkat;

	$data['esign'] = json_decode($r['esign_dsp']);
	$data['tipe_plan'] = $dsp->tipe_plan;
	$data['komisi_'] = $dsp->komisi_;



	if ($cid != '-') {
		$data['cid'] = $cid;
	}

	$this->template($view,"USKEP ONLINE",$data);
?>
