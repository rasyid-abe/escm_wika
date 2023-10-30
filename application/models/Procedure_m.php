<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procedure_m extends MY_Model {

	public function __construct(){

		parent::__construct();

	}

	public function get_ppm_id_by_pr($pr_mumber) {

		$this->db->select('ppm_id');
		$this->db->where('pr_number', $pr_mumber);
		$query = $this->db->get('prc_pr_main');

		if ($query->num_rows() > 0) {
			$data = $query->row();
			return $data->ppm_id;
		} else {
			return "0";
		}

	}

	public function get_manager_user($ppm_id) {

		$name = "";
		$posisi = "";
		//$query;

		$this->db->select('comment_name, pos_name');
		$this->db->where('ppm_id', $ppm_id);
		$this->db->order_by('comment_id', "ASC");
		$this->db->offset(1);
		$this->db->limit(1);
		$query = $this->db->get('prc_plan_comment');

		if ($query->num_rows() > 0) {
			$data = $query->row();
			$name = $data->comment_name;
			$posisi = $data->pos_name;
		}

		return ["name" => $name, "posisi" => $posisi];

	}

	public function setMessage($message){

		$current_message = $this->session->userdata("message");


		if(!empty($message)){
			if(is_array($message)){
				$message = implode("<br/>", $message);
			}
			$this->session->set_userdata("message",$message."<br/>".$current_message);
		}

	}

	public function renderMessage($message,$status,$redirect = ""){

		$this->form_validation->set_error_delimiters('<p>', '</p>');

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode(array('message' => $message, "status"=>$status, "redirect"=>$redirect)));

	}

	public function batalkanPermintaan($pr_number){

	}

	public function selesaiPengadaan($ptm_number){

		$this->db->trans_begin();

		$this->db->where("ptm_number",$ptm_number)
		->update("prc_tender_main",array("ptm_completed_date"=>date("Y-m-d H:i:s")));

		$this->db
		->where("ptm_number",$ptm_number)
		->where("pvs_is_winner !=",1)
		->update("prc_tender_vendor_status",array("pvs_status"=>24));

		$this->db
		->where("ptm_number",$ptm_number)
		->where("pvs_is_winner",1)
		->update("prc_tender_vendor_status",array("pvs_status"=>11));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}

	}

	public function batalkanPengadaan($ptm_number){

		$this->db->trans_begin();

		$this->db
		->where("ptm_number",$ptm_number)
		->update("prc_tender_main",array("ptm_completed_date"=>date("Y-m-d H:i:s")));

		$this->db
		->where("ptm_number",$ptm_number)
		->update("prc_tender_vendor_status",array("pvs_status"=>26));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}

	}

	public function getNextJobTitle($nextPosCode){
		return $this->db->where("pos_id",$nextPosCode)->get("adm_pos")->row()->job_title;
	}

	public function ulangiPengadaan($ptm_number){

		$this->load->helper('string');

		$this->db->trans_begin();

		$this->db
		->where("ptm_number",$ptm_number)
		->update("prc_tender_vendor_status",array("pvs_status"=>25));

		$tender = $this->db
		->where("ptm_number",$ptm_number)
		->order_by('ptm_created_date','desc')
		->get("prc_tender_main")
		->row_array();

		$new = increment_string($tender['ptm_number'],"-");

		$tender['ptm_number'] = $new;
		$tender['ptm_status'] = 1040;

		$this->db->insert("prc_tender_main",$tender);

		//y update ptm number in joined packet
		$this->db->where("joinrfq", $ptm_number)->update("prc_pr_main", array("joinrfq"=>$new));
		//end

		$table_list = array(
			"prc_tender_doc"=>"ptd_id",
			"prc_tender_item"=>"tit_id",
		);

		foreach ($table_list as $k => $v) {

			$x = $this->db
			->where("ptm_number",$ptm_number)
			->get($k)
			->result_array();

			foreach ($x as $key => $value) {
				$value['ptm_number'] = $new;
				unset($value[$v]);
				$this->db->insert($k,$value);
			}

		}

		$prep = $this->db
		->where("ptm_number",$ptm_number)
		->get("prc_tender_prep")
		->row_array();

		$prep['ptm_number'] = $new;
		unset($prep['ptp_id']);

		$this->db->insert("prc_tender_prep",$prep);

		$this->db->where("ptm_number",$ptm_number)->update("prc_tender_main",array("ptm_downreff"=>$new));
		$this->db->where("ptm_number",$new)->update("prc_tender_main",array("ptm_upreff"=>$ptm_number));

		$last_comment = $this->db
		->where(array("ptm_number"=>$ptm_number,"ptc_activity"=>1040))
		->get("prc_tender_comment")->row_array();

		$last_comment['ptc_start_date'] = date("Y-m-d H:i:s");
		$last_comment['ptm_number'] = $new;
		unset($last_comment['ptc_id']);
		unset($last_comment['ptc_name']);
		unset($last_comment['ptc_end_date']);
		unset($last_comment['ptc_user']);
		unset($last_comment['ptc_response']);
		unset($last_comment['ptc_comment']);
		unset($last_comment['ptc_attachment']);

		$this->db->insert("prc_tender_comment",$last_comment);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return $new;
		}

	}

	public function movePRtoRFQ($pr_number){

		$this->load->model(array("Procrfq_m","Procpr_m", "Administration_m"));

		$get_pr = $this->Procpr_m->getPR($pr_number)->row_array();

		$get_pr_sap = $this->Procpr_m->getPR_Sap($pr_number)->row_array();

		$ptm_number = $this->Procrfq_m->getUrutRFQ();
		
		$input = [];

		$input['ptm_number'] = $ptm_number;

		$input['ptm_created_date'] = date("Y-m-d H:i:s");

		$field = array(
			'subject_of_work',
			'scope_of_work',
			'district_id',
			'district_name',
			'requester_name',
			'requester_pos_code',
			'requester_pos_name',
			'delivery_point_id',
			'delivery_point',
			'currency',
			'contract_type',
			'dept_id',
			'dept_name',
			'mata_anggaran',
			'nama_mata_anggaran',
			'sub_mata_anggaran',
			'nama_sub_mata_anggaran',
			'pagu_anggaran',
			'sisa_anggaran',
			'pagu_anggaran',
			'requester_id',
			'type_of_plan',
			'project_name',
			'packet',
			'buyer_id',
			'buyer',
			'buyer_pos_code',
			'buyer_pos_name'
		);
	
		if (isset($get_pr_sap['pr_is_sap'])) {
			if ($get_pr_sap['pr_is_sap'] == 1) {
				foreach ($field as $key => $value) {
					$input['ptm_'.$value] = $get_pr_sap['pr_'.$value];
				}

				$input['pr_type'] = $get_pr_sap['pr_type'];
				$input['ptm_tender_project_type'] = ltrim(strtoupper($get_pr_sap['pr_type_pengadaan']));
				$input['spk_code'] = isset($get_pr_sap['pr_spk_code']) ? $get_pr_sap['pr_spk_code'] : '';
				$input['is_sap'] = $get_pr_sap['pr_is_sap'];
				$input['ptm_doc_type_sap'] = isset($get_pr_sap['pr_doc_type']) ? $get_pr_sap['pr_doc_type'] : '';

			}
			
		} else {
			foreach ($field as $key => $value) {
				$input['ptm_'.$value] = $get_pr['pr_'.$value];
			}

			$input['pr_type'] = $get_pr['pr_type'];
			$input['ptm_tender_project_type'] = ltrim(strtoupper($get_pr['pr_type_pengadaan']));
			$input['spk_code'] = isset($get_pr['pr_spk_code']) ? $get_pr['pr_spk_code'] : '';
		}

		$input['pr_number'] = $pr_number;
		$input['ptm_status'] = 1040; //y ubah workflow dari 1020->1040

		$act = $this->Procrfq_m->insertDataRFQ($input);

		$input = array("ptm_number"=>$ptm_number);

		$metode = $get_pr['pr_metode_pengadaan'];

		if ($metode == 'Penunjukan Langsung') {
			$metode = 0;

		} elseif ($metode == 'Tender Terbatas') {
			$metode = 1;

		} elseif ($metode == 'Tender Umum') {
			$metode = 2;
		}

		$input['ptp_tender_method'] = $metode;

		if (isset($get_pr_sap['pr_metode_pengadaan'])) {

			$metode = $get_pr_sap['pr_metode_pengadaan'];

			if ($metode == 'Penunjukan Langsung') {
				$metode = 0;

			} elseif ($metode == 'Tender Terbatas') {
				$metode = 1;

			} elseif ($metode == 'Tender Umum') {
				$metode = 2;
			}

			$input['ptp_tender_method'] = $metode;
		}

		$act = $this->Procrfq_m->insertPrepRFQ($input);

		$get_dok = $this->Procpr_m->getDokumenPR("",$pr_number)->result_array();

		foreach ($get_dok as $key => $value) {

			$input = array();

			$field = array(
				'category',
				'description',
				'file_name',
			);

			foreach ($field as $k => $v) {
				$input['ptd_'.$v] = $value['ppd_'.$v];
			}

			$input['ptm_number'] = $ptm_number;

			$this->Procrfq_m->insertDokumenRFQ($input);

		}

		$get_item = $this->Procpr_m->getItemPR("",$pr_number)->result_array();

		foreach ($get_item as $key => $value) {

			$input = array();

			$field = array(
				'code',
				'description',
				'quantity',
				'unit',
				'price',
				'currency',
				'type',
				'ppn',
				'pph',
				'periode_pengadaan',
				'spk_code',
				'incoterm',
				'lokasi_incoterm',
				'sumber_hps',
				'hps',
				'lampiran',
			);

			foreach ($field as $k => $v) {
				$input['tit_'.$v] = $value['ppi_'.$v];
			}

			$input['ptm_number'] = $ptm_number;
			$input['tit_pr_number'] = $value['ppis_pr_number'];
			$input['tit_pr_item'] = $value['ppis_pr_item'];
			$input['tit_delivery_date'] = $value['ppis_delivery_date'];
			$input['tit_pr_type'] = $value['ppis_pr_type'];
			$input['tit_acc_assig'] = $value['ppis_acc_assig'];
			$input['tit_cat_tech'] = $value['ppis_cat_tech'];
			$input['tit_tax_code'] = $value['ppi_tax_code'];
			$input['tit_no_asset'] = $value['ppi_no_asset'];
			$input['tit_sub_number'] = $value['ppi_sub_number'];
			$input['tit_retention'] = $value['ppi_retention'];

			$this->Procrfq_m->insertItemRFQ($input);

		}

		return $ptm_number;

	}

	public function getActivity($id = ""){

		if(!empty($id)){

			$this->db->where("awa_id",$id);

		}

		return $this->db->get("adm_wkf_activity");

	}

	public function getResponse($awr = "",$awa = ""){

		if(!empty($awr)){

			$this->db->where("awr_id",$awr);

		}

		if(!empty($awa)){

			$this->db->where("awa_id",$awa);

		}

		$this->db->order_by("awr_sequence","asc");

		return $this->db->get("adm_wkf_response");
	}

	public function getResponseList($code){
		$data = $this->getResponse("",$code)->result_array();
		$ret = array();
		foreach ($data as $key => $value) {
			$ret[$value['awr_id']] = $value['awr_name'];
		}
		return $ret;
	}

	public function getResponseName($code = ""){
		$response = "";
		if(!empty($code)){
			$response = $this->getResponse($code, "")->row_array();
			$response = (!empty($response['awr_name'])) ? $response['awr_name'] : "";
		}
		return $response;
	}

	public function getNextState($code_field,$name_field,$table,$where = array(),$or_where=""){

		if(!empty($where)){
			$this->db->where($where);
		}

		if(!empty($or_where)){
			$this->db->or_where($or_where);
		}

		$getdata = $this->db
		->select($code_field." as nextPosCode,".$name_field." as nextPosName")
		->get($table)->row_array();

		if(empty($getdata)){

		}

		return $getdata;

	}

	//haqim

	public function getNextJobTitlePlan($pos_id,$anggaran="",$plan_type){

		if ($plan_type == 'rkp') {
			$table = 'vw_prc_hierarchy_approval_5';
		} elseif ($plan_type == 'rkap') {
			$table = 'vw_prc_hierarchy_approval_6';
		}elseif ($plan_type == 'rkp_matgis') {
			$table = 'vw_prc_hierarchy_approval_5';
		}

		$this->db->select('hap_amount');
		$this->db->where('hap_pos_code', $pos_id);
		$last_pos = $this->db->get($table)->result_array();

		$next_pos_id = null;

		if(!isset($last_pos[0]['hap_amount'])){

		} else {

			$min_amount = $last_pos[0]['hap_amount'];

			if (floatval(str_replace(",00", '', str_replace(".", "", $anggaran))) > $min_amount) {
				$this->db->select('hap_pos_parent');
				$this->db->where('hap_pos_code', $pos_id);
				$parents = $this->db->get($table)->result_array();

				if (count($parents) > 0) {
					foreach ($parents as $key => $value) {

						$this->db->select('hap_pos_code');
						$this->db->where('hap_pos_code', $value['hap_pos_parent']);

						$parents = $this->db->get($table)->result_array();
						if (count($parents) == 1) {
							$next_pos_id = $parents[0]['hap_pos_code'];
							break;
						}

					}
				} else {
					$next_pos_id = null;
				}
			} else{
				$nextpos = $this->db->select('hap_pos_parent')->where(array('hap_pos_code' => $pos_id, 'hap_pos_parent !=' => NULL))->get($table)->row_array();
				$next_pos_id = $nextpos['hap_pos_parent'];
			}

		}

		return $next_pos_id;
	}

	//send drp mail

	public function prc_plan_comment_complete(
		$ppm_id="",
		$dept_name="",
		$ppm_planner_pos_name="",
		$ppm_planner_pos_code ="",
		$nama_proses = "",
		$next_pos_id="",
		$status = ""
	) {

		if ($status == "3") {
			$response = "<b>Telah Disetujui dan</b>";
		} else if ($status == "4")  {
			$response = "<b>Perlu Direvisi dan</b>";
		} else {
			$response = "";
		}

		$msg = "Selamat datang di eSCM,
		<br/>
		<br/>
		Perencanaan Pengadaan Berikut : <br/>
		Proses : $nama_proses<br/>
		Sebagai : ".$ppm_planner_pos_name."<br/>
		$response Membutuhkan Response.
		Silahkan login di ".COMPANY_WEBSITE." untuk melanjutkan proses pekerjaan.";

		if ($next_pos_id == 212) {
			$next_pos_id = $ppm_planner_pos_code;
		}

		$email_list = $this->db->distinct()->select("email")->where("pos_id",$next_pos_id)->get("vw_user_access_2")->result_array();

		$e = array();

		foreach ($email_list as $key => $value) {
			$e[] = $value['email'];
		}


		$this->load->helper('url');

		$msg = auto_link($msg);


		// $email = $this->sendEmail(implode(",", $e),"Pemberitahuan Perencanaan Pengadaan Nomor $ppm_id",$msg);
		return false;

	}

	//end

	public function prc_pr_comment_complete(
		$pr_number = "",
		$name = "",
		$activity = 0,
		$response = "",
		$comment = "",
		$attachment = "",
		$ptcId = 0,
		$perencanaan_id = 0,
		$user_id = null,
		$isSwakelola="",
		$type_of_plan,
		$joinpr = null,
		$buyer_id = "",
		$ppc = null,
		$is_sap = null
	) {

		$this->db->select('pr_dept_id,pr_type,pr_requester_id');
		$this->db->where('pr_number', $pr_number);
		$get_dept = $this->db->get('prc_pr_main')->row_array();
		$dept_id = $get_dept['pr_dept_id'];
		$pr_type = $get_dept['pr_type'];

		if ($type_of_plan =='rkap') {

			$tbl = "adm_auth_hie_pr_proyek";
			$view = "vw_prc_hierarchy_approval_7";
			$view_rfq = "vw_prc_hierarchy_approval_8";

		} elseif ($type_of_plan =='rkp') {

			$tbl = "adm_auth_hie_pr_proyek";
			$view = "vw_prc_hierarchy_approval_7";
			$view_rfq = "vw_prc_hierarchy_approval_8";

		} elseif ($type_of_plan =='rkp_np') {

			$tbl = "adm_auth_hie_pr_proyek";
			$view = "vw_prc_hierarchy_approval_7";
			$view_rfq = "vw_prc_hierarchy_approval_8";

		} elseif ($type_of_plan =='rkp_matgis') {

			$tbl = "adm_auth_hie_pr_proyek";
			$view = "vw_prc_hierarchy_approval_7";
			$view_rfq = "vw_prc_hierarchy_approval_8";

		} else {

			$tbl = "adm_auth_hie_pr_proyek";
			$view = "vw_prc_hierarchy_approval_7";
			$view_rfq = "vw_prc_hierarchy_approval_8";

		} 

		if(is_numeric($response)){
			$response_real = $this->getResponseName($response);
			$response = url_title($response_real,"_",true);
		}

		$message = "";
		$nextPosCode = "";
		$nextPosName = "";
		$lastPosCode = "";
		$lastPosName = "";
		$nextActivity = 0;
		$anyIncompleteComment = 0;
		$tenderMethod = 0;
		$submissionMethod = 0;
		$justification = "";
		$totalOE = 0.0;
		$tmpPosition = "";
		$newNumber = 0;
		$plan_num = 0;
		$nextjobtitle = "";

		$anyIncompleteComment = $this->db
		->where(array("ppc_id"=>$ptcId,"ppc_name"=>null))
		->get("prc_pr_comment")
		->num_rows();

		if($anyIncompleteComment > 0){

			$this->db->where(array(
				"pr_number"=>$pr_number,
				"ppc_name"=>null
			));

			$this->db->where("ppc_activity",$activity,false);

			$table = "prc_pr_comment";

			$code_field = "ppc_pos_code";

			$name_field = "ppc_position";

			$getdata = $this->db
			->select($code_field." as lastPosCode,".$name_field." as lastPosName, ppc_activity as activity")
			->get($table)->row_array();

			if(empty($getdata)){
				$getdata = $this->db
				->select("pr_requester_pos_code as lastPosCode,pr_requester_pos_name as lastPosName,
					ppc_activity as activity")
				->where("pr_number",$pr_number)->get("prc_pr_main")->row_array();
			}

			$lastPosName = $getdata['lastPosName'];
			$lastPosCode = $getdata['lastPosCode'];
			$lastActivity = $getdata['activity'];

			$nextPosCode = $lastPosCode;
			$nextPosName = $lastPosName;

			//completing tender comment

			$totalOE = $this->db
			->select("sum((ppi_price*ppi_quantity)*(1+(COALESCE(ppi_pph::double precision,0)/100)+(COALESCE(ppi_ppn,0)/100))) as total")
			->from("prc_pr_item")
			->where("pr_number",$pr_number)
			->get()->row()->total;

			$amount = $this->db
			->select("max_amount")
			->from($tbl)
			->where("pos_id",$lastPosCode)
			->get()->row_array();
			if(!empty($amount)){
				$max_amount = $amount['max_amount'];
			} else {
				$max_amount = 0;
			}

			$update = $this->db
			->where(array("ppc_id"=>$ptcId))
			->update("prc_pr_comment",array(
				"ppc_response" => $response_real,
				"ppc_name" => $name,
				"ppc_end_date" => date("Y-m-d H:i:s"),
				"ppc_comment" => $comment,
				"ppc_attachment" => $attachment,
				"ppc_user" => $user_id,
			));

			if($activity == 1000 || $activity == 1001 || $activity == 1002){

				if($response == url_title('Lanjutkan',"_",true)){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent
						from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1010;

				} else if($response == url_title('Simpan Sebagai Draft',"_",true)) {

					$nextActivity = ($pr_type == "MATERIAL STRATEGIS") ? 1001 : 1002;

				} else if($response == url_title('Batalkan Permintaan Pengadaan',"_",true)) {

					$nextActivity = 1904;

					$this->batalkanPermintaan($pr_number);
				}

			} else if($activity == 1010){

				if($response == url_title('Setuju',"_",true)){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent
						from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
					->get($view)
					->row_array();

					$next_hap = 0;

					if(!empty($hap)){
						$next_hap = $hap['hap_amount'];
					}

					$nextPosCode = isset($getdata['nextPosCode']) ;
					$nextPosName = isset($getdata['nextPosName']);

					if($totalOE > $next_hap){

						$nextActivity = 1010;

					}else {

						if ($type_of_plan == "rkp") {  //proyek tanpa dispatcher dan join

							$newNumber = $this->movePRtoRFQ($pr_number);

							if(!empty($newNumber)){

								$getdata = $this->getNextState(
									"pos_id",
									"pos_name",
									"vw_adm_pos",
									array("job_title"=>"PELAKSANA PENGADAAN", "dept_id"=>$dept_id, "employee_id"=>$get_dept['pr_requester_id']));

								$nextPosCode = $getdata['nextPosCode'];
								$nextPosName = $getdata['nextPosName'];

								$nextActivity = 1040;
							}

						}else{ //get dispatcher pos

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"vw_adm_pos",
								array("job_title"=>"MANAJER USER", "dept_name"=>"SUPPLY CHAIN MANAGEMENT", "pos_name"=>"Dispatcher"),
								"job_title = 'MANAJER USER' and dept_name = 'SCM' and pos_name = 'Dispatcher'");

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];
							$nextActivity = 1011;

						}
					}

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"pr_requester_pos_code",
						"pr_requester_pos_name",
						"prc_pr_main",
						array("pr_number"=>$pr_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = ($pr_type == "MATERIAL STRATEGIS") ? 1001 : 1000;

				} else if($response == url_title('Batalkan Permintaan Pengadaan',"_",true)) {
					$nextActivity = 1904;
					$this->batalkanPermintaan($pr_number);
				}


			} else if($activity == 1011){

				if($response == url_title('Simpan dan Lanjut',"_",true)){

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"vw_adm_pos",
						array("job_title"=>"PELAKSANA PENGADAAN", "employee_id"=>$buyer_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];
					$nextActivity = 1012;

				} else {
					//empty
				}

			} else if ($activity == 1012){

				if($response == url_title('Simpan dan Lanjut',"_",true)){


					if (empty($joinpr)) {
						$newNumber = $this->movePRtoRFQ($pr_number);
					}

					if(!empty($newNumber) || !empty($joinpr)){

						//=======================================================
						//y get pr planner sebagai rfq buyer

						if ($type_of_plan == 'rkap') {
							$buyers = $this->getNextState(
								"pr_requester_id",
								"pr_requester_name",
								"prc_pr_main",
								array("pr_number"=>$pr_number));

							$buyerpos = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								array("job_title"=>"PELAKSANA PENGADAAN","dept_id"=>$dept_id));

							$inputbuyer['ptm_buyer_id'] = $buyers['nextPosCode'];
							$inputbuyer['ptm_buyer'] = $buyers['nextPosName'];
							$inputbuyer['ptm_buyer_pos_code'] = $buyerpos['nextPosCode'];
							$inputbuyer['ptm_buyer_pos_name'] = $buyerpos['nextPosName'];

							$nextPosCode = $buyerpos['nextPosCode'];
							$nextPosName = $buyerpos['nextPosName'];

						//haqim
						} elseif($type_of_plan == 'rkp') {

							$this->db->join($view_rfq." a", 'a.hap_pos_code = b.pos_id');
							$this->db->join('adm_employee_pos c', 'c.pos_id = b.pos_id');
							$this->db->join('adm_employee d', 'd.id = c.employee_id');
							$this->db->where('b.job_title','PELAKSANA PENGADAAN');
							$this->db->where('b.dept_id', $dept_id);
							$this->db->select('b.*,c.employee_id,d.fullname');

							$buyer = $this->db->get('adm_pos b')->row_array();
							$inputbuyer['ptm_buyer_id'] = $buyer['employee_id'];
							$inputbuyer['ptm_buyer'] = $buyer['fullname'];
							$inputbuyer['ptm_buyer_pos_code'] = $buyer['pos_id'];
							$inputbuyer['ptm_buyer_pos_name'] = $buyer['pos_name'];
							$nextPosCode = $buyer['pos_id'];
							$nextPosName = $buyer['pos_name'];
						}

						$nextActivity = 1040;

						$this->db->where('ppc_id', $ppc)->update('prc_pr_comment', array('ppc_activity'=>1013));
						//end
						//y end
						//======================================================
					}
				} else { }

			} else if ($activity == 1020){

				//PERSETUJUAN ANGGARAN
				//hlmifzi
				if($response == url_title('Setuju',"_",true) && $isSwakelola == null){

					if(!empty($newNumber)){

						$nextjobtitle = 'PELAKSANA PENGADAAN'; //y rfq kembali ke pic user (PR[approval PR] -> RFQ[PIC User PR as Buyer])

						$nextActivity = 1040; //1029

						if ($type_of_plan == 'rkap') {
							$buyers = $this->getNextState(
								"pr_requester_id",
								"pr_requester_name",
								"prc_pr_main",
								array("pr_number"=>$pr_number));

							$buyerpos = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								array("job_title"=>"PELAKSANA PENGADAAN","dept_id"=>$dept_id));

							$inputbuyer['ptm_buyer_id'] = $buyers['nextPosCode'];
							$inputbuyer['ptm_buyer'] = $buyers['nextPosName'];
							$inputbuyer['ptm_buyer_pos_code'] = $buyerpos['nextPosCode'];
							$inputbuyer['ptm_buyer_pos_name'] = $buyerpos['nextPosName'];

							$nextPosCode = $buyerpos['nextPosCode'];
							$nextPosName = $buyerpos['nextPosName'];

						//haqim
						} elseif($type_of_plan == 'rkp') {

							$this->db->join($view_rfq." a", 'a.hap_pos_code = b.pos_id');
							$this->db->where('b.job_title','PELAKSANA PENGADAAN');
							$this->db->where('b.dept_id', $dept_id);

							$buyer = $this->db->get('vw_employee b')->row_array();
							$inputbuyer['ptm_buyer_id'] = $buyer['id'];
							$inputbuyer['ptm_buyer'] = $buyer['fullname'];
							$inputbuyer['ptm_buyer_pos_code'] = $buyer['pos_id'];
							$inputbuyer['ptm_buyer_pos_name'] = $buyer['pos_name'];
							$nextPosCode = $buyer['pos_id'];
							$nextPosName = $buyer['pos_name'];
						}

						$this->db->where('ptm_number', $newNumber)->update('prc_tender_main', $inputbuyer);

						//y end
						//======================================================
					}


				} else if ($response == url_title('Setuju',"_",true) && $isSwakelola != null){

					$nextjobtitle = 'PIC ANGGARAN';

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"adm_pos",
						array("job_title"=>$nextjobtitle));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1028;

				} else if ($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"pr_requester_pos_code",
						"pr_requester_pos_name",
						"prc_pr_main",
						array("pr_number"=>$pr_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = ($pr_type == "MATERIAL STRATEGIS") ? 1001 : 1000;

				}

			}

			if(!empty($nextActivity)){
				$this->db->where("pr_number",$pr_number)->update("prc_pr_main",array("pr_status"=>$nextActivity));
			}

			$ret = array();

			if(!empty($nextPosCode)){

				$nama_proses = $this->db->select("awa_name")->where("awa_id",$nextActivity)->get("adm_wkf_activity")->row()->awa_name;

				$tender_name = $this->db->select("pr_subject_of_work")->where("pr_number",$pr_number)->get("prc_pr_main")->row()->pr_subject_of_work;

				$email_list = $this->db->distinct()->select("email")->where("pos_id",$nextPosCode)->get("vw_user_access_2")->result_array();

				$e = array();

				foreach ($email_list as $key => $value) {
					$e[] = $value['email'];
				}

				$msg = "Selamat datang di eSCM,
				<br/>
				<br/>
				Permintaan Pengadaan Berikut : <br/>
				Nomor : <strong>$pr_number - $tender_name</strong> <br/>
				Proses : $nama_proses<br/>
				Sebagai : ".$nextPosName."<br/>
				Membutuhkan Response.
				Silahkan login di ".COMPANY_WEBSITE." untuk melanjutkan proses pekerjaan.";

				//haqim
				$this->load->helper('url');

				$msg = auto_link($msg);
				//end

				// $email = $this->sendEmail(implode(",", $e),"Pemberitahuan Permintaan Pengadaan Nomor $pr_number",$msg);

				$ret = array(
					"message"=>$message,
					"nextposcode"=>$nextPosCode,
					"nextposname"=>$nextPosName,
					"lastposcode"=>$lastPosCode,
					"lastposname"=>$lastPosName,
					"nextactivity"=>$nextActivity,
					"anyincompletecomment"=>$anyIncompleteComment,
					"tendermethod"=>$tenderMethod,
					"submissionmethod"=>$submissionMethod,
					"justification"=>$justification,
					"totaloe"=>$totalOE,
					"tmpposition"=>$tmpPosition,
					"newnumber"=>$newNumber,
					"nextactivity"=>$nextActivity,
					"response"=>$response
				);

			} else { }

			return $ret;

		}
	}

	public function prc_tender_comment_complete(
		$ptm_number = "",
		$name = "",
		$activity = 0,
		$response = "",
		$comment = "",
		$attachment = "",
		$ptcId = 0,
		$user_id = null,
		$type_of_plan,
		$winner = null,
		$winner_quota = "",
		$committee = null
	) {

		if ($type_of_plan == 'rkp'){
			$tbl = 'adm_auth_hie_rfq_proyek';
			$tbl_pemenang = 'adm_auth_hie_pemenang_proyek';
			$tbl_pr = 'adm_auth_hie_pr_proyek';
			$tbl_kontrak = 'adm_auth_hie_kontrak_proyek';
			$view = 'vw_prc_hierarchy_approval_8';
			$view_pemenang = 'vw_prc_hierarchy_approval_9';
			$view_kontrak = 'vw_prc_hierarchy_approval_10';
		}elseif ($type_of_plan == 'rkp_matgis') {
			$tbl = 'adm_auth_hie_rfq_proyek';
			$tbl_pemenang = 'adm_auth_hie_pemenang_proyek';
			$tbl_pr = 'adm_auth_hie_pr_proyek';
			$tbl_kontrak = 'adm_auth_hie_kontrak_proyek';
			$view = 'vw_prc_hierarchy_approval_8';
			$view_pemenang = 'vw_prc_hierarchy_approval_9';
			$view_kontrak = 'vw_prc_hierarchy_approval_10';
		}elseif ($type_of_plan == 'rkap'){
			$tbl = 'adm_auth_hie_rfq_non_proyek';
			$tbl_pemenang = 'adm_auth_hie_pemenang_non_proyek';
			$tbl_pr = 'adm_auth_hie_pr_non_proyek';
			$tbl_kontrak = 'adm_auth_hie_kontrak_non_proyek';
			$view = 'vw_prc_hierarchy_approval_2';
			$view_pemenang = 'vw_prc_hierarchy_approval_3';
			$view_kontrak = 'vw_prc_hierarchy_approval_11';
		}else {
			$tbl = 'adm_auth_hie_rfq_proyek';
			$tbl_pemenang = 'adm_auth_hie_pemenang_proyek';
			$tbl_pr = 'adm_auth_hie_pr_proyek';
			$tbl_kontrak = 'adm_auth_hie_kontrak_proyek';
			$view = 'vw_prc_hierarchy_approval_8';
			$view_pemenang = 'vw_prc_hierarchy_approval_9';
			$view_kontrak = 'vw_prc_hierarchy_approval_10';
		}

		$this->db->select('ptm_dept_id, is_sap');
		$this->db->where('ptm_number', $ptm_number);
		$get_dept_id = $this->db->get('prc_tender_main')->row_array();
		$dept_id = $get_dept_id['ptm_dept_id'];

		if(is_numeric($response)){
			$response_real = $this->getResponseName($response);
			$response = url_title($response_real,"_",true);
		}

		$message = "";
		$nextPosCode = "";
		$nextPosName = "";
		$lastPosCode = "";
		$lastPosName = "";
		$nextActivity = 0;
		$anyIncompleteComment = 0;
		$tenderMethod = 0;
		$submissionMethod = 0;
		$justification = "";
		$totalOE = 0.0;
		$tmpPosition = "";
		$newNumber = 0;
		$nextActivity = 0;
		$nextjobtitle = "";
		$plan_num = 0;

		$anyIncompleteComment = $this->db
		->where(array("ptc_id"=>$ptcId,"ptc_name"=>null))
		->get("prc_tender_comment")
		->num_rows();

		if($anyIncompleteComment > 0){

		$this->db->where(array(
			"ptm_number"=>$ptm_number,
			"ptc_name"=>null
		));

		$this->db->where("ptc_activity",$activity,false);

		$table = "prc_tender_comment";

		$code_field = "ptc_pos_code";

		$name_field = "ptc_position";

		$getdata = $this->db
		->select($code_field." as lastPosCode,".$name_field." as lastPosName, ptc_activity as activity")
		->get($table)->row_array();

		$lastPosName = $getdata['lastPosName'];
		$lastPosCode = $getdata['lastPosCode'];
		$lastActivity = $getdata['activity'];
		$nextPosCode = $lastPosCode;
		$nextPosName = $lastPosName;

		//completing tender comment
		$totalOE = $this->db->select("sum((tit_price*tit_quantity)*(1+(COALESCE(tit_pph::double precision,0)/100)+(COALESCE(tit_ppn::integer,0)/100))) as total")->from("prc_tender_item")
		->where("ptm_number",$ptm_number)->get()->row()->total;

		$max_amount = $this->db->select("max_amount")->from($tbl)
		->where("pos_id",$lastPosCode)->get()->row();

		//start code hlmifzi
		$max_amount_2 = $this->db->select("max_amount")->from($tbl_pemenang)
		->where("pos_id",$lastPosCode)->get()->row();
		// ubah $pr_number jadi ptm_number
		$totalOE_2 = $this->db
		->select("sum((tit_price*tit_quantity)*(1+(COALESCE(tit_pph::double precision,0)/100)+(COALESCE(tit_ppn::integer,0)/100))) as total")
		->from("prc_tender_item")
		->where("ptm_number",$ptm_number)
		->get()->row()->total;
		//end

		$max_amount = (isset($max_amount->max_amount)) ? $max_amount->max_amount : 0;

		$update = $this->db
		->where(array("ptc_id"=>$ptcId))
		->update("prc_tender_comment",array(
			"ptc_response" => $response_real,
			"ptc_name" => $name,
			"ptc_end_date" => date("Y-m-d H:i:s"),
			"ptc_comment" => $comment,
			"ptc_attachment" => $attachment,
			"ptc_user" => $user_id,
		));

		$update = $this->db
		->where(array("ptm_number"=>$ptm_number))
		->update("prc_tender_main",array(
			"ptm_status" => $lastActivity,
		));

		//ganti ketua panitia sebagai manajer pengadaan
		$lastcom = $this->db
					->where(array("ptc_id"=>$ptcId))
					->get("prc_tender_comment")
					->row_array();

		$ispanitia = strpos($lastcom['ptc_position'], "PANITIA PENGADAAN");

		if ($committee['set'] != NULL and $ispanitia != FALSE) {

			$realman = $this->db
						->where(array('dept_id'=>$get_dept_id['ptm_dept_id'], 'job_title'=>"MANAJER PENGADAAN"))
						->get("vw_adm_pos_v1")
						->row_array();

			$lastPosCode = $realman['pos_id'];
			$lastPosName = $realman['pos_name'];
		}
		//end y code

		if($activity == 1029){

			if($response == url_title('Lanjutkan',"_",true)){

				$nextjobtitle = 'MANAJER PENGADAAN';

				$getdata = $this->getNextState(
					"pos_id",
					"pos_name",
					"adm_pos",
					array("job_title"=>$nextjobtitle));

				$nextPosCode = $getdata['nextPosCode'];
				$nextPosName = $getdata['nextPosName'];

				$nextActivity = 1030;

			}

		} else if($activity == 1030){

			//Penunjukkan Pelaksana Pengadaan

			if($response == url_title('Lanjutkan',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			}

		} else if($activity == 1040){

			//Pembuatan Dokumen Pengadaan

			if($response == url_title('Simpan Sebagai Draft',"_",true)){

				$nextActivity = 1040;

			} else if($response == url_title('Lanjutkan ke Persetujuan',"_",true)){

				$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
				->get($view)
				->row_array();

				$next_hap = 0;

				if(!empty($hap)){
					$next_hap = $hap['hap_amount'];
				}

				if($totalOE > $next_hap){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent
						from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextjobtitle = $this->getNextJobTitle($nextPosCode);


					$nextActivity = 1041;

				} else {

					$nextjobtitle = 'VP PENGADAAN';

					$this->db->join($view." a", 'a.hap_pos_code = b.pos_id');
					$getdata = $this->getNextState(
						"a.hap_pos_code",
						"a.hap_pos_name",
						"adm_pos b",
						array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1050;

				}

			}

		} else if($activity == 1041){

			if($response == url_title('Setuju',"_",true)){

				$getdata = $this->db
				->select("adm_bid_committee")
				->where("ptm_number",$ptm_number)
				->get("prc_tender_prep")->row_array();

				$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
				->get($view)
				->row_array();

				$next_hap = 0;

				if(!empty($hap)){
					$next_hap = $hap['hap_amount'];
				}

				if($totalOE > $next_hap){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent
						from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					//y rfq dari buyer ke staff scm
					if($nextPosCode == NULL){
						$getdatastaf = $this->getNextState(
							"ptm_requester_pos_code",
							"ptm_requester_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdatastaf['nextPosName'];
						$nextPosCode = $getdatastaf['nextPosCode'];
					}
					//y end

					$nextjobtitle = $this->getNextJobTitle($nextPosCode);

					$nextActivity = 1041;

				} else {

					$proc = $this->db
					->where(array("ptm_number"=>$ptm_number))
					->get("prc_tender_prep")->row_array();

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($proc['ptp_prequalify'] == 2){
						//start code hlmifzi
						$nextActivity = 1060;
						//end code
					} else if($proc['ptp_tender_method'] == 2){

						$nextActivity = 1070;

					} else {

						$nextActivity = 1060;

					}

				}

			} else if($response == url_title('Revisi',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			}

		} else if($activity == 1050){

			//Persetujuan Dokumen Pengadaan Non Panitia

			if($response == url_title('Revisi',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			} else if($response == url_title('Setuju',"_",true)){

				$getdata = $this->db
				->select("ptp_tender_method")
				->where("ptm_number",$ptm_number)
				->get("prc_tender_prep")->row_array();

				$tender_method = $getdata['ptp_tender_method'];

				$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
				->get($view)
				->row_array();

				$next_hap = 0;

				if(!empty($hap)){
					$next_hap = $hap['hap_amount'];
				}

				if(($totalOE > $next_hap) && !empty($getdata) && !($tender_method != 0 && $getdata['hap_pos_job'] == "DIREKTUR USER")){

					$getdata = $this->db
					->where("hap_pos_code = (select distinct hap_pos_parent from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)")
					->get($view)
					->row_array();

					$nextPosCode = $getdata['hap_pos_code'];
					$nextPosName = $getdata['hap_pos_name'];

					$nextjobtitle = $this->getNextJobTitle($nextPosCode);

					$nextActivity = 1050;

				} else {

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = (!empty($tender_method) && $tender_method == 2) ? 1070 : 1060;

				}

			}

		} else if($activity == 1051){

			//Persetujuan Dokumen Pengadaan Ketua

			if($response == url_title('Revisi',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			} else if($response == url_title('Setuju',"_",true)){

				//CEK REVIEW SUDAH DIISI SUDAH SEMUA ATAU BELUM
				$check = $this->db->where(array("ptc_end_date"=>null,"ptc_name"=>null,"ptm_number
					"=>$ptm_number,"ptc_activity"=>1052))->get("prc_tender_comment")->num_rows();

				if(empty($check)){
					//SUDAH DIREVIEW SEMUA

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextActivity = (!empty($tender_method) && $tender_method == 2) ? 1070 : 1060;

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

				} else {
					$message = "Review belum dikerjakan oleh anggota panitia";
					$update = $this->db
					->where(array("ptc_id"=>$ptcId))
					->update("prc_tender_comment",array(
						"ptc_response" => null,
						"ptc_name" => null,
						"ptc_end_date" => null,
						"ptc_comment" => "",
						"ptc_attachment" => "",
					));
				}

			}

		} else if($activity == 1052){

			//Persetujuan Dokumen Pengadaan Non Ketua

			$nextActivity = 0;

		} else if($activity == 1060){

			$getdata = $this->getNextState(
				"ptm_buyer_pos_code",
				"ptm_buyer_pos_name",
				"prc_tender_main",
				array("ptm_number"=>$ptm_number));

			$nextPosName = $getdata['nextPosName'];
			$nextPosCode = $getdata['nextPosCode'];

			$nextActivity = 1080;

		} else if($activity == 1070){

					$proc = $this->db
					->where(array("ptm_number"=>$ptm_number))
					->get("prc_tender_prep")->row_array();

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($proc['ptp_prequalify'] == 1){

						$nextActivity = 1071;

					} else {

						$nextActivity = 1080;

					}

				}  else if($activity == 1071){

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextjobtitle = 'MANAJER PENGADAAN';
						$this->db->join($view." a", 'a.hap_pos_code = b.pos_id');
						$getdata = $this->getNextState(
							"a.hap_pos_code",
							"a.hap_pos_name",
							"adm_pos b",
							array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));
						// $getdata = $this->getNextState(
						// 	"pos_id",
						// 	"pos_name",
						// 	"adm_pos",
						// 	array("job_title"=>$nextjobtitle));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextActivity = 1072;

					}else if($response == url_title('Batalkan Pengadaan',"_",true)) {

						$this->batalkanPengadaan($ptm_number);
						$nextActivity = 1902;

					} else {

						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;

					}

				} else if($activity == 1072){


					if($response == url_title('Setuju',"_",true)){

						$nextjobtitle = 'VP PENGADAAN';

						$this->db->join($view." a", 'a.hap_pos_code = b.pos_id');
						$getdata = $this->getNextState(
							"a.hap_pos_code",
							"a.hap_pos_name",
							"adm_pos b",
							array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextActivity = 1073;

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1071;

					}

				} else if($activity == 1073){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($response == url_title('Setuju',"_",true)){

						$nextActivity = 1074;

					} else {

						$nextActivity = 1071;

					}

				} else if($activity == 1074){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$this->db->where("ptm_number",$ptm_number)->update("prc_tender_prep",array("ptp_prequalify"=>2));
						$nextActivity = 1040;

					} else if($response == url_title('Ulangi Pengadaan',"_",true)){

						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;

					} else {

						$nextActivity = 1902;

						$this->batalkanPengadaan($ptm_number);

					}

				} else if($activity == 1080){

					if($response == url_title('Lanjutkan ke Pembukaan Penawaran',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1090;


					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

				} else if($activity == 1090){

					if($response == url_title('Lanjutkan ke Evaluasi Penawaran',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$getdata = $this->db
						->select("ptp_submission_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						switch ($getdata['ptp_submission_method']) {
							case 1:
							$nextActivity = 1110;
							break;
							case 2:
							$nextActivity = 1112;
							break;

							default:
							$nextActivity = 1100;
							break;
						}


					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)){
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

				} else if($activity == 1100){

					if($response == url_title('Lanjutkan ke Persetujuan Evaluasi',"_",true)){

						$getdata = $this->db
						->select("adm_bid_committee")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view,
							"hap_pos_code = (select distinct hap_pos_parent
							from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextjobtitle = $this->getNextJobTitle($nextPosCode);

						$nextActivity = 1102;

					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)){

						$this->ulangiPengadaan($ptm_number);

						$nextActivity = 1903;

					} else if($response == url_title('Proses E-Auction',"_",true)) {

						$nextActivity = 1100;

					}

				} else if($activity == 1101){


					if($response == url_title('Setuju',"_",true)){
						//haqim
						$this->db->select('hap_pos_parent');
						$this->db->where('hap_pos_code', $lastPosCode);
						$check_parent = $this->db->get($view)->row_array();
						if ($check_parent['hap_pos_parent'] != null) {

							$nextjobtitle = 'VP PENGADAAN';

							// $getdata = $this->getNextState(
							// 	"pos_id",
							// 	"pos_name",
							// 	"adm_pos",
							// 	array("job_title"=>$nextjobtitle));
							$this->db->join($view." a", 'a.hap_pos_code = b.pos_id');
							$getdata = $this->getNextState(
								"a.hap_pos_code",
								"a.hap_pos_name",
								"adm_pos b",
								array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));
							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$nextActivity = 1102;
						} else {
							//haqim --sama seperti activity 1102
							$getdata = $this->getNextState(
								"ptm_buyer_pos_code",
								"ptm_buyer_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

							if($response == url_title('Setuju',"_",true)){

								$nextActivity = 1140;

							} else {

								$nextActivity = 1100;

							}
						}

						//end



					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1100;

					}

				}else if($activity == 1102){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($response == url_title('Setuju',"_",true)){

						$nextActivity = 1140;

					} else {

						$nextActivity = 1100;

					}

				} else if($activity == 1110){

					if($response == url_title('Lanjutkan ke Evaluasi Penawaran Harga',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$getdata = $this->db
						->select("ptp_submission_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						$nextActivity = 1120;

					} else if($response == url_title('Jumlah yang Lulus Tidak Kuorum',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

				} else if($activity == 1112){

					if($response == url_title('Lanjutkan ke Undang Vendor Tahap 2',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1113;

					} else if($response == url_title('Jumlah yang Lulus Tidak Kuorum',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

				} else if($activity == 1113){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1114;

				}else if($activity == 1114){

					if($response == url_title('Lanjutkan ke Pembukaan Penawaran',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1115; //1120;


					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

			}  else if($activity == 1115){

				if($response == url_title('Lanjutkan ke Persetujuan Evaluasi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1120;


				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;
				}

			}  else if($activity == 1120){

				if($response == url_title('Lanjutkan ke Persetujuan Evaluasi',"_",true)){

					$nextjobtitle = 'MANAJER PENGADAAN';

					$this->db->join($view." a", 'a.hap_pos_code = b.pos_id');
					$getdata = $this->getNextState(
						"a.hap_pos_code",
						"a.hap_pos_name",
						"adm_pos b",
						array("b.job_title"=>$nextjobtitle,"b.dept_id"=>$dept_id)

					);

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];
					$nextActivity = 1122;

				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;
				} else if($response == url_title('Proses E-Auction',"_",true)) {

					$nextActivity = 1120;

				}

			} else if($activity == 1121){

				if($response == url_title('Lanjutkan',"_",true)){

					$getdata = $this->db
					->select("adm_bid_committee")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					if(!empty($getdata['adm_bid_committee'])){

					} else {

						$nextjobtitle = 'VP PENGADAAN';

						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos b",
							array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextActivity = 1122;

					}

				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;
				}

			}else if($activity == 1122){

				if($response == url_title('Setuju',"_",true)){

					$getdata = $this->db
					->select("adm_bid_committee")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1140;

				}elseif($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$getdata = $this->db
					->select("ptp_submission_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$nextActivity = ($getdata['ptp_submission_method'] == 0) ? 1100 : 1110;

				}else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;
				}

			} else if($activity == 1130){

			//Persetujuan Evaluasi

				if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$getdata = $this->db
					->select("ptp_submission_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$nextActivity = ($getdata['ptp_submission_method'] == 0) ? 1100 : 1110;

				} else if($response == url_title('Setuju',"_",true)){

					if($totalOE > $max_amount){
						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view,
							"hap_pos_code = (select distinct hap_pos_parent
							from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextjobtitle = $this->getNextJobTitle($nextPosCode);

						$nextActivity = 1130;

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];
						$nextActivity = 1140;

					}

				}

			} else if($activity == 1131){

			//Persetujuan Evaluasi Ketua

				if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$getdata = $this->db
					->select("ptp_submission_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$nextActivity = ($getdata['ptp_submission_method'] == 0) ? 1100 : 1110;

				} else if($response == url_title('Setuju',"_",true)){

				//CEK REVIEW SUDAH DIISI SUDAH SEMUA ATAU BELUM
					$check = $this->db->where(array("ptc_end_date"=>null,"ptc_name"=>null,"ptm_number
						"=>$ptm_number,"ptc_activity"=>1132))->get("prc_tender_comment")->num_rows();

					if(empty($check)){
					//SUDAH DIREVIEW SEMUA
						$getdata = $this->db
						->select("adm_bid_committee,ptp_tender_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						$nextActivity = 1140;

						if(!empty($getdata['adm_bid_committee'])){

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"vw_adm_bid_committee",
								array("committee_id"=>$getdata['adm_bid_committee'],"committee_type"=>2));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						} else {

							$getdata = $this->getNextState(
								"ptm_buyer_pos_code",
								"ptm_buyer_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						}

					} else {
						$message = "Review belum dikerjakan oleh anggota panitia pengadaan";
						$update = $this->db
						->where(array("ptc_id"=>$ptcId))
						->update("prc_tender_comment",array(
							"ptc_response" => null,
							"ptc_name" => null,
							"ptc_end_date" => null,
							"ptc_comment" => "",
							"ptc_attachment" => "",
						));
					}

				}

			} else if($activity == 1132){

			//Persetujuan Evaluasi Non Ketua

				$nextActivity = 0;

			} else if($activity == 1140){

				if($response == url_title('Lanjutkan ke Persetujuan Calon Pelaksana Pekerjaan',"_",true)){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent
						from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextjobtitle = $this->db->where("pos_id",$nextPosCode)->get("adm_pos")->row()->job_title;

					$nextActivity = 1141;

				} else if($response == url_title('Buka Negosiasi',"_",true)) {
					$nextActivity = 1140;
				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;
				}

			} else if($activity == 1141){

				if($response == url_title('Lanjutkan ',"_",true)){

					$getdata = $this->db
					->select("adm_bid_committee")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
					->get($view_pemenang)
					->row_array();

					$next_hap = 0;

					if(!empty($hap)){
						$next_hap = $hap['hap_amount'];
					}

					$x = $this->db->query("select distinct hap_pos_parent
						from ".$view_pemenang." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL")->result_array();

					$y = $this->db->where('pos_id',$lastPosCode)
					->get('vw_adm_pos')
					->row_array();

					$poscode = null;

					if(count($x) > 1){
						foreach ($x as $key => $value) {
							if(!$poscode){
								$get_user = $this->db->where("pos_id",$value['hap_pos_parent'])->get("vw_adm_pos")->row_array();
								if($get_user['dept_id'] == $y['dept_id']){
									$poscode = $get_user['pos_id'];
								}
							}
						}
					} else if($lastPosCode == "MANAJER PERENCANAAN" || $lastPosCode == "MANAJER DIVISI" || count($x) < 1) {
						$poscode = 0;

					} else {

						$poscode = $x[0]['hap_pos_parent'];
					}

					$pos = $this->Administration_m->getPos($lastPosCode)->row_array();

					$datarfq = $this->Procrfq_m->getRFQ($ptm_number)->row_array();
					$mpdiv = $this->Administration_m->getMasterMdiv(array('amm_id'=>$datarfq['amm_id']))->row_array();

					//dari manajer pegadaan ke mppp
					if ($pos['job_title'] == "MANAJER PENGADAAN" && $datarfq['ptm_type_of_plan'] == "rkp") {

						$man = $this->db->where(array('ptm_number'=>$ptm_number,'ptc_activity'=>1141))->order_by("ptc_id", "asc")->get("prc_tender_comment")->row_array();

						$next_hap = 1000000000;

						$poscd = $man['ptc_pos_code'];

						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view_pemenang,
							"hap_pos_code = (select distinct hap_pos_parent
						from ".$view_pemenang." where hap_pos_code = ".$poscd." AND hap_pos_parent IS NOT NULL)");

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$next_hap = 0;

					// dari mppp ke mdiv
					}else if ($pos['job_title'] == "MANAJER PERENCANAAN" && $datarfq['ptm_type_of_plan'] == "rkp") {

						$nextPosCode = $mpdiv['pos_code'];
						$nextPosName = $mpdiv['pos_name'];

						$next_hap = $next_hap+1;

					//dari mdiv ke gm dst
					}else if ($pos['job_title'] == "MANAJER DIVISI" && $datarfq['ptm_type_of_plan'] == "rkp") {

						$man = $this->db->where(array('ptm_number'=>$ptm_number,'ptc_activity'=>1141))->order_by("ptc_id", "asc")->get("prc_tender_comment")->row_array();

						$next_hap = 1000000000;

						$poscd = $man['ptc_pos_code'];

						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view_pemenang,
							"hap_pos_code = (select distinct hap_pos_parent
						from ".$view_pemenang." where hap_pos_code = ".$poscd." AND hap_pos_parent IS NOT NULL)");


						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

					} else {  // aproval berjenjang
						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view_pemenang,
							"hap_pos_code = $poscode");

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];
					}


					if($totalOE > $next_hap){

						$nextActivity = 1141;

					} else {

						//approval panitia pengadaan
						//approval ke dbs
						$this->db->order_by('pos_name', 'asc');
						$this->db->limit(1);
						$this->db->join("$tbl_pemenang b", 'b.pos_id = adm_pos.pos_id');
						$getdata_keu = $this->getNextState(
							"adm_pos.pos_id",
							"adm_pos.pos_name",
							'adm_pos',
							"job_title = 'PIC ANGGARAN'");

						$tunjuk_pemenang = true;

						if (count($getdata_keu) != 0) {

							$getdata_dsb = $this->getNextState(
								"hap_pos_code",
								"hap_pos_name",
								$view_pemenang,
								"hap_pos_parent = ".$getdata_keu['nextPosCode']);

							if ($lastPosCode !=  $getdata_dsb['nextPosCode'] AND $lastPosCode != $getdata_keu['nextPosCode']) {

								$nextPosName = $getdata_dsb['nextPosName'];
								$nextPosCode = $getdata_dsb['nextPosCode'];
								$tunjuk_pemenang = false;
								$nextActivity = 1153;

							}else{

								$tunjuk_pemenang = true;

							}


						}

						if ($tunjuk_pemenang) {

							$getdata = $this->db
							->select("ptp_tender_method")
							->where("ptm_number",$ptm_number)
							->get("prc_tender_prep")->row_array();

							if($getdata['ptp_tender_method'] == 0){

								$nextjobtitle = 'VP PENGADAAN';

								$this->db->join($view_pemenang." a", 'a.hap_pos_code = b.pos_id');
								$getdata = $this->getNextState(
									"a.hap_pos_code",
									"a.hap_pos_name",
									"adm_pos b",
									array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

								$nextPosCode = $getdata['nextPosCode'];
								$nextPosName = $getdata['nextPosName'];

								$wintype = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

								if ($wintype["ptm_winner"] == 2) {
									$nextActivity = 1181;
								}else{
									$nextActivity = 1180;
								}

							} else {

								$getdata = $this->getNextState(
									"ptm_buyer_pos_code",
									"ptm_buyer_pos_name",
									"prc_tender_main",
									array("ptm_number"=>$ptm_number));

								$nextPosName = $getdata['nextPosName'];
								$nextPosCode = $getdata['nextPosCode'];
								$nextActivity = 1160;
							}

						}

					}

				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {

					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;

				} else if($response == url_title('Kembali ke Negosiasi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];
					$nextActivity = 1140;

				}

			} else if ($activity == 1144) {

				$this->db->order_by('pos_name', 'asc');
				$this->db->limit(1);
				$this->db->join("$tbl_pemenang b", 'b.pos_id = adm_pos.pos_id');
				$getdata_keu = $this->getNextState(
					"adm_pos.pos_id",
					"adm_pos.pos_name",
					'adm_pos',
					"job_title = 'PIC ANGGARAN'");

				$tunjuk_pemenang = true;

				if (count($getdata_keu) != 0) {

					$getdata_dsb = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view_pemenang,
						"hap_pos_parent = ".$getdata_keu['nextPosCode']);

					if ($lastPosCode !=  $getdata_dsb['nextPosCode'] AND $lastPosCode != $getdata_keu['nextPosCode']) {

						$nextPosName = $getdata_dsb['nextPosName'];
						$nextPosCode = $getdata_dsb['nextPosCode'];
						$tunjuk_pemenang = false;
						$nextActivity = 1153;

					}else{

						$tunjuk_pemenang = true;

					}


				}

				if ($tunjuk_pemenang) {

					$getdata = $this->db
					->select("ptp_tender_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					if($getdata['ptp_tender_method'] == 0){

						$nextjobtitle = 'VP PENGADAAN';

						$this->db->join($view_pemenang." a", 'a.hap_pos_code = b.pos_id');
						$getdata = $this->getNextState(
							"a.hap_pos_code",
							"a.hap_pos_name",
							"adm_pos b",
							array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$wintype = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

						if ($wintype["ptm_winner"] == 2) {
							$nextactivity = 1181;
						}else{
							$nextActivity = 1180;
						}

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];
						$nextActivity = 1160;
					}

				}

			} else if ($activity == 1153) {

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];
				
				$nextActivity = 1160;

			} else if ($activity == 1154) {

				$getdata = $this->db
				->select("ptp_tender_method")
				->where("ptm_number",$ptm_number)
				->get("prc_tender_prep")->row_array();

				if($getdata['ptp_tender_method'] == 0){

					$nextjobtitle = 'VP PENGADAAN';

					$this->db->join($view_pemenang." a", 'a.hap_pos_code = b.pos_id');
					$getdata = $this->getNextState(
						"a.hap_pos_code",
						"a.hap_pos_name",
						"adm_pos b",
						array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$wintype = $this->Procrfq_m->getRFQ($ptm_number)->row_array();


					if ($wintype["ptm_winner"] == "2") {
						$nextActivity = 1181;
					}else{
						$nextActivity = 1180;
					}

				} else {

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];
					$nextActivity = 1160;
				}


			} else if($activity == 1150){

				//Persetujuan Calon Pemenang Evaluasi

				if($response == url_title('Tidak Setuju',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1140;

				} else if($response == url_title('Setuju',"_",true)){

					if($totalOE_2 > $max_amount_2){

						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view_pemenang,
							"hap_pos_code = (select distinct hap_pos_parent
							from ".$view_pemenang." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextjobtitle = $this->getNextJobTitle($nextPosCode);

						$nextActivity = 1150;

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$getdata = $this->db
						->select("ptp_tender_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						if($getdata['ptp_tender_method'] == 0){

							$nextjobtitle = 'VP PENGADAAN';
							// $getdata = $this->getNextState(
							// 	"pos_id",
							// 	"pos_name",
							// 	"adm_pos",
							// 	array("job_title"=>$nextjobtitle));

							$this->db->join($view_pemenang." a", 'a.hap_pos_code = b.pos_id');
							$getdata = $this->getNextState(
								"a.hap_pos_code",
								"a.hap_pos_name",
								"adm_pos b",
								array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$nextActivity = 1180;

						} else {

							$getdata = $this->getNextState(
								"ptm_buyer_pos_code",
								"ptm_buyer_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];
							$nextActivity = 1160;
						}

					}

				}

			} else if($activity == 1151){

			//Persetujuan Calon Pemenang Ketua

				if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$getdata = $this->db
					->select("ptp_submission_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$nextActivity = ($getdata['ptp_submission_method'] == 0) ? 1100 : 1110;

				} else if($response == url_title('Setuju',"_",true)){

				//CEK REVIEW SUDAH DIISI SUDAH SEMUA ATAU BELUM
					$check = $this->db->where(array("ptc_end_date"=>null,"ptc_name"=>null,"ptm_number
						"=>$ptm_number,"ptc_activity"=>1152))->get("prc_tender_comment")->num_rows();

					if(empty($check)){
					//SUDAH DIREVIEW SEMUA

						$getdata = $this->db
						->select("adm_bid_committee,ptp_tender_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						$nextActivity = 1160;

						if(!empty($getdata['adm_bid_committee'])){

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"vw_adm_bid_committee",
								array("committee_id"=>$getdata['adm_bid_committee'],"committee_type"=>2));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						} else {

							$getdata = $this->getNextState(
								"ptm_buyer_pos_code",
								"ptm_buyer_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						}

					} else {
						$message = "Review belum dikerjakan oleh anggota panitia pengadaan";
						$update = $this->db
						->where(array("ptc_id"=>$ptcId))
						->update("prc_tender_comment",array(
							"ptc_response" => null,
							"ptc_name" => null,
							"ptc_end_date" => null,
							"ptc_comment" => "",
							"ptc_attachment" => "",
						));
					}

				}

			} else if($activity == 1152){

			//Persetujuan Calon Pemenang Non Ketua

				$nextActivity = 0;

			} else if($activity == 1160){

				if($response == url_title('Umumkan Pemenang',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1170;

				}

			} else if($activity == 1170){

				if($response == url_title('Terbukti dan Ulangi Pengadaan',"_",true)){

					$this->ulangiPengadaan($ptm_number);

					$nextActivity = 1903;

				} else if($response == url_title('Terbukti dan Batalkan Pengadaan',"_",true)){

					$nextActivity = 1902;

					$this->batalkanPengadaan($ptm_number);

				} else {

					$nextjobtitle = 'VP PENGADAAN';
					$this->db->join($view_pemenang." a", 'a.hap_pos_code = b.pos_id');
					$getdata = $this->getNextState(
						"a.hap_pos_code",
						"a.hap_pos_name",
						"adm_pos b",
						array("b.job_title"=>$nextjobtitle,'b.dept_id'=>$dept_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$wintype = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

					if ($wintype["ptm_winner"] == 2) {
						$nextActivity = 1181;
					}else{
						$nextActivity = 1180;
					}

				}

			} else if($activity == 1180){

				if($response == url_title('Tunjuk Pelaksana Pekerjaan',"_",true)){

					$nextActivity = 1901;

					$this->selesaiPengadaan($ptm_number);

					$this->load->model("Contract_m");

					//new create contract by aldo

					$check = $this->db
					->query("SELECT * FROM vw_prc_monitor WHERE ptm_number = '".$ptm_number."' AND last_status = 1180")
					->row_array();

					$deptval = $this->db->where("dept_id", $check['ptm_dept_id'])->get("adm_dept")->row_array();

					foreach ($winner as $key => $value) {
						$vnd = $value;
					}

					$vdheader = $this->db->where(array("ptv_vendor_code"=>$vnd, "ptm_number"=>$ptm_number))->get("vw_prc_quotation_vendor_sum")->row_array();

					if(!empty($vnd)){

						$vendor_id = $vdheader['ptv_vendor_code'];

						$dept_id = $check['ptm_dept_id'];

						$dept = $this->db->where("dept_id",$dept_id)->get("adm_dept")->row_array();

						$is_matgis = ($check['ptm_type_of_plan'] == "rkp_matgis");

						$district_id =($check['ptm_district_id']) ? $check['ptm_district_id'] : 1;

						if(!$is_matgis){
							$spew = array(
								"job_title"=>"PENGELOLA KONTRAK",
								"district_id"=>$district_id,
								"dept_id"=>$dept_id
							);
							$spem = array(
								"job_title"=>"MANAJER PENGADAAN",
								"district_id"=>$district_id,
								"dept_id"=>$dept_id
							);
						} else {
							$spew = "job_title = 'PENGELOLA KONTRAK' AND district_id = $district_id AND dept_name = 'SUPPLY CHAIN MANAGEMENT'";
							$or_spew = "job_title = 'PENGELOLA KONTRAK' AND district_id = $district_id AND dept_name = 'SCM'";
							$spem = "job_title = 'MANAJER KONTRAK' AND district_id = $district_id AND dept_name = 'SUPPLY CHAIN MANAGEMENT'";
							$or_spem = "job_title = 'MANAJER KONTRAK' AND district_id = $district_id AND dept_name = 'SCM'";
						}

						if (isset($or_spem) AND !empty($or_spem)) {
							$this->db->or_where($or_spem);
						}

						$this->db->select("pos_id, pos_name, employee_id");
						$this->db->where($spem);
						$getman = $this->db->get("user_login_rule")->row_array();

						if (isset($or_spew) AND !empty($or_spew)) {
							$this->db->or_where($or_spew);
						}

						$this->db->select("pos_id, pos_name, employee_id");
						$this->db->where($spew);
						$getspe = $this->db->get("user_login_rule")->row_array();

						$getdata = $getspe;

                        $typeplan = ($check['ptm_type_of_plan'] == "rkp") ? "proyek" : "departemen";

                        $input['type_of_plan'] = $typeplan;

						// $input['type_of_plan'] = 'departemen';

						$input['ctr_is_matgis'] = $is_matgis ? 1 : 0;

						$input['notes'] = strtoupper("SINGLE WINNER ".$check['ptm_number']." ".$check['vendor_id']);

						$input['dept_code'] = $deptval['dep_code'];

						$input['dept_id'] = $dept_id;

						$input['spk_code'] = $check['spk_code'];

						$input['ptm_number'] = $check['ptm_number'];

						$input['status'] = 2010;

						$input['currency'] = $check['ptm_currency'];

						$input['vendor_id'] = $vdheader['ptv_vendor_code'];

						$input['vendor_name'] = $vdheader['vendor_name'];

						$input['subject_work'] = $check['ptm_subject_of_work'];

						$input['scope_work'] = $check['ptm_scope_of_work'];

						$input['contract_type'] = $check['ptm_contract_type'];

						$input['completed_tender_date'] = date("Y-m-d H:i:s");

						$input['contract_amount'] = $vdheader['total_ppn'];

						$input['created_date'] = date("Y-m-d H:i:s");

						$input['is_sap'] = $get_dept_id['is_sap'] == 'sap' ? 1 : 0;

						if(!empty($getspe)){

							$input['ctr_spe_employee'] = $getspe['employee_id'];

							$input['ctr_spe_pos'] = $getspe['pos_id'];

							$input['ctr_spe_pos_name'] = $getspe['pos_name'];

						}

						if(!empty($getman)){

							$input['ctr_man_employee'] = $getman['employee_id'];

							$input['ctr_man_pos'] = $getman['pos_id'];

							$input['ctr_man_pos_name'] = $getman['pos_name'];

						}

						$this->db->insert("ctr_contract_header",$input);

						$contract_id = $this->db->insert_id();

						$vendor_id = $vnd;

						$this->db->where("vendor_id",$vendor_id);

						$quo_item = $this->Procrfq_m
						->getViewVendorQuoComRFQ("","",$check['ptm_number'])
						->result_array();

						if($get_dept_id['is_sap'] == 'sap') {
							$quo_item = $this->Procrfq_m
							->getViewVendorQuoComRFQ_Sap("","",$check['ptm_number'])
							->result_array();
						}

						foreach ($quo_item as $key => $value) {

							$short = (!empty($value['short_description'])) ? $value['short_description'] : $value['pqi_description'];

							$weight = ($is_matgis) ? $value['pqi_quantity']*1.1 : $value['pqi_quantity'];

							$i = array(
								"tit_id"=>$value['tit_id'],
								"contract_id"=>$contract_id,
								"item_code"=>$value['tit_code'],
								"short_description"=>$short,
								"long_description"=>$value['pqi_description'],
								"price"=>$value['pqi_price'],
								"qty"=>$value['pqi_quantity'], //$weight,
								"uom"=>$value['tit_unit'],
								"min_qty"=>1,
								"max_qty"=>$weight,
								"ppn"=>($value['pqi_ppn']) ? $value['pqi_ppn'] : 0,
								"pph"=>($value['pqi_pph']) ? $value['pqi_pph'] : 0,
								'vendor_code'=>$vendor_id,
								"pr_number_sap"=>$value['tit_pr_number'],
								"pr_item_sap"=>$value['tit_pr_item'],
								"pr_delivery_date"=>$value['tit_delivery_date'],
								"pr_type_sap"=>$value['tit_pr_type'],
								"pr_cat_tech"=>$value['tit_cat_tech'],
								"pr_acc_assig"=>$value['tit_acc_assig'],
							);

							$sub_total = $i['qty']*$i['price']*((100+$i['pph']+$i['ppn'])/100);

							$i['sub_total'] = $sub_total;

							$act = $this->Contract_m->insertItem($i);


						}

						$this->db->insert("ctr_contract_comment",array(
							"ptm_number"=>$ptm_number,
							"contract_id"=>$contract_id,
							"ccc_activity"=>2010,
							"ccc_position"=>$getdata['pos_name'],
							"ccc_pos_code"=>$getdata['pos_id'],
							"ccc_start_date"=>date("Y-m-d H:i:s"),
						));


					}

				} else if($response == url_title('Batalkan Pengadaan',"_",true)){

					$nextActivity = 1902;

					$this->batalkanPengadaan($ptm_number);

				} else if($response == url_title('Ulangi Proses Negosiasi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1140;

				}

			} else if($activity == 1181){

				if ($response == url_title('Simpan Sebagai Draft',"_",true)) {

					$nextActivity = 1181;

				}
				else if($response == url_title('Tunjuk Pelaksana Pekerjaan',"_",true)){

					$nextActivity = 1905;

					$this->selesaiPengadaan($ptm_number);

					$this->load->model("Contract_m");

					//new autocreate contract from log by aldo

					if(!empty($winner_quota)){

						$check = $this->db
						->query("SELECT * FROM vw_prc_monitor WHERE ptm_number = '".$ptm_number."' AND last_status = 1181")
						->row_array();

						$is_matgis = ($check['ptm_type_of_plan'] == "rkp_matgis");

						$deptval = $this->db->where("dept_id", $check['ptm_dept_id'])->get("adm_dept")->row_array();

						$vend_item = [];

						foreach ($winner_quota as $x => $y) {

							if ($y['percentage'] != "0.00") {

								$fw = $this->db
								->select("tit_id,tit_code,pr_dept_id,pr_dept_name,tit_description,tit_unit,tit_type,tit_currency,tit_pr_number,tit_pr_item,tit_delivery_date,tit_pr_type,tit_cat_tech,tit_acc_assig")
								->join("prc_pr_main","prc_pr_main.pr_number=prc_tender_item.pr_number","left")
								->where("tit_id",$y['tit_id'])
								->where("ptm_number",$y['ptm_number'])
								->get("prc_tender_item")
								->row_array();

								$pw = [
									'percentage' => $y['percentage'],
									'weight' => $y['weight']
								];

								$d = array_merge($fw, $pw);

								$vend_item[$y['vendor_id']][trim($d['tit_code'])] = $d;
							}
						}


						foreach ($vend_item as $x => $y) {

							$vendor_id = $x;

							$vendor = $this->db
							->where("vendor_id",$vendor_id)
							->get("vnd_header")
							->row_array();

							if(!empty($vendor)){

								$item_cont = [];

								$total_contract = 0;

								foreach ($y as $a) {

									$this->db->where("vendor_id",$vendor_id);

									$quo_item = $this->Procrfq_m
									->getViewVendorQuoComRFQ($a['tit_id'],"",$ptm_number)
									->row_array();

									$weight = $a['weight'];

									$short = (!empty($a['tit_description'])) ? $a['tit_description'] : $quo_item['pqi_description'];

									$i = array(
										"tit_id"=>$a['tit_id'],
										"item_code"=>trim($a['tit_code']),
										"short_description"=>$short,
										"long_description"=>$quo_item['pqi_description'],
										"price"=>$quo_item['pqi_price'],
										"qty"=>$a['weight'], //$weight,
										"uom"=>$a['tit_unit'],
										"min_qty"=>1,
										"max_qty"=>$weight,
										"ppn"=>($quo_item['pqi_ppn']) ? $quo_item['pqi_ppn'] : 0,
										"pph"=>($quo_item['pqi_pph']) ? $quo_item['pqi_pph'] : 0,
										'vendor_code'=>$vendor_id,
										"pr_number_sap"=>$a['tit_pr_number'],
										"pr_item_sap"=>$a['tit_pr_item'],
										"pr_delivery_date"=>$a['tit_delivery_date'],
										"pr_type_sap"=>$a['tit_pr_type'],
										"pr_cat_tech"=>$a['tit_cat_tech'],
										"pr_acc_assig"=>$a['tit_acc_assig']
									);

									$sub_total = $i['qty']*$i['price']*((100+$i['pph']+$i['ppn'])/100);

									$i['sub_total'] = $sub_total;

									$item_cont[] = $i;

									$total_contract += $sub_total;

								}

								$is_matgis = ($check['ptm_type_of_plan'] == "rkp_matgis");

								$district_id =($check['ptm_district_id']) ? $check['ptm_district_id'] : 1;

								if(!$is_matgis){
									$spew = array(
										"job_title"=>"PENGELOLA KONTRAK",
										"district_id"=>$district_id,
										"dept_id"=>$dept_id
									);
									$spem = array(
										"job_title"=>"MANAJER PENGADAAN",
										"district_id"=>$district_id,
										"dept_id"=>$dept_id
									);
								} else {
									$spew = "job_title = 'PENGELOLA KONTRAK' AND district_id = $district_id AND dept_name = 'SUPPLY CHAIN MANAGEMENT'";
									$or_spew = "job_title = 'PENGELOLA KONTRAK' AND district_id = $district_id AND dept_name = 'SCM'";
									$spem = "job_title = 'MANAJER KONTRAK' AND district_id = $district_id AND dept_name = 'SUPPLY CHAIN MANAGEMENT'";
									$or_spem = "job_title = 'MANAJER KONTRAK' AND district_id = $district_id AND dept_name = 'SCM'";
								}

								if (isset($or_spem) AND !empty($or_spem)) {
									$this->db->or_where($or_spem);
								}

								$this->db->select("pos_id, pos_name, employee_id");
								$this->db->where($spem);
								$getman = $this->db->get("user_login_rule")->row_array();


								if (isset($or_spew) AND !empty($or_spew)) {
									$this->db->or_where($or_spew);
								}

								$this->db->select("pos_id, pos_name, employee_id");
								$this->db->where($spew);
								$getspe = $this->db->get("user_login_rule")->row_array();


								$getdata = $getspe;

								$typeplan = ($check['ptm_type_of_plan'] == "rkp") ? "proyek" : "departemen";

								$input['type_of_plan'] = $typeplan;

								$input['ctr_is_matgis'] = $is_matgis ? 1 : 0;

								$input['notes'] = strtoupper("MULTI WINNER ".$ptm_number." ".$vendor_id." ".$dept_id);

								$input['dept_code'] = $deptval['dep_code'];

								$input['dept_id'] = $dept_id;

								$input['spk_code'] = $check['spk_code'];

								$input['ptm_number'] = $ptm_number;

								$input['currency'] = $check['ptm_currency'];

								$input['vendor_id'] = $vendor_id;

								$input['status'] = 2010;

								$input['vendor_name'] = $vendor['vendor_name'];

								$input['subject_work'] = $check['ptm_subject_of_work'];

								$input['scope_work'] = $check['ptm_scope_of_work'];

								$input['contract_type'] = $check['ptm_contract_type'];

								$input['completed_tender_date'] = date("Y-m-d H:i:s");

								$input['contract_amount'] = $total_contract;

								$input['created_date'] = date("Y-m-d H:i:s");

								$input['is_sap'] = $get_dept_id['is_sap'] == 'sap' ? 1 : 0;

								if(!empty($getspe)){

									$input['ctr_spe_employee'] = $getspe['employee_id'];

									$input['ctr_spe_pos'] = $getspe['pos_id'];

									$input['ctr_spe_pos_name'] = $getspe['pos_name'];

								}

								if(!empty($getman)){

									$input['ctr_man_employee'] = $getman['employee_id'];

									$input['ctr_man_pos'] = $getman['pos_id'];

									$input['ctr_man_pos_name'] = $getman['pos_name'];

								}

								$this->db->insert("ctr_contract_header",$input);

								$contract_id = $this->db->insert_id();

								foreach ($item_cont as $b) {

									$b["contract_id"] = $contract_id;

									$act = $this->Contract_m->insertItem($b);

								}

								$this->db->insert("ctr_contract_comment",array(
									"ptm_number"=>$ptm_number,
									"contract_id"=>$contract_id,
									"ccc_activity"=>2010,
									"ccc_position"=>$getdata['pos_name'],
									"ccc_pos_code"=>$getdata['pos_id'],
									"ccc_start_date"=>date("Y-m-d H:i:s"),
								));

							}

						}

					}

				} else if($response == url_title('Batalkan Pengadaan',"_",true)){

					$nextActivity = 1902;

					$this->batalkanPengadaan($ptm_number);

				} else if($response == url_title('Ulangi Proses Negosiasi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1140;

				}

			}

			if(!empty($getdata['nextPosCode'])){//====tambah=====

				$nama_proses = $this->db->select("awa_name")->where("awa_id",$nextActivity)->get("adm_wkf_activity")->row()->awa_name;

				$tender_name = $this->db->select("ptm_subject_of_work")->where("ptm_number",$ptm_number)->get("prc_tender_main")->row()->ptm_subject_of_work;

				// $email_list = $this->db->distinct()->select("email")->where("pos_id",$getdata['nextPosCode'])->get("vw_user_access")->result_array();
				$email_list = $this->db->distinct()->select("email")->where("pos_id",$nextPosCode)->get("vw_user_access_2")->result_array();

				$e = array();

				foreach ($email_list as $key => $value) {
					$e[] = $value['email'];
				}


				$msg = "Selamat datang di eSCM,
				<br/>
				<br/>
				Permintaan Pengadaan Berikut : <br/>
				Nomor : <strong>$ptm_number - $tender_name</strong> <br/>
				Proses : $nama_proses<br/>
				Sebagai : ".$nextPosName."<br/>
				Membutuhkan Response.
				Silahkan login di ".COMPANY_WEBSITE." untuk melanjutkan proses pekerjaan.";

				// $email = $this->sendEmail(implode(",", $e),"Pemberitahuan Pengadaan Nomor $ptm_number",$msg);

			} //==================================

			if(empty($nextjobtitle) && !empty($nextPosCode)){
				$nextjobtitle = $this->getNextJobTitle($nextPosCode);
			}

			//ganti approval semua manajer ke ketua panitia pengadaan
			if ($committee['set'] != NULL and $nextjobtitle == "MANAJER PENGADAAN") {

				$getdata = $this->db
					->select("adm_bid_committee,ptp_tender_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

				$committee_id = ($activity == 1040) ? $committee['panitia_id']: $getdata['adm_bid_committee'];

				$commdat = $this->getNextState(
					"pos_id",
					"pos_name",
					"vw_adm_bid_committee",
					array("committee_id"=>$committee_id,"committee_type"=>1));

				$nextPosName = $commdat['nextPosName']." (PANITIA PENGADAAN)";
				$nextPosCode = $commdat['nextPosCode'];
			}
			//end y code

			$ret = array(
				"nextjobtitle"=>$nextjobtitle,
				"message"=>$message,
				"nextposcode"=>$nextPosCode,
				"nextposname"=>$nextPosName,
				"lastposcode"=>$lastPosCode,
				"lastposname"=>$lastPosName,
				"nextactivity"=>$nextActivity,
				"anyincompletecomment"=>$anyIncompleteComment,
				"tendermethod"=>$tenderMethod,
				"submissionmethod"=>$submissionMethod,
				"justification"=>$justification,
				"totaloe"=>$totalOE,
				"tmpposition"=>$tmpPosition,
				"newnumber"=>$newNumber,
				"nextactivity"=>$nextActivity,
				"response"=>$response
			);

			return $ret;

		}
	}

}
