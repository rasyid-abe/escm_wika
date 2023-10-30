<?php

	$view = 'pemaketan/sap/pembuatan_permintaan_pengadaan_v';

	$position = $this->Administration_m->getPosition("PELAKSANA PENGADAAN");

	if (!$position) {
		$this->noAccess("Hanya PELAKSANA PENGADAAN yang dapat membuat permintaan pengadaan");
	}

	$data['pos'] = $position;

	if (isset($_GET["data_pr"])) {

		$data_pr = json_decode($_GET["data_pr"]);

		foreach($data_pr as $kepr => $vpr) {
			$pr_v = $vpr;
		}

		$ppi_id = $this->db->where_in('ppi_id', $pr_v)->limit(1)->get('prc_pr_item')->row_array();

		$data['pr_main'] = $this->db->where_in('pr_number', $ppi_id['pr_number'])->limit(1)->get('prc_pr_main')->row_array();

		$data['pr_item_row'] = $this->db->where_in('pr_number', $ppi_id['pr_number'])->limit(1)->get('prc_pr_item')->row_array();

		$data['pr_item'] = $this->db->where_in('ppi_id', $pr_v)->get('vw_prc_perencanaan_rari')->result_array();

		$data["comment_list"][0] = $this->Comment_m->getProcurementPRActive($ppi_id['pr_number'])->result_array();

		// if ($data['pr_main']['pr_status'] > 1000) {
		// 	$this->setMessage("Gagal proses data. Perencanaan sudah digunakan.");
		// 	redirect("paket_pengadaan/paket_sap"); 
		// }
	}

	if (isset($_GET["edit_data_pr"])) {

		$data['pr_main'] = $this->db->where_in('pr_number', $_GET["edit_data_pr"])->limit(1)->get('prc_pr_main')->row_array();

		$data['pr_item_row'] = $this->db->where_in('pr_number', $_GET["edit_data_pr"])->limit(1)->get('prc_pr_item')->row_array();

		$data['pr_item'] = $this->db->where_in('pr_number', $_GET["edit_data_pr"])->get('vw_prc_perencanaan_rari')->result_array();

		$data["comment_list"][0] = $this->Comment_m->getProcurementPRActive($_GET["edit_data_pr"])->result_array();

		// if ($data['pr_main']['pr_status'] > 1000) {
		// 	$this->setMessage("Gagal proses data. Perencanaan sudah digunakan.");
		// 	redirect("paket_pengadaan/paket_sap"); 
		// }
	}

	$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

	$activity = $this->Procedure_m->getActivity(1000)->row_array();

	$data['content'] = $this->Workflow_m->getContentByActivity(1000)->result_array();
	$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
	$data['del_point_list'] = $this->Administration_m->get_divisi_departemen()->result_array();
	$data['contract_type'] = array("LUMPSUM" => "LUMPSUM");
	$data['workflow_list'] = $this->Procedure_m->getResponseList($activity['awa_id']);
	$data['pr_type'] = array("KONSOLIDASI" => "KONSOLIDASI", "NON KONSOLIDASI" => "NON KONSOLIDASI"); //y tipe pr

	$this->db->limit(1);
	$permintaan = $this->Procpr_m->getPR('','sap')->row_array();

	if (!empty($permintaan)) {
		foreach ($permintaan as $key => $value) {
			$permintaan[$key] = null;
		}
	}

	$skala_resiko = $this->db->where('jenis_penilaian', 'barang');
	$skala_resiko = $this->db->get('adm_nilai_resiko_paket');
	$data['skala_nilai'] = $skala_resiko->result_array();

	$skala_resiko_jasa = $this->db->where('jenis_penilaian', 'jasa');
	$skala_resiko_jasa = $this->db->get('adm_nilai_resiko_paket');
	$data['skala_nilai_jasa'] = $skala_resiko_jasa->result_array();

	$this->db->order_by('nilai', 'ASC');
	$skala_resiko_nilai = $this->db->get('adm_skala_resiko_paket');
	$data['skala_resiko_nilai'] = $skala_resiko_nilai->result_array();

	$data['adm_incoterm'] = $this->db->get('adm_incoterm')->result_array();

	$data['permintaan'] = $permintaan;
	$data['doc_type'] = $this->db->get('adm_doc_type')->result_array();
	$data['tax_code'] = $this->db->get('adm_tax_code')->result_array();	

	$this->session->unset_userdata("code_group");

	$this->session->unset_userdata("selection_vendor_tender");

	$this->template($view, $activity['awa_name'], $data);

?>