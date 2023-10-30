<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procrfq_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function isKirimPenawaran($vendor_id, $ptm_number) {

		$this->db->where("ptm_number", $ptm_number);
		$this->db->where("ptv_vendor_code", $vendor_id);

		return $this->db->get("prc_tender_quo_main");
	}

	public function getListEmployeByDepartment($id){

		if(!empty($id)){

			//$this->db->where("adm_employee_pos.dept_id", $id);
			$this->db->where("adm_employee.status",1);
			$this->db->where("adm_employee_pos.is_active", "1");

		}

		$this->db->select("adm_employee.fullname, adm_employee_pos.pos_name");

		$this->db->join("adm_employee","adm_employee.id=adm_employee_pos.employee_id");


		return $this->db->get("adm_employee_pos");

	}

	public function getTenderComment($id){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("prc_tender_comment");

	}

	public function getPLainComment($id){

		if(!empty($id)){

			$this->db->where("ppm_id",$id);

		}

		return $this->db->get("prc_plan_comment");

	}

	public function getPRDataComment($id){

		if(!empty($id)){

			$this->db->where("pr_number",$id);

		}

		return $this->db->get("prc_pr_comment");

	}

	public function getPRData($id){

		if(!empty($id)){

			$this->db->where("pr_number",$id);

		}

		return $this->db->get("prc_pr_main");

	}

	public function getUskepData($rfq_number){

		if(!empty($rfq_number)){

			$this->db->where("rfq_number",$rfq_number);

		}

		return $this->db->get("prc_tender_uskep_online");

	}

	public function updateDataUskep($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('rfq_number',$id)->update('prc_tender_uskep_online',$input);


		}

	}

	public function insertDataUskep($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_tender_uskep_online",$input);
		}

	}

	public function insertMessageRFQ($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_bidder_message",$input);

			return $this->db->affected_rows();
		}

	}

	public function getMessageRFQ($code = "",$activity = ""){

		//$this->db->select("prc_bidder_message.*,vendor_name,awa_name,DATE_FORMAT(pbm_date,'%d-%m-%Y / %T') as pbm_date_format");
		// $this->db->select("prc_bidder_message.*,vendor_name,awa_name,TO_TIMESTAMP('pbm_date','YYYY-MM-DD HH:MI:SS') as pbm_date_format");
		$this->db->select("prc_bidder_message.*,vendor_name,awa_name,pbm_date as pbm_date_format");

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}

		if(!empty($activity)){

			$this->db->where("prc_bidder_message.awa_id",$activity);

		}

		$this->db->join("vnd_header","pbm_vendor_code=vendor_id","left");

		$this->db->join("adm_wkf_activity","adm_wkf_activity.awa_id=prc_bidder_message.awa_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_bidder_message");

	}

	public function getPQMID($vendor_id, $rfq_code) {
		if(!empty($vendor_id)){

			$this->db->where("ptv_vendor_code",$vendor_id);

		}

		if(!empty($rfq_code)){

			$this->db->where("ptm_number",$rfq_code);

		}


		return $this->db->get("prc_tender_quo_main");
	}

	public function getQuoTech($pqm_id, $pqt_item) {

		if(!empty($pqm_id)){

			$this->db->where("pqm_id",$pqm_id);

		}

		if(!empty($pqt_item)){

			$this->db->where("pqt_item",$pqt_item);

		}


		return $this->db->get("prc_tender_quo_tech");
	}

	public function getEvalMethodDetails($id,$mode = "") {
		$this->db->where("evt_id",$id);
		if($mode != "")
		{
			$this->db->where("etd_mode",$mode);
		}

		return $this->db->get("prc_evaluation_template_detail");
	}

	public function getMessageRFQnego($code = "",$activity = ""){

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}

		if(!empty($activity)){

			$this->db->where("awa_id",$activity);

		}

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("vw_msg_rfq_nego");
	}

	public function getEvalMethod($id) {
		$this->db->where("evt_id",$id);
		return $this->db->get("prc_evaluation_template");
	}


	public function getClaimRFQ($code = ""){

		$this->db->select("prc_tender_claim.*,vendor_name");

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}

		$this->db->join("vnd_header","pcl_vendor_id=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_claim");

	}

	public function getVendorBidderRFQ($code = ""){

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}
		$this->db->order_by("vendor_name","asc");
		return $this->db->get("vw_prc_bidder_list");

	}

	public function getVendorBidderRFQ2($code = ""){

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}
		$this->db->order_by("pvs_technical_status","desc");
		return $this->db->get("vw_prc_bidder_list");

	}

	public function getPrepRFQ($id){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("prc_tender_prep");

	}

	public function getRFQ($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("prc_tender_main");

	}

	public function getProjectCost($id){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}
		$this->db->select('pr_number');
		$data = $this->db->get("prc_tender_main")->row_array();

		$this->db->select('a.spk_code,a.coa_code,a.coa_name');
		$this->db->where('b.pr_number', $data['pr_number']);
		$this->db->join('prc_plan_main d', 'd.ppm_project_id = a.spk_code');
		$this->db->join('vw_daftar_pekerjaan_sppbj c', 'c.ppm_id = d.ppm_id');
		$this->db->join('prc_tender_main b', 'b.pr_number = c.pr_number');
		return $this->db->get('prc_plan_project_cost a');

	}

	public function getQuoItemRFQ($pqm_id = "",$tit_id = ""){

		if(!empty($pqm_id)){

			$this->db->where("pqm_id",$pqm_id);

		}

		if(!empty($tit_id)){

			$this->db->where("tit_id",$tit_id);

		}

		$this->db->order_by("pqm_id","desc");

		return $this->db->get("prc_tender_quo_item");

	}

	public function getQuoItemHistRFQ($pqm_id = "",$tit_id = ""){

		if(!empty($pqm_id)){

			$this->db->where("vendor_id",$pqm_id);

		}

		if(!empty($tit_id)){

			$this->db->where("tit_id",$tit_id);

		}

		//$this->db->order_by("pqm_hist_id","desc");

		return $this->db->get("vw_prc_quotation_item_hist");

	}


	public function getQuoItemHeaderRFQ($ptm_number = "",$ptv_vendor_code = ""){

		if(!empty($ptm_number)){

			$this->db->where("ptm_number",$ptm_number);

		}

		if(!empty($ptv_vendor_code)){

			$this->db->where("ptv_vendor_code",$ptv_vendor_code);

		}

		//$this->db->order_by("pqm_hist_id","desc");

		return $this->db->get("prc_tender_quo_main");

	}

	public function getVendorBidderQualifiedRFQLimit($code = "", $limit){

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}

		$this->db->join("vw_vnd_header",'vw_vnd_header.vendor_id = vw_prc_bidder_list.pvs_vendor_code');
		$this->db->order_by("amount", "ASC");
		$this->db->limit($limit);
		return $this->db->get("vw_prc_bidder_list");

	}

	public function getMonitorRFQ($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("vw_prc_monitor");

	}

	public function getMonitorRFQManual($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("prc_tender_main");

	}

	public function getMonitorRFQandBidder($id = ""){

		if(!empty($id)){

			$this->db->where("prc.ptm_number",$id);

		}

		$this->db->select('prc.ptm_created_date, prc.pr_number, prc.ptm_number, prc.ptm_requester_name, prc.ptm_sub_mata_anggaran, prc.ptm_nama_sub_mata_anggaran, prc.ptm_nama_mata_anggaran, prc.ptm_mata_anggaran, prc.ptm_subject_of_work, prc.ptm_packet, prc.ptm_dept_name, prc.jenis_pengadaan, prc.last_pos, prc.status, prc.ptm_dept_id, prc.ptm_dept, prc.last_status, prc.ptm_pagu_anggaran, prc.tender_metode, count(prc.ptm_number) as jml_bidder');
		$this->db->join('vw_prc_bidder_list bidder', 'prc.ptm_number = bidder.ptm_number', 'left');
		$this->db->group_by('prc.ptm_created_date, prc.pr_number, prc.ptm_number, prc.ptm_requester_name, prc.ptm_sub_mata_anggaran, prc.ptm_nama_sub_mata_anggaran, prc.ptm_nama_mata_anggaran, prc.ptm_mata_anggaran, prc.ptm_subject_of_work, prc.ptm_packet, prc.ptm_dept_name, prc.jenis_pengadaan, prc.last_pos, prc.status, prc.ptm_dept_id, prc.ptm_dept, prc.last_status, prc.ptm_pagu_anggaran, prc.tender_metode');

		$this->db->order_by("prc.ptm_created_date","desc");

		return $this->db->get("vw_prc_monitor prc");

	}

	public function getHPSRFQ($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("vw_prc_tender_hps");

	}

	public function getEachHPS($id = "", $vend = ""){

		if(!empty($id)){
			$this->db->where("ptm_number",$id);
		}

		if(!empty($vend)){
			$this->db->where("ptv_vendor_code", $vend);
		}

		return $this->db->get("prc_tender_item");

	}

	public function getUrutRFQ($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM ptm_created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(ptm_number) as urut");

		$get = $this->db->get("prc_tender_main")->row()->urut;

		return "RFQ.".date("Ym").".".urut_id($get+1,5);

	}

	public function insertDataRFQ($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_tender_main",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertItemRFQ($input=array()){

		if (!empty($input)){

			unset($input['tit_id']);

			$this->db->insert("prc_tender_item",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertPrepRFQ($input=array()){

		if (!empty($input)){

			unset($input['ptp_id']);

			$this->db->insert("prc_tender_prep",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateItemRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('tit_id',$id)->update('prc_tender_item',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptm_number',$id)->update('prc_tender_main',$input);

			return $this->db->affected_rows();

		}

	}

	// haqim
	public function getPekerjaanRFQ($id = "",$user = null,$buyer = null){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		if(!empty($buyer)){

			$this->db->where("ptm_buyer_id",$buyer);

		}

		$this->db->where("ptc_user",null);
		$this->db->or_where("ptc_user",$user);

		return $this->db->get("vw_daftar_pekerjaan_rfq");

	}
	
	// end

	public function getPekerjaanRFQSAP($id = "",$user = null,$buyer = null){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		if(!empty($buyer)){

			$this->db->where("ptm_buyer_id",$buyer);

		}

		$this->db->where("ptc_user",null);
		$this->db->or_where("ptc_user",$user);

		return $this->db->get("vw_daftar_pekerjaan_rfq_sap");

	}

	public function getPekerjaanRFQSAP_PO($id = "",$user = null,$buyer = null){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		if(!empty($buyer)){

			$this->db->where("ptm_buyer_id",$buyer);

		}

		$this->db->where("ptc_user",null);
		$this->db->or_where("ptc_user",$user);

		return $this->db->get("vw_daftar_pekerjaan_rfq_sap_v2");

	}

	public function getPerson($id = "",$ptm_number = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		if(!empty($ptm_number)){

			$this->db->where("ptm_number",$ptm_number);

		}

		$this->db->order_by("id","asc");

		return $this->db->get("prc_person_in_charge");

	}

	public function getDokumenRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptd_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("ptd_id","asc");

		return $this->db->get("prc_tender_doc");

	}


	public function getSmbCatalogByCode($code = ""){

		if(!empty($code)){

			$this->db->where("mat_catalog_code", $code);

		}

		return $this->db->get("com_mat_catalog_smbd");
	}

	public function getItemRFQ($code = "",$tender = "",$tit_code=""){

		$this->db->join("vnd_header", "vnd_header.vendor_id=prc_tender_item.ptv_vendor_code","left");

		if(!empty($code)){

			$this->db->where("tit_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("prc_tender_item.ptm_number",$tender);

		}

		if(!empty($tit_code)){

			$this->db->where("tit_code",$tit_code);

		}

		$this->db->order_by("tit_id","asc");

		return $this->db->get("prc_tender_item");

	}

	public function replacePerson($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ptm_number"=>$input['ptm_number'],"id"=>$id));
				$check = $this->getPerson()->row_array();
				if(!empty($check)){
					$last_id = $check['id'];
					$this->updatePerson($last_id,$input);
				} else {
					$this->insertPerson($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertPerson($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function replaceRks($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ptm_number"=>$input['ptm_number'],"id"=>$id));
				$check = $this->getPerson()->row_array();
				if(!empty($check)){
					$last_id = $check['id'];
					$this->updateRks($last_id,$input);
				} else {
					$this->insertRks($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertRks($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function replaceItemRFQ($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ptm_number"=>$input['ptm_number'],"tit_id"=>$id));
				$check = $this->getItemRFQ()->row_array();
				if(!empty($check)){
					$last_id = $check['tit_id'];
					$this->updateItemRFQ($last_id,$input);
				} else {
					$this->insertItemRFQ($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertItemRFQ($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function deleteIfNotExistItemRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("tit_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_item");
			return $this->db->affected_rows();
		}
	}

	public function insertPerson($input=array()){

		if (!empty($input)){

			unset($input['id']);

			$this->db->insert("prc_person_in_charge",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertRks($input=array()){

		if (!empty($input)){

			unset($input['id']);

			$this->db->insert("prc_tender_rks",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertDokumenRFQ($input){

		if (!empty($input)){

			unset($input['ptd_id']);

			$this->db->insert("prc_tender_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceDokumenRFQ($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptd_id"=>$id));
				$check = $this->getDokumenRFQ()->row_array();
				if(!empty($check)){
					$last_id = $check['ptd_id'];
					$input['ptd_id'] = $last_id;
					$this->updateDokumenRFQ($last_id,$input);
				} else {
					$this->insertDokumenRFQ($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertDokumenRFQ($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function deleteIfNotExistDokumenRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where(array("ptd_file_name"=>"","ptm_number"=>$id))->delete("prc_tender_doc");
			$this->db->where_not_in("ptd_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_doc");
			return $this->db->affected_rows();
		}
	}

	public function updatePerson($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('prc_person_in_charge',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateRks($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('prc_tender_rks',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDokumenRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptd_id',$id)->update('prc_tender_doc',$input);

			return $this->db->affected_rows();

		}

	}

	public function updatePrepRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptm_number',$id)->update('prc_tender_prep',$input);

			return $this->db->affected_rows();

		}

	}


	public function getVendorRFQ($code = "",$tender = ""){

		$this->db->select("prc_tender_vendor.*,vnd_header.vendor_name");

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->join("vnd_header","ptv_vendor_code=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_vendor");

	}

	public function insertVendorRFQ($input){

		if (!empty($input)){

			unset($input['ptv_id']);

			$this->db->insert("prc_tender_vendor",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateVendorRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptv_id',$id)->update('prc_tender_vendor',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceVendorRFQ($input){

		if(!empty($input)){

			$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptv_vendor_code"=>$input['ptv_vendor_code']));
			$check = $this->getVendorRFQ()->row_array();
			if(!empty($check)){
				$last_id = $check['ptv_id'];
				$this->updateVendorRFQ($last_id,$input);
			} else {
				$this->insertVendorRFQ($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function deleteIfNotExistPerson($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("id",$deleted)->where("ptm_number",$id)->delete("prc_person_in_charge");
			return $this->db->affected_rows();
		}
	}

	public function deleteIfNotExistRks($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("id",$deleted)->where("ptm_number",$id)->delete("prc_tender_rks");
			return $this->db->affected_rows();
		}
	}

	public function deleteIfNotExistVendorRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("ptv_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_vendor");
			return $this->db->affected_rows();
		}
	}

	public function getVendorStatusRFQ($code = "",$tender = ""){

		$this->db->select("prc_tender_vendor_status.*,vnd_header.vendor_name,vnd_header.email_address");

		if(!empty($code)){

			$this->db->where("pvs_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->join("vnd_header","pvs_vendor_code=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_vendor_status");

	}

	public function insertVendorStatusRFQ($input){

		if (!empty($input)){

			unset($input['pvs_id']);

			$this->db->insert("prc_tender_vendor_status",$input);

			return $this->db->affected_rows();

		}

	}


	public function replaceVendorStatusRFQ($input){

		if(!empty($input)){
			$this->db->where(array("ptm_number"=>$input['ptm_number'],"pvs_vendor_code"=>$input['pvs_vendor_code']));
			$check = $this->getVendorStatusRFQ()->row_array();

			if(!empty($check)){
				$last_id = $check['pvs_id'];
				$this->updateVendorStatusRFQ($last_id,$input);
			} else {
				$this->insertVendorStatusRFQ($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function updateVendorStatusRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pvs_id',$id)->update('prc_tender_vendor_status',$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteIfNotExistVendorStatusRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("pvs_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_vendor_status");
			return $this->db->affected_rows();
		}
	}

	public function getVendorQuoMainRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->join("vnd_header","ptv_vendor_code=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_quo_main");

	}

	public function getVendorPriceRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		//$this->db->order_by("pqm_id","asc");

		return $this->db->get("vw_prc_quotation_vendor_sum");

	}

	public function getVendorQuoRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("pqm_id","asc");

		return $this->db->get("vw_prc_vnd_quo");

	}

	public function getVendorQuoHistRFQ($code = "",$tender = ""){

		$this->db->select("vw_prc_quo_vnd_hist.*,pqm_created_date as pqm_created_date_format");

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("pqm_id","asc");

		return $this->db->get("vw_prc_quo_vnd_hist");

	}

	public function insertVendorQuoMainRFQ($input){

		if (!empty($input)){

			unset($input['pqm_id']);

			$this->db->insert("prc_tender_quo_main",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateVendorQuoMainRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pqm_id',$id)->update('prc_tender_quo_main',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceVendorQuoMainRFQ($input){

		if(!empty($input)){

			$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptv_vendor_code"=>$input['ptv_vendor_code']));
			$check = $this->getVendorQuoMainRFQ()->row_array();
			if(!empty($check)){
				$last_id = $check['pqm_id'];
				$this->updateVendorQuoMainRFQ($last_id,$input);
			} else {
				$this->insertVendorQuoMainRFQ($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function deleteIfNotExistVendorQuoMainRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("pqm_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_quo_main");
			return $this->db->affected_rows();
		}
	}

	public function getEvalViewRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("total","desc");

		return $this->db->get("vw_prc_evaluation");

	}

	public function getEvalViewRFQmulti($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}
		$this->db->where(array("adm"=>"Lulus", "pass"=>"Lulus"));
		$this->db->order_by("total","desc");

		return $this->db->get("vw_prc_evaluation");

	}

	    public function getEvalViewRFQvnd($code = "",$tender = ""){

        if(!empty($code)){

            $this->db->where("ptv_vendor_code",$code);

        }

        if(!empty($tender)){

            $this->db->where("ptm_number",$tender);

        }

        $this->db->order_by("total","desc");

        return $this->db->get("vw_prc_item_vendor");

    }


	public function updateVendorStatusByGrade($ptm_number = "",$activity = ""){

		$check = $this->getEvalViewRFQ("",$ptm_number)->result_array();

		foreach ($check as $key => $value) {

			$vnd_id = $value['ptv_vendor_code'];
			$last_status = 0;

			if($activity == "admin"){
				if($value['adm'] == "Lulus"){
					$last_status = 7;
				} else {
					$last_status = -7;
				}
			}
			if($activity == "teknis"){
				if($value['pass'] == "Lulus"){
					if($value['adm'] == "Lulus"){
						$last_status = 5;
					} else {
						$last_status = -7;
					}
				} else {
					$last_status = -5;
				}
			}
			if($activity == "harga"){
				if($value['adm'] == "Lulus" && $value['pass'] == "Lulus"){
					$last_status = 8;
				} else {
					$last_status = -8;
				}
			}

			if(!empty($last_status)){
				$this->db
				->where(
					array(
						"ptm_number"=>$ptm_number,
						"pvs_vendor_code"=>$vnd_id
						)
					)
				->update("prc_tender_vendor_status",
					array("pvs_status"=>$last_status)
					);
			}

		}

	}

	public function getEvalRFQ($code = "",$tender = ""){

		$this->db->select("PTE.*,VND.vendor_name");

		if(!empty($code)){

			$this->db->where("PTE.ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("PTE.ptm_number",$tender);

		}

		$this->db->order_by("vendor_name","asc");

		$this->db->join("vnd_header VND","PTE.ptv_vendor_code=VND.vendor_id","left");

		//$this->db->join("prc_tender_vendor_status PTVS","PTVS.pvs_vendor_code=PTE.ptv_vendor_code AND PTVS.ptm_number=PTE.ptm_number ","left");

		return $this->db->get("prc_tender_eval PTE");

	}

	public function getEvalComRFQ($code = "",$tender = "",$type = ""){

		if(!empty($code)){

			$this->db->where("pec_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		if(!empty($type)){

			$this->db->where("pec_mode",$type);

		}

		$this->db->order_by("pec_datetime","desc");

		return $this->db->get("prc_tender_eval_comment");

	}

	public function insertEvalComRFQ($input){

		if (!empty($input)){

			unset($input['pec_id']);

			$this->db->insert("prc_tender_eval_comment",$input);

			return $this->db->affected_rows();

		}

	}

	public function insertEvalRFQ($input){

		if (!empty($input)){

			unset($input['pte_id']);

			$this->db->insert("prc_tender_eval",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateEvalRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pte_id',$id)->update('prc_tender_eval',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceEvalRFQ($input){

		if(!empty($input)){

			$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptv_vendor_code"=>$input['ptv_vendor_code']));
			$check = $this->getEvalRFQ()->row_array();
			if(!empty($check)){
				$last_id = $check['pte_id'];
				$this->updateEvalRFQ($last_id,$input);
			} else {
				$this->insertEvalRFQ($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function deleteIfNotExistEvalRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("pte_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_eval");
			return $this->db->affected_rows();
		}
	}


	public function getVendorQuoTechRFQ($code = "",$pqm = ""){

		if(!empty($code)){

			$this->db->where("pqt_id",$code);

		}

		if(!empty($pqm)){

			$this->db->where("pqm_id",$pqm);

		}

		return $this->db->get("prc_tender_quo_tech");

	}

	public function getViewVendorQuoTechRFQ($code = "",$pqm = ""){

		if(!empty($code)){

			$this->db->where("pqt_id",$code);

		}

		if(!empty($pqm)){

			$this->db->where("pqm_id",$pqm);

		}

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("vw_prc_tender_quo_tech");

	}

	public function getViewVendorQuoComRFQ($code = "",$pqm = "", $ptm_number = ""){

		if(!empty($code)){

			$this->db->where("tit_id",$code);

		}

		if(!empty($pqm)){

			$this->db->where("pqm_id",$pqm);

		}

		if(!empty($ptm_number)){

			$this->db->where("vw_prc_quotation_item.ptm_number",$ptm_number);

		}

		$this->db->order_by("vw_prc_quotation_item.vendor_name","asc");

		return $this->db->get("vw_prc_quotation_item");

	}

	public function getViewVendorQuoComRFQ_Sap($code = "",$pqm = "", $ptm_number = ""){

		if(!empty($code)){

			$this->db->where("tit_id",$code);

		}

		if(!empty($pqm)){

			$this->db->where("pqm_id",$pqm);

		}

		if(!empty($ptm_number)){

			$this->db->where("vw_prc_quotation_item_sap.ptm_number",$ptm_number);

		}

		$this->db->order_by("vw_prc_quotation_item_sap.vendor_name","asc");

		return $this->db->get("vw_prc_quotation_item_sap");

	}

	public function updateQuoTechRFQ($id,$input){

		if(!empty($id) && !empty($input)){

			$this->db->where('pqt_id',$id)->update('prc_tender_quo_tech',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateStatusVendorByQuo($ptm_number,$vendor_id){
		$pqm = $this->db
		->where(array("ptv_vendor_code"=>$vendor_id,"ptm_number"=>$ptm_number))
		->get("prc_tender_quo_main")->row_array();
		$pqm_id = (!empty($pqm)) ? $pqm['pqm_id'] : "";
		if(!empty($pqm_id)){
			$quo_tech = $this->db->where("pqm_id",$pqm_id)->get("prc_tender_quo_tech")->result_array();
			$point = 0;
			$passing_grade = count($quo_tech)*2;
			foreach ($quo_tech as $key => $value) {
				if($value['pqt_check'] == 1){
					$point++;
				}
				if($value['pqt_check_vendor'] == 1){
					$point++;
				}
			}

			if($point == $passing_grade){
				$update = array("pvs_status"=>4);
			} else {
				$update = array("pvs_status"=>-4);
			}

			$this->db
			->where(array("pvs_vendor_code"=>$vendor_id,"ptm_number"=>$ptm_number))
			->update("prc_tender_vendor_status",$update);

		}
	}

	//haqim
	public function do_upload($name) {

        /*
			menggunakan config upload di construct controller
        */

        if(!$this->upload->do_upload($name)) //upload and validate
        {

            $this->upload->display_errors(); //show ajax error

        }
        return $this->upload->data('file_name');
    }

	public function chat_rfq($rfq_number,$ybs){

		$this->db->select('rfq_number,employee_from,employee_to,employee_cc,pesan,date,attach');
		$this->db->where('rfq_number', $rfq_number);
		$this->db->group_start();
		$this->db->like('employee_from', $ybs);
		$this->db->or_like('employee_to', $ybs);
		$this->db->or_like('employee_cc', $ybs);
		$this->db->group_end();
		$this->db->order_by('status', 'desc');
		$this->db->order_by('date', 'desc');

		return $this->db->get('prc_chat_rfq')->result_array();
	}

	public function submit_chat_rfq($data){
		$this->db->insert('prc_chat_rfq', $data);
		return $this->db->affected_rows();
	}
	//end

	public function getRFQbyPR($id='')
	{
		if (!empty($id)) {
			$this->db->like("pr_number", $id);
		}
		return $this->db->get("prc_tender_main")->row_array();
	}

	public function getCTRbyRFQ($id='')
	{
		if (!empty($id)) {
			$this->db->where("ptm_number", $id);
		}
		return $this->db->get("ctr_contract_header")->result_array();
	}

	public function getPelaksanaanDept($id = ""){
		if (!empty($id)) {
			$this->db->where("ptm_dept_id", $id);
		}
		return $this->db->get("vw_pelaksanaan_dept");
	}

	public function insert_tender_winner($data){ // multiwinner matgis
		$this->db->select('tit_id');
		$this->db->where(array('ptm_number'=>$data['ptm_number'],'tit_id'=>$data['tit_id'],'vendor_id'=>$data['vendor_id']));
		$check = $this->db->get('prc_tender_winner')->num_rows();

		if ($check > 0) {

			$this->db->where(array('ptm_number'=>$data['ptm_number'],'tit_id'=>$data['tit_id'],'vendor_id'=>$data['vendor_id']));
			$this->db->update('prc_tender_winner', $data);

		}else{
			$this->db->insert("prc_tender_winner",$data);

		}
	}

	public function getSubmittedItemRFQ($ptm_number){
		$this->db->where(array('ptm_number'=>$ptm_number));
		$this->db->order_by("tit_id","asc");
		return $this->db->get('prc_tender_winner');
	}
	
	public function getRksTender($ptm_number) {
		$this->db->where(array('ptm_number'=>$ptm_number));
		$this->db->order_by("id","asc");
		return $this->db->get('prc_tender_rks');
	}	
	
	public function getHeaderRKS() {
		$query = $this->db->query("select distinct header_main, flag from adm_rks order by flag asc");
		return $query;
	}
}
