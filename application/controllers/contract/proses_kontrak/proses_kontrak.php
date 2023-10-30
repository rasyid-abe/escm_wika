<?php

	$post = $this->input->post();

	$view = 'contract/proses_kontrak/proses_kontrak_v';

	$position = $this->Administration_m->getPosition("PIC USER");

	/*
	if(!$position){
	$this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
	}
	*/

	$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);


	$data['id'] = $id;

	$data['pos'] = $position;
	//haqim
	$this->data['dir'] = CONTRACT_FOLDER."/comment";
	//end

	$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
	$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
	$data['contract_type'] = array("PO"=>"PO","PERJANJIAN"=>"PERJANJIAN");
	$data['contract_item'] = array("BARANG"=>"BARANG","JASA"=>"JASA");

	$last_comment = $this->Comment_m->getContract("",$id,"")->row_array();

	$ptm_number = $last_comment['tender_id'];

	$contract_id = $last_comment['contract_id'];

	$activity_id = (!empty($last_comment['activity'])) ? $last_comment['activity'] : 2000;

	$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();

	$data['activity_id'] = $activity_id;

	if($activity_id == 2000){

		$kontrak = $this->Contract_m->getContractNew($ptm_number)->row_array();

	} else {

		$kontrak = $this->Contract_m->getData($contract_id)->row_array();

	}


	$data['currency'] = $this->Administration_m->get_currency()->result_array();

	$this->db->where(array(
		"job_title"=>"PENGELOLA KONTRAK",
		"district_id"=>$this->data['userdata']['district_id']
		));

	$data['pelaksana_kontrak'] = $this->Administration_m->getUserRule()->result_array();

	$this->db->where(array(
		"job_title"=>"MANAJER PENGADAAN",
		"district_id"=>$this->data['userdata']['district_id']
		));

	$data['manajer_kontrak'] = $this->Administration_m->getUserRule()->result_array();

	$data['last_comment'] = $last_comment;

	$data['tipe_pengadaan'] = $this->Administration_m->isHeadQuatersProcurement($ptm_number);

	//startcode helmi

	$quo_id = array();

	$vendor_list = array();
	$vendor_qualified = array();
	$head = array();
	$harga = array();
	$total_harga = array();

	$data['nilai_kontrak'] = $head;

	//end

	$data['total_kontrak'] = $this->db->select('*')
	                 ->join('ctr_contract_header b', 'a.vendor_name = b.vendor_name')
	                 ->join('prc_tender_vendor_status c', 'a.ptm_number = c.ptm_number')
	                 ->where(array('a.ptm_number'=>$ptm_number, 'b.ptm_number'=>$ptm_number, 'c.ptm_number'=>$ptm_number, 'c.pvs_is_winner'=>1))
	                 ->get('vw_prc_quotation_vendor_sum a')
	                 ->row_array();

	$data['kontrak'] = $kontrak;

	$manager_name = (!empty($kontrak['ctr_man_employee'])) ?
	$this->db->where("id",$kontrak['ctr_man_employee'])->get("adm_employee")->row()->fullname : "";

	$data['manager_name'] = $manager_name;

	$spe_name = (!empty($kontrak['ctr_spe_employee'])) ?
	$this->db->where("id",$kontrak['ctr_spe_employee'])->get("adm_employee")->row()->fullname : "";

	$data['specialist_name'] = $spe_name;

	if(isset($kontrak['ctr_is_matgis'])){

		$hps = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

		$data['rab'] = (isset($hps['hps_sum'])) ? $hps['hps_sum'] : 0;

	} else {

		$hps = $this->Procrfq_m->getEachHPS($ptm_number, $kontrak['vendor_id'])->result_array();

		$totalhps = 0;

		foreach ($hps as $kh => $valhps) {

			$qty = $valhps['tit_quantity'];

			$price = $valhps['tit_price'];

			$totalhps += $qty * $price;

		}

		$hps = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

		$data['rab'] = ($totalhps == "") ? $hps['hps_sum'] : $totalhps;

	}

	// $data['item'] = $this->Contract_m->getItem("",$contract_id)->result_array();
	$item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
	$data['item'] = $item2;
	$data['contract_id'] = $contract_id;

	// $data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();
	//

	$this->db->select_sum('subtotal_rab');
	$this->db->where('contract_id', $contract_id);
	$data['subtotal_rab'] = $this->db->get('vw_smbd_sum_rab')->row_array();

	$this->db->where('is_locked', '0');
	$data['adm_user'] = $this->db->get('adm_user')->result_array();

     //hlmifzi
	$data['kode_item'] = $this->Contract_m->getItem("",$contract_id)->row_array();
	//end

	$data['milestone'] = $this->Contract_m->getMilestone("",$contract_id)->result_array();

	$data['jaminan'] = $this->Contract_m->getJaminan("",$contract_id)->result_array();

	$data['person'] = $this->Contract_m->getPerson("",$contract_id)->result_array();

	$data['document'] = $this->Contract_m->getDoc("",$contract_id)->result_array();

	$data['doc_category'] = $this->Contract_m->getDocType()->result_array();

	$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

	
	$this->db->where('ptm_number',$ptm_number);
	$tenderMain = $this->db->get('prc_tender_main')->row_array();
	$projectName = $tenderMain['ptm_project_name'];
	$spkCode = explode("-",$projectName);
	
	$data['ptm_number'] = $ptm_number;

	$data['spk_code'] = $spkCode;

	$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

	$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);

	$data["comment_list"][0] = $this->Comment_m->getContractActive($ptm_number, "", $kontrak['contract_id'])->result_array();

	$data['history_amd'] = $this->Contract_m->getHistoryAmd($ptm_number, $kontrak['contract_number'])->result_array();

	$data['history_amd_num'] = $this->Contract_m->getHistoryAmd($ptm_number, $kontrak['contract_number'])->num_rows();

	$data["end_date_1"] = $this->Comment_m->getEndDate($ptm_number, ['2010'], $kontrak['contract_id'])->row_array();
	$data["end_date_2"] = $this->Comment_m->getEndDate($ptm_number, ['2027'], $kontrak['contract_id'])->row_array();
	$data["end_date_3"] = $this->Comment_m->getEndDate($ptm_number, ['2030'], $kontrak['contract_id'])->row_array();
	$data["end_date_4"] = $this->Comment_m->getEndDate($ptm_number, ['2901'], $kontrak['contract_id'])->row_array();
	$data["end_date_5"] = $this->Comment_m->getEndDate($ptm_number, ['2903'], $kontrak['contract_id'])->row_array();

	//start code hlmifzi
	$data['penilaian']= $this->db->get('adm_question_kpi_vendor')->result_array();

	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();

	$data['doc_type'] = $this->db->get('adm_doc_type')->result_array();

	$data['tax_code'] = $this->db->get('adm_tax_code')->result_array();

	$data['is_sap'] = $this->db->get_where('ctr_contract_header', ['contract_id' => $contract_id])->row('is_sap');

	$data['item_po'] = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->row('item_po');

	if($data['is_sap'] == "1"){

			$this->db->where("pr_number",$ptm_number);


			$data['tender'] = $this->db->get("vw_prc_monitor")->row_array();
	}

	

	$oop = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->row_array();
	$idko = "";
	if ($oop['pr_acc_assig'] == "U") {
		$idko = "PO Asset";
	} elseif ($oop['pr_cat_tech'] == 0) {
		$idko = "PO Barang";
	} elseif ($oop['pr_cat_tech'] == 9) {
		$idko = "PO Jasa";
	} elseif ($oop['pr_cat_tech'] == 5) {
		$idko = "PO Barang";
	}

	$data['idko'] = $idko;

	$ex = $this->db->get_where('ctr_contract_header', ['contract_id' => $contract_id])->row_array();
	if ($ex['contract_number'] != '') {
		$data['ex'] = $ex['contract_number'];
	} else {
		$data['ex'] = '';
	}

	$this->session->set_userdata("rfq_id",$ptm_number);

	$this->session->set_userdata("contract_id",$contract_id);

	$this->session->set_userdata("module",'contract');

	$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);

?>
