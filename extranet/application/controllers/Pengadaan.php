<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("general");
		if($this->session->userdata('reg_status_id') != 8){
            redirect(site_url());
		};
	}

	public function index()
	{
		$data["list"] = $this->db->query("select b.ptp_quot_closing_date,c.pvs_status, a.ptm_number, a.ptm_subject_of_work, b.ptp_reg_opening_date, b.ptp_prebid_date, b.ptp_reg_closing_date, b.ptp_quot_opening_date, d.lkp_description as status from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number join prc_tender_vendor_status c on b.ptm_number = c.ptm_number join z_bidder_status d on c.pvs_status = d.lkp_id join prc_tender_prep e on e.ptm_number = a.ptm_number where c.pvs_vendor_code = '" . $this->session->userdata("userid") . "' and ((c.pvs_status = 1 and e.ptp_reg_closing_date > now()) or (c.pvs_status in (2, 20) and e.ptp_quot_opening_date > now()) or (c.pvs_status = 10))")->result_array();
		$data['title'] = 'Daftar Pekerjaan';
		$this->layout->view("pengadaan/listpekerjaan", $data);
	}

	public function sendaanwijzing()
	{
		$msg = $this->input->post('message');
		if (!empty($msg)) {
			$parse = explode("#", $msg);
			$tipe = $parse[0];
			$kode = $tipe . '-' . $parse[1];
			$nama = htmlspecialchars($parse[2]);
			$pesan = htmlspecialchars($parse[3]);
			$waktu = date("Y-m-d H:i:s");
			$waktus = date("d/m/Y H:i");
			$i = $this->db->insert("adm_chat", array(
				"datetime_ac" => $waktu, "key_ac" => $kode, "name_ac" => $nama,
				"message_ac" => $pesan
			));
			if ($tipe == 0) {
				echo $tipe . '#' . $parse[1] . "#" . $nama . "#" . $pesan;
			} else {
				echo $tipe . '#' . $parse[1] . "#" . $nama . "#" . $pesan . "<br/><small>(" . $waktus . ")</small>";
			}
		}
	}

	public function monitorpengadaan()
	{
		$data["list"] = $this->db->query("select b.ptp_quot_closing_date,c.pvs_status, a.ptm_number, a.ptm_subject_of_work, b.ptp_prebid_date, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_quot_opening_date, d.lkp_description as status from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number join prc_tender_vendor_status c on b.ptm_number = c.ptm_number join z_bidder_status d on c.pvs_status = d.lkp_id  where c.pvs_vendor_code = '" . $this->session->userdata("userid") . "'")->result_array();
		$data["title"] = "Monitor Pengadaan";
		$this->layout->view("pengadaan/list_monitor_pengadaan", $data);
	}

	public function terminasi_lelang()
	{
		$data["list"] = $this->db->query("select ptm_status, b.ptp_quot_closing_date,c.pvs_status, a.ptm_number, a.ptm_subject_of_work, b.ptp_prebid_date, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_quot_opening_date, d.lkp_description as status from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number join prc_tender_vendor_status c on b.ptm_number = c.ptm_number join z_bidder_status d on c.pvs_status = d.lkp_id  where ptm_status = '1800' AND c.pvs_vendor_code = '" . $this->session->userdata("userid") . "'")->result_array();
		$data["title"] = "Terminasi Lelang Pengadaan";
		$this->layout->view("pengadaan/list_terminasi_lelang", $data);
	}

	public function lists($input)
	{
		$input = $this->encryption->decrypt($this->umum->forbidden($input, 'dekrip'));
		if ($input) {
			$this->session->set_userdata("last_state", $input);
			switch ($input) {
				case "undangan":
					$where = " and c.pvs_status in (1) and b.ptp_reg_closing_date > now() ";
					$data["title"] = "Undangan Pengadaan";
					break;
				case "negosiasi":
					$where = " and c.pvs_status in (10) AND ptm_status = 1140 ";
					$data["title"] = "Negosiasi";
					break;
				case "award":
					$where = " and c.pvs_status in (11) ";
					$data["title"] = "Award Announcement";
					break;
				case "dikirim":
					$where = " and c.pvs_status in (3, 21) ";
					$data["title"] = "Penawaran yang Sudah Dikirim";
					break;
				case "kirimpenawaran":
					//start code hlmifzi
					// $where = " and c.pvs_status in (2, 20, 12) and b.ptp_quot_closing_date > now()";
					$where = " and c.pvs_status in (2, 20, 12) and ( (b.ptp_quot_opening_date <= now() and b.ptp_quot_closing_date >= now()) OR (b.ptp_quot_opening_date >= now() AND b.ptp_reg_opening_date < now()) OR (b.ptp_bid_opening2 <= now() AND b.ptp_bid_closing2 >= now() AND c.pvs_technical_status = 1) )";
					//end
					$data["title"] = "Pengadaan yang menunggu Penawaran";
					break;
				case "penawarandievaluasi":
					$where = " and c.pvs_status in (-5,-8,-7,-4,4,5,7,8,22,23) ";
					$data["title"] = "Penawaran yang Sedang Dievaluasi";
					break;
				case "aanwijzingonline":
					$where = "  AND b.ptp_aanwijzing_online=1 AND ptp_prebid_date < NOW() AND ptp_quot_opening_date > NOW() ";
					$data["title"] = "Aanwijzing Online";
					break;
				case "eauction":
					$where = " and c.pvs_status in (4,5,8) AND e.status = 1 AND NOW() BETWEEN e.TANGGAL_MULAI AND e.TANGGAL_BERAKHIR";
					$data["title"] = "E-Auction";
					break;

				default:

					break;
			}

			$query = "select c.pvs_status, a.ptm_number, a.ptm_subject_of_work, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_quot_closing_date, d.lkp_description as status
			from prc_tender_main a
			join prc_tender_prep b on a.ptm_number = b.ptm_number
			join prc_tender_vendor_status c on b.ptm_number = c.ptm_number
			join z_bidder_status d on c.pvs_status = d.lkp_id
			left join prc_eauction_header e on e.ppm_id=a.ptm_number AND e.status = 1
			where c.pvs_vendor_code = '" . $this->session->userdata("userid") . "'
			AND ptm_status >=1080
			" . $where;

			//echo $query;

			$data["list"] = $this->db->query($query)->result_array();
			$this->layout->view("pengadaan/listpekerjaan", $data);
		} else {
			$this->layout->view("pengadaan/listpekerjaan");
		}
	}

	//start code hlmifzi
	public function buatsanggah()
	{
		$data["list"] = $this->db->query("
			select a.ptm_number, c.ptm_subject_of_work, b.ptp_denial_period
			from prc_tender_vendor_status a
			JOIN prc_tender_prep b on a.ptm_number = b.ptm_number
			join prc_tender_main c on c.ptm_number = b.ptm_number
			where pvs_vendor_code = '" . $this->session->userdata("userid") . "' and a.ptm_number
			not in (SELECT ptm_number FROM prc_tender_claim WHERE pcl_jwb_isi IS NULL) and b.ptp_denial_period != 0 and c.ptm_status = 1170
			")->result_array();
		$data["title"] = "Buat Sanggahan";
		$this->layout->view("pengadaan/sanggah", $data);
	}
	//endcode

	public function lihat_pengadaan($id = "")
	{
		$data['title'] = 'Data Pengadaan';
		$tenderid = $this->encryption->decrypt($this->umum->forbidden($id, 'dekrip'));
		//echo "Y";
		$data["header"] = $this->db->select("ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,ptp_eauction,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, ptp_quot_closing_date, ptp_doc_open_date, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai")
			->join("prc_tender_prep b", "a.ptm_number = b.ptm_number")->where("b.ptm_number", $tenderid)->get("prc_tender_main a")->row_array();
		$data["item"] = $this->db->query("select tit_code,tit_ppn,tit_pph, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
		$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();

		$data["submits"] = false;

		if ($data["header"]["ptp_submission_method"] == '2') {
			$data["tahap2"] = true;
		} else {
			$data["tahap2"] = false;
		}
		$this->layout->view("pengadaan/overview", $data);
	}

	public function inputsanggah()
	{

		$post = $this->input->post();

		$nilaijaminan = str_replace(".", "", $post["nilaijaminan"]);

		if (!empty($_FILES['lampiran_sanggah']['name'])) {
			$files = $this->do_upload('lampiran_sanggah', $this->session->userdata("userid"), "sanggah");
			if (is_array($files)) {
				$files[1] = str_replace("<p>", "", $files[1]);
				$files[1] = str_replace("</p>", "", $files[1]);
				echo "<script>alert(\"Upload File Lampiran Sanggah Gagal. " . $files[1] . "\"); window.history.go(-1);</script>";
				exit();
			}
		} else {
			$files = "";
		}

		if (!empty($_FILES['lampiran_jaminan']['name'])) {
			$files_jam = $this->do_upload('lampiran_jaminan', $this->session->userdata("userid"), "sanggah");
			if (is_array($files)) {
				$files[1] = str_replace("<p>", "", $files[1]);
				$files[1] = str_replace("</p>", "", $files[1]);
				echo "<script>alert(\"Upload File Lampiran Jaminan Gagal. " . $files[1] . "\"); window.history.go(-1);</script>";
				exit();
			}
		} else {
			$files = "";
		}

		$result = $this->db->insert("prc_tender_claim", array(
			"ptm_number"			=> $post["nopengadaan"],
			"pcl_vendor_id"			=> $this->session->userdata("userid"),
			"pcl_title"				=> $post["judul"],
			"pcl_reason"			=> $post["isi"],
			"pcl_supporting_text"	=> $post["pendukung"],
			"pcl_supporting_att"	=> $files,
			"pcl_jam_amount"		=> $nilaijaminan,
			"pcl_jam_bank"			=> $post["bank"],
			"pcl_jam_number"		=> $post["nomorjaminan"],
			"pcl_jam_start_date"	=> $post["startdate"],
			"pcl_jam_end_date"		=> $post["enddate"],
			"pcl_jam_att"			=> $files_jam,
			"pcl_created_date"		=> date("Y-m-d H:i:s"),
		));

		if ($this->db->affected_rows($result) > 0) {
			echo "<script>alert(\"Sanggah Berhasil Disimpan\"); window.location.assign(\"" . site_url() . "\");</script>";
		} else {
			echo "<script>alert(\"Data Gagal Disimpan\"); window.history.go(-1);</script>";
		}
	}

	public function monitorsanggah()
	{
		$data["list"] = $this->db->query("select pcl_id, a.ptm_number, pcl_title, pcl_jwb_isi, b.ptm_subject_of_work from prc_tender_claim a join prc_tender_main b on a.ptm_number = b.ptm_number where pcl_vendor_id = '" . $this->session->userdata("userid") . "'")->result_array();
		$data['title'] = 'Monitor Sanggahan';
		$this->layout->view("pengadaan/monitorsanggah", $data);
	}

	public function view_sanggah()
	{
		$pcl_id = $this->input->post("ids");
		$data["content"] = $this->db->query("select a.ptm_number, pcl_vendor_id, pcl_title, pcl_reason, pcl_supporting_text, pcl_supporting_att, pcl_jam_amount,pcl_jam_att, pcl_jam_bank, pcl_jam_number, pcl_jam_start_date, pcl_jam_end_date, pcl_jwb_judul, pcl_jwb_no, pcl_jwb_isi, pcl_jwb_attachment, pcl_created_date, pcl_completed_date, b.ptm_subject_of_work from prc_tender_claim a join prc_tender_main b on a.ptm_number = b.ptm_number where pcl_id = '" . $pcl_id . "'")->row_array();
		$data['title'] = 'Lihat Sanggahan';

		$this->layout->view("pengadaan/sanggah", $data);
	}

	public function eauction_list()
	{

		$userdata = $this->session->all_userdata();
		$tenderid = $userdata["tenderid"];

		$last_bid = $this->db
			->where(array("ppm_id" => $tenderid, "vendor_id" => $userdata['userid']))
			->order_by("id", "desc")
			->limit(1)
			->get("prc_eauction_history")
			->row_array();

		$last_offer = $this->db
			->select('total_ppn')
			->where(array("ptm_number" => $tenderid, "ptv_vendor_code" => $userdata['userid']))
			->order_by("total_ppn", "asc")
			->get('vw_prc_quotation_vendor_sum')
			->row()
			->total_ppn;

		$lowest_bid = $this->db
			->where(array("ppm_id" => $tenderid))
			->order_by("jumlah_bid", "asc")
			->order_by("tgl_bid", "asc")
			->limit(1)
			->get("prc_eauction_history")
			->row_array();

		$label = (isset($last_bid['jumlah_bid']) && isset($lowest_bid['jumlah_bid']) && $last_bid['jumlah_bid'] == $lowest_bid['jumlah_bid']) ? "<i class='fa fa-gavel' aria-hidden='true'></i> " : "";

		$data['latest_bid'] = (isset($last_bid['jumlah_bid'])) ? $label . inttomoney($last_bid['jumlah_bid']) : $label . inttomoney($last_offer);

		$batas_atas = $this->db
			->where("ppm_id", $tenderid)
			->where("status", 1)
			->get("prc_eauction_header")
			->row()->batas_atas;

		echo json_encode($data);
	}

	public function view()
	{
		$post = $this->input->post();
		$data['post'] = $post;
		$data["title"] = "Penawaran";

		$protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
		$urls = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/index.php/pusher/sendMessage/';

		$data['message'] = null;

		if (empty($post)) {
			redirect(site_url("home"));
		}

		$tenderid = $post["ids"];
		$query	 = $this->db->select("*")->where("ptm_number", $tenderid)->get("prc_tender_prep")->row_array();
		$this->session->set_userdata("tenderid", $tenderid);
		$userdata = $this->session->all_userdata();
		$data['userdata'] = $userdata;
		//hlmifzi
		$data['dateex'] = strtotime(date($query["ptp_quot_closing_date"])) * 1000;
		$last_state = (isset($userdata['last_state'])) ? $userdata['last_state'] : $post['state'];

		$prep = $this->db
			->where("a.ptm_number", $tenderid)
			->join("prc_tender_main a", "a.ptm_number=b.ptm_number", "left")
			->join("prc_eauction_header c", "a.ptm_number=c.ppm_id AND c.status = 1", "left")
			->get("prc_tender_prep b")
			->row_array();

		$data['prep'] = $prep;

		$load_view = true;

		// $api_new = $this->loginApi("admin", "wika123");
		// $cookie_name = "e_catalog_api";
		// setcookie($cookie_name, $api_new['data']['token'], time() + (86400 * 30), "/");

		// $url = "https://dev-ecatalog.scmwika.com/api_new/Product";
		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 	'Content-Type: application/x-www-form-urlencoded',
		// 	//'Authorization:' . $_COOKIE["e_catalog_api"]
		// ));
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// $result = curl_exec($ch);
		$data["product_item"] = '';

		$prc_number = $this->db->where("ptm_number", $tenderid);
		$prc_number = $this->db->get("prc_tender_main")->row_array();

		if (!empty($prc_number)) {

			$this->db->where("pr_number", $prc_number['pr_number']);
		}
		$risiko_detail = $this->db->get("prc_risiko_detail")->result_array();
		$data["risiko_detail"] = $risiko_detail;
		// print_r($post);
		// exit;
		if ($last_state == "eauction") {

			$last_penawaran = $this->db->where(
				array(
					"ppm_id" => $tenderid,
					"vendor_id" => $userdata['userid'],
				)
			)->order_by("id", "desc")->limit(1)->get("prc_eauction_history")
				->row_array();

			$data['dari'] = (isset($prep['tanggal_mulai'])) ?  strtotime($prep["tanggal_mulai"]) : 0;
			$data['sampai'] = (isset($prep['tanggal_berakhir'])) ?  strtotime($prep["tanggal_berakhir"]) : 0;

			$penawaran = (isset($post['penawaran_inp'])) ? (int) moneytoint($post['penawaran_inp']) : 0;

			$history_id = null;

			if (!empty($penawaran)) {

				$this->db->trans_begin();

				$batas_atas = $prep['batas_atas'];
				$batas_bawah = $prep['batas_bawah'];

				$jml_last_penawaran = (!empty($last_penawaran['jumlah_bid'])) ? $last_penawaran['jumlah_bid'] : $batas_atas;
				$penurunan = $prep['minimal_penurunan'];

				$last_offer = $this->db
					->select('total_ppn')
					->where(array("ptm_number" => $tenderid, "ptv_vendor_code" => $userdata['userid']))
					->get('vw_prc_quotation_vendor_sum')
					->row()
					->total_ppn;

				$jml_last_penawaran = (!empty($last_penawaran['jumlah_bid'])) ? $last_penawaran['jumlah_bid'] : $batas_atas;
				$penurunan = $prep['minimal_penurunan'];

				if (empty($penawaran)) {
					$data['message'] = "Penawaran tidak boleh 0";
				} else if ($penawaran < $batas_bawah) {

					$data['message'] = "Penawaran harus diatas harga batas bawah";
				} else if ($penawaran > $batas_atas) {

					$data['message'] = "Penawaran harus dibawah harga batas atas";
				} else {

					$is_matgis = ($prep['ptm_type_of_plan'] == "rkp_matgis");

					if (!$is_matgis) {
						$this->db->where(array(
							"ppm_id" => $tenderid,
							"vendor_id" => $userdata['userid'],
						))->update("prc_eauction_history", ["selected" => 0]);
					}

					$inp = array(
						"eauction_id" => $prep['id'],
						"ppm_id" => $tenderid,
						"selected" => ($is_matgis) ? 0 : 1,
						"jumlah_bid" => $penawaran,
						"tgl_bid" => date("Y-m-d H:i:s"),
						"vendor_id" => $userdata['userid'],
					);

					$insert = $this->db->insert("prc_eauction_history", $inp);

					$this->db->where(array(
						"ppm_id" => $tenderid,
						"vendor_id" => $userdata['userid'],
					))->update("prc_eauction_vendor", [
						"last_bid" => $inp['jumlah_bid'],
						"tgl_bid" => $inp['tgl_bid'],
					]);

					$last_penawaran = $this->db->where(
						array(
							"ppm_id" => $tenderid,
							"vendor_id" => $userdata['userid'],
						)
					)->order_by("id", "desc")->limit(1)->get("prc_eauction_history")
						->row_array();

					if (isset($post['harga_inp']) || !empty($post['harga_inp'])) {

						foreach ($post['harga_inp'] as $itemid => $penawaran) {

							$penawaran = (int) moneytoint($penawaran);

							$item = $this->db->where(array("tit_id" => $itemid))
								->get("prc_tender_item")->row_array();

							$get_item = $this->db->where(array(
								"ppm_id" => $tenderid, "(tit_id)::integer" => $itemid
							))->get("prc_eauction_item")->row_array();

							$last_item_penawaran = $this->db->where(array(
								"ppm_id" => $tenderid,
								"vendor_id" => $userdata['userid'],
								"tit_id" => $itemid,
							))->order_by("id", "desc")
								->limit(1)->get("prc_eauction_history_item")
								->row_array();

							$jml_last_penawaran = (!empty($last_item_penawaran['jumlah_bid'])) ? $last_item_penawaran['jumlah_bid'] : $item['tit_price'];

							$inp = array(
								"eauction_id" => $prep['id'],
								"history_id" => $last_penawaran['id'],
								"ppm_id" => $tenderid,
								"jumlah_bid" => moneytoint($penawaran),
								"qty_bid" => $post['jumlah_inp'][$itemid],
								"tit_id" => $itemid,
								"tgl_bid" => date("Y-m-d H:i:s"),
								"vendor_id" => $userdata['userid'],
							);

							$insert = $this->db->insert("prc_eauction_history_item", $inp);
						}
					}
				}

				if (!empty($data['message'])) {

					$this->db->trans_rollback();
					$this->setMessage($data['message']);
					$this->renderMessage("error");
				} else if ($this->db->trans_status() === FALSE) {

					$this->db->trans_rollback();
					$this->setMessage("Gagal mengubah data");
					$this->renderMessage("error");
				} else {

					$this->db->trans_commit();
					$this->setMessage("Sukses mengubah data");
					$this->renderMessage("success");
				}

				$load_view = false;
			}

			$data['last_quo'] = $last_penawaran;

			$data['tender'] = $prep;

			$data['item'] = $this->db
				->select("b.*, d.ppm_id, d.value_min, c.ptm_number, e.tit_code, e.tit_unit")
				->where(array("c.ptm_number" => "$tenderid", "c.ptv_vendor_code" => $userdata['userid']))
				->join("prc_tender_quo_main c", "b.pqm_id = c.pqm_id", "left")
				->join("prc_eauction_item d", "c.ptm_number = d.ppm_id", "left")
				->join("prc_tender_item e", "e.tit_id = b.tit_id", "left")
				->get("prc_tender_quo_item b")
				->result_array();

			$history = $this->db->where(array(
				"ppm_id" => $tenderid,
				"vendor_id" => $userdata['userid']
			))->get("prc_eauction_history_item")->result_array();

			$list_hist = array();

			foreach ($history as $key => $value) {
				$list_hist[$value['tit_id']] = $value['jumlah_bid'];
			}

			$data['history_item'] = $list_hist;

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $urls,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => array(
					'message' => '{"online": "true"}'
				),
				CURLOPT_HTTPHEADER => array(
					'Cookie: wika_internal_sess=3c1a6cqomdilt6am2qfc62receap3ndk'
				)
			));

			$resst = curl_exec($curl);
			curl_close($curl);

			if ($load_view) {
				$this->layout->view("pengadaan/eauction", $data);
			}
		} else {

			$current_stat = $post["current_status"];

			$aanwijzing = $post["aanwijzing"];
			$reg_close = $post["reg_close"];
			$bid_open = $post["bid_open"];

			$proc_date = $this->db->select("ptp_bid_opening2,
				ptp_bid_closing2,
				ptp_tgl_aanwijzing2,
				ptp_reg_opening_date,
				ptp_reg_closing_date,
				ptp_quot_closing_date,
				ptp_quot_opening_date,
				ptp_quot_closing_date,
				ptp_prebid_date,
				ptp_doc_open_date,
				ptp_prebid_location,
				ptp_aanwijzing_online")->where("ptm_number", $tenderid)
				->get("prc_tender_prep")->row_array();

			if ($last_state == "aanwijzingonline") {

				$vnd = $this->db->where(array("ptm_number" => $tenderid, "pvs_status >" => 0))->get("prc_tender_vendor_status")->result_array();

				$vendor = array();

				foreach ($vnd as $key => $value) {
					if ($data['userdata']['userid'] != $value['pvs_vendor_code']) {
						$vendor[] = $value['pvs_vendor_code'];
					}
				}

				$vendor_aanwijzing = array();

				if (!empty($vendor)) {

					$vendor_aanwijzing = $this->db
						->select("vendor_id,vendor_name,fin_class,lkp_description")
						->distinct()
						->where_in("status", array("5", "9"))
						->where_in("vendor_id", $vendor)
						->join("prc_tender_vendor_status", "pvs_vendor_code=vendor_id", "left")
						->join("z_bidder_status", "lkp_id=pvs_status", "left")
						->get("vw_vnd_bidder_list")->result_array();

					$data['vendor_aanwijzing'] = $vendor_aanwijzing;

					foreach ($vendor_aanwijzing as $key => $value) {
						$data['user_aanwijzing'][$value['vendor_name']] = "Offline";
					}
				}

				$data['userdata']['district_name'] = $prep['ptm_district_name'];

				$data['chat_aanwijzing'] = $this->db->where("key_ac", "1-" . $tenderid)->get("adm_chat")->result_array();
				$data['chat_eauction'] = $this->db->where("key_ac", "2-" . $tenderid)->get("adm_chat")->result_array();
				$status_aanwijzing = $this->db->where(array(
					"key_ac" => "0-" . $tenderid,
				))->order_by("datetime_ac", "asc")->get("adm_chat")
					->result_array();

				foreach ($status_aanwijzing as $key => $value) {
					$data['user_aanwijzing'][$value['name_ac']] = (!empty($value['message_ac'])) ? $value['message_ac'] : "Offline";
				}

				$nama_user = $userdata['nama_vendor'];
				if (!isset($data['user_aanwijzing'][$nama_user])) {
					$data['user_aanwijzing'][$nama_user] = "Offline";
				}

				$this->layout->view("pengadaan/aanwijzing_online", $data);
			}

			$statss = array(-5, -8, -7, -4, 4, 5, 7, 8, 22, 23, 24, 25, 26);

			if ($current_stat == "1" || $current_stat == "-1") {
				$data["header"] = $this->db->query("SELECT ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,ptp_eauction,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, ptp_quot_closing_date, ptp_doc_open_date, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '" . $tenderid . "'")->row_array();
				$data["item"] = $this->db->query("select tit_code,tit_ppn,tit_pph, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
				$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();
				if ($current_stat == "1" && (strtotime($data["header"]["ptp_reg_closing_date"]) > strtotime($data["header"]["waktu"]))) {
					$data["submits"] = true;
				} else {
					$data["submits"] = false;
				}
				if ($data["header"]["ptp_submission_method"] == '2') {
					$data["tahap2"] = true;
				} else {
					$data["tahap2"] = false;
				}
				$this->layout->view("pengadaan/overview", $data);
			} else if (in_array($current_stat, array("20", "2"))) {
				$now = $this->db->query("select now() as waktu")->row_array();

				if ((strtotime($proc_date['ptp_quot_opening_date']) <= strtotime($now["waktu"])) && (strtotime($proc_date['ptp_quot_closing_date']) >= strtotime($now["waktu"])) && ($prep["ptp_submission_method"] != '2')) {
					$data["tenderid"] = $tenderid;

					$cek_item_penawaran = $this->db->query("select pqi_id from prc_tender_quo_item where pqm_id in (select pqm_id from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "')")->num_rows();

					//draft
					if ($cek_item_penawaran > 1) {

						$now = $this->db->query("select now() as waktu")->row_array();
						$cek_item_penawaran = $this->db->query("select pqi_id from prc_tender_quo_item where pqm_id in (select pqm_id from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "')")->num_rows();

						if (($prep["ptp_submission_method"] != '2')) {

							$time = time();
							$opening = strtotime($proc_date["ptp_quot_opening_date"]);
							$closing = strtotime($proc_date["ptp_quot_closing_date"]);

							if ($last_state == "dikirim") {
							}

							if (time() > $closing || time() < $opening) {
								$data['readonly'] = "1";
								echo "<script>alert(\"M0 : Maaf, Saat ini bukan waktu memasukan penawaran 3\"); window.history.go(-1);</script>";
							}

							$data["tenderid"] = $tenderid;
							$data["isDraft"] = true;
							$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
							$data["pajak"] = $data["pajak"]["pajak"];
							$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();

							$check = (isset($data["header"]["pqm_id"])) ? $data["header"]["pqm_id"] : "";

							$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();

							if (!empty($check)) {
								$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
								$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
							} else {
								$data["template"] = $this->db->query("select c.etd_item, c.etd_mode, c.etd_weight from prc_tender_prep a join prc_evaluation_template b on a.evt_id = b.evt_id RIGHT JOIN prc_evaluation_template_detail c on b.evt_id = c.evt_id where a.ptm_number = '" . $tenderid . "'")->result_array();
								$data["item"] = $this->db->query("select tit_id, tit_description, tit_quantity, tit_ppn, tit_pph from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
							}
						}

						//insert
					} else {

						//hlmifzi
						$data['dateex'] = strtotime(date($query["ptp_quot_closing_date"])) * 1000;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["template"] = $this->db->query("select c.etd_item, c.etd_mode, c.etd_weight from prc_tender_prep a join prc_evaluation_template b on a.evt_id = b.evt_id RIGHT JOIN prc_evaluation_template_detail c on b.evt_id = c.evt_id where a.ptm_number = '" . $tenderid . "'")->result_array();
						$data["item"] = $this->db->query("select tit_id, tit_ppn,tit_pph, tit_description, tit_quantity, tit_ppn, tit_pph from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
						$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
					}
					// $data['risiko_detail'] = $this->Procpr_m->getPrRisikoDetail($permintaan['pr_number'])->result_array();
					//risiko detail data

					$this->layout->view("pengadaan/penawaran", $data);
				} else if ($prep["ptp_submission_method"] == '2') {

					$time = time();
					$opening = strtotime($proc_date["ptp_quot_opening_date"]);
					$closing = strtotime($proc_date["ptp_quot_closing_date"]);
					$opening2 = strtotime($proc_date["ptp_bid_opening2"]);
					$closing2 = strtotime($proc_date["ptp_bid_closing2"]);


					if ((strtotime($reg_close) < $time) && (strtotime($aanwijzing) < $time) && ($time < strtotime($bid_open))) {
						//Penawaran Pertama
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["template"] = $this->db->query("select c.etd_item, c.etd_mode, c.etd_weight from prc_tender_prep a join prc_evaluation_template b on a.evt_id = b.evt_id RIGHT JOIN prc_evaluation_template_detail c on b.evt_id = c.evt_id where a.ptm_number = '" . $tenderid . "'")->result_array();
						$data["item"] = $this->db->query("select tit_id,tit_ppn,tit_pph, tit_description, tit_quantity from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
						$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "teknis";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else if (($closing2 >= $time) && ($opening2 <= $time)) {
						//Penawaran Kedua
						$cek_item_penawaran = $this->db->query("select pqi_id from prc_tender_quo_item where pqm_id in (select pqm_id from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "')")->num_rows();
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select tit_id,tit_ppn,tit_pph, tit_description, tit_quantity from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
						$data["modes"] = "harga";
						$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						if ($cek_item_penawaran > 0) {
							$data["quos"] = true;
						} else {
							$data["quos"] = false;
						}
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else {
						echo "<script>alert(\"M2 : Maaf, Saat ini bukan waktu memasukan penawaran 1\"); window.history.go(-1);</script>";
					}
				} else {
					echo "<script>alert(\"M1 : Maaf, Saat ini bukan waktu memasukan penawaran 2\"); window.history.go(-1);</script>";
				}
			} else if (in_array($current_stat, array("3", "21", "12"))) {
				//echo "A";
				$now = $this->db->query("select now() as waktu")->row_array();
				$cek_item_penawaran = $this->db->query("select pqi_id from prc_tender_quo_item where pqm_id in (select pqm_id from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "')")->num_rows();

				if (($prep["ptp_submission_method"] != '2')) {

					$time = time();
					$opening = strtotime($proc_date["ptp_quot_opening_date"]);
					$closing = strtotime($proc_date["ptp_quot_closing_date"]);

					if ($last_state == "dikirim") {
					}

					if (time() > $closing || time() < $opening) {
						$data['readonly'] = "1";
						echo "<script>alert(\"M0 : Maaf, Saat ini bukan waktu memasukan penawaran 3\"); window.history.go(-1);</script>";
					}

					$data["tenderid"] = $tenderid;
					$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
					$data["pajak"] = $data["pajak"]["pajak"];
					$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();

					$check = (isset($data["header"]["pqm_id"])) ? $data["header"]["pqm_id"] : "";

					$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();

					if (!empty($check)) {
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
					} else {
						$data["template"] = $this->db->query("select c.etd_item, c.etd_mode, c.etd_weight from prc_tender_prep a join prc_evaluation_template b on a.evt_id = b.evt_id RIGHT JOIN prc_evaluation_template_detail c on b.evt_id = c.evt_id where a.ptm_number = '" . $tenderid . "'")->result_array();
						$data["item"] = $this->db->query("select tit_id, tit_description, tit_quantity, tit_ppn, tit_pph from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
					}

					$this->layout->view("pengadaan/penawaran", $data);
				} else {

					$tgl2 = $this->db->query("select ptp_bid_opening2 as open, ptp_bid_closing2 as closing, ptp_tgl_aanwijzing2 as aanw from prc_tender_prep where ptm_number = '" . $tenderid . "'")->row_array();
					if ((strtotime($reg_close) < strtotime($now["waktu"])) && (strtotime($aanwijzing) < strtotime($now["waktu"])) && (strtotime($now["waktu"]) < strtotime($bid_open))) {
						//Penawaran Pertama
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "teknis";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else if ($cek_item_penawaran < 1) {
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "teknis";
						$data["readonly"] = "1";
						//echo "b";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else if ((strtotime($tgl2["aanw"]) < strtotime($now["waktu"])) && (strtotime($now["waktu"]) < strtotime($tgl2["open"])) && ($cek_item_penawaran > 0)) {
						//Penawaran Kedua
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "harga";
						if ($cek_item_penawaran > 0) {
							$data["quos"] = true;
						} else {
							$data["quos"] = false;
						}
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else {
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["modes"] = "harga";
						$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						if ($cek_item_penawaran > 0) {
							$data["quos"] = true;
						} else {
							$data["quos"] = false;
						}
						if (strtotime($now["waktu"]) > strtotime($tgl2["closing"])) {
							$data['readharga'] = "readonly";
						} else {
							$data['readharga'] = "";
						}
						$data["readonly"] = "1";
						//echo "c";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					}
				}
			} else if (in_array($current_stat, $statss)) {
				//echo "B";
				$data["tenderid"] = $tenderid;
				$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pajak"] = $data["pajak"]["pajak"];
				$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
				$data["readonly"] = "1";
				$this->layout->view("pengadaan/penawaran", $data);
			} else if ($current_stat == "11") {
				$data["tenderid"] = $tenderid;
				$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pajak"] = $data["pajak"]["pajak"];
				$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
				$data["readonly"] = "1";
				$data["winner"] = "1";
				$this->layout->view("pengadaan/penawaran", $data);
			} else if ($current_stat == "10") {

				$data["tenderid"] = $tenderid;
				$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pajak"] = $data["pajak"]["pajak"];
				$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pesan"] = $this->db->query("select awa_id as pta_id, pbm_message, pbm_date, pbm_mode, pbm_user from prc_bidder_message where ptm_number = '" . $tenderid . "' and pbm_vendor_code = '" . $this->session->userdata("userid") . "' order by pbm_id desc")->result_array();
				$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$data['isnego'] = TRUE;

				$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
				$prep = $this->db
					->where("a.ptm_number", $tenderid)
					->join("prc_tender_main a", "a.ptm_number=b.ptm_number", "left")
					->join("prc_eauction_header c", "a.ptm_number=c.ppm_id AND c.status = 1", "left")
					->get("prc_tender_prep b")
					->row_array();
				$data['prep'] = $prep;

				$this->layout->view("pengadaan/negosiasi", $data);
			} else {
				echo "<script>alert(\"Request Tidak Dikenali\"); window.location.assign(\"" . site_url() . "\");</script>";
			}
		}
	}

	public function loginApi($username, $password)
	{

		// $url = "https://dev-ecatalog.scmwika.com/api_new/GenerateToken";
		// $curl = curl_init($url);

		// $data = array(
		// 	'username' => $username,
		// 	'password' => $password
		// );

		// $payload = json_encode($data);

		// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
		// curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		// 	'Content-Type:application/json',
		// 	'Accept:application/json'
		// ));
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		// $result = curl_exec($curl);
		// $response = json_decode($result, true);

		// return $response;
	}

	//start code hlmifzi
	public function view_monitor()
	{

		$post = $this->input->post();
		$data['post'] = $post;
		$data["title"] = "Monitoring";

		if (empty($post)) {
			redirect(site_url("home"));
		}

		$tenderid = $post["ids"];
		$this->session->set_userdata("tenderid", $tenderid);
		$userdata = $this->session->all_userdata();
		$data['userdata'] = $userdata;
		$last_state = (isset($userdata['last_state'])) ? $userdata['last_state'] : $post['state'];

		$prep = $this->db
			->where("a.ptm_number", $tenderid)
			->join("prc_tender_main a", "a.ptm_number=b.ptm_number", "left")
			->join("prc_eauction_header c", "a.ptm_number=c.ppm_id AND c.status = 1", "left")
			->get("prc_tender_prep b")
			->row_array();

		$data['prep'] = $prep;

		$data['rks'] = $this->db->where('ptm_number', $tenderid)->get("prc_tender_rks")->result_array();		

		if ($last_state == "eauction") {

			$last_penawaran = $this->db->where(
				array(
					"ppm_id" => $tenderid,
					"vendor_id" => $userdata['userid'],
				)
			)->order_by("id", "desc")->limit(1)->get("prc_eauction_history")
				->row_array();

			$data['dari'] = (isset($prep['tanggal_mulai'])) ?  strtotime($prep["tanggal_mulai"]) : 0;
			$data['sampai'] = (isset($prep['tanggal_berakhir'])) ?  strtotime($prep["tanggal_berakhir"]) : 0;

			$penawaran = (isset($post['penawaran_inp'])) ? (int) moneytoint($post['penawaran_inp']) : 0;

			if (!empty($penawaran)) {

				$batas_atas = $prep['batas_atas'];
				$batas_bawah = $prep['batas_bawah'];


				$jml_last_penawaran = (!empty($last_penawaran['jumlah_bid'])) ? $last_penawaran['jumlah_bid'] : $batas_atas;
				$penurunan = $prep['minimal_penurunan'];

				if (empty($penawaran)) {
					$data['message'] = "Penawaran tidak boleh 0";
				} else if ($penawaran < $batas_bawah) {

					$data['message'] = "Penawaran harus diatas harga batas bawah";
				} else if ($penawaran > $batas_atas) {

					$data['message'] = "Penawaran harus dibawah harga batas atas";
				} else if ($penawaran > $jml_last_penawaran - $penurunan) {
					$data['message'] = "Penawaran harus lebih rendah dari harga terendah";
				} else {

					$inp = array(
						"ppm_id" => $tenderid,
						"jumlah_bid" => $penawaran,
						"tgl_bid" => date("Y-m-d H:i:s"),
						"vendor_id" => $userdata['userid'],
					);

					$insert = $this->db->insert("prc_eauction_history", $inp);
				}
			}

			if (isset($post['harga_inp']) || !empty($post['harga_inp'])) {

				foreach ($post['harga_inp'] as $itemid => $penawaran) {

					$penawaran = (int) moneytoint($penawaran);

					$item = $this->db->where(array("tit_id" => $itemid))
						->get("prc_tender_item")->row_array();

					$get_item = $this->db->where(array(
						"ppm_id" => $tenderid, "tit_id" => $itemid
					))->get("prc_eauction_item")->row_array();

					$last_item_penawaran = $this->db->where(array(
						"ppm_id" => $tenderid,
						"vendor_id" => $userdata['userid'],
						"tit_id" => $itemid,
					))->order_by("id", "desc")
						->limit(1)->get("prc_eauction_history_item")
						->row_array();

					$jml_last_penawaran = (!empty($last_item_penawaran['jumlah_bid'])) ? $last_item_penawaran['jumlah_bid'] : $item['tit_price'];

					if ($jml_last_penawaran != $penawaran) {

						$penurunan = $get_item['value_min'];

						if (empty($penawaran)) {
							$data['message'] = "Penawaran item " . $item['tit_id'] . " tidak boleh 0";
						} else if ($penawaran > $jml_last_penawaran - $penurunan) {
						} else {

							$inp = array(
								"ppm_id" => $tenderid,
								"jumlah_bid" => moneytoint($penawaran),
								"qty_bid" => $post['jumlah_inp'][$itemid],
								"tit_id" => $itemid,
								"tgl_bid" => date("Y-m-d H:i:s"),
								"vendor_id" => $userdata['userid'],
							);

							$insert = $this->db->insert("prc_eauction_history_item", $inp);
						}
					}
				}
			}

			$last_penawaran = $this->db->where(
				array(
					"ppm_id" => $tenderid,
					"vendor_id" => $userdata['userid'],
				)
			)->order_by("id", "desc")->limit(1)->get("prc_eauction_history")
				->row_array();

			$data['last_quo'] = $last_penawaran;

			$data['tender'] = $prep;

			$data['item'] = $this->db
				->where("ptm_number", $tenderid)
				->join("prc_eauction_item c", "b.ptm_number=c.ppm_id AND b.tit_id=c.tit_id", "left")
				->get("prc_tender_item b")
				->result_array();

			$history = $this->db->where(array(
				"ppm_id" => $tenderid,
				"vendor_id" => $userdata['userid']
			))
				->get("prc_eauction_history_item")->result_array();

			$list_hist = array();

			foreach ($history as $key => $value) {
				$list_hist[$value['tit_id']] = $value['jumlah_bid'];
			}

			$data['history_item'] = $list_hist;

			$this->layout->view("pengadaan/eauction", $data);
		} else {

			$current_stat = $post["current_status"];
			$aanwijzing = $post["aanwijzing"];
			$reg_close = $post["reg_close"];
			$bid_open = $post["bid_open"];

			$proc_date = $this->db->select("ptp_bid_opening2,
				ptp_tgl_aanwijzing2,
				ptp_reg_opening_date,
				ptp_reg_closing_date,
				ptp_quot_closing_date,
				ptp_quot_opening_date,
				ptp_quot_closing_date,
				ptp_prebid_date,
				ptp_doc_open_date,
				ptp_prebid_location,
				ptp_aanwijzing_online")->where("ptm_number", $tenderid)
				->get("prc_tender_prep")->row_array();

			if ($last_state == "aanwijzingonline") {

				$vnd = $this->db->where(array("ptm_number" => $tenderid, "pvs_status >" => 0))->get("prc_tender_vendor_status")->result_array();

				$vendor = array();

				foreach ($vnd as $key => $value) {
					if ($data['userdata']['userid'] != $value['pvs_vendor_code']) {
						$vendor[] = $value['pvs_vendor_code'];
					}
				}

				$vendor_aanwijzing = array();

				if (!empty($vendor)) {

					$vendor_aanwijzing = $this->db
						->select("vendor_id,vendor_name,fin_class,lkp_description")
						->distinct()
						->where_in("(status)::integer", array(5, 9))
						//->where("pvs_status",2)
						->where_in("vendor_id", $vendor)
						->join("prc_tender_vendor_status", "pvs_vendor_code=vendor_id", "left")
						->join("z_bidder_status", "lkp_id=pvs_status", "left")
						->get("vw_vnd_bidder_list")->result_array();

					$data['vendor_aanwijzing'] = $vendor_aanwijzing;

					foreach ($vendor_aanwijzing as $key => $value) {
						$data['user_aanwijzing'][$value['vendor_name']] = "Offline";
					}
				}

				$data['userdata']['district_name'] = $prep['ptm_district_name'];

				$data['chat_aanwijzing'] = $this->db->where("key_ac", "1-" . $tenderid)->get("adm_chat")->result_array();
				$data['chat_eauction'] = $this->db->where("key_ac", "2-" . $tenderid)->get("adm_chat")->result_array();
				$status_aanwijzing = $this->db->where(array(
					"key_ac" => "0-" . $tenderid,
				))->order_by("datetime_ac", "asc")->get("adm_chat")
					->result_array();

				foreach ($status_aanwijzing as $key => $value) {
					$data['user_aanwijzing'][$value['name_ac']] = (!empty($value['message_ac'])) ? $value['message_ac'] : "Offline";
				}

				$nama_user = $userdata['nama_vendor'];
				if (!isset($data['user_aanwijzing'][$nama_user])) {
					$data['user_aanwijzing'][$nama_user] = "Offline";
				}

				$this->layout->view("pengadaan/aanwijzing_online", $data);
			}


			$statss = array(-5, -8, -7, -4, 4, 5, 7, 8, 22, 23, 24, 25, 26);

			if ($current_stat == "1" || $current_stat == "-1") {
				//echo "Y";
				$data["header"] = $this->db->query("SELECT ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,ptp_eauction,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, ptp_quot_closing_date, ptp_doc_open_date, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '" . $tenderid . "'")->row_array();
				$data["item"] = $this->db->query("select tit_code,tit_ppn,tit_pph, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
				$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();
				if ($current_stat == "1" && (strtotime($data["header"]["ptp_reg_closing_date"]) > strtotime($data["header"]["waktu"]))) {
					$data["submits"] = true;
				} else {
					$data["submits"] = false;
				}
				if ($data["header"]["ptp_submission_method"] == '2') {
					$data["tahap2"] = true;
				} else {
					$data["tahap2"] = false;
				}
				$this->layout->view("pengadaan/overview", $data);
			} else if (in_array($current_stat, array("20", "2"))) {

				$now = $this->db->query("select now() as waktu")->row_array();
				if ((strtotime($proc_date['ptp_quot_opening_date']) <= strtotime($now["waktu"])) && (strtotime($proc_date['ptp_quot_closing_date']) >= strtotime($now["waktu"])) && ($prep["ptp_submission_method"] != '2')) {
					//start code hlmifzi
					$data["header"] = $this->db->query("SELECT ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,b.ptp_eauction, ptp_quot_closing_date,ptp_doc_open_date,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '" . $tenderid . "'")->row_array();
					$data["item"] = $this->db->query("select tit_code, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
					$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();


					if ($data["header"]["ptp_submission_method"] == '2') {
						$data["tahap2"] = true;
					} else {
						$data["tahap2"] = false;
					}

					$this->layout->view("pengadaan/view_monitor_pengadaan", $data);
					//end code

				} else if ($prep["ptp_submission_method"] == '2') {

					$time = time();
					$opening = strtotime($proc_date["ptp_quot_opening_date"]);
					$closing = strtotime($proc_date["ptp_quot_closing_date"]);


					if ((strtotime($reg_close) < $time) && (strtotime($aanwijzing) < $time) && ($time < strtotime($bid_open))) {
						//Penawaran Pertama
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["template"] = $this->db->query("select c.etd_item, c.etd_mode, c.etd_weight from prc_tender_prep a join prc_evaluation_template b on a.evt_id = b.evt_id RIGHT JOIN prc_evaluation_template_detail c on b.evt_id = c.evt_id where a.ptm_number = '" . $tenderid . "'")->result_array();
						$data["item"] = $this->db->query("select tit_id,tit_ppn,tit_pph, tit_description, tit_quantity from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
						$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "teknis";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else if (($closing >= $time) && ($opening <= $time)) {
						//Penawaran Kedua
						$cek_item_penawaran = $this->db->query("select pqi_id from prc_tender_quo_item where pqm_id in (select pqm_id from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "')")->num_rows();
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select tit_id,tit_ppn,tit_pph, tit_description, tit_quantity from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
						$data["modes"] = "harga";
						$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						if ($cek_item_penawaran > 0) {
							$data["quos"] = true;
						} else {
							$data["quos"] = false;
						}
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else {
						echo "<script>alert(\"M2 : Maaf, Saat ini bukan waktu memasukan penawaran 1\"); window.history.go(-1);</script>";
					}
				} else {
					//start code hlmifzi
					$data["header"] = $this->db->query("SELECT ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,b.ptp_eauction,ptp_quot_closing_date,ptp_doc_open_date,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '" . $tenderid . "'")->row_array();
					$data["item"] = $this->db->query("select tit_code, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
					$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();


					if ($data["header"]["ptp_submission_method"] == '2') {
						$data["tahap2"] = true;
					} else {
						$data["tahap2"] = false;
					}

					$this->layout->view("pengadaan/view_monitor_pengadaan", $data);
					//end code
				}
			} else if (in_array($current_stat, array("3", "21", "12"))) {
				//echo "A";
				$now = $this->db->query("select now() as waktu")->row_array();
				$cek_item_penawaran = $this->db->query("select pqi_id from prc_tender_quo_item where pqm_id in (select pqm_id from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "')")->num_rows();

				if (($prep["ptp_submission_method"] != '2')) {

					$time = time();
					$opening = strtotime($proc_date["ptp_quot_opening_date"]);
					$closing = strtotime($proc_date["ptp_quot_closing_date"]);

					if ($last_state == "dikirim") {
					}

					if (time() > $closing || time() < $opening) {
						//start code hlmifzi
						$data["header"] = $this->db->query("SELECT ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,b.ptp_eauction, ptp_quot_closing_date,ptp_doc_open_date,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '" . $tenderid . "'")->row_array();
						$data["item"] = $this->db->query("select tit_code, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
						$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();


						if ($data["header"]["ptp_submission_method"] == '2') {
							$data["tahap2"] = true;
						} else {
							$data["tahap2"] = false;
						}

						$this->layout->view("pengadaan/view_monitor_pengadaan", $data);
						//end code
					}

					$data["tenderid"] = $tenderid;
					$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
					$data["pajak"] = $data["pajak"]["pajak"];
					$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();

					$check = (isset($data["header"]["pqm_id"])) ? $data["header"]["pqm_id"] : "";

					$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();

					if (!empty($check)) {
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
					} else {
						$data["template"] = $this->db->query("select c.etd_item, c.etd_mode, c.etd_weight from prc_tender_prep a join prc_evaluation_template b on a.evt_id = b.evt_id RIGHT JOIN prc_evaluation_template_detail c on b.evt_id = c.evt_id where a.ptm_number = '" . $tenderid . "'")->result_array();
						$data["item"] = $this->db->query("select tit_id, tit_description, tit_quantity, tit_ppn, tit_pph from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
					}

					$this->layout->view("pengadaan/penawaran", $data);
				} else {

					$tgl2 = $this->db->query("select ptp_bid_opening2 as open, ptp_tgl_aanwijzing2 as aanw from prc_tender_prep where ptm_number = '" . $tenderid . "'")->row_array();
					if ((strtotime($reg_close) < strtotime($now["waktu"])) && (strtotime($aanwijzing) < strtotime($now["waktu"])) && (strtotime($now["waktu"]) < strtotime($bid_open))) {
						//Penawaran Pertama
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "teknis";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else if ($cek_item_penawaran < 1) {
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "teknis";
						$data["readonly"] = "1";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else if ((strtotime($tgl2["aanw"]) < strtotime($now["waktu"])) && (strtotime($now["waktu"]) < strtotime($tgl2["open"])) && ($cek_item_penawaran > 0)) {
						//Penawaran Kedua
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						$data["modes"] = "harga";
						if ($cek_item_penawaran > 0) {
							$data["quos"] = true;
						} else {
							$data["quos"] = false;
						}
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					} else {
						$data["tenderid"] = $tenderid;
						$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["pajak"] = $data["pajak"]["pajak"];
						$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
						$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
						$data["modes"] = "harga";
						$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
						if ($cek_item_penawaran > 0) {
							$data["quos"] = true;
						} else {
							$data["quos"] = false;
						}
						$data["readonly"] = "1";
						$this->layout->view("pengadaan/penawaran_duatahap", $data);
					}
				}
			} else if (in_array($current_stat, $statss)) {
				$data["tenderid"] = $tenderid;
				$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pajak"] = $data["pajak"]["pajak"];
				$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();

				//============================================
				if ($data["header"] == NULL) {
					$data["header"] = $this->db->query("SELECT ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,ptp_eauction,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, ptp_quot_closing_date, ptp_doc_open_date, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '" . $tenderid . "'")->row_array();
					$data["item"] = $this->db->query("select tit_code,tit_ppn,tit_pph, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
					$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();
					if ($current_stat == "1" && (strtotime($data["header"]["ptp_reg_closing_date"]) > strtotime($data["header"]["waktu"]))) {
						$data["submits"] = true;
					} else {
						$data["submits"] = false;
					}
					if ($data["header"]["ptp_submission_method"] == '2') {
						$data["tahap2"] = true;
					} else {
						$data["tahap2"] = false;
					}
					$this->layout->view("pengadaan/overview", $data);
				} else {
					//============================================

					$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
					$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
					$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
					$data["readonly"] = "1";
					$this->layout->view("pengadaan/penawaran", $data);
				}
			} else if ($current_stat == "11") {
				$data["tenderid"] = $tenderid;
				$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pajak"] = $data["pajak"]["pajak"];
				$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["template"] = $this->db->query("select pqt_id, pqt_item, pqt_weight, pqt_check_vendor, pqt_vendor_desc, pqt_attachment from prc_tender_quo_tech where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$data["currency"] = $this->db->query("select curr_code, curr_name from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
				$data["readonly"] = "1";
				$data["winner"] = "1";
				$this->layout->view("pengadaan/penawaran", $data);
			} else if ($current_stat == "10") {

				$data["tenderid"] = $tenderid;
				$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pajak"] = $data["pajak"]["pajak"];
				$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
				$data["pesan"] = $this->db->query("select awa_id as pta_id, pbm_message, pbm_date, pbm_mode, pbm_user from prc_bidder_message where ptm_number = '" . $tenderid . "' and pbm_vendor_code = '" . $this->session->userdata("userid") . "' order by pbm_id desc")->result_array();
				$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
				$this->layout->view("pengadaan/negosiasi", $data);
			} else {

				$data["header"] = $this->db->query("SELECT ptp_negosiation_date,ptp_uskep_date,ptp_announcement_date,ptp_disclaimer_date,ptp_appointment_date,b.ptp_eauction, ptp_quot_closing_date,ptp_doc_open_date,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '" . $tenderid . "' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '" . $tenderid . "'")->row_array();
				$data["item"] = $this->db->query("select tit_code, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '" . $tenderid . "'")->result_array();
				$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptd_type = '1' and ptm_number = '" . $tenderid . "'")->result_array();


				if ($data["header"]["ptp_submission_method"] == '2') {
					$data["tahap2"] = true;
				} else {
					$data["tahap2"] = false;
				}

				$this->layout->view("pengadaan/view_monitor_pengadaan", $data);
			}
		}
	} //end

	public function edit_harga_nego()
	{
		$tenderid = $this->session->userdata("tenderid");
		$data["tenderid"] = $tenderid;
		$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '" . $this->session->userdata("userid") . "'")->row_array();
		$data["pajak"] = $data["pajak"]["pajak"];
		$data["header"] = $this->db->query("select * from prc_tender_quo_main where ptm_number = '" . $tenderid . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
		$data["item"] = $this->db->query("select * from prc_tender_quo_item join prc_tender_item on prc_tender_quo_item.tit_id = prc_tender_item.tit_id where pqm_id = '" . $data["header"]["pqm_id"] . "'")->result_array();
		$data["currency"] = $this->db->query("select * from adm_curr where is_active = 'true' order by curr_id asc")->result_array();
		$prep = $this->db
			->where("a.ptm_number", $tenderid)
			->join("prc_tender_main a", "a.ptm_number=b.ptm_number", "left")
			->join("prc_eauction_header c", "a.ptm_number=c.ppm_id AND c.status = 1", "left")
			->get("prc_tender_prep b")
			->row_array();
		$data['prep'] = $prep;
		$data['isnego'] = TRUE;
		$this->load->view("pengadaan/penawaran_nego", $data);
	}

	public function daftar()
	{

		$respon = $this->input->post("response");
		$lelang = $this->input->post("lelang");
		$ptm_number = $this->input->post("ptm_number");
		$userid = $this->session->userdata("userid");

		$is_pq = $this->db->select("ptp_prequalify")
			->where("ptm_number", $ptm_number)->get("prc_tender_prep")->row_array();

		if ($is_pq['ptp_prequalify']) {
			if (!empty($_FILES['lampiran_prakualifikasi']['name'])) {
				$files = $this->do_upload('lampiran_prakualifikasi', $this->session->userdata("userid"), "prakualifikasi");
				if (is_array($files)) {
					echo $files[1];
					exit();
				}
			} else {
				$files = "";
			}
		} else {
			$files = "";
		}

		if (empty($lelang)) {

			$isi = array(
				"pvs_status" => ($respon == 1) ? 2 : -1,
			);

			$where = array(
				"ptm_number" => $ptm_number,
				"pvs_vendor_code" => $userid,
			);

			$query = $this->db->where($where)->update("prc_tender_vendor_status", $isi);
		} else {

			$isi = array(
				"pvs_status" => 2,
				"ptm_number" => $ptm_number,
				"pvs_vendor_code" => $userid,
			);

			if (!empty($files)) {
				$isi["pvs_pq_attachment"] = $files;
			}

			$query = $this->db->insert("prc_tender_vendor_status", $isi);
		}

		$query = $this->db->affected_rows($query);

		if ($query > 0) {

			if ($respon == "1") {

				echo "<script>alert(\"Selamat, Anda Berhasil Mendaftar Menjadi Peserta Pengadaan Ini\"); window.location.assign(\"" . site_url() . "\");</script>";
			} else {

				echo "<script>alert(\"Data Berhasil Disimpan\"); window.location.assign(\"" . site_url() . "\");</script>";
			}
		} else {

			echo "<script>alert(\"Data Gagal Disimpan, Silahkan Ulangi Proses\"); window.location.assign(\"" . site_url() . "\");</script>";
		}
	}

	public function deleteDetailItem()
	{
		$post = $this->input->post();
		$this->db->where('id', $post['id_tbl_del']);
		$act = $this->db->delete('prc_risiko_detail');
		if ($act) {
			$response = array(
				"status" => 200,
				"data" => $act,
			);
		} else {
			$response = array(
				"status" => 500,
				"data" => $act,
			);
		}
		return json_encode($response);
	}

	public function submitquo()
	{
		$section = $this->input->post("section");
		$head = (!empty($this->session->userdata("header"))) ? $this->session->userdata("header") : array();
		$post = array_merge($head, $this->input->post());

		$statuss = TRUE;

		$pqm_rate_curs = isset($post["pqm_rate_curs"]) ? $post["pqm_rate_curs"] : 0;

		if ($section == "header") {
			$this->session->set_userdata("header", $post);

			if (!empty($_FILES['lampiran_penawaran']['name'])) {
				$files_quo = $this->do_upload('lampiran_penawaran', $this->session->userdata("userid"), "penawaran");
				if (is_array($files_quo)) {
					echo $files_quo[1];
					exit();
				}
			} else {
				$files_quo = "";
			}

			$this->session->set_userdata("files_quo", $files_quo);

			echo "1";
		} else if ($section == "bidbond") {
			$this->session->set_userdata("header", $post);
			if (!empty($_FILES['lampiran_bidbond']['name'])) {
				$files = $this->do_upload('lampiran_bidbond', $this->session->userdata("userid"), "bidbond");
				if (is_array($files)) {
					echo $files[1];
					exit();
				}
			} else {
				$files = "";
			}
			$this->session->set_userdata("files", $files);
		} else if ($section == "adm") {
			$temp = [];
			for ($i = 1; $i < $post['num_adm']; $i++) {
				if (!empty($_FILES['lampiran_adm_' . $i]['name'])) {
					$temps = $this->do_upload('lampiran_adm_' . $i, $this->session->userdata("userid"), "administrasi");
					array_push($temp, $temps);
					if (is_array($temps)) {
						echo $temps[1];
						exit();
					}
				} else {
					array_push($temp, "");
				}
			}
			$post['attachment'] = $temp;

			$this->session->set_userdata("adm", $post);
			echo "1";
		} else if ($section == "teknis") {
			$temp = [];
			for ($i = 1; $i < $post['num_tek']; $i++) {
				if (!empty($_FILES['lampiran_tek_' . $i]['name'])) {
					$temps = $this->do_upload('lampiran_tek_' . $i, $this->session->userdata("userid"), "teknis");
					array_push($temp, $temps);
					if (is_array($temps)) {
						echo $temps[1];
						exit();
					}
				} else {
					array_push($temp, "");
				}
			}
			$post['attachment'] = $temp;

			$this->session->set_userdata("teknis", $post);
			echo "1";
		} else if ($section == "komersial") {

			// start header

			if (empty($post["bid_bond_input"])) {
				$post["bid_bond_input"] = 0;
			}
			$this->db->trans_begin();

			if ($post["modo"] == "insert") {

				$input = array(
					"ptm_number" => $post["tenderids"],
					"ptv_vendor_code" => $this->session->userdata("userid"),
					"pqm_number" => $post["nopenawaran"],
					"pqm_type" => $post["tipepenawaran"],
					"pqm_bid_bond_value" => $post["bid_bond_input"],
					"pqm_local_content" => !empty($post["kandunganlokal"]) ? $post["kandunganlokal"] : null,
					"pqm_deliverable_time" => $post["penyerahan_t"],
					"pqm_deliverable_unit" => $post["penyerahan_u"],
					"pqm_guarantee_time" => $post["garansi_t"],
					"pqm_guarantee_unit" => $post["garansi_u"],
					"pqm_valid_thru" => $post["berlakuhingga"],
					"pqm_notes" => $post["catatan"],
					"pqm_currency" => $post["pqm_currency"],
					"pqm_rate_curs" => $pqm_rate_curs,
					"pqm_created_date" => date("Y-m-d H:i:s"),
				);

				$f = $this->session->userdata("files");
				$fq = $this->session->userdata("files_quo");
				if (!empty($f)) {
					$input['pqm_att'] = $f;
				}
				if (!empty($fq)) {
					$input['pqm_att_quo'] = $fq;
				}

				$result = $this->db->insert("prc_tender_quo_main", $input);
			} else if ($post["modo"] == "edit") {

				$input = array(
					"ptm_number" => $post["tenderids"],
					"ptv_vendor_code" => $this->session->userdata("userid"),
					"pqm_number" => $post["nopenawaran"],
					"pqm_type" => $post["tipepenawaran"],
					"pqm_bid_bond_value" => $post["bid_bond_input"],
					"pqm_local_content" => !empty($post["kandunganlokal"]) ? $post["kandunganlokal"] : null,
					"pqm_deliverable_time" => $post["penyerahan_t"],
					"pqm_deliverable_unit" => $post["penyerahan_u"],
					"pqm_guarantee_time" => $post["garansi_t"],
					"pqm_guarantee_unit" => $post["garansi_u"],
					"pqm_valid_thru" => $post["berlakuhingga"],
					"pqm_notes" => $post["catatan"],
					"pqm_currency" => $post["pqm_currency"],
					"pqm_rate_curs" => $pqm_rate_curs,
					"pqm_created_date" => date("Y-m-d H:i:s"),
				);

				$f = $this->session->userdata("files");
				$fq = $this->session->userdata("files_quo");
				if (!empty($f)) {
					$input['pqm_att'] = $f;
				}
				if (!empty($fq)) {
					$input['pqm_att_quo'] = $fq;
				}

				$result = $this->db->where("pqm_id", $post["pqmid"])->update("prc_tender_quo_main", $input);
			}


			if ($this->db->affected_rows($result) > 0) {
				if ($post["modo"] == "insert") {
					$no_penawaran = $this->db->query("SELECT pqm_id from prc_tender_quo_main where ptm_number = '" . $post["tenderid"] . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
				} else if ($post["modo"] == "edit") {
					$no_penawaran["pqm_id"] = $post["pqmid"];
				}
			} else {
				$statuss = FALSE;
				$this->db->trans_rollback();
				echo "2a";
				exit();
			}
			$this->session->unset_userdata("header");
			//end of header

			if ($statuss == TRUE) {
				//start of adm
				$post = $this->session->userdata("adm");
				$post["modo"] = $this->input->post("modo");
				$num_adm = $post["num_adm"];
				$affected = 0;
				for ($i = 1; $i < $num_adm; $i++) {
					if ($post["radio_" . $i] == "1") {
						$check = "1";
					} else {
						$check = "0";
					}
					if ($post["modo"] == "insert") {

						$result = $this->db->insert("prc_tender_quo_tech", array(
							"pqm_id"			=> $no_penawaran["pqm_id"],
							"pqt_item"			=> $post["desks_" . $i],
							"pqt_check_vendor" 	=> $check,
							"pqt_attachment"	=> $post["attachment"][$i - 1],
						));
					} else if ($post["modo"] == "edit") {
						if (empty($post["attachment"][$i - 1])) {
							$this->db->select("pqt_attachment");
							$this->db->where("pqt_id", $post["pqtids_" . $i]);
							$tmps = $this->db->get("prc_tender_quo_tech")->row_array();
							$post["attachment"][$i - 1] = $tmps["pqt_attachment"];
						}

						$result = $this->db->where("pqt_id", $post["pqtids_" . $i])
							->update("prc_tender_quo_tech", array(
								"pqt_check_vendor" 	=> $check,
								"pqt_attachment"	=> $post["attachment"][$i - 1],
							));
					}
					$affected = $affected + $this->db->affected_rows($result);
					if ($this->db->affected_rows($result) == 0) {
						$this->db->select("pqt_check_vendor, pqt_attachment");
						$this->db->where("pqt_id", $post["pqtids_" . $i]);
						$tmps = $this->db->get("prc_tender_quo_tech")->row_array();
						if (($check == $tmps['pqt_check_vendor']) &&  ($post["attachment"][$i - 1] == $tmps['pqt_attachment'])) {
							$affected += 1;
						}
					}
				}
				if ($affected != ($num_adm - 1)) {
					$statuss = FALSE;
					$this->db->trans_rollback();
					echo "3a";
					exit();
				}
				$this->session->unset_userdata("adm");
				//end of adm
			}

			if ($statuss == TRUE) {
				//start of teknis
				$post = $this->session->userdata("teknis");
				$post["modo"] = $this->input->post("modo");
				$num_tek = $post["num_tek"];
				$affected = 0;
				for ($i = 1; $i < $num_tek; $i++) {

					if ($post["modo"] == "insert") {

						$result = $this->db->insert("prc_tender_quo_tech", array(
							"pqm_id"			=> $no_penawaran["pqm_id"],
							"pqt_item"			=> $post["desk_" . $i],
							"pqt_weight"		=> $post["weight_" . $i],
							"pqt_vendor_desc"	=> $post["respon_" . $i],
							"pqt_attachment"	=> $post["attachment"][$i - 1],
						));
					} else if ($post["modo"] == "edit") {

						if (empty($post["attachment"][$i - 1])) {
							$this->db->select("pqt_attachment");
							$this->db->where("pqt_id", $post["pqtid_" . $i]);
							$tmps = $this->db->get("prc_tender_quo_tech")->row_array();
							$post["attachment"][$i - 1] = $tmps["pqt_attachment"];
						}

						$result = $this->db->where("pqt_id", $post["pqtid_" . $i])
							->update("prc_tender_quo_tech", array(
								"pqt_vendor_desc"	=> $post["respon_" . $i],
								"pqt_attachment"	=> $post["attachment"][$i - 1],
							));
					}
					$affected = $affected + $this->db->affected_rows($result);
					if ($this->db->affected_rows($result) == 0) {
						$this->db->select("pqt_vendor_desc, pqt_attachment");
						$this->db->where("pqt_id", $post["pqtid_" . $i]);
						$tmps = $this->db->get("prc_tender_quo_tech")->row_array();
						if (($post["respon_" . $i] == $tmps['pqt_vendor_desc']) &&  ($post["attachment"][$i - 1] == $tmps['pqt_attachment'])) {
							$affected += 1;
						}
					}
				}
				if ($affected != ($num_tek - 1)) {
					$statuss = FALSE;
					$this->db->trans_rollback();
					echo "4a";
					exit();
				}
				$this->session->unset_userdata("teknis");
				//end of teknis
			}

			if ($statuss == TRUE) {
				//start of komersial
				$post = $this->input->post();
				$num_item = $post["num_item"];
				$affected = 0;
				for ($i = 1; $i < $num_item; $i++) {
					if ($post["tipe_penawaran"] == 'A' || $post["qty_" . $i . "_input"] > 0 && $post["price_" . $i . "_input"] > 0) {

						if ($post["modo"] == "insert") {

							$input = array(
								"pqm_id" => $no_penawaran["pqm_id"],
								"tit_id" => $post["tit_" . $i],
								"pqi_description" => $post["desc_" . $i],
								"pqi_quantity" => floatval($post["qty_" . $i . "_input"]),
								"pqi_price" => ($post["price_" . $i . "_input"] * $pqm_rate_curs),
								"pqi_ppn" => !empty($post["ppn_" . $i]) ? $post["ppn_" . $i] : 0,
								"pqi_pph" => !empty($post["pph_" . $i]) ? $post["pph_" . $i] : 0,
								"pqi_guarantee" => $post["guarantee_" . $i],
								"pqi_deliverable" => $post["deliverable_" . $i],
								"pqi_guarantee_type" => $post["guarantee_type_" . $i],
								"pqi_deliverable_type" => $post["deliverable_type_" . $i],
							);

							$result = $this->db->insert("prc_tender_quo_item", $input);
						} else if ($post["modo"] == "edit") {

							$input = array(
								"pqi_description" => $post["desc_" . $i],
								"pqi_quantity" => floatval($post["qty_" . $i . "_input"]),
								"pqi_price" => ((int)$post["price_" . $i . "_input"] * (int)$pqm_rate_curs),
								"pqi_ppn" => !empty($post["ppn_" . $i]) ? $post["ppn_" . $i] : 0,
								"pqi_pph" => !empty($post["pph_" . $i]) ? $post["pph_" . $i] : 0,
								"pqi_guarantee" => $post["guarantee_" . $i],
								"pqi_deliverable" => $post["deliverable_" . $i],
								"pqi_guarantee_type" => $post["guarantee_type_" . $i],
								"pqi_deliverable_type" => $post["deliverable_type_" . $i],
							);

							$result = $this->db->where("pqi_id", $post["pqiid_" . $i])->update("prc_tender_quo_item", $input);
						}

						$affected = $affected + $this->db->affected_rows($result);
						if ($this->db->affected_rows($result) == 0) {
							$this->db->select("pqi_description, pqi_quantity, pqi_price");
							$this->db->where("pqi_id", $post["pqiid_" . $i]);
							$tmps = $this->db->get("prc_tender_quo_item")->row_array();
							if (($post["desc_" . $i] == $tmps['pqi_description']) &&  ($post["qty_" . $i . "_input"] == $tmps['pqi_quantity']) &&  ($post["price_" . $i . "_input"] == $tmps['pqi_price'])) {
								$affected += 1;
							}
						}
					}
				}
				if ($affected == ($num_item - 1)) {

					if ($post["submitStatus"] == "draft") {
						$pvs_status = 2;
					} else {
						$pvs_status = 3;
					}

					if ($post["modo"] == "insert") {

						$check = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderids"]))->get("prc_tender_vendor_status")->num_rows();


						if (!empty($check)) {
							$result = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderids"]))->update("prc_tender_vendor_status", array("pvs_status" => $pvs_status));
						} else {
							$result = $this->db->insert("prc_tender_vendor_status", array(
								"pvs_status" => $pvs_status,
								"pvs_vendor_code" => $this->session->userdata("userid"),
								"ptm_number" => $post["tenderids"]
							));
						}

						if ($this->db->affected_rows($result) > 0) {
						} else {
							$statuss = FALSE;
							$this->db->trans_rollback();
							echo "5a";
							exit();
						}
					} else if ($post["modo"] == "edit") {

						$check = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderids"]))->get("prc_tender_vendor_status")->num_rows();

						if (!empty($check)) {
							$result = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderids"]))->update("prc_tender_vendor_status", array("pvs_status" => $pvs_status));
						} else {
							$result = $this->db->insert("prc_tender_vendor_status", array(
								"pvs_status" => $pvs_status,
								"pvs_vendor_code" => $this->session->userdata("userid"),
								"ptm_number" => $post["tenderids"]
							));
						}
					}
				}

				if ($statuss == TRUE) {
					$this->db->trans_commit();
					$query = "SELECT a.ptv_vendor_code, sum(b.pqi_price * b.pqi_quantity) AS jumlah
					FROM prc_tender_quo_main a JOIN prc_tender_quo_item b ON a.pqm_id = b.pqm_id
					WHERE ptm_number = '" . $post["tenderids"] . "'
					GROUP BY ptv_vendor_code
					ORDER BY jumlah ASC";

					$urutan = $this->db->query($query)->result_array();

					$tmp = 1;

					$rank = 1;

					foreach ($urutan as $urutan) {
						if ($urutan["ptv_vendor_code"] == $this->session->userdata("userid")) {
							$rank = $tmp;
						}
						$tmp++;
					}

					echo $rank;
				}
				//end of komersial
			}
		} else if ($section == "detail_item") {
			$loop = $this->input->post();
			$prc_number = $this->db->where("ptm_number", $post["tenderids"]);
			$prc_number = $this->db->get("prc_tender_main")->row_array();
			$input_item_detail = array();
			$input_item_detail_edit = array();

			
			
			foreach ($post as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key2 => $value2) {
						if (isset($post['id_tbl'][$key2])) {
							$input_item_detail_edit[$key2]['id'] = (isset($post['id_tbl'][$key2])) ? $post['id_tbl'][$key2] : "";
							$input_item_detail_edit[$key2]['rsd_item'] = (isset($post['rsd_item_tbl'][$key2])) ? $post['rsd_item_tbl'][$key2] : "";
							$input_item_detail_edit[$key2]['rsd_keterangan'] = (isset($post['rsd_keterangan_tbl'][$key2])) ? $post['rsd_keterangan_tbl'][$key2] : "";
							$input_item_detail_edit[$key2]['rsd_volume'] = (isset($post['rsd_volume_tbl'][$key2])) ? $post['rsd_volume_tbl'][$key2] : "";
							$input_item_detail_edit[$key2]['rsd_satuan'] = (isset($post['rsd_satuan_tbl'][$key2])) ? $post['rsd_satuan_tbl'][$key2] : "";
							$input_item_detail_edit[$key2]['rsd_harga_satuan'] = (isset($post['rsd_harga_satuan_tbl'][$key2])) ? $post['rsd_harga_satuan_tbl'][$key2] : "";
							$input_item_detail_edit[$key2]['rsd_subtotal'] = (isset($post['rsd_subtotal_tbl'][$key2])) ? $post['rsd_subtotal_tbl'][$key2] : "";
						} 
						if (isset($post['rsd_item_tbl'][$key2])) {
							$input_item_detail[$key2]['rsd_item'] = (isset($post['rsd_item_tbl'][$key2])) ? $post['rsd_item_tbl'][$key2] : "";
							$input_item_detail[$key2]['rsd_keterangan'] = (isset($post['rsd_keterangan_tbl'][$key2])) ? $post['rsd_keterangan_tbl'][$key2] : "";
							$input_item_detail[$key2]['rsd_volume'] = (isset($post['rsd_volume_tbl'][$key2])) ? $post['rsd_volume_tbl'][$key2] : "";
							$input_item_detail[$key2]['rsd_satuan'] = (isset($post['rsd_satuan_tbl'][$key2])) ? $post['rsd_satuan_tbl'][$key2] : "";
							$input_item_detail[$key2]['rsd_harga_satuan'] = (isset($post['rsd_harga_satuan_tbl'][$key2])) ? $post['rsd_harga_satuan_tbl'][$key2] : "";
							$input_item_detail[$key2]['rsd_subtotal'] = (isset($post['rsd_subtotal_tbl'][$key2])) ? $post['rsd_subtotal_tbl'][$key2] : "";
						}
					}
				}
			}

			
			
			$this->db->where('pr_number', $prc_number['pr_number']);
			$del = $this->db->delete('prc_risiko_detail');

			foreach ($input_item_detail as $value) {
				$value['pr_number'] = $prc_number['pr_number'];
				$act = $this->db->insert("prc_risiko_detail", $value);
				$act = $this->db->affected_rows();
			}
		}

		exit();
	}

	public function submit_duatahap()
	{
		$section = $this->input->post("section");
		$head = (!empty($this->session->userdata("header"))) ? $this->session->userdata("header") : array();
		$post = array_merge($head, $this->input->post());
		$statuss = TRUE;
		if ($section == "header") {
			$this->session->set_userdata("header", $post);

			if (!empty($_FILES['lampiran_penawaran']['name'])) {
				$files_quo = $this->do_upload('lampiran_penawaran', $this->session->userdata("userid"), "penawaran");
				if (is_array($files_quo)) {
					echo $files_quo[1];
					exit();
				}
			} else {
				$files_quo = "";
			}
			$this->session->set_userdata("files_quo", $files_quo);

			echo "1";
		} else if ($section == "bidbond") {
			$this->session->set_userdata("header", $post);
			if (!empty($_FILES['lampiran_bidbond']['name'])) {
				$files = $this->do_upload('lampiran_bidbond', $this->session->userdata("userid"), "bidbond");
				if (is_array($files)) {
					echo $files[1];
					exit();
				}
			} else {
				$files = "";
			}
			$this->session->set_userdata("files", $files);
		} else if ($section == "adm") {
			$temp = [];
			for ($i = 1; $i < $post['num_adm']; $i++) {
				if (!empty($_FILES['lampiran_adm_' . $i]['name'])) {
					$temps = $this->do_upload('lampiran_adm_' . $i, $this->session->userdata("userid"), "administrasi");
					array_push($temp, $temps);
					if (is_array($temps)) {
						echo $temps[1];
						exit();
					}
				} else {
					array_push($temp, "");
				}
			}
			$post['attachment'] = $temp;

			$this->session->set_userdata("adm", $post);
			echo "1";
		} else if ($section == "teknis") {

			$temp = [];
			for ($i = 1; $i < $post['num_tek']; $i++) {
				if (!empty($_FILES['lampiran_tek_' . $i]['name'])) {
					$temps = $this->do_upload('lampiran_tek_' . $i, $this->session->userdata("userid"), "teknis");
					array_push($temp, $temps);
					if (is_array($temps)) {
						echo $temps[1];
						exit();
					}
				} else {
					array_push($temp, "");
				}
			}
			$post['attachment'] = $temp;

			$this->session->set_userdata("teknis", $post);
			// start header
			$post = $this->session->userdata("header");
			$post["modo"] = $this->input->post("modo");
			if (empty($post["bid_bond_input"])) {
				$post["bid_bond_input"] = 0;
			}
			$this->db->trans_begin();
			$tenderid = $post["tenderid"];
			if ($post["modo"] == "insert") {

				$input = array(
					"ptm_number" => $post["tenderid"],
					"ptv_vendor_code" => $this->session->userdata("userid"),
					"pqm_number" => $post["nopenawaran"],
					"pqm_type" => $post["tipepenawaran"],
					"pqm_bid_bond_value" => $post["bid_bond_input"],
					"pqm_local_content" => !empty($post["kandunganlokal"]) ? $post["kandunganlokal"] : null,
					"pqm_valid_thru" => $post["berlakuhingga"],
					"pqm_notes" => $post["catatan"],
					"pqm_currency" => $post["pqm_currency"],
					"pqm_rate_curs" => $post["pqm_rate_curs"],
					"pqm_delivery_time" => $post["jangkawaktu"],
					"pqm_delivery_unit" => $post["timeunit"],
					"pqm_created_date" => date("Y-m-d H:i:s"),
				);

				$f = $this->session->userdata("files");
				$fq = $this->session->userdata("files_quo");
				if (!empty($f)) {
					$input['pqm_att'] = $f;
				}
				if (!empty($fq)) {
					$input['pqm_att_quo'] = $fq;
				}

				$result = $this->db->insert("prc_tender_quo_main", $input);
			} else if ($post["modo"] == "edit") {

				$input = array(
					"ptm_number" => $post["tenderid"],
					"ptv_vendor_code" => $this->session->userdata("userid"),
					"pqm_number" => $post["nopenawaran"],
					"pqm_type" => $post["tipepenawaran"],
					"pqm_bid_bond_value" => $post["bid_bond_input"],
					"pqm_local_content" => !empty($post["kandunganlokal"]) ? $post["kandunganlokal"] : null,
					"pqm_deliverable_time" => $post["penyerahan_t"],
					"pqm_deliverable_unit" => $post["penyerahan_u"],
					"pqm_guarantee_time" => $post["garansi_t"],
					"pqm_guarantee_unit" => $post["garansi_u"],
					"pqm_valid_thru" => $post["berlakuhingga"],
					"pqm_notes" => $post["catatan"],
					"pqm_currency" => $post["pqm_currency"],
					"pqm_rate_curs" => $post["pqm_rate_curs"],
					"pqm_delivery_time" => $post["jangkawaktu"],
					"pqm_delivery_unit" => $post["timeunit"],
					"pqm_created_date" => date("Y-m-d H:i:s"),
				);

				$f = $this->session->userdata("files");
				$fq = $this->session->userdata("files_quo");
				if (!empty($f)) {
					$input['pqm_att'] = $f;
				}
				if (!empty($fq)) {
					$input['pqm_att_quo'] = $fq;
				}

				$result = $this->db->where("pqm_id", $post["pqmid"])->update("prc_tender_quo_main", $input);
			}
			if ($this->db->affected_rows($result) > 0) {
				if ($post["modo"] == "insert") {
					$no_penawaran = $this->db->query("SELECT pqm_id from prc_tender_quo_main where ptm_number = '" . $post["tenderid"] . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
				} else if ($post["modo"] == "edit") {
					$no_penawaran["pqm_id"] = $post["pqmid"];
				}
			} else {
				$statuss = FALSE;
				$this->db->trans_rollback();
				echo "2a";
				exit();
			}
			$this->session->unset_userdata("header");
			//end of header

			if ($statuss == TRUE) {
				//start of adm
				$post = $this->session->userdata("adm");
				$post["modo"] = $this->input->post("modo");
				$num_adm = $post["num_adm"];
				$affected = 0;
				for ($i = 1; $i < $num_adm; $i++) {

					if ($post["radio_" . $i] == "1") {
						$check = "1";
					} else {
						$check = "0";
					}

					if ($post["modo"] == "insert") {


						$result = $this->db->insert("prc_tender_quo_tech", array(
							"pqm_id"			=> $no_penawaran["pqm_id"],
							"pqt_item"			=> $post["desks_" . $i],
							"pqt_check_vendor" 	=> $check,
							"pqt_attachment"	=> $post["attachment"][$i - 1]
						));
					} else if ($post["modo"] == "edit") {

						if (empty($post["attachment"][$i - 1])) {
							$this->db->select("pqt_attachment");
							$this->db->where("pqt_id", $post["pqtids_" . $i]);
							$tmps = $this->db->get("prc_tender_quo_tech")->row_array();
							$post["attachment"][$i - 1] = $tmps["pqt_attachment"];
						}

						$result = $this->db->where("pqt_id", $post["pqtids_" . $i])->update("prc_tender_quo_tech", array(
							"pqt_check_vendor" 	=> $check,
							"pqt_attachment"	=> $post["attachment"][$i - 1]
						));
					}

					$affected = $affected + $this->db->affected_rows($result);
				}

				if ($affected != ($num_adm - 1)) {
					$statuss = FALSE;
					$this->db->trans_rollback();
					echo "3a";
					exit();
				}

				$this->session->unset_userdata("adm");
				//end of adm
			}

			if ($statuss == TRUE) {
				//start of teknis
				$post = $this->session->userdata("teknis");
				$post["modo"] = $this->input->post("modo");
				$num_tek = $post["num_tek"];
				$affected = 0;
				for ($i = 1; $i < $num_tek; $i++) {

					if ($post["modo"] == "insert") {

						$result = $this->db->insert("prc_tender_quo_tech", array(
							"pqm_id"			=> $no_penawaran["pqm_id"],
							"pqt_item"			=> $post["desk_" . $i],
							"pqt_weight" 		=> $post["weight_" . $i],
							"pqt_vendor_desc"	=> $post["respon_" . $i],
							"pqt_attachment"	=> $post["attachment"][$i - 1]
						));
					} else if ($post["modo"] == "edit") {

						if (empty($post["attachment"][$i - 1])) {
							$this->db->select("pqt_attachment");
							$this->db->where("pqt_id", $post["pqtid_" . $i]);
							$tmps = $this->db->get("prc_tender_quo_tech")->row_array();
							$post["attachment"][$i - 1] = $tmps["pqt_attachment"];
						}

						$result = $this->db->where("pqt_id", $post["pqtid_" . $i])
							->update("prc_tender_quo_tech", array(
								"pqt_vendor_desc"	=> $post["respon_" . $i],
								"pqt_attachment"	=> $post["attachment"][$i - 1]
							));
					}

					$affected = $affected + $this->db->affected_rows($result);
				}

				if ($affected != ($num_tek - 1)) {
					$statuss = FALSE;
					$this->db->trans_rollback();
					echo "4a";
					exit();
				}
				$this->session->unset_userdata("teknis");
				//end of teknis
			}

			if ($statuss == TRUE) {
				if ($post["modo"] == "insert") {
					/*tenderids=>tenderid hlmifzi*/
					$check = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderid"]))->get("prc_tender_vendor_status")->num_rows();

					if (!empty($check)) {
						$result = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderid"]))->update("prc_tender_vendor_status", array("pvs_status" => 21));
						/*end*/
					} else {
						$result = $this->db->insert("prc_tender_vendor_status", array(
							"pvs_status" => 21,
							"pvs_vendor_code" => $this->session->userdata("userid"),
							"ptm_number" => $post["tenderids"]
						));
					}

					if ($this->db->affected_rows($result) > 0) {
					} else {
						$statuss = FALSE;
						$this->db->trans_rollback();
						echo "5a";
						exit();
					}
				}
			}

			if ($statuss == TRUE) {
				$this->db->trans_commit();
				echo "999";
			}
		} else if ($section == "komersial") {
			$post = $this->input->post();
			if ($post["modo"] == "insert") {
				$no_penawaran = $this->db->query("SELECT pqm_id from prc_tender_quo_main where ptm_number = '" . $post["tenderids"] . "' and ptv_vendor_code = '" . $this->session->userdata("userid") . "'")->row_array();
			} else if ($post["modo"] == "edit") {
				$no_penawaran["pqm_id"] = $post["pqmid"];
			}
			$statuss = TRUE;
			$this->db->trans_begin();

			$num_item = $post["num_item"];
			$affected = 0;
			for ($i = 1; $i < $num_item; $i++) {
				if ($post["qty_" . $i . "_input"] > 0 && $post["price_" . $i . "_input"] > 0) {
					if ($post["modo"] == "insert") {

						$result = $this->db->insert("prc_tender_quo_item", array(
							"pqm_id"			=> $no_penawaran["pqm_id"],
							"tit_id"			=> $post["tit_" . $i],
							"pqi_description"	=> $post["desc_" . $i],
							"pqi_quantity"		=> $post["qty_" . $i . "_input"],
							"pqi_price"			=> ($post["price_" . $i . "_input"] * $post["pqm_rate_curs"]),
							"pqi_ppn"			=> 0, //!empty($post["ppn_".$i]) ? $post["ppn_".$i] : 0,
							"pqi_pph"			=> 0 //!empty($post["pph_".$i]) ? $post["pph_".$i] : 0,
						));
					} else if ($post["modo"] == "edit") {

						$result = $this->db->where("pqi_id", $post["pqiid_" . $i])
							->update("prc_tender_quo_item", array(
								"pqi_description"	=> $post["desc_" . $i],
								"pqi_quantity"		=> $post["qty_" . $i . "_input"],
								"pqi_price"			=> ($post["price_" . $i . "_input"] * $post["pqm_rate_curs"]),
								"pqi_ppn"			=> 0, //!empty($post["ppn_".$i]) ? $post["ppn_".$i] : 0,
								"pqi_pph"			=> 0 //!empty($post["pph_".$i]) ? $post["pph_".$i] : 0,
							));
					}
					$affected = $affected + $this->db->affected_rows($result);
				}
			}
			if ($affected == ($num_item - 1)) {
				if ($post["modo"] == "insert") {

					$check = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderids"]))->get("prc_tender_vendor_status")->num_rows();

					if (!empty($check)) {
						$result = $this->db->where(array("pvs_vendor_code" => $this->session->userdata("userid"), "ptm_number" => $post["tenderids"]))->update("prc_tender_vendor_status", array("pvs_status" => 21));
					} else {
						$result = $this->db->insert("prc_tender_vendor_status", array(
							"pvs_status" => 21,
							"pvs_vendor_code" => $this->session->userdata("userid"),
							"ptm_number" => $post["tenderids"]
						));
					}

					if ($this->db->affected_rows($result) > 0) {
					} else {
						$statuss = FALSE;
						$this->db->trans_rollback();
						echo "5a";
						exit();
					}
				}
			} else {
				$statuss = FALSE;
				$this->db->trans_rollback();
				echo "6a";
				exit();
			}

			if ($statuss == TRUE) {
				$this->db->trans_commit();

				$query = "SELECT a.ptv_vendor_code, sum(b.pqi_price * b.pqi_quantity) AS jumlah
				FROM prc_tender_quo_main a JOIN prc_tender_quo_item b ON a.pqm_id = b.pqm_id
				WHERE ptm_number = '" . $post["tenderids"] . "'
				GROUP BY ptv_vendor_code
				ORDER BY jumlah ASC";

				$urutan = $this->db->query($query)->result_array();

				$tmp = 1;

				foreach ($urutan as $urutan) {
					if ($urutan["ptv_vendor_code"] == $this->session->userdata("userid")) {
						$rank = $tmp;
					}
					$tmp++;
				}

				echo $rank;
			}
			//end of komersial
		}
	}

	public function submitnegos()
	{
		$section = $this->input->post("section");
		$head = (!empty($this->session->userdata("header"))) ? $this->session->userdata("header") : array();
		$post = array_merge($head, $this->input->post());
		$statuss = TRUE;
		
		if ($section == "header") {
			$this->session->set_userdata("header", $post);

			if (!empty($_FILES['lampiran_penawaran']['name'])) {
				$files_quo = $this->do_upload('lampiran_penawaran', $this->session->userdata("userid"), "penawaran");
				if (is_array($files_quo)) {
					echo $files_quo[1];
					exit();
				}
			} else {
				$files_quo = "";
			}
			$this->session->set_userdata("files_quo", $files_quo);

			echo "1";
		} else if ($section == "bidbond") {
			$this->session->set_userdata("header", $post);
			if (!empty($_FILES['lampiran_bidbond']['name'])) {
				$files = $this->do_upload('lampiran_bidbond', $this->session->userdata("userid"), "bidbond");
				if (is_array($files)) {
					echo $files[1];
					exit();
				}
			} else {
				$files = "";
			}
			$this->session->set_userdata("files", $files);
		} else if ($section == "komersial") {

			// start header
			$post = $this->session->userdata("header");
			if (empty($post["bid_bond_input"])) {
				$post["bid_bond_input"] = 0;
			}
			$this->db->trans_begin();

			$result = $this->db->query("select * from prc_tender_quo_main where pqm_id = " . $post["pqmid"]);

			if ($this->db->affected_rows($result) > 0) {
				$posts = $result->row_array();

				//y insert penawaran terakhir ke history
				$lastquo = $this->db->where(array('pqm_id' => $post['pqmid']))->get('prc_tender_quo_main')->row_array();
				$inn = array(
					"pqm_id" => $lastquo["pqm_id"],
					"ptm_number" => $lastquo["ptm_number"],
					"ptv_vendor_code" => $lastquo["ptv_vendor_code"],
					"pqm_number" => $lastquo["pqm_number"],
					"pqm_type" => $lastquo["pqm_type"],
					"pqm_bid_bond_value" => $lastquo["pqm_bid_bond_value"],
					"pqm_local_content" => $lastquo["pqm_local_content"],
					"pqm_deliverable_time" => $lastquo["pqm_deliverable_time"],
					"pqm_deliverable_unit" => $lastquo["pqm_deliverable_unit"],
					"pqm_guarantee_time" => $lastquo["pqm_guarantee_time"],
					"pqm_guarantee_unit" => $lastquo["pqm_guarantee_unit"],
					"pqm_valid_thru" => $lastquo["pqm_valid_thru"],
					"pqm_notes" => $lastquo["pqm_notes"],
					"pqm_currency" => $post["pqm_currency"],
					"pqm_rate_curs" => $post["pqm_rate_curs"],
					"pqm_created_date" => $lastquo["pqm_created_date"],
					"pqm_att" => $lastquo["pqm_att"],
					"pqm_att_quo" => $lastquo["pqm_att_quo"],
				);

				$rslt = $this->db->insert("prc_tender_quo_main_hist", $inn);

				//y end

			} else {
				$statuss = FALSE;
				$this->db->trans_rollback();
				echo "2a1";
				exit();
			}
			if ($this->db->affected_rows($result) > 0) {

				$tmp = $this->db->query("select max(pqm_hist_id) as maks from prc_tender_quo_main_hist where ptm_number = '" . $posts["ptm_number"] . "' and ptv_vendor_code = '" . $posts["ptv_vendor_code"] . "'")->row_array();
				$no_penawaran["pqi_hist_id"] = $tmp["maks"];

				$input = array(
					"pqm_id" => $post["pqmid"],
					"ptm_number" => $post["tenderid"],
					"ptv_vendor_code" => $this->session->userdata("userid"),
					"pqm_number" => $post["nopenawaran"],
					"pqm_type" => $post["tipepenawaran"],
					"pqm_bid_bond_value" => $post["bid_bond_input"],
					"pqm_local_content" => !empty($post["kandunganlokal"]) ? $post["kandunganlokal"] : null,
					"pqm_deliverable_time" => $post["penyerahan_t"],
					"pqm_deliverable_unit" => $post["penyerahan_u"],
					"pqm_guarantee_time" => $post["garansi_t"],
					"pqm_guarantee_unit" => $post["garansi_u"],
					"pqm_valid_thru" => $post["berlakuhingga"],
					"pqm_notes" => $post["catatan"],
					"pqm_currency" => $post["pqm_currency"],
					"pqm_rate_curs" => $post["pqm_rate_curs"],
					"pqm_created_date" => date("Y-m-d H:i:s"),
				);

				$f = $this->session->userdata("files");
				$fq = $this->session->userdata("files_quo");
				if (!empty($f)) {
					$input['pqm_att'] = $f;
				} else {
					$lastatt = $this->db->where(array("pqm_id" => $post["pqmid"]))->get("prc_tender_quo_main")->row_array();
					$input['pqm_att'] = $lastatt["pqm_att"];
				}
				if (!empty($fq)) {
					$input['pqm_att_quo'] = $fq;
				} else {
					$lastattquo = $this->db->where(array("pqm_id" => $post["pqmid"]))->get("prc_tender_quo_main")->row_array();
					$input['pqm_att_quo'] = $lastattquo["pqm_att_quo"];
				}

				$result = $this->db->where("pqm_id", $post['pqmid'])->update("prc_tender_quo_main", $input);
			} else {
				$statuss = FALSE;
				$this->db->trans_rollback();
				echo "2a2";
				exit();
			}
			if ($this->db->affected_rows($result) > 0) {
				$no_penawaran["pqm_id"] = $post["pqmid"];
			} else {
				$statuss = FALSE;
				$this->db->trans_rollback();
				echo "2a3";
				exit();
			}
			$this->session->unset_userdata("header");
			//end of header

			if ($statuss == TRUE) {
				//start of komersial
				$post = $this->input->post();
				$num_item = $post["num_item"];
				$affected = 0;

				$temp = $this->db->where("pqm_id", $no_penawaran["pqm_id"])->get("prc_tender_quo_item")->result_array();
				foreach ($temp as $row) {
					$row['pqm_hist_id'] = $no_penawaran["pqi_hist_id"];
					unset($row['pqm_id']);
					unset($row['pqi_id']);
					$result = $this->db->insert('prc_tender_quo_item_hist', $row);
					$affected = $affected + $this->db->affected_rows($result);
				}
				
				if ($affected == ($num_item - 1)) {
					$affected = 0;
					for ($i = 1; $i < $num_item; $i++) {
						if ($post["qty_" . $i . "_input"] > 0 && $post["price_" . $i . "_input"] > 0) {
							$input = array(
								"pqi_description" => $post["desc_" . $i],
								"pqi_quantity" => floatval($post["qty_" . $i . "_input"]),
								"pqi_price" => (isset($post["pqm_rate_curs"]) ? $post["price_" . $i . "_input"] * $post["pqm_rate_curs"] : $post["price_" . $i . "_input"]),
								"pqi_ppn" => !empty($post["ppn_" . $i]) ? $post["ppn_" . $i] : 0,
								"pqi_pph" => !empty($post["pph_" . $i]) ? $post["pph_" . $i] : 0,
								"pqi_guarantee" => $post["guarantee_" . $i],
								"pqi_deliverable" => $post["deliverable_" . $i],
								"pqi_guarantee_type" => $post["guarantee_type_" . $i],
								"pqi_deliverable_type" => $post["deliverable_type_" . $i],
							);

							$result = $this->db->where("pqi_id", $post["pqiid_" . $i])->update("prc_tender_quo_item", $input);
							$affected = $affected + $this->db->affected_rows($result);
						}
					}
				} else {
					$statuss = FALSE;
					$this->db->trans_rollback();
					echo "6a2";
					exit();
				}
			}

			if ($statuss == TRUE) {
				$this->db->trans_commit();
				echo '1';
			}
			//end of komersial
		}
	}

	public function submit_nego()
	{

		$post = $this->input->post();

		$result = $this->db->insert("prc_bidder_message", array(
			"ptm_number"		=> $post["ptm_number"],
			"awa_id"			=> $post["pta_id"],
			"pbm_vendor_code"	=> $this->session->userdata("userid"),
			"pbm_message"		=> $post["comment"],
			"pbm_date"			=> date("Y-m-d H:i:s"),
		));

		if ($this->db->affected_rows($result) > 0) {
			echo "1";
		} else {
			echo "0";
		}
	}
}
