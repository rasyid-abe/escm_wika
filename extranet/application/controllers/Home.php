<?php

use React\Stream\ThroughStream;

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->model("profile");
		$this->load->model(array("Vsi_m"));

		if($this->session->userdata('reg_status_id') != 8){
            redirect(site_url());
		};
	}

	public function index()
	{
		$userid = $this->session->userdata("userid");
		$data["undangan"] = $this->db->query("select count(a.ptm_number) as jumlah from prc_tender_vendor_status a join prc_tender_prep b on a.ptm_number = b.ptm_number where a.pvs_vendor_code = '".$userid."' and a.pvs_status = '1' and b.ptp_reg_closing_date > now()")->row_array();
		$data["negosiasi"] = $this->db->query("select count(prc_tender_vendor_status.ptm_number) as jumlah from prc_tender_vendor_status
			LEFT JOIN prc_tender_main ON prc_tender_main.ptm_number=prc_tender_vendor_status.ptm_number
			where pvs_vendor_code = '".$userid."' and pvs_status = '10' AND ptm_status=1140 and pvs_technical_status > 0")->row_array();
		$data["penawaran_dikirim"] = $this->db->query("select count(ptm_number) as jumlah from prc_tender_vendor_status where pvs_vendor_code = '".$userid."' and pvs_status in (3, 21)")->row_array();
		$data["award"] = $this->db->query("select count(ptm_number) as jumlah from prc_tender_vendor_status where pvs_vendor_code = '".$userid."' and pvs_status = '11'")->row_array();
		//start code hlmifzi
		$data["menunggu_penawaran"] = $this->db->query("select count(a.ptm_number) as jumlah from prc_tender_vendor_status a join prc_tender_prep b on a.ptm_number = b.ptm_number where a.pvs_vendor_code = '".$userid."' and pvs_status in (2, 20, 12) and (b.ptp_quot_closing_date > now() or b.ptp_bid_closing2 > now())")->row_array();
		//end code
		$data["penawaran_dievaluasi"] = $this->db->query("select count(ptm_number) as jumlah from prc_tender_vendor_status where pvs_vendor_code = '".$userid."' and pvs_status in (-5,-8,-7,-4,4,5,7,22,23,25,26)")->row_array();
		$data["aanwijzing_online"] = $this->db->query("select count(A.ptm_number) as jumlah from prc_tender_vendor_status A
			INNER JOIN prc_tender_main B ON A.ptm_number = B.ptm_number
			INNER JOIN prc_tender_prep C ON A.ptm_number = C.ptm_number
			where C.ptp_aanwijzing_online=1 AND A.pvs_vendor_code = '".$userid."'  AND ptp_prebid_date < NOW() AND ptp_quot_opening_date > NOW() ")->row()->jumlah;

		$query_eauction = "select count(A.vendor_id) as jumlah from prc_eauction_vendor A INNER JOIN prc_eauction_header B ON A.PPM_ID = B.PPM_ID INNER JOIN prc_tender_vendor_status C on C.pvs_vendor_code = A.vendor_id and C.ptm_number = A.ppm_id where NOW() BETWEEN TANGGAL_MULAI AND TANGGAL_BERAKHIR AND C.pvs_status IN (4,5,8) AND B.status = 1 AND A.vendor_id = '".$userid."'";
		$data["eauction"] = $this->db->query($query_eauction)->row()->jumlah;
		$data['bast'] = $this->db
		->query("SELECT po_id as id, contract_number,po_notes as description,b.vendor_name,progress_percentage, 'WO' as type FROM ctr_po_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id
			WHERE b.vendor_id='".$userid."' AND progress_percentage='100' AND COALESCE(bastp_status::integer,0) IN (0,99) AND bastp_number IS NULL
			UNION ALL
			SELECT milestone_id as id, contract_number,b.description,vendor_name,progress_percentage, 'LUMPSUM' as type FROM ctr_contract_milestone b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id
			WHERE a.vendor_id='".$userid."' AND progress_percentage='100' AND COALESCE(bastp_status::integer,0) IN (0,99) AND bastp_number IS NULL")
		->num_rows();
		$data["terminasi_lelang"] = $this->db->query("select count(a.ptm_number) as jumlah from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number join prc_tender_vendor_status c on b.ptm_number = c.ptm_number join z_bidder_status d on c.pvs_status = d.lkp_id  where ptm_status = '1800' AND c.pvs_vendor_code = '".$userid."'")->row_array();

		//start code hlmifzi
		$data['tagihan'] = $this->db
		->query("SELECT invoice_id as id,b.contract_number,invoice_notes as description,b.vendor_name, 'WO' as type FROM ctr_invoice_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id
			WHERE b.vendor_id='".$userid."' AND invoice_status is null AND invoice_number is NULL

			UNION ALL

			SELECT invoice_id as id,b.contract_number,invoice_notes as description,b.vendor_name, 'WO' as type FROM ctr_invoice_milestone_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id
			WHERE b.vendor_id='".$userid."' AND invoice_status is null AND invoice_number is NULL


			")->num_rows();

			$data['title'] = 'Ringkasan Pekerjaan';

			$periode = $this->Vsi_m->getPeriode()->row_array();
			$list = $this->Vsi_m->getListVsi()->result_array();
			$periode = $periode;
	
			$data['countVSI'] = ($periode != NULL) ? count($list) : count(array());
			

		$this->layout->view('home', $data);
	}

	public function profile(){
		$data = $this->profile->datavendor($this->session->userdata("userid"));
		
		$data['vendor_type'] =  $this->profile->getVndType()->result_array();

		// if vendor type = 2
		$data['get_header'] =  $this->profile->getHeader($this->session->userdata("userid"))->row_array();
		$data['get_pendidikan'] =  $this->profile->getPendidikan($this->session->userdata("userid"))->result_array();
		$data['get_pengalaman'] =  $this->profile->getPengalaman($this->session->userdata("userid"))->result_array();
		$data['get_pelatihan'] =  $this->profile->getPelatihan($this->session->userdata("userid"))->result_array();

		$data['doc_pq'] = array();

		$this->db->select('vdp_id, vtm_id, vdp_status, avd_id');
		$this->db->where('vendor_id', $this->session->userdata("userid"));
		$data_header = $this->profile->getVndDocPq()->row();
		$vtm_id = 0;
		$avd_id = 0;
		$vdp_status = 0;
		$vdp_id = 0;

		if (count(array($data_header)) && isset($data_header) ) {
			$vtm_id = $data_header->vtm_id;
			$avd_id = $data_header->avd_id;
			$vdp_status = $data_header->vdp_status;
			$vdp_id = $data_header->vdp_id;
		}

		$data['template_doc'] = $this->profile->getVndDocTemplate($vtm_id, $avd_id)->result_array();

		$comment_list = $this->profile->getCommentDocPQ("", $this->session->userdata("userid"))->result_array();
		$data['comment_list'] = $comment_list;

		$data['vtm_id'] = $vtm_id;
		$data['must_upload'] = 0;

		//mengecek apakah ada update template terbaru
		//set userdata ada di welcome_db
		if ($vdp_status == 1 OR $this->session->userdata('check_updated_template_doc_pq') == 1) {
			// $this->db->where('vdp_status', '2');
			$this->db->where('is_active', 1);
			$this->db->select('adm_vnd_doc_detail.vdd_name,vtm_id,vnd_doc_pq_detail.*');
			$this->db->where('vendor_id', $this->session->userdata("userid"));
			$data['doc_pq'] = $this->profile->getVndDocPqDetail()->result_array();

		}else{
			$data['must_upload'] = 1;
		}
		if ($vdp_status == "-1") {
			$this->db->select("vdpc_id, vdpc_response, vdpc_comment");
			$this->db->order_by('vdpc_id', 'desc');
			$this->db->limit(1);
			$this->db->where('vdp_id', $data_header->vdp_id);
			$getLastCommentDocPQ = $this->db->get('vnd_doc_pq_comment')->row();

			$doc_pq_msg = array(
				"title" => "Mohon Direvisi",
				"message" => $getLastCommentDocPQ->vdpc_comment
			);

			$this->session->set_userdata('doc_pq_msg', $doc_pq_msg);
			$data['must_upload'] = 1;

		}else{
			$this->session->unset_userdata('doc_pq_msg');
		}

		if (count($data['doc_pq']) < 1) {
			$data['must_upload'] = 1;
		}
		

		$data['title'] = 'Profil';

		$id = $this->session->userdata("userid");
		$this->load->model('Hse_m');
	
		$vendor = $this->db->where('vendor_id',$id)->get('vnd_header')->row_array();
		
		//HSE
		$data['hasSubmitHse'] = $this->Hse_m->statusHseVendorVerification($id);
		$data['hasHse'] = $this->Hse_m->GetCheckCqmsTrxHByVendor($id);

		// print_r($data['hasSubmitHse'];);
		// exit;
		if($data['hasSubmitHse'])
		{
			$data['hseData'] = $this->Hse_m->getHseByVendor($id);
			$vendor_type = $this->Hse_m->get_vendor_type($vendor['cot_kelompok']);
			
			$data['hseQuestionList'] = $this->Hse_m->GetVendorQuestionList($vendor['cot_kelompok']);				
			$data['vendor_id'] = $id;
	
			$data['vendor_score'] = $this->Hse_m->get_vendor_score($id);
			$data['catatanKecelakaan'] = $this->Hse_m->get_adm_cqsms_kecelakaan($data['hseData']['header']['id']);
	
			$data['hse_cat'] = $this->Hse_m->get_kategory_hse();
	
			$type = ($data['hseData']['header']['cqsms_type'] == 1) ? 'Sertifikat' : 'Pertanyaan';
			$data['titleHSE'] = 'Data Hse '.$vendor['vendor_name'].' - '.$vendor_type['ack_name'];
			$data['vendor_verifikasi'] = $this->Hse_m->get_vendor_verifikasi($id);
		}
			
		$this->layout->view('profile', $data);
	}

	public function submit_doc_pq(){
		$post = $this->input->post();

		$this->db->select('vdp_id as last_id');
		$this->db->where('vendor_id', $this->session->userdata("userid"));
		$dataVndDocPq = $this->profile->getVndDocPq()->row();

		$this->db->where(array('vendor_id' => $this->session->userdata("userid"), "is_active"=>1));
		$count_uploaded_doc = $this->profile->getVndDocPqDetail()->num_rows();

		if (count($dataVndDocPq) == 0) {
			$dataVndDocPq = 0;
		}else{
			$vdp_id = $dataVndDocPq->last_id;
		}

		if ($vdp_id == 0) {
			$data_header['vdp_id'] = 1;
		}

		$uploaded_vdd_ids = $post['item_id'];
		$error = false;
		$message = ""; //return message
		$data_detail = array();
		for ($i=0; $i < count($post['item_id']); $i++) {

			$temps = $this->do_upload('file_'.$i, $this->session->userdata("userid"), "Dokumen PQ");

				if(is_array($temps)){
						$message = $temps[1];
						if (!$count_uploaded_doc) {
							$error =  true; //true or false
							$i = count($post['item_id']);
						}

					}
					else{
					// array_push($temp, "");
					$data_detail[] = array(
						"vdp_id"=>$vdp_id,
						"vdd_id"=> $post['item_id'][$i],
						"doc_file"=>$temps,
						"created_datetime" => date('Y-m-d H:i:s'),
						"is_active" => 1
					);
					unset($uploaded_vdd_ids[$i]); //unset if there is new file
				}
		}

		//get vdpd_id from vnd_doc_pq_detail based on uploaded_vdd_ids(not updated file)
		$vdpd_ids = array();
		if (count($uploaded_vdd_ids) > 0) {
			$this->db->select('DISTINCT ON (vnd_doc_pq_detail.vdd_id) vdpd_id', 'vnd_doc_pq_detail.vdd_id');
			$this->db->where_in('vnd_doc_pq_detail.vdd_id', $uploaded_vdd_ids);
			$this->db->where('is_active', 1);
			$this->db->order_by('vnd_doc_pq_detail.vdd_id', 'desc');
			$this->db->order_by('vnd_doc_pq_detail.vdpd_id', 'desc');
			$uploaded_doc_ids = $this->profile->getVndDocPqDetail()->result_array();

			foreach ($uploaded_doc_ids as $key => $value) {
				$vdpd_ids[] = $value['vdpd_id'];
			}
		}



		$this->db->trans_begin();

		$update_data_header = array(
			"vdp_status" => 1,
			"updated_datetime"=>date("Y-m-d H:i:s")
		);
		$where_data_header = array("vendor_id" => $this->session->userdata("userid"));

		$updateHeader = $this->profile->updateVndDocPq($update_data_header, $where_data_header);
		if ($updateHeader <= 0) {
			$error = true;
			$message = "Failed to update data header";
		}

		if (!empty($data_detail)) {
			$insertDetail = $this->profile->insertBatchVndDocPqDetail($data_detail, $vdp_id, $vdpd_ids);

			if ($insertDetail <= 0) {
				$error = true;
				$message = "Failed to store data detail";
			}

		}

		if ($this->db->trans_status() === false OR $error) {

			echo json_encode($message != '' ? $message : "failed");

			$this->db->trans_rollback();
		}else{

			$this->db->trans_commit();
			echo json_encode("success");

		}

	}
}
