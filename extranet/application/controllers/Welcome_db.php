<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_db extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("login");
	}

	public function index(){
		if(!empty($this->session->userdata('userid'))){

			$status_aktivasi = $this->db->select("reg_status_id")
			->where('vendor_id', $this->session->userdata('userid'))
			->get("vnd_header")->row()->reg_status_id;
	
			$this->session->set_userdata('status_aktivasi', $status_aktivasi);

			$check_uploaded_doc_pq = $this->db->where(array("vendor_id"=>$this->session->userdata('userid'), "vdp_status !="=>"0"))->get("vnd_doc_pq")->row();

			$vtm_id = $check_uploaded_doc_pq != null ? $check_uploaded_doc_pq->vtm_id : 0;			
			
			$data['vnd_data'] = $this->db->where('vendor_id', $this->session->userdata('userid'))->get('vnd_header')->row_array();
			
			if($data['vnd_data']['vendor_type'] != 3) {

				$template_doc_pq_date = $this->db->select('updated_date')
				->where(array("vtm_id"=>$vtm_id, "status"=>"Aktif"))
				->get("adm_vnd_doc")->row()->updated_date;
	
				$vnd_doc_pq_date = $this->db->select('vnd_doc_pq.vdp_id,vdp_status,vnd_doc_pq.created_datetime,vnd_doc_pq.updated_datetime')
					->where(array("vendor_id"=>$this->session->userdata('userid')))
					->where_not_in("vdp_status", array("1"))
					->where('vnd_doc_pq_detail.is_active', 1)
					->join('vnd_doc_pq_detail', 'vnd_doc_pq_detail.vdp_id = vnd_doc_pq.vdp_id', 'left')
					->get("vnd_doc_pq")->row();
	
				// membandingkan tanggal submit doc pq dengan tgl update tempate doc pq
				// 1 berarti sudah submit doc pq terbaru
				if (new DateTime($vnd_doc_pq_date->updated_datetime) > new DateTime($template_doc_pq_date))
				{
					$this->session->set_userdata('check_updated_template_doc_pq', "1");
				}
			}

			if($this->session->userdata('reg_status_id') == 0){
				if($this->session->userdata('vendor_type') == 1){

					if(isset($data['vnd_data']['vendor_type'])) {
						
						redirect('registrasi_vendor/utama');
						
					} else {

						redirect('registrasi_vendor/tambahan');

					}


				} elseif($this->session->userdata('vendor_type') == 2) {

					// if(isset($data['vnd_data']['vendor_type'])) {
						
						redirect('registrasi_perorangan/utama');
						
					// } else {

					// 	redirect('registrasi_vendor/tambahan');

					// }

				} elseif($this->session->userdata('vendor_type') == 3) {
					
					if(isset($data['vnd_data']['vendor_type'])) {
						
						redirect('registrasi_luar_negeri/utama');
						
					} else {

						redirect('registrasi_luar_negeri/tambahan');

					}

				}
				
			} else {
				if (count(array($check_uploaded_doc_pq)) < 1) {

					redirect('home/profile');
	
				} else {

					redirect(site_url('home'));

				}
			}

		} else {

			$this->db->select('*');
			$this->db->from('vnd_news');
			$this->db->order_by('news_id', 'desc');
			$this->db->limit(4);
			$query = $this->db->get();

			$query_lkpp = $this->db->get('vnd_news_lkpp');

			$data = array();
			$data['get_list'] = $query->result_array();
			$data['get_lkpp'] = $query_lkpp->result_array();

			$this->load->view('logins', $data);
		}
	}

	public function lelang_login(){
		$this->load->view('lelang_logins');
	}

	public function gambar(){
		// Adapted for The Art of Web: www.the-art-of-weB.com
		// Please acknowledge use of this code by including this header.
		// initialise image with dimensions of 120 x 30 pixels
			$image = @imagecreatetruecolor(120, 30) or die("Cannot Initialize new GD image stream");

		// set background and allocate drawing colours
			$background = imagecolorallocate($image, 0x66, 0x99, 0x66);
			imagefill($image, 0, 0, $background);
			$linecolor = imagecolorallocate($image, 0x99, 0xCC, 0x99);
			$textcolor1 = imagecolorallocate($image, 0x00, 0x00, 0x00);
			$textcolor2 = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);

		// draw random lines on canvas
			for($i=0; $i < 6; $i++) {
				imagesetthickness($image, rand(1,3));
				imageline($image, 0, rand(0,30), 120, rand(0,30) , $linecolor);
			}

		// add random digits to canvas using random black/white colour
			$digit = '';
			for($x = 15; $x <= 95; $x += 20) {
				$textcolor = (rand() % 2) ? $textcolor1 : $textcolor2;
				$digit .= ($num = rand(0, 9));
				imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
			}

		// record digits in session variable
			$this->session->set_userdata("digit", $digit);

		// display image and clean up
		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}

	public function in(){
		$post = $this->input->post();

		$username = $post['username_login'];
		$password = $post['password_login'];
		$captcha = $post['captcha'];
		$this->session->set_userdata("language", $post['bahasa']);

		if($captcha == $this->session->userdata("digit")){
			$pass_hash = strtoupper(do_hash($password));

			$data = $this->db->query("select vendor_id, vendor_name, vendor_type, login_id, reg_isactivate, status, reg_status_id from vnd_header where login_id = '".$username."' and password = '".$pass_hash."'")->row_array();
			
			if(!empty($data["vendor_id"])){
				$check_uploaded_doc_pq = $this->db->where(array("vendor_id"=>$data["vendor_id"]))->get("vnd_doc_pq")->row_array();

				if (false){
						$this->session->set_userdata('message', 'Maaf akun Anda sedang menunggu diverifikasi');
				} else {
					$session = $this->db->query("select last_access + '60 minutes'::interval as last_access, NOW() as nows from vnd_session where login_id = '".$data["login_id"]."'")->row_array();
				
					if(!empty($session)){

						if($session["last_access"] > $session["nows"]){

							$this->session->set_userdata('message', 'Maaf akun anda sedang login ditempat lain');

						} else {

							$this->session->set_userdata('userid', $data["vendor_id"]);
							$this->session->set_userdata('vendor_type', $data["vendor_type"]);
							$this->session->set_userdata('npwp_no', $data["npwp_no"]);
							$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
							$this->session->set_userdata('login_id', $data["login_id"]);
							$this->session->set_userdata('reg_status_id', $data["reg_status_id"]);

							$this->db->query("UPDATE vnd_session SET last_access = date_trunc('second', now()), session_id = '".session_id()."', ip_address = '".$_SERVER['REMOTE_ADDR']."' WHERE login_id = '".$data["login_id"]."'");
						}

					} else {
						
						$this->session->set_userdata('userid', $data["vendor_id"]);
						$this->session->set_userdata('vendor_type', $data["vendor_type"]);
						$this->session->set_userdata('npwp_no', $data["npwp_no"]);
						$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
						$this->session->set_userdata('login_id', $data["login_id"]);
						$this->session->set_userdata('reg_status_id', $data["reg_status_id"]);

						$this->db->query("INSERT INTO vnd_session
							(session_id, ip_address, last_access, login_id) VALUES
							('".session_id()."', '".$_SERVER['REMOTE_ADDR']."', date_trunc('second', now()), '".$data["login_id"]."')");

					}

					// login for generate API
					// $api_new = $this->login->loginApi("admin","wika123");
					// setcookie("token_katalogue", $api_new['data']['token'], time() + (86400 * 30), "/");
				}
			} else {
				$this->session->set_userdata('message', 'Maaf kombinasi username dan password yang anda masukan salah');
			}
		} else {
			$this->session->set_userdata('message', 'Captcha Salah');
		}
		redirect(site_url());
	}

	public function lelang_in(){
		$post = $this->input->post();
		if($post){
			if(empty($post['picker_id'])){
				$username = $post['username_login'];
				$password = $post['password_login'];
				$captcha = $post['captcha'];

				if($captcha == $this->session->userdata("digit")){
					$data = $this->db->query("select vendor_id, vendor_name, login_id, reg_isactivate, status, reg_status_id from vnd_header where login_id = '".$username."' and password = '".strtoupper(do_hash($password))."'")->row_array();

					if(!empty($data["vendor_id"])){
						if($data["reg_isactivate"] == '1'){
							if(($data["status"] == '9' && $data["reg_status_id"] == '8') || ($data["status"] == '5' && $data["reg_status_id"] == '6')){
								$session = $this->db->query("select last_access + '60 minutes'::interval as last_access, NOW() as nows from vnd_session where login_id = '".$data["login_id"]."'")->row_array();
								if(!empty($session)){
									if($session["last_access"] > $session["nows"]){
										echo "0";
										exit();
									} else {
										$this->session->set_userdata('userid', $data["vendor_id"]);
										$this->session->set_userdata('vendor_type', $data["vendor_type"]);
										echo "1";
										exit();
									}
								}
								else{
									$this->session->set_userdata('userid', $data["vendor_id"]);
									$this->session->set_userdata('vendor_type', $data["vendor_type"]);
									echo "1";
									exit();
								}
							} else {
								echo "0";
								exit();
							}
						} else {
							echo "0";
							exit();
						}
					} else{
						echo "0";
						exit();
					}
				} else {
					echo "2";
					exit();
				}
			} else {
				$tenderid = $this->security->xss_clean($post['picker_id']);
				$klasifikasi = $this->db->query("select ptp_klasifikasi_peserta from prc_tender_prep where ptm_number = '".$tenderid."'")->row_array();
				$klasifikasi = $klasifikasi["ptp_klasifikasi_peserta"];

				$ven_klas = $this->db->query("select fin_class from vnd_header where vendor_id = '".$this->session->userdata("userid")."'")->row_array();
				$ven_klas = $ven_klas["fin_class"];

				$cek = $this->db->query("select ptm_number from prc_tender_vendor_status where ptm_number = '".$tenderid."' and pvs_vendor_code = '".$this->session->userdata("userid")."'")->num_rows();
				if($cek < 1 ) {
					if(($ven_klas == 'K' && substr($klasifikasi, 0, 1) == '1') || ($ven_klas == 'M' && substr($klasifikasi, 1, 1) == '1') || ($ven_klas == 'B' && substr($klasifikasi, 2, 1) == '1')){
						$cek_result = $this->db->query("select count(tit_id) as jumlah from prc_tender_item A join vnd_product B on substring(tit_code from 1 for 4) = B.product_code where A.ptm_number = '".$tenderid."' and B.vendor_id = ".$this->session->userdata("userid"))->row_array();
						$master = $this->db->query("select count(tit_id) as jumlah from prc_tender_item A where A.ptm_number = '".$tenderid."'")->row_array();
						if($cek_result["jumlah"] == $master["jumlah"]){
							$data = $this->db->query("select vendor_id, vendor_name, login_id, reg_isactivate, status, reg_status_id from vnd_header where vendor_id = '".$this->session->userdata("userid")."'")->row_array();
							$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
							$this->session->set_userdata('login_id', $data["login_id"]);
							$this->db->query("INSERT INTO vnd_session (session_id, ip_address, last_access, login_id) VALUES ('".session_id()."', '".$_SERVER['REMOTE_ADDR']."', NOW(), '".$data["login_id"]."')");
							echo '1';
							exit();
						}
						else{
							$this->session->unset_userdata("userid");
							echo '22';
							exit();
						}
					}
					else{
						$this->session->unset_userdata("userid");
						echo '11';
						exit();
					}
				}
				else{
					$this->session->unset_userdata("userid");
					echo '33';
					exit();
				}
			}
		}
	}

	public function lelang_overview($tenderid, $stat){
		$tenderid = $this->encryption->decrypt($this->umum->forbidden($tenderid, 'dekrip'));
		$stat = $this->encryption->decrypt($this->umum->forbidden($stat, 'dekrip'));

		$data["header"] = $this->db->query("SELECT B.ptp_negosiation_date,B.ptp_uskep_date,B.ptp_announcement_date,B.ptp_disclaimer_date,B.ptp_appointment_date, A.ptm_number, B.ptp_submission_method, A.ptm_subject_of_work, A.ptm_scope_of_work, A.ptm_contract_type, B.ptp_klasifikasi_peserta, A.ptm_currency, B.ptp_reg_opening_date, B.ptp_reg_closing_date, B.ptp_prebid_date,ptp_quot_closing_date,ptp_doc_open_date, B.ptp_quot_opening_date, B.ptp_prebid_location, B.ptp_bid_opening2, B.ptp_tgl_aanwijzing2,ptp_prequalify, B.ptp_lokasi_aanwijzing2, CASE B.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, B.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '".$tenderid."' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main A join prc_tender_prep B on A.ptm_number = B.ptm_number where B.ptm_number = '".$tenderid."'")->row_array();
		$data["item"] = $this->db->query("select tit_code, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '".$tenderid."'")->result_array();
		$data["dokumen"] = $this->db->query("select * from prc_tender_doc where ptm_number = '".$tenderid."' AND ptd_type = '1'")->result_array();
		if($stat == "1"){
			$data["submits"] = true;
		}
		else{
			$data["submits"] = false;
		}
		$data["lelang"] = true;
		if ($data["header"]["ptp_submission_method"] == '2') {
			$data["tahap2"] = true;
		}
		else{
			$data["tahap2"] = false;
		}
		if($stat == "1"){
			$this->layout->view("pengadaan/overview", $data);
		}
		else{
			$this->load->view("pengadaan/overview", $data);
		}
	}

	public function out(){
		$this->db->query("DELETE FROM vnd_session WHERE login_id = '".$this->session->userdata('login_id')."'");
		$this->session->sess_destroy();
		redirect(site_url());
	}

	public function lelang(){
		$data["list"] = $this->db->query("SELECT DISTINCT M .ptm_number, M .ptm_subject_of_work, P.ptp_reg_opening_date, P.ptp_reg_closing_date, P.ptp_quot_opening_date AS bid_date FROM prc_tender_main AS M INNER JOIN prc_tender_comment AS C ON M .ptm_number = C .ptm_number INNER JOIN prc_tender_prep AS P ON M .ptm_number = P.ptm_number WHERE (C .ptc_end_date IS NULL) AND ( C .ptc_activity IN (1080, 1090, 1071, 1072)) AND (P.ptp_tender_method = '2') AND ( P.ptp_reg_opening_date <= now()) AND ( P.ptp_reg_closing_date >= now()) order by P.ptp_reg_opening_date desc")->result_array();
		$data["past_list"] = $this->db->query("SELECT DISTINCT M .ptm_number, M .ptm_subject_of_work, P.ptp_reg_opening_date, P.ptp_reg_closing_date, P.ptp_quot_opening_date AS bid_date FROM prc_tender_main AS M INNER JOIN prc_tender_comment AS C ON M .ptm_number = C .ptm_number INNER JOIN prc_tender_prep AS P ON M .ptm_number = P.ptm_number WHERE (C .ptc_end_date IS NOT NULL) AND ( C .ptc_activity IN (1080, 1090, 1071, 1072)) AND (P.ptp_tender_method = '2') AND ( P.ptp_reg_opening_date < now()) AND ( P.ptp_reg_closing_date < now()) AND ( P.ptp_quot_opening_date < now()) order by P.ptp_reg_opening_date desc limit 10")->result_array();
		$this->load->view("lelang", $data);
	}

	public function unduh($filename){
		$this->load->helper('download');
		$filename = $this->encryption->decrypt($this->umum->forbidden($filename, 'dekrip'));
		if(file_exists("../uploads/procurement/permintaan/".$filename)){
			force_download('../uploads/procurement/permintaan/'.$filename, NULL);
		}
		else{
			echo "<script>alert(\"File not Found\"); window.history.go(-1);</script>";
		}
	}

	public function mandor_registration(){
		$d['bidang'] = $this->db->get_where('adm_master',['status'=> 'Y', 'am_type' => 'bidang_registration_mandor'])->result_array();
		$this->load->view('mandor_registration_v', $d);
	}

	public function get_sub_bidang()
	{
		$post = $this->input->post();
		$this->db->select('*');
		$this->db->from('adm_master');
		$this->db->where([
			'status'=> 'Y',
			'am_type' => 'sub_bidang_registration_mandor',
			'am_parent_code' => $post['bidang_code']]);
		if(!empty($post['selected_sub_bidang'])){
			$this->db->where_not_in('am_kode', $post['selected_sub_bidang']);
		}
		$return['data'] =  $this->db->get()->result_array();

		echo json_encode($return);
	}

	public function submit_mandor()
	{
		$post = $this->input->post();

		$this->db->trans_begin();

		if (is_uploaded_file($_FILES['vmh_statement_letter_inp']['tmp_name'])) {
			$files = $this->do_upload('vmh_statement_letter_inp','statement', "administrasi");
		}

		if (is_uploaded_file($_FILES['vmh_rekening_koran_inp']['tmp_name'])) {
			$files1 = $this->do_upload('vmh_rekening_koran_inp','rekening_koran', "keuangan");
		}
		$datavmh['vmh_name'] 				= $post['vmh_name_inp'][0]  ;
		$datavmh['vmh_address'] 			= $post['vmh_address_inp'] [0] ;
		$datavmh['vmh_npwp'] 				= $post['vmh_npwp_inp'][0]  ;
		$datavmh['vmh_email'] 				= $post['vmh_email_inp'][0]  ;
		$datavmh['vmh_hp'] 					= $post['vmh_hp_inp'][0]  ;
		$datavmh['vmh_qty_employee'] 		= $post['vmh_qty_employee_inp'][0]  ;
		$datavmh['vmh_statement_letter'] 	= $files ? $files : '';//$_FILES['vmh_statement_letter_inp']['name'] ;
		$datavmh['vmh_bank_account'] 		= $post['vmh_bank_account_inp'][0] ;
		$datavmh['vmh_bank_no_account'] 	= $post['vmh_bank_no_account_inp'][0]  ;
		$datavmh['vmh_bank_name'] 			= $post['vmh_bank_name_inp'][0]  ;
		$datavmh['vmh_rekening_koran'] 		= $files1 ? $files1 : '';//$_FILES['vmh_rekening_koran_inp']['name']  ;
		$datavmh['created_date'] 			= date('Y-m-d H:i:s') ;
		$datavmh['created_by'] 				= $post['vmh_name_inp'][0] ;
		$datavmh['status'] 					= 'WA' ;

		$this->db->insert('vnd_mandor_header', $datavmh);
		$vmh_insert_id = $this->db->insert_id();

		for ($i=0; $i < count($post['vmp_pic_name_inp']) ; $i++) {
			$datavmp[$i]['vmh_id'] 				= $vmh_insert_id  ;
			$datavmp[$i]['vmh_name'] 			= $post['vmh_name_inp'][0]  ;
			$datavmp[$i]['vmp_pic_name'] 	    = $post['vmp_pic_name_inp'][$i]  ;
			$datavmp[$i]['vmp_pic_position'] 	= $post['vmp_pic_position_inp'][$i]  ;
			$datavmp[$i]['vmp_pic_contact'] 	= $post['vmp_pic_contact_inp'][$i]  ;
			$datavmp[$i]['created_date'] 		= date('Y-m-d H:i:s') ;
			$datavmp[$i]['created_by'] 			= $post['vmh_name_inp'][0] ;
			$datavmp[$i]['status'] 				= 'A' ;
		}

		$this->db->insert_batch('vnd_mandor_pic', $datavmp);
		for ($i=0; $i < count($post['vmb_bidang_code_inp']) ; $i++) {
			$bidang_name = $this->db->get_where('adm_master',['am_kode'=>$post['vmb_bidang_code_inp'][$i]])->row_array()['am_name'];
			$sub_bidang_name = $this->db->get_where('adm_master',['am_kode'=>$post['vmb_sub_bidang_code_inp'][$i]])->row_array()['am_name'];
			$datavmb[$i]['vmh_id'] 				= $vmh_insert_id ;
			$datavmb[$i]['vmh_name'] 			= $post['vmh_name_inp'][0]  ;
			$datavmb[$i]['vmb_bidang_code'] 	= $post['vmb_bidang_code_inp'][$i]  ;
			$datavmb[$i]['vmb_bidang_name'] 	= $bidang_name  ;
			$datavmb[$i]['vmb_sub_bidang_code'] = $post['vmb_sub_bidang_code_inp'][$i]  ;
			$datavmb[$i]['vmb_sub_bidang_name'] = $sub_bidang_name ;
			$datavmb[$i]['created_date'] 		= date('Y-m-d H:i:s') ;
			$datavmb[$i]['created_by'] 			= $post['vmh_name_inp'][0] ;
			$datavmb[$i]['status'] 				= 'A' ;
		}
		$this->db->insert_batch('vnd_mandor_bidang', $datavmb);

		for ($i=0; $i < count($post['vmpe_project_name_inp']) ; $i++) {
			if (is_uploaded_file($_FILES['vmpe_evidence_project_inp']['tmp_name'][$i])) {
				$_FILES['vmpe_evidence_project_inp_detail']['tmp_name'] = $_FILES['vmpe_evidence_project_inp']['tmp_name'][$i];
				$_FILES['vmpe_evidence_project_inp_detail']['name'] = $_FILES['vmpe_evidence_project_inp']['name'][$i];
				$_FILES['vmpe_evidence_project_inp_detail']['type'] = $_FILES['vmpe_evidence_project_inp']['type'][$i];
				$_FILES['vmpe_evidence_project_inp_detail']['tmp_name'] = $_FILES['vmpe_evidence_project_inp']['tmp_name'][$i];
				$_FILES['vmpe_evidence_project_inp_detail']['error'] = $_FILES['vmpe_evidence_project_inp']['error'][$i];
				$_FILES['vmpe_evidence_project_inp_detail']['size'] = $_FILES['vmpe_evidence_project_inp']['size'][$i];

				$files = $this->do_upload('vmpe_evidence_project_inp_detail','rekening_koran', "keuangan");
			}

			$bidang_name = [];
			$bidang_code = [];
			$sub_bidang_name = [];
			$sub_bidang_code = [];
			for ($j=0; $j < count($post['vmb_bidang_code_proyek_inp'][$i]) ; $j++) {
				array_push($bidang_code,$post['vmb_bidang_code_proyek_inp'][$i][$j]);
				array_push($sub_bidang_code,$post['vmb_sub_bidang_code_proyek_inp'][$i][$j]);
				array_push($bidang_name, $this->db->get_where('adm_master',['am_kode'=> $post['vmb_bidang_code_proyek_inp'][$i][$j]])->row_array()['am_name']);
				array_push($sub_bidang_name, $this->db->get_where('adm_master',['am_kode'=> $post['vmb_sub_bidang_code_proyek_inp'][$i][$j]])->row_array()['am_name']);
			}

			$datavmpe[$i]['vmh_id'] 				= $vmh_insert_id  ;
			$datavmpe[$i]['vmh_name'] 				= $post['vmh_name_inp'][0]  ;
			$datavmpe[$i]['vmpe_year'] 				= $post['vmpe_year_inp'][$i]  ;
			$datavmpe[$i]['vmpe_project_name'] 		= $post['vmpe_project_name_inp'][$i]  ;
			$datavmpe[$i]['vmpe_contractor_name'] 	= $post['vmpe_contractor_name_inp'][$i]  ;
			$datavmpe[$i]['vmpe_project_value'] 	= preg_replace("/[^0-9]/", "", $post['vmpe_project_value_inp'][$i] ); ;

			$datavmpe[$i]['vmb_bidang_code'] 		= json_encode($bidang_code);
			$datavmpe[$i]['vmb_bidang_name'] 		= json_encode($bidang_name);
			$datavmpe[$i]['vmb_sub_bidang_code'] 	= json_encode($bidang_code);
			$datavmpe[$i]['vmb_sub_bidang_name'] 	= json_encode($sub_bidang_name);

			$datavmpe[$i]['vmpe_evidence_project'] 	= $files ? $files : '';//$_FILES['vmpe_evidence_project_inp']['name'][$i] ;
			$datavmpe[$i]['created_date'] 			= date('Y-m-d H:i:s') ;
			$datavmpe[$i]['created_by'] 			= $post['vmh_name_inp'][0] ;
			$datavmpe[$i]['status'] 				= 'A' ;
		}

		$this->db->insert_batch('vnd_mandor_project_experience', $datavmpe);

		for ($i=0; $i < count($post['vmtq_ahli_bidang_inp']) ; $i++) {
			$datavmtq[$i]['vmh_id'] 				= $vmh_insert_id;
			$datavmtq[$i]['vmh_name'] 				= $post['vmh_name_inp'][0];
			$datavmtq[$i]['vmtq_ahli_bidang'] 		= $post['vmtq_ahli_bidang_inp'][$i];
			$datavmtq[$i]['vmtq_qty_ahli_bidang']	= $post['vmtq_qty_ahli_bidang_inp'][$i];
			$datavmtq[$i]['created_date'] 			= date('Y-m-d H:i:s') ;
			$datavmtq[$i]['created_by'] 			= $post['vmh_name_inp'][0] ;
			$datavmtq[$i]['status'] 				= 'A' ;
		}
		$this->db->insert_batch('vnd_mandor_teknik_qty_ahli_bidang', $datavmtq);

		for ($i=0; $i < count($post['vmt_tools_name_inp']) ; $i++) {
			$datavmt[$i]['vmh_id'] 					= $vmh_insert_id;
			$datavmt[$i]['vmh_name'] 				= $post['vmh_name_inp'][$i];
			$datavmt[$i]['vmt_tools_name'] 			= $post['vmt_tools_name_inp'][$i];
			$datavmt[$i]['vmt_tool_brand']			= $post['vmt_tool_brand_inp'][$i];
			$datavmt[$i]['vmt_qty_tools']			= $post['vmt_qty_tools_inp'][$i];
			$datavmt[$i]['vmt_condition']			= $post['vmt_condition_inp'][$i];
			$datavmt[$i]['created_date'] 			= date('Y-m-d H:i:s') ;
			$datavmt[$i]['created_by'] 				= $post['vmh_name_inp'][0] ;
			$datavmt[$i]['status'] 					= 'A' ;
		}
		$this->db->insert_batch('vnd_mandor_tools', $datavmt);


		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$this->session->set_flashdata("pesan", '<div style="text-align:center" class="col-md-12 col-sm-12 alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">x</button> Terjadi Kesalahan Teknis, Silahkan Coba Beberapa saat lagi !</div>');
		}else{
			$this->db->trans_commit();
			$this->session->set_flashdata("pesan", '<div style="text-align:center" class="col-md-12 col-sm-12 alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">x</button> Selamat '.$post['vmh_name_inp'][0].' telah terdaftar sebagai mandor PT Wijaya Karya !</div>');
			redirect('welcome/mandor_registration');
		}


	}
}
