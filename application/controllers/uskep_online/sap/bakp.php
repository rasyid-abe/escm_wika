<?php
	$this->load->library('terbilang');
	$view = 'uskep_online/bakp_sap_v';
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
	$arr_data['proyek'] = $this->db->get_where('prc_plan_main', ['ppm_project_id' => $gget[0]])->row('ppm_subject_of_work');
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

	$uskep = $this->db->get_where('uskep_online', ['no_rfq' => $gget[3]]);

	$p = json_decode($uskep->row('data_dpkn'));

	$proyek = $p->tipe_proyek;
	$catmanagement = $p->catmanagement;
	$jnspengadaan = $p->jnspengadaan;
	$nilai = $p->nilai;

	$min = min($p->total_negosiai_vendor);

	$proyek_big = $min >= 100000000000 ? '1' : '0';

	$kelas = '';
	if ($p->catmanagement == '0') {
		if (($min <= 2000000000) && ($p->nilai == 'kecil')) {
			$kelas = 'low';
		} else if (($min <= 5000000000) && ($p->nilai == 'menengah')) {
			$kelas = 'low';
		} else if (($min <= 10000000000) && ($p->nilai == 'besar')) {
			$kelas = 'low';
		} else if (( ($min > 2000000000) && ($min <= 50000000000) ) && ($p->nilai == 'kecil')) {
			$kelas = 'medium';
		} else if (( ($min > 5000000000) && ($min <= 50000000000) ) && ($p->nilai == 'menengah')) {
			$kelas = 'medium';
		} else if (( ($min > 10000000000) && ($min <= 50000000000) ) && ($p->nilai == 'besar')) {
			$kelas = 'medium';
		} else {
			$kelas = 'high';
		}
	}

	// $nilai = $p->nilai;
	$doctype = 'bakp';

	if ($proyek != '') {
		$this->db->where('tipe_proyek', $proyek);
	}
	if ($catmanagement != '') {
		$this->db->where('is_category_management', $catmanagement);
	}
	if ($jnspengadaan != '') {
		$this->db->where('tipe_kontrak', $jnspengadaan);
	}
	if ($nilai != '') {
		$this->db->where('nilai', $nilai);
	}
	if ($kelas != '') {
		$this->db->where('kelas', $kelas);
	}
	if ($proyek_big != '') {
		$this->db->where('proyek_big', $proyek_big);
	}

	$this->db->where('tipe_dokumen', $doctype);
	$this->db->select('max(order_no)');
	$max = $this->db->get('vw_response_hcis')->row_array();

	$bakp_ttd = [];
	for ($i=1; $i <= (int)$max['max']; $i++) {
		if ($proyek != '') {
            $this->db->where('tipe_proyek', $proyek);
        }
        if ($catmanagement != '') {
            $this->db->where('is_category_management', $catmanagement);
        }
        if ($jnspengadaan != '') {
            $this->db->where('tipe_kontrak', $jnspengadaan);
        }
		if ($nilai != '') {
            $this->db->where('nilai', $nilai);
        }
        if ($kelas != '') {
            $this->db->where('kelas', $kelas);
        }
        if ($proyek_big != '') {
            $this->db->where('proyek_big', $proyek_big);
        }
		$this->db->where('tipe_dokumen', $doctype);
		$this->db->where('order_no', $i);
		$bakp_ttd[] = $this->db->get('vw_response_hcis')->result_array();
	}

	$data['ttd_bakp'] = $bakp_ttd;

	$data['import'] = $arr_data;
	$data['mtode'] = $db['metode_pengadaan'];

	$ccid = $this->db->get_where('ctr_contract_comment', ['ptm_number' => trim($gget[3])]);

	if ($ccid->num_rows() > 0) {
		$data['cid'] = $ccid->row('ccc_id');
	}

	$this->template($view,"USKEP ONLINE",$data);
?>
