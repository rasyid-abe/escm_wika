<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Contract_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function get_vendor_info($id="")
	{
		if(!empty($id)){
			$this->db->where('vendor_id',$id);
		}

		return $this->db->get("vnd_header");;
	}

	public function getGrses($id="")
	{
		if(!empty($id)){
			$this->db->where('id',$id);
		}
		
		return $this->db->get("ctr_gr_ses");;
	}

	public function save_doc_matgis($data)
	{

		$this->db->insert('ctr_wo_doc', $data);
	}

	public function getContractNew($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		$this->db->where("last_status",1901);

		return $this->db->get("vw_prc_monitor");

	}

	public function getProgress($progress_id = "",$type = "",$jenis = ""){

		$data = array();

		if(!empty($progress_id)){

			$data['progress_id'] = $progress_id;

			if($type == "milestone"){

				$data['header'] = $this->getHeaderMilestoneProgress($jenis,$progress_id)->row_array();

				$this->db->select("contract_item_id as id,item_code as kode,long_description as deskripsi,uom as satuan,price as harga_satuan,qty as jumlah,min_qty as order_minimum,max_qty as order_maksimum");

				$data["item"] = $this->getItem(null,$data['header']['contract_id'])->result_array();

			} else {

				$data['header'] = $this->getHeaderWOProgress($jenis,$progress_id)->row_array();

				$data["item"] = $this->getItemProgress($progress_id)->result_array();

			}

			if(!empty($data['item'])){

				foreach ($data['item'] as $key => $value) {

					$data['item'][$key]['harga_satuan'] = inttomoney($value['harga_satuan']);
					$data['item'][$key]['jumlah'] = inttomoney($value['jumlah']);
					$data['item'][$key]['order_minimum'] = inttomoney($value['order_minimum']);
					$data['item'][$key]['order_maksimum'] = inttomoney($value['order_maksimum']);

				}

			}

			$contract = $this->getData($data['header']['contract_id'])->row_array();
			$data['header']['contract_amount'] = (!empty($contract)) ? inttomoney($contract['contract_amount']) : 0;

		}

		return $data;

	}

	public function getHeaderMilestoneProgress($type = "",$progress_id = ""){

		if(!empty($progress_id)){
			$this->db->where("progress_id",$progress_id);
		}

		if(!empty($type)){
			$this->db->where("type_inv",$type);
		}

		$this->db->select("b.*,a.contract_number,b.description as progress_description,c.contract_id,subject_work,
		CASE c.progress_status
		WHEN 1 THEN 'Menunggu Persetujuan PIC User'
		WHEN 2 THEN 'Menunggu Persetujuan Manajer User'
		WHEN 3 THEN 'Menunggu Persetujuan VP USER'
		WHEN 4 THEN 'Menunggu Persetujuan PIC BAST'
		WHEN 5 THEN 'Menunggu Persetujuan Manajer BAST'
		WHEN 6 THEN 'Finalisasi Persetujuan VP BAST'
		WHEN 99 THEN 'Revisi'
		ELSE 'Aktif' END AS activity,vendor_name,progress_id as progress_number,bastp_number,bastp_date
		")
		->join("ctr_contract_milestone c","c.milestone_id=b.milestone_id")
		->join("ctr_contract_header a","a.contract_id=c.contract_id");

		return $this->db->get("ctr_contract_milestone_progress b");
	}

	public function getHeaderWOProgress($type = "",$progress_id = ""){

		if(!empty($progress_id)){
			$this->db->where("progress_id",$progress_id);
		}

		if(!empty($type)){
			$this->db->where("type_inv",$type);
		}

		$this->db->select("b.*,c.po_number,contract_number,progress_description,subject_work,c.vendor_name,progress_id as progress_number,c.contract_id,
		CASE b.status
		WHEN 1 THEN 'Menunggu Persetujuan PIC User'
		WHEN 2 THEN 'Menunggu Persetujuan Manajer User'
		WHEN 3 THEN 'Menunggu Persetujuan VP USER'
		WHEN 4 THEN 'Menunggu Persetujuan PIC BAST'
		WHEN 5 THEN 'Menunggu Persetujuan Manajer BAST'
		WHEN 6 THEN 'Finalisasi Persetujuan VP BAST'
		WHEN 99 THEN 'Revisi'
		ELSE 'Aktif' END AS activity,bastp_number,bastp_date
		")
		->join("ctr_po_header c","c.po_id=b.po_id")
		->join("ctr_contract_header a","a.contract_id=c.contract_id");
		return $this->db->get("ctr_po_progress_header b");

	}

	public function getItemWOProgress($progress_id = ""){

		if(!empty($progress_id)){
			$this->db->where("progress_id",$progress_id);
		}

		$this->db->select("c.po_item_id as id,c.item_code as kode,c.short_description as deskripsi, c.uom as satuan, c.price as harga_satuan, approved_qty as jumlah, a.min_qty as order_minimum, a.max_qty as order_maksimum")
		->join("ctr_po_item c","c.po_item_id=b.po_item_id")
		->join("ctr_contract_item a","a.contract_item_id=c.contract_item_id","left")
		->order_by("progress_item_id","desc");
		return $this->db->get("ctr_po_progress_item b");
	}

	public function getUrutWO($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(po_id) as urut");

		$get = $this->db->get("ctr_po_header")->row()->urut;

		return "PO.".date("Ym").".".urut_id($get+1,5);

	}

	public function getUrutWOMatgis($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(wo_id) as urut");

		$get = $this->db->get("ctr_wo_header")->row()->urut;

		return "WO.".date("Ym").".".urut_id($get+1,5);

	}


	public function getUrut($tahun = "",$type = "",$type2 = "",$ishq = "",$divcode = ""){

		$this->load->model("Administration_m");

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		if(!empty($type)){
			if ($type == "HARGA SATUAN") {
				$search = "SPB";
			}else{
				$search = "SPERJ";
			}
			$this->db->like("contract_number",$search);
		}

		$this->db->select("COUNT(contract_number) as urut");

		$get = $this->db->get("ctr_contract_header")->row()->urut;

		$urut = "";

		$id = urut_id($get+1,4);

		if($type != "HARGA SATUAN"){
			$urut = "SPERJ.".$id."/".$divcode."/WIKA-".$tahun;
		} else {
			if($ishq){
				$urut = "SPB/".$type2.".".$id."/DPBJ-Pusat/".romanic_number(date("m"),true)."/WIKA-".$tahun;
			} else {
				$urut = "SPB/".$type2.".".$id."/DPBJ-".$divcode."/".romanic_number(date("m"),true)."/WIKA-".$tahun;
			}
		}

		return $urut;

	}

	public function getUrutCtr($tahun = "", $spk_code = ""){

		$this->db->select("COUNT(contract_number) as urut");

		$get = $this->db->get("ctr_contract_header")->row()->urut;

		$urut = "";

		$id = urut_id($get+1,4);

		$urut = $tahun . '-' . $spk_code . '-' . $id;

		return $urut;

	}

	public function getData($contract_id = "",$ptm_number = ""){

		if(!empty($ptm_number)){

			$this->db->where("a.ptm_number",$ptm_number);

		}

		if(!empty($contract_id)){

			$this->db->where("a.contract_id",$contract_id);

		}

		// $this->db->order_by("a.contract_id","desc");

		return $this->db->get("ctr_contract_header a");

	}

	public function getDataWO($po_id = "",$contract_id = ""){

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		if(!empty($po_id)){

			$this->db->where("po_id",$po_id);

		}

		$this->db->order_by("po_id","desc");

		return $this->db->get("ctr_po_header");

	}

	public function getDataSIMatgis($si_id = "",$contract_id = ""){

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		if(!empty($si_id)){

			$this->db->where("si_id",$si_id);

		}

		$this->db->order_by("si_id","desc");

		return $this->db->get("ctr_si_header");

	}
	public function getDataWOMatgis($wo_id = "",$contract_id = ""){

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		if(!empty($wo_id)){

			$this->db->where("wo_id",$wo_id);

		}

		$this->db->order_by("wo_id","desc");

		return $this->db->get("ctr_wo_header");

	}

	public function getDataSppm($sppm_id = "",$wo_id = ""){

		if(!empty($wo_id)){

			$this->db->where("wo_id",$wo_id);

		}

		if(!empty($sppm_id)){

			$this->db->where("wo_id",$sppm_id);

		}

		$this->db->order_by("sppm_id","desc");

		return $this->db->get("ctr_sppm_header");

	}

	public function getWOItem($po_item_id = "",$po_id = ""){

		$this->db->select("b.*,a.min_qty,a.max_qty");

		if(!empty($po_item_id)){

			$this->db->where("po_item_id",$po_item_id);

		}

		if(!empty($po_id)){

			$this->db->where("po_id",$po_id);

		}

		$this->db->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left");

		$this->db->order_by("po_item_id","desc");

		return $this->db->get("ctr_po_item b");

	}
	public function getWOMatgisItem($wo_item_id = "",$wo_id = ""){

		$this->db->select("b.*,a.min_qty,a.max_qty");

		if(!empty($wo_item_id)){

			$this->db->where("wo_item_id",$wo_item_id);

		}

		if(!empty($wo_id)){

			$this->db->where("wo_id",$wo_id);

		}

		$this->db->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left");

		$this->db->order_by("wo_item_id","desc");

		return $this->db->get("ctr_wo_item b");

	}
	public function getSIMatgisItem($si_item_id = "",$wo_id = ""){

		$this->db->select("b.*,a.min_qty,a.max_qty");

		if(!empty($si_item_id)){

			$this->db->where("si_item_id",$si_item_id);

		}

		if(!empty($wo_id)){

			$this->db->where("wo_id",$wo_id);

		}

		$this->db->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left");

		$this->db->order_by("si_item_id","desc");

		return $this->db->get("ctr_si_item b");

	}

	public function getItem($tit_id = "",$contract_id = ""){

		if(!empty($tit_id)){

			$this->db->where("tit_id",$tit_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("contract_id","desc");

		return $this->db->get("vw_smbd_sum_rab");

	}

	public function getMilestone($milestone_id = "",$contract_id = ""){

		if(!empty($milestone_id)){

			$this->db->where("milestone_id",$milestone_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("milestone_id","asc");

		return $this->db->get("ctr_contract_milestone");

	}

	public function getJaminan($id = "",$contract_id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		if(!empty($contract_id)){

			$this->db->where("cj_contract_id",$contract_id);

		}

		$this->db->order_by("id","asc");

		return $this->db->get("ctr_jaminan");

	}

	public function getPerson($id = "",$contract_id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		if(!empty($contract_id)){

			$this->db->where("cp_contract_id",$contract_id);

		}

		$this->db->order_by("id","asc");

		return $this->db->get("ctr_person_in_charge");

	}

	public function getHistoryAmd($ptm = "", $contract_number = ""){

		$this->db->where("ptm_number", $ptm);

		$this->db->where("contract_number !=", $contract_number);

		$this->db->order_by("contract_id", "asc");

		return $this->db->get("ctr_contract_header");

	}

	public function getInvoice($invoice_id = "",$contract_id = ""){

		if(!empty($invoice_id)){

			$this->db->where("invoice_id",$invoice_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("invoice_id","asc");

		return $this->db->get("ctr_invoice_header");

	}

	public function getInvoiceMilestone($invoice_id = "",$contract_id = ""){

		if(!empty($invoice_id)){

			$this->db->where("invoice_id",$invoice_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("invoice_id","asc");

		return $this->db->get("ctr_invoice_milestone_header");

	}

	public function getInvoiceItem($milestone_id = "",$invoice_id = ""){

		$this->db->select("ctr_invoice_item.*,ctr_contract_milestone.description,ctr_contract_milestone.percentage,ctr_contract_milestone.target_date");

		if(!empty($milestone_id)){

			$this->db->where("ctr_invoice_item.milestone_id",$milestone_id);

		}

		if(!empty($invoice_id)){

			$this->db->where("ctr_invoice_item.invoice_id",$invoice_id);

		}

		$this->db->join("ctr_contract_milestone","ctr_contract_milestone.milestone_id=ctr_invoice_item.milestone_id","left");

		$this->db->order_by("invoice_item_id","asc");

		return $this->db->get("ctr_invoice_item");

	}

	public function getInvoiceDoc($doc_id = "",$invoice_id = ""){

		if(!empty($invoice_id)){

			$this->db->where("invoice_id",$invoice_id);

		}

		if(!empty($doc_id)){

			$this->db->where("doc_id",$doc_id);

		}

		$this->db->order_by("doc_id","asc");

		return $this->db->get("ctr_invoice_doc");

	}

	public function getMilestoneProgress($progress_id = "",$milestone_id = ""){

		if(!empty($progress_id)){

			$this->db->where("progress_id",$progress_id);

		}

		if(!empty($milestone_id)){

			$this->db->where("milestone_id",$milestone_id);

		}

		$this->db->order_by("progress_id","asc");
		$this->db->join("ctr_contract_milestone c","c.milestone_id=a.milestone_id");
		$this->db->join("ctr_contract_header b","b.contract_id=c.contract_id");

		return $this->db->get("ctr_contract_milestone_progress a");

	}


	public function getMilestoneComment($comment_id = "",$milestone_id = ""){

		if(!empty($comment_id)){

			$this->db->where("comment_id",$comment_id);

		}

		if(!empty($milestone_id)){

			$this->db->where("milestone_id",$milestone_id);

		}

		$this->db->order_by("comment_id","asc");

		return $this->db->get("ctr_contract_milestone_comment");

	}

	public function getDoc($doc_id = "",$contract_id = ""){

		if(!empty($doc_id)){

			$this->db->where("doc_id",$doc_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("doc_id","asc");

		return $this->db->get("ctr_contract_doc");

	}


	public function getSIDoc($doc_id = "",$si_id = ""){

		if(!empty($doc_id)){

			$this->db->where("doc_id",$doc_id);

		}

		if(!empty($si_id)){

			$this->db->where("si_id",$si_id);

		}

		$this->db->order_by("doc_id","asc");

		return $this->db->get("ctr_si_doc");

	}

	public function replaceDoc($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("contract_id"=>$input['contract_id'],"doc_id"=>$id));
				$check = $this->getDoc()->row_array();
				if(!empty($check)){
					$last_id = $check['doc_id'];
					$this->updateDoc($last_id,$input);
				} else {
					$this->insertDoc($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertDoc($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function updateDoc($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('doc_id',$id)->update('ctr_contract_doc',$input);

			return $this->db->affected_rows();

		}

	}


	public function insertDoc($input){

		if (!empty($input)){

			unset($input['doc_id']);

			$this->db->insert("ctr_contract_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteIfNotExistDoc($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where(array("filename"=>"","contract_id"=>$id))->delete("ctr_contract_doc");
			$this->db->where_not_in("doc_id",$deleted)->where("contract_id",$id)->delete("ctr_contract_doc");
			return $this->db->affected_rows();
		}
	}

	public function getDocType(){

		$this->db->order_by("cdt_id","asc");

		return $this->db->get("ctr_doc_type");

	}


	public function insertData($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_contract_header",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertItem($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_contract_item",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateItemSap($input=array()){

		if (!empty($input)){

			$this->db->where('contract_id', $input['contract_id']);
			$this->db->delete('ctr_contract_item');

			$this->db->insert("ctr_contract_item",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateData($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('contract_id',$id)->update('ctr_contract_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function insertWOData($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_po_header",$input);

			return $this->db->affected_rows();
		}

	}
	public function insertWODataMatgis($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_wo_header",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertSPPMMatgis($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_sppm_header",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertSIDataMatgis($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_si_header",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateWOData($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('po_id',$id)->update('ctr_po_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateWODataMatgis($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('wo_id',$id)->update('ctr_wo_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function getPekerjaan($id = "",$user = ""){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}
		$this->db->where("is_sap", "NO");

		$this->db->where(array("ccc_name"=>null,"ccc_end_date"=>null,"amandemen_number"=>null));

		$this->db->where_not_in("ccc_activity",array(2902,2903,2904));

		if(!empty($user)){

			$this->db->group_start();

			$this->db->where("ccc_user",null);

			$this->db->or_where("ccc_user",$user);

			$this->db->group_end();

		}

		return $this->db->get("vw_daftar_pekerjaan_kontrak");

	}

	public function getPekerjaan_sap($id = "",$user = ""){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}

		$this->db->where("is_sap", "YES");

		$this->db->where(array("ccc_name"=>null,"ccc_end_date"=>null,"amandemen_number"=>null));

		$this->db->where_not_in("ccc_activity",array(2902,2903,2904));

		if(!empty($user)){

			$this->db->group_start();

			$this->db->where("ccc_user",null);

			$this->db->or_where("ccc_user",$user);

			$this->db->group_end();

		}

		return $this->db->get("vw_daftar_pekerjaan_kontrak");

	}

	public function getPekerjaan_po_manual($id = "",$user = "", $ty){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}

		$this->db->where("is_sap", "YES");

		if ($ty == 'user') {
			$this->db->where("ccc_user",$user);
			$this->db->where("ctr_is_manual",'YES');
		} elseif ($ty == 'legal') {
			$this->db->where("ctr_is_manual",'YES');
			$this->db->where("ccc_user",$user);
			$this->db->where("ctr_po_number is NOT NULL", NULL, FALSE);
		} else {

			$this->db->where(array("ccc_name"=>null,"ccc_end_date"=>null,"amandemen_number"=>null));

			$this->db->where_not_in("ccc_activity",array(2902,2903,2904));

			if(!empty($user)){

				$this->db->group_start();

				$this->db->where("ccc_user",null);

				$this->db->or_where("ccc_user",$user);

				$this->db->group_end();

			}
		}


		return $this->db->get("vw_daftar_pekerjaan_kontrak");

	}


	public function getPekerjaanAmandemen($id = "",$user = ""){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}

		$this->db->where(array("ccc_name"=>null,"ccc_end_date"=>null,"amandemen_number !="=>null));

		$this->db->where_not_in("ccc_activity",array(2902,2903,2904));

		if(!empty($user)){

			$this->db->group_start();

			$this->db->where("ccc_user",null);

			$this->db->or_where("ccc_user",$user);

			$this->db->group_end();

		}

		$this->db->order_by("contract_id", "DESC");

		return $this->db->get("vw_daftar_pekerjaan_kontrak");

	}

	public function getPekerjaanWO($id = "",$user = ""){

		if(!empty($id)){

			$this->db->where("po_id",$id);

		}

		$this->db->where(array("cwo_name"=>null,"cwo_end_date"=>null));

		$this->db->where_not_in("cwo_activity",array(2902,2903));

		$this->db->group_start();
		$this->db->where("cwo_user",null);
		$this->db->or_where("cwo_user",!empty($user) ? $user : null);
		$this->db->group_end();

		return $this->db->get("vw_daftar_pekerjaan_wo");

	}

	public function getPekerjaanInvoiceMilestone(){

		return $this->db->get('vw_daftar_pekerjaan_invoice_milestone');

	}

	public function getPekerjaanInvoiceWO(){

		return $this->db->get('vw_daftar_pekerjaan_invoice_wo');

	}

	public function getPekerjaanProgressWO(){

		return $this->db->get('vw_daftar_pekerjaan_progress_wo');

	}

	public function getPekerjaanProgressMilestone(){

		return $this->db->get('vw_daftar_pekerjaan_progress_milestone');

	}

	public function getPekerjaanBastWO(){

		return $this->db->get('vw_daftar_pekerjaan_bast_wo');

	}

	public function getPekerjaanBastMilestone(){

		return $this->db->get('vw_daftar_pekerjaan_bast_milestone');

	}

	public function insertMilestone($input=array()){

		if (!empty($input)){

			unset($input['milestone_id']);

			$this->db->insert("ctr_contract_milestone",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertJaminan($input=array()){

		if (!empty($input)){

			unset($input['id']);

			$this->db->insert("ctr_jaminan",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertPerson($input=array()){

		if (!empty($input)){

			unset($input['id']);

			$this->db->insert("ctr_person_in_charge",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateMilestone($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('milestone_id',$id)->update('ctr_contract_milestone',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateJaminan($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ctr_jaminan',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateItem($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ctr_contract_item',$input);

			return $this->db->affected_rows();

		}

	}

	public function updatePerson($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ctr_person_in_charge',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceItem($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("contract_id"=>$input['contract_id'],"contract_item_id"=>$id));
				$check = $this->getItem()->row_array();
				if(!empty($check)){
					$last_id = $check['contract_item_id'];
					$this->updateItem($last_id,$input);
				} else {
					$this->insertItem($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertItem($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function replaceMilestone($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("contract_id"=>$input['contract_id'],"milestone_id"=>$id));
				$check = $this->getMilestone()->row_array();
				if(!empty($check)){
					$last_id = $check['milestone_id'];
					$this->updateMilestone($last_id,$input);
				} else {
					$this->insertMilestone($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertMilestone($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function replaceJaminan($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("cj_contract_id"=>$input['cj_contract_id'],"id"=>$id));
				$check = $this->getJaminan()->row_array();
				if(!empty($check)){
					$last_id = $check['id'];
					$this->updateJaminan($last_id,$input);
				} else {
					$this->insertJaminan($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertJaminan($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function replacePerson($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("cp_contract_id"=>$input['cp_contract_id'],"id"=>$id));
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

	public function insertWOItem($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_po_item",$input);

			return $this->db->affected_rows();
		}

	}
	public function insertWOItemMatgis($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_wo_item",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertSPPMItemMatgis($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_sppm_item",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateWOItem($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('po_item_id',$id)->update('ctr_po_item',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceWOItem($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("po_id"=>$input['po_id'],"po_item_id"=>$id));
				$check = $this->getWOItem()->row_array();
				if(!empty($check)){
					$last_id = $check['po_item_id'];
					$this->updateWOItem($last_id,$input);
				} else {
					$this->insertWOItem($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertWOItem($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function getMonitor($id = ""){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}

		$this->db->where("vw_ctr_monitor_amandemen.is_sap",0);
		$this->db->or_where("vw_ctr_monitor_amandemen.is_sap", NULL, FALSE);

		$this->db->where("amandemen_number IS NULL", NULL, FALSE);

		$this->db->join("vnd_header vnd","vnd.vendor_id = vw_ctr_monitor_amandemen.vendor_id", "LEFT");

		$this->db->join("prc_tender_main tender","tender.ptm_number = vw_ctr_monitor_amandemen.ptm_number", "LEFT");

		$this->db->order_by("contract_id", "DESC");

		return $this->db->get("vw_ctr_monitor_amandemen");

	}

	public function getMonitor_sap($id = ""){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}

		$this->db->where("vw_ctr_monitor_amandemen.is_sap", 1);

		$this->db->where("amandemen_number IS NULL", NULL, FALSE);

		$this->db->join("vnd_header vnd","vnd.vendor_id = vw_ctr_monitor_amandemen.vendor_id", "LEFT");

		$this->db->join("prc_tender_main tender","tender.ptm_number = vw_ctr_monitor_amandemen.ptm_number", "LEFT");

		$this->db->order_by("contract_id", "DESC");

		return $this->db->get("vw_ctr_monitor_amandemen");

	}

	public function getMonitorAmandemen($id = ""){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}

		$this->db->where("amandemen_number !=", NULL);

		$this->db->or_where("amandemen_number !=", "");

		$this->db->join("vnd_header vnd","vnd.vendor_id = vw_ctr_monitor_amandemen.vendor_id", "LEFT");

		$this->db->join("prc_tender_main tender","tender.ptm_number = vw_ctr_monitor_amandemen.ptm_number", "LEFT");

		$this->db->order_by("contract_id", "DESC");

		return $this->db->get("vw_ctr_monitor_amandemen");

	}

	public function deleteIfNotExistWOItem($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("po_item_id",$deleted)->where("po_id",$id)->delete("ctr_po_item");
			return $this->db->affected_rows();
		}
	}


	public function deleteIfNotExistMilestone($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("milestone_id",$deleted)->where("contract_id",$id)->delete("ctr_contract_milestone");
			return $this->db->affected_rows();
		}
	}

	public function deleteIfNotExistJaminan($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("id",$deleted)->where("cj_contract_id",$id)->delete("ctr_jaminan");
			return $this->db->affected_rows();
		}
	}

	public function deleteIfNotExistItem($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("contract_item_id",$deleted)->where("contract_id",$id)->delete("ctr_contract_item");
			return $this->db->affected_rows();
		}
	}

	public function deleteIfNotExistPerson($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("id",$deleted)->where("cp_contract_id",$id)->delete("ctr_person_in_charge");
			return $this->db->affected_rows();
		}
	}

	public function get_token_simpb() {
		$posData = [];
		$posData = http_build_query(array(
			'grant_type' 	=> 'client_credentials',
			'client_id' => 'app_iproc',
			'secret_key' => '3d38073ea83253144846c9084c251563'
		));

		$url = SIMPABEAN_URL.'/auth/get_token';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($posData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $posData);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4); //timeout in seconds
		$result = curl_exec($ch);
		$resultDecode = json_decode($result, true);
		return $resultDecode['access_token'];
		curl_close($ch);
	}

	public function push_simpb($token, $data) {
		$dept_code = ($data['type_of_plan'] == "proyek") ? "dept_code" : "po_for_dept";
		$file = curl_file_create(CONTRACT_DOC.$data['ctr_doc']);
		$authorization = "Authorization: Bearer ".$token;
		$headers = array(
			// 'Content-type: application/json',
			'Authorization: Bearer '.$token,
			'Cache-Control: no-cache',
			'Content-Type: multipart/form-data',
			'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW'
		);
		$url = SIMPABEAN_URL.'/po/input';

		$posData=[];
		$posData['po_no'] = $data['po_number'];
		$posData['po_date'] = $data['created_date'];
		$posData['po_desc'] = $data['po_notes'];
		$posData['po_type'] = $data['type_of_plan'];
		$posData['seller_name'] = $data['vendor_name'];
		$posData['address'] = $data['address'];
		$posData['country_id'] = $data['country'];
		$posData['spk_no'] = $data['spk_code'];
		$posData[$dept_code] = $data['dept_code'];
		$posData['contract_currency'] = $data['currency'];
		$posData['contract_value_valas'] = (int)$data['ctr_amount'];
		$posData['po_file'] = $file;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, count($posData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $posData);
		// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4); //timeout in seconds

		$result = curl_exec($ch);
		var_dump($result);
		$resultDecode = json_decode($result, true);
		return $resultDecode;
		curl_close($ch);

	}

	public function push_kode_nasabah($vendor_id) {

		$data = $this->db->where("vendor_id", $vendor_id)->get("vw_vnd_header")->row_array();

		if ($data['nasabah_code'] == NULL) {

			$headers = array(
				'Cache-Control: no-cache',
				'Content-Type: multipart/form-data',
				'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW'
			);
			$url = NASABAH_URL;

			$vendordoc = $this->getDocWs($data['vendor_id']);
			$vendorbank = $this->getBankWs($data['vendor_id']);
			$direktur = $this->getBoardWs($data['vendor_id']);

			$posData = [
				//important
				'jenisperusahaan' => $data["prefix"],
				'nmnasabah' => $data["vendor_name"],
				'alamat' => $data["address_street"],
				//'nama_direktur' => $direktur['name'],
				'nama_direktur' => $data["contact_name"],
				'tipe' => "Vendor",
				'npwp' => $data["npwp_no"],
				'kota' => $data["npwp_city"],
				'kode_pos' => $data["npwp_postcode"],
				'propinsi' => $data["npwp_prop"],
				'telepon' => $data["address_phone_no"],
				'tempat_perusahaan' => $data["address_street"],
				'tanggal_perusahaan' => $data["address_domisili_date"],
				'nama_kontak' => $data["contact_name"],
				'tipe_perusahaan' => "Swasta",
				'jenis' => $data['cot_jenis_name'],
				'jabatan' => $data["contact_pos"],
				'pkp' => $data["npwp_pkp"],
				'telpon1' => $data["address_phone_no"],
				'handphone' => $data["address_phone_no"],
				'kelompok' => $data['cot_kelompok_name'],
				'jenis_kantor' => "Pusat",
				'siupp' => $data["siup_no"],
				'cotid' => $data["vnd_cot"],
				//not important
				'keterangan' => NULL,
				'is_pkp' => $data["npwp_pkp"],
				'alamat_npwp' => $data["npwp_address"],
				'ext' => NULL,
				'fax' => NULL,
				'website' => $data["address_website"],
				'email' => $data["email_address"],
				'kualifikasi_vendor' => NULL,
				'sertifikat' => NULL,
				'nama_kontak2' => NULL,
				'jabatan2' => NULL,
				'jenis_nasabah' => $data['jenis_nasabah'],
				'skt' => $data["npwp_pkp_no"],
				'email1' => $data["email_address"],
				'email2' => NULL,
				'fax_cp1' => NULL,
				'fax_cp2' => NULL,
				'telpon2' => NULL,
				'handphone2' => NULL,
				'tipe_lain_perusahaan' => NULL,
				'tipe_faktur' => NULL,
				'nama_bank' => $vendorbank['bank'],
				'cabang' => NULL,
				'nomor_rekening' => $vendorbank['rek'],
				'atas_nama' => $vendorbank['nama'],
				'is_app' => "t",
				'id_user' => NULL,
				'file_npwp' => $vendordoc['npwpdoc'],
				'file_sppkp' => $vendordoc['pkpdoc'],
				'file_lain' => NULL
			];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, count($posData));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $posData);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 4); //timeout in seconds

			$result = curl_exec($ch);

			return $result;
			curl_close($ch);

		}

	}

	public function getBankWs($vendor_id = ''){
		$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
		$databank = json_decode(file_get_contents($url_ws."/vndbank.json?token=123456&vendorId=".$vendor_id."&act=1"), true);

		$cou = count($databank['listVndBank']);

		for ($i=0; $i < $cou; $i++) {

			$isbank = strpos($databank['listVndBank'][$i]['currency'], "IDR");

			if ($isbank !== FALSE) {
				$nama = $databank['listVndBank'][$i]['accountName'];
				$bank = $databank['listVndBank'][$i]['bankName'];
				$rek = $databank['listVndBank'][$i]['accountNo'];
			}

			if (!isset($nama) || !isset($bank) || !isset($rek)) {
				$nama = $databank['listVndBank'][$i]['accountName'];
				$bank = $databank['listVndBank'][$i]['bankName'];
				$rek = $databank['listVndBank'][$i]['accountNo'];
			}
		}

		$banks = [
			'nama' => isset($nama) ? $nama : NULL,
			'bank' => isset($bank) ? $bank : NULL,
			'rek' => isset($rek) ? $rek : NULL
		];

		return $banks;
	}

	public function getDocWs($vendor_id = ''){

		$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
		$url_doc = "https://verifikasi.pengadaan.com/pengadaanvendor/Download/";

		$dokumen = json_decode(file_get_contents($url_ws."/vndsuppdoc.json?token=123456&vendorId=".$vendor_id."&act=1"), true);

		if(!empty($dokumen)){
			$dokumen = array_reverse($dokumen["listVndSuppDoc"]);
		}

		$cou = count($dokumen);

		for ($i=0; $i < $cou ; $i++) {
			$npwpcek = strpos(strtolower($dokumen[$i]['vndSuppdocDesc']), "npwp");
			$npwpcek1 = strpos(strtolower($dokumen[$i]['vndSuppdocDesc']), "perusahaan");

			$pkpcek = strpos(strtolower($dokumen[$i]['vndSuppdocDesc']), "pkp");
			if ($pkpcek !== FALSE) {
				$pkp = $url_doc.$dokumen[$i]['vndSuppdocFilename'];
			}
			if ($npwpcek !== FALSE && $npwpcek1 !== FALSE) {
				$npwp = $url_doc.$dokumen[$i]['vndSuppdocFilename'];
			}
			if (!isset($npwp)) {
				if ($npwpcek !== FALSE){
					$npwp = $url_doc.$dokumen[$i]['vndSuppdocFilename'];
				}
			}
		}

		$doc['pkpdoc'] = isset($pkp) ? $pkp : NULL;
		$doc['npwpdoc'] = isset($npwp) ? $npwp : NULL;

		return $doc;
	}

	public function getBoardWs($vendor_id = ''){

		$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
		$boards = json_decode(file_get_contents($url_ws."/vndboard.json?token=123456&vendorId=".$vendor_id."&act=1"), true);

		$cou = count($boards['listVndBoard']);

		for ($i=0; $i < $cou; $i++) {

			$pos = $boards['listVndBoard'][$i]['pos'];

			if ($pos == "DIREKTUR UTAMA") {
				$board = $boards['listVndBoard'][$i];
				break;
			}else if ($pos == "PRESIDEN DIREKTUR") {
				$board = $boards['listVndBoard'][$i];
				break;
			}else if ($pos == "DIREKTUR"){
				$board = $boards['listVndBoard'][$i];
				break;
			}else{
				$board = NULL;
			}
		}

		return $board;
	}

	public function generateVsi()
	{
		$ctr = $this->getData()->result_array();
	}

	public function getMonitorContract($startDate, $endDate, $id = "") {
		if(!empty($id)){
			$this->db->where("contract_id",$id);
		}
		if(empty($endDate)) {
			$endDate = $startDate;
		}

		$this->db->join("vnd_header vnd","vnd.vendor_id = vw_ctr_monitor_amandemen.vendor_id", "LEFT");
		$this->db->join("prc_tender_main tender","tender.ptm_number = vw_ctr_monitor_amandemen.ptm_number", "LEFT");
		$this->db->order_by("contract_id", "DESC");
		$this->db->where("vw_ctr_monitor_amandemen.is_sap",0);
		$this->db->or_where("vw_ctr_monitor_amandemen.is_sap", NULL, FALSE);
		$this->db->where("amandemen_number IS NULL", NULL, FALSE);
		$this->db->where('vw_ctr_monitor_amandemen.start_date >=', $startDate);
		$this->db->where('vw_ctr_monitor_amandemen.start_date <=', $endDate);
		return $this->db->get("vw_ctr_monitor_amandemen")->result();
	}

	public function getMonitorContract_sap($startDate, $endDate, $id = "") {
		if(!empty($id)){
			$this->db->where("contract_id",$id);
		}
		if(empty($endDate)) {
			$endDate = $startDate;
		}

		$this->db->join("vnd_header vnd","vnd.vendor_id = vw_ctr_monitor_amandemen.vendor_id", "LEFT");
		$this->db->join("prc_tender_main tender","tender.ptm_number = vw_ctr_monitor_amandemen.ptm_number", "LEFT");
		$this->db->order_by("contract_id", "DESC");
		$this->db->where("vw_ctr_monitor_amandemen.is_sap",1);
		$this->db->where("amandemen_number IS NULL", NULL, FALSE);
		$this->db->where('vw_ctr_monitor_amandemen.start_date >=', $startDate);
		$this->db->where('vw_ctr_monitor_amandemen.start_date <=', $endDate);
		return $this->db->get("vw_ctr_monitor_amandemen")->result();
	}

	public function getMonitorContractByKeyword($siup_type, $divisi, $id = "") {
		if(!empty($id)){
			$this->db->where("contract_id",$id);
		}

		$this->db->where("vw_ctr_monitor_amandemen.is_sap",0);
		$this->db->or_where("vw_ctr_monitor_amandemen.is_sap", NULL, FALSE);
		$this->db->where("amandemen_number IS NULL", NULL, FALSE);
		$this->db->join("vnd_header vnd","vnd.vendor_id = vw_ctr_monitor_amandemen.vendor_id", "LEFT");
		$this->db->join("prc_tender_main tender","tender.ptm_number = vw_ctr_monitor_amandemen.ptm_number", "LEFT");
		$this->db->order_by("contract_id", "DESC");
		$this->db->like('vnd.siup_type', $siup_type, 'both');
		$this->db->or_like('tender.ptm_dept_name', $divisi, 'both');
		return $this->db->get("vw_ctr_monitor_amandemen")->result();
	}

	public function getMonitorContractByKeyword_sap($siup_type, $divisi, $id = "") {
		if(!empty($id)){
			$this->db->where("contract_id",$id);
		}

		$this->db->where("vw_ctr_monitor_amandemen.is_sap",1);
		$this->db->where("amandemen_number IS NULL", NULL, FALSE);
		$this->db->join("vnd_header vnd","vnd.vendor_id = vw_ctr_monitor_amandemen.vendor_id", "LEFT");
		$this->db->join("prc_tender_main tender","tender.ptm_number = vw_ctr_monitor_amandemen.ptm_number", "LEFT");
		$this->db->order_by("contract_id", "DESC");
		$this->db->like('vnd.siup_type', $siup_type, 'both');
		$this->db->or_like('tender.ptm_dept_name', $divisi, 'both');
		return $this->db->get("vw_ctr_monitor_amandemen")->result();
	}
}
