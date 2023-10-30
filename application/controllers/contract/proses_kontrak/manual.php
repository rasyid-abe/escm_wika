<?php
	$view = 'contract/proses_kontrak/manual_kontrak_v';

	$position = $this->Administration_m->getPosition("PIC USER");

	if(!$position){
		$this->noAccess("Hanya PIC USER yang dapat membuat kontrak manual");
	}

	$data = array();

	$this->db->where('is_locked', '0');
	$data['adm_user'] = $this->db->get('adm_user')->result_array();

	$this->db->order_by('id');
	$data['res_incoterm'] = $this->db->get('adm_incoterm')->result_array();

	$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA");

	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();

	$this->db->where('stereotype', 'PROVINCE');
	$data['locations'] = $this->db->get('adm_ref_locations')->result_array();

	$uskep = $this->db->get_where('uskep_online', [
		'no_rfq' => $this->Procrfq_m->getUrutRFQ(),
		'is_sap' => 0, 
	])->row_array();
	if ($uskep != NULL) {

		if ($uskep['dsp_status_esign'] != NULL) {
			$data['dsp_status_esign'] = $uskep['dsp_status_esign'];
		} else {
			$data['dsp_status_esign'] = '';
		}

		if ($uskep['dpkn_status_esign'] != NULL) {
			$s_dpkn = [];
			$s_dpkn_total = 0;
			foreach (json_decode($uskep['dpkn_status_esign'])->recipients as $k => $v) {
				if ($v->activities->status == 'SIGN_DOCUMENT') {
					$s_dpkn_total++;
					$s_dpkn[] = 'PROGRESS';
				} else {
					$s_dpkn[] = 'DONE';
				}
			}
			$sts_dpkn = count($s_dpkn) == $s_dpkn_total ? 'done' : 'progress';
			$data['dpkn_status_esign'] = [$s_dpkn, $sts_dpkn];
		} else {
			$data['dpkn_status_esign'] = '';
		}

		if ($uskep['bakp_status_esign'] != NULL) {
			$s_bakp = [];
			$s_bakp_total = 0;
			foreach (json_decode($uskep['bakp_status_esign'])->recipients as $k => $v) {
				if ($v->activities->status == 'SIGN_DOCUMENT') {
					$s_bakp_total++;
					$s_bakp[] = 'PROGRESS';
				} else {
					$s_bakp[] = 'DONE';
				}
			}
			$sts_bakp = count($s_bakp) == $s_bakp_total ? 'done' : 'progress';
			$data['bakp_status_esign'] = [$s_bakp, $sts_bakp];
		} else {
			$data['bakp_status_esign'] = '';
		}

		$data['dsp'] = $uskep['data_dsp'];
		$data['dpkn'] = $uskep['data_dpkn'];
		$data['bakp'] = $uskep['data_bakp'];
		$data['rfq'] = $uskep['no_rfq'];
		$data['dsp_filename'] = $uskep['dsp_filename'];
		$data['dpkn_filename'] = $uskep['dpkn_filename'];
		$data['bakp_filename'] = $uskep['bakp_filename'];
	} else {
		$data['dsp'] = '';
		$data['dpkn'] = '';
		$data['bakp'] = '';
		$data['rfq'] = '';
		$data['dsp_filename'] = '';
		$data['dpkn_filename'] = '';
		$data['bakp_filename'] = '';
		$data['dsp_status_esign'] = '';
		$data['dpkn_status_esign'] = '';
		$data['bakp_status_esign'] = '';
	}

	$this->template($view,"Tambah Kontrak Manual PMCS",$data);
?>
