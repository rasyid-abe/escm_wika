  <?php 
  $view = 'pemaketan/matgis/pembuatan_matgis_v';

  $position = $this->Administration_m->getPosition("PIC USER");

if (!$position) {
	$this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

$data['pos'] = $position;

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$activity = $this->Procedure_m->getActivity(1000)->row_array();

// $project_cost = $this->Procpr_m->getProjectCost($pr_number)->result_array();

// $data['project_cost'] = $project_cost;

$data['content'] = $this->Workflow_m->getContentByActivity(1000)->result_array();

// /$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['del_point_list'] = $this->Administration_m->get_divisi_departemen()->result_array();
$data['contract_type'] = array("LUMPSUM" => "LUMPSUM");
$data['workflow_list'] = $this->Procedure_m->getResponseList($activity['awa_id']);
$data['pr_type'] = array("KONSOLIDASI" => "KONSOLIDASI", "NON KONSOLIDASI" => "NON KONSOLIDASI"); //y tipe pr

$this->db->limit(1);
$permintaan = $this->Procpr_m->getPR()->row_array();

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

$data['permintaan'] = $permintaan;
$this->session->unset_userdata("code_group");

$this->template($view, "Pembuatan Pengadaan Matgis", $data);
  