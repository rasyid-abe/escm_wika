<?php 

$post = $this->input->post();

$view = 'contract/proses_kontrak/view/pembatalan_kontrak_v';

$contract_id =  $this->uri->segment(3, 0);

$data['id'] = $contract_id;

$this->data['dir'] = CONTRACT_FOLDER;

$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['district_list'] = $this->Administration_m->getDistrict()->result_array();
$data['contract_type'] = array("PO"=>"PO","SPK"=>"SPK","KONTRAK"=>"KONTRAK","PERJANJIAN"=>"PERJANJIAN");

$kontrak = $this->Contract_m->getData($contract_id)->row_array();

$ptm_number = $kontrak['ptm_number'];

//startcode helmi

$pqm = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->result_array();

$quo_id = array();

$vendor_list = array();
$vendor_qualified = array();
$head = array();
$harga = array();
$total_harga = array();

foreach ($pqm as $key => $value) {

	$vnd = $this->Procrfq_m->getVendorStatusRFQ($value['ptv_vendor_code'],$ptm_number)->row_array();
	
	if(!empty($vnd)){
		$quo_id[] = $value['pqm_id'];
		$vnd['type_quo'] = $value['pqm_type'];
		$vnd['id'] = $value['pqm_id'];

		if($vnd['pvs_status'] > 0){
		$vendor_list[] = $vnd;
			$vendor_qualified[] = $value['ptv_vendor_code'];
			$head[$vnd['vendor_name']] = array("bid_bond"=>$value['pqm_bid_bond_value'],"valid_time"=>$value['pqm_valid_thru'],
				"subtotal"=>0,"subtotal_tax"=>0,"total"=>0);
		}
	}

}

$this->db->where("tit_id !=",null)->where_in("pqm_id",$quo_id);

$myharga = $this->Procrfq_m->getViewVendorQuoComRFQ()->result_array();

foreach ($myharga as $key => $value) {

	if(in_array($value['ptv_vendor_code'], $vendor_qualified)){

		$head[$value['vendor_name']]['total'] += ($value['pqi_price']*$value['pqi_quantity']) + (($value['pqi_price']*$value['pqi_quantity']) * 
		(($value['pqi_ppn']+$value['pqi_pph'])/100));

	}
}

$data['nilai_kontrak'] = $head; 

//end

 $data['total_kontrak'] = $this->db->select('total_ppn')
                             ->join('ctr_contract_header b', 'a.vendor_name = b.vendor_name')
                             ->join('prc_tender_vendor_status c', 'a.ptm_number = c.ptm_number')
                             ->where(array('a.ptm_number'=>$ptm_number, 'b.ptm_number'=>$ptm_number, 'c.ptm_number'=>$ptm_number, 'c.pvs_is_winner'=>1))
                             ->get('vw_prc_quotation_vendor_sum a')
                             ->row_array();


$activity_id = (!empty($kontrak['status'])) ? $kontrak['status'] : 2000;

$activity = $this->Procedure2_m->getActivity($activity_id)->row_array();

$data['ptm_number'] = $ptm_number;

$data['activity_id'] = $activity_id;

$this->db->where("job_title","PENGELOLA KONTRAK");

$data['pelaksana_kontrak'] = $this->Administration_m->getUserRule()->result_array();

$manager_name = (!empty($kontrak['ctr_man_employee'])) ? 
$this->db->where("id",$kontrak['ctr_man_employee'])->get("adm_employee")->row()->fullname : "";

$data['manager_name'] = $manager_name;

$spe_name = (!empty($kontrak['ctr_spe_employee'])) ? 
$this->db->where("id",$kontrak['ctr_spe_employee'])->get("adm_employee")->row()->fullname : "";

$data['specialist_name'] = $spe_name;

$data['kontrak'] = $kontrak;

$eachhps = $this->Procrfq_m->getEachHPS($ptm_number, $kontrak['vendor_id'])->result_array();

$totalhps = 0;
foreach ($eachhps as $kh => $valhps) {
	$qty = $valhps['tit_quantity'];
	$price = $valhps['tit_price'];
	$totalhps += $qty * $price;
}

$hps = $this->Procrfq_m->getHPSRFQ($ptm_number)->row_array();

$data['hps'] = ($totalhps == "") ? $hps['hps_total'] : $totalhps;

$data['item'] = $this->Contract_m->getItem("",$contract_id)->result_array();

$data['milestone'] = $this->Contract_m->getMilestone("",$contract_id)->result_array();

$data['document'] = $this->Contract_m->getDoc("",$contract_id)->result_array();

$data['doc_category'] = $this->Contract_m->getDocType()->result_array();

$data['tender'] = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure2_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = $this->Comment_m->getContractActive($ptm_number, "", $kontrak['contract_id'])->result_array();

$data['controller_name'] = "contract";

//hlmifzi
$data['penilaian']= $this->db->get('adm_question_kpi_vendor')->result_array();

$this->session->set_userdata("rfq_id",$ptm_number);

$this->session->set_userdata("contract_id",$contract_id);

$this->session->unset_userdata("pembatalan_kontrak");
$this->session->unset_userdata("contract_id");

$this->load->view($view,$data);