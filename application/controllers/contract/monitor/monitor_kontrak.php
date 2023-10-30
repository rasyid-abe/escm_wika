<?php
	$this->session->unset_userdata("contract_id");
	$this->session->unset_userdata("ptm_number");
	$post = $this->input->post();

	$key = $this->input->post('siup_type_keyword');
	$divisi_keyword = $this->input->post('divisi_keyword');
	$startDate = $this->input->post('date_start');
	$endDate = $this->input->post('date_end');

	$view = 'contract/monitor/monitor_kontrak_v';

	$data = array("act"=>$act);

	$data['btn_contract'] = false;
	$data['btn_contract_sap'] = false;

	$siup_type = $this->db->select('siup_type')->distinct('siup_type')->get("vnd_header")->result_array();

	$data['siup_type'] = $siup_type;

	$ptm_dept_name = $this->db->select('ptm_dept_name')->distinct('ptm_dept_name')->get("prc_tender_main")->result_array();

	$data['ptm_dept_name'] = $ptm_dept_name;

	if(!empty($startDate)) {
		$data['monitor_kontrak_data'] = $this->Contract_m->getMonitorContract($startDate, $endDate);
		$data['monitor_kontrak_data_sap'] = $this->Contract_m->getMonitorContract_sap($startDate, $endDate);
	} elseif(!empty($key)) {
		$data['monitor_kontrak_data'] = $this->Contract_m->getMonitorContractByKeyword($key, $divisi_keyword);
		$data['monitor_kontrak_data_sap'] = $this->Contract_m->getMonitorContractByKeyword_sap($key, $divisi_keyword);
	} elseif(!empty($divisi_keyword)) {
		$data['monitor_kontrak_data'] = $this->Contract_m->getMonitorContractByKeyword($key, $divisi_keyword);
		$data['monitor_kontrak_data_sap'] = $this->Contract_m->getMonitorContractByKeyword_sap($key, $divisi_keyword);
	}  else {
		$data['monitor_kontrak_data'] = $this->Contract_m->getMonitor()->result();
		$data['monitor_kontrak_data_sap'] = $this->Contract_m->getMonitor_sap()->result();
	}

	$position = $this->Administration_m->getPosition("PIC USER");

	if($position) {
		$data['btn_contract'] = true;
		$data['btn_contract_sap'] = true;
	}

	if(!empty($act)) {
		$this->load->view($view,$data);
	} else {
		$this->template($view,"Monitor Kontrak",$data);
	}
?>
