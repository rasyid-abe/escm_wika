<?php
	$this->load->library('terbilang');
	$view = 'uskep_online/edit_bakp_v';

	$row = $this->db->get_where('uskep_online', ['no_rfq' => $rfqcode])->row_array();
	$r_dsp = json_decode($row['data_dsp']);
	$r_dpkn = json_decode($row['data_dpkn']);
	$r_bakp = json_decode($row['data_bakp']);

	$twin = $row['win_type'];
	$esign_dpkn = json_decode($row['esign_dpkn']);

	$data = array();
	$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA");

	$arr_data = [];
	$arr_data['no_rfq'] = $rfqcode;
	$arr_data['pengadaan'] = $row['paket_pengadaan'];
	$arr_data['proyek'] = $row['proyek'];
	$arr_data['nilai_rab'] = $r_dpkn->total_rab;
	$arr_data['status_adm'] = $r_dsp->administrasi->status_vendor;
	$arr_data['tek_perc'] = $r_dsp->teknis->percent_teknis;
	$arr_data['threshold'] = $r_dsp->teknis->threshold;
	$arr_data['tek_nilai'] = $r_dsp->teknis->nilai;
	$arr_data['tek_bobot'] = $r_dsp->teknis->bobot;
	$arr_data['hrg_perc'] = $r_dsp->harga->percent_harga;
	$arr_data['hrg_hps'] = $r_dsp->harga->nilai_hps;
	$arr_data['hrg_nego'] = $r_dsp->harga->harga_nego;
	$arr_data['effisien'] = $r_dsp->harga->deviasi;
	$arr_data['hrg_nilai'] = $r_dsp->harga->nilai;
	$arr_data['hrg_bobot'] = $r_dsp->harga->bobot;
	$arr_data['hrg_tot_nilai'] = $r_dsp->harga->evaluasi;
	$arr_data['peringkat'] = $r_dsp->harga->peringkat;

	$vendor = [];
	foreach (json_decode($row['vendor']) as $key => $value) {
		$vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
		array_push($vendor, $vend['vendor_name']);
	}
	$arr_data['vendor'] = $vendor;

	$idx = [];
	for ($i=0; $i < $twin; $i++) {
		$idx[] = array_search((string)$i+1, $r_dsp->harga->peringkat);
	}

	$arr_win = $arr_omz = [];
	foreach ($idx as $key => $value) {
		$arr_win[] = $vendor[$value];
		$arr_omz[] = $r_dsp->harga->harga_nego[$value];
	}
	$arr_data['idx_win'] = $idx;
	$arr_data['vendor_win'] = $arr_win;
	$arr_data['vendor_omz'] = $arr_omz;

	$data['esign'] = $esign_dpkn;
	$data['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign_dpkn->keg_id])->row_array();
	$data['import'] = $arr_data;

	// bakp
	$data['nomor_bakp'] = $r_bakp->nomor_bakp;
	$data['tgl_bakp'] = $r_bakp->tgl_bakp;
	$data['hari'] = $r_bakp->hari;
	$data['tanggal'] = $r_bakp->tanggal;
	$data['bulan'] = $r_bakp->bulan;
	$data['tahun'] = $r_bakp->tahun;
	$data['fultgl'] = $r_bakp->fultgl;
	$data['tempat'] = $r_bakp->tempat;
	$data['daftar'] = $r_bakp->daftar;
	$data['penawaran'] = $r_bakp->penawaran;
	$data['catatan_tbl1'] = $r_bakp->catatan_tbl1;
	$data['catatan_tbl21'] = $r_bakp->catatan_tbl21;
	$data['catatan_tbl22'] = $r_bakp->catatan_tbl22;
	$data['tatatan_tbl24'] = $r_bakp->tatatan_tbl24;
	$data['note'] = $r_bakp->note;

	// echo "<pre>";
	// print_r($data);
	// die;

	$this->template($view,"USKEP ONLINE",$data);
?>
