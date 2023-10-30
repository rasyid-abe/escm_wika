<?php
	$this->load->library('terbilang');
	$view = 'uskep_online/bakp_v';
	// $position = $this->Administration_m->getPosition("PELAKSANA PENGADAAN");

	// if(!$position){
	// 	$this->noAccess("Hanya PELAKSANA PENGADAAN yang dapat membuat kontrak manual");
	// }

	$gget = json_decode($this->input->get('data'));
	$tender = $this->Procrfq_m->getMonitorRFQ($gget[3])->row_array();

	$data = array();
	$this->db->where('is_locked', '0');
	$data['adm_user'] = $this->db->get('adm_user')->result_array();
	$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA");
	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();
	// $data['tgl_penetapan_pemenang'] = $tender['ptm_completed_date'];
	$data['data_uskep'] = $this->Procrfq_m->getUskepData($gget[3])->row_array();

	$db = $this->db->get_where('uskep_online', ['no_rfq' => $gget[3]])->row_array();
	$dsp = json_decode($db['data_dsp']);
	$esign_dpkn = json_decode($db['esign_dpkn']);
	$twin = $db['win_type'];

	$arr_data = [];
	$arr_data['no_rfq'] = $gget[3];
	$arr_data['pengadaan'] = $gget[1];
	$arr_data['proyek'] = $this->db->get_where('project_info', ['kode_spk' => $gget[0]])->row('nama_spk');
	$arr_data['nilai_rab'] = $gget[4];
	$arr_data['status_adm'] = $dsp->administrasi->status_vendor;
	$arr_data['tek_perc'] = $dsp->teknis->percent_teknis;
	$arr_data['threshold'] = $dsp->teknis->threshold;
	$arr_data['tek_nilai'] = $dsp->teknis->nilai;
	$arr_data['tek_bobot'] = $dsp->teknis->bobot;
	$arr_data['hrg_perc'] = $dsp->harga->percent_harga;
	$arr_data['hrg_hps'] = $dsp->harga->nilai_hps;
	$arr_data['hrg_nego'] = $dsp->harga->harga_nego;
	$arr_data['effisien'] = $dsp->harga->deviasi;
	$arr_data['hrg_nilai'] = $dsp->harga->nilai;
	$arr_data['hrg_bobot'] = $dsp->harga->bobot;
	$arr_data['hrg_tot_nilai'] = $dsp->harga->evaluasi;
	$arr_data['peringkat'] = $dsp->harga->peringkat;

	$vendor = [];
	foreach ($gget[2] as $key => $value) {
		$vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
		array_push($vendor, $vend['vendor_name']);
	}
	$arr_data['vendor'] = $vendor;

	$idx = [];
	for ($i=0; $i < $twin; $i++) {
		$idx[] = array_search((string)$i+1, $dsp->harga->peringkat);
	}

	$arr_win = $arr_omz = [];
	foreach ($idx as $key => $value) {
		$arr_win[] = $vendor[$value];
		$arr_omz[] = $dsp->harga->harga_nego[$value];
	}
	$arr_data['idx_win'] = $idx;
	$arr_data['vendor_win'] = $arr_win;
	$arr_data['vendor_omz'] = $arr_omz;

	$data['esign'] = $esign_dpkn;
	$data['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign_dpkn->keg_id])->row_array();
	$data['import'] = $arr_data;

	$this->template($view,"USKEP ONLINE",$data);
?>
