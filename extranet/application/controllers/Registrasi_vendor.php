<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi_vendor extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array("Profile"));
		if($this->session->userdata('vendor_type') != 1 || $this->session->userdata('reg_status_id') != 0){
            redirect(site_url());
		};
	}

	public function utama()
	{
		$vendor_id = $this->session->userdata("userid");		

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$this->db->where('vendor_id', $vendor_id);
		$kontak = $this->db->get('vnd_kontak');

		$this->db->where('vendor_id', $vendor_id);
		$alamat = $this->db->get('vnd_alamat');

		$this->db->where('stereotype', 'PROVINCE');
		$locations = $this->db->get('adm_ref_locations');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['kontak'] = $kontak->result_array();
		$data['alamat'] = $alamat->result_array();
		$data['account'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_account')->result_array();
		$data['locations'] = $locations->result_array();
		$this->layout->view('_profile01/utama_v', $data);
	}

	public function legal()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$akta = $this->db->get('vnd_akta');

		$this->db->where('vendor_id', $vendor_id);
		$sk = $this->db->get('vnd_sk');

		$this->db->where('vendor_id', $vendor_id);
		$izin = $this->db->get('vnd_izin');

		$this->db->where('vendor_id', $vendor_id);
		$sertifikat = $this->db->get('vnd_sertifikat');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['akta'] = $akta->result_array();
		$data['sk'] = $sk->result_array();
		$data['izin'] = $izin->result_array();
		$data['sertifikat'] = $sertifikat->result_array();
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile01/legal_v', $data);
	}

	public function pajak()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$akta = $this->db->get('vnd_akta');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$this->db->where('vendor_id', $vendor_id);
		$spt = $this->db->get('vnd_spt');

		$this->db->join('adm_ref_locations loc', 'loc.location_id = vnd_alamat.location_id');
		$this->db->where('vendor_id', $vendor_id);
		$alamat = $this->db->get('vnd_alamat');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['spt'] = $spt->result_array();
		$data['alamat'] = $alamat->result_array();
		$this->layout->view('_profile01/pajak_v', $data);
	}

	public function keuangan()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$this->db->where('vendor_id', $vendor_id);
		$bank = $this->db->get('vnd_bank');

		$this->db->where('vendor_id', $vendor_id);
		$lap_keuangan = $this->db->get('vnd_fin_rpt');

		$this->db->where('vendor_id', $vendor_id);
		$this->db->where('jenis', 'listVndDnB');
		$dnb = $this->db->get('vnd_dnb');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['bank'] = $bank->result_array();
		$data['laporan'] = $lap_keuangan->result_array();
		$data['dnb'] = $dnb->result_array();
		$this->layout->view('_profile01/keuangan_v', $data);
	}

	public function saham()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$saham = $this->db->get('vnd_saham');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['saham'] = $saham->result_array();
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile01/saham_v', $data);
	}

	public function pengurus()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$pengurus = $this->db->get('vnd_board');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['pengurus'] = $pengurus->result_array();
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile01/pengurus_v', $data);
	}

	public function personil()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$personil = $this->db->get('vnd_personil');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['personil'] = $personil->result_array();
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile01/personil_v', $data);
	}

	public function pengalaman()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$pengalaman = $this->db->get('vnd_pengalaman');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['pengalaman'] = $pengalaman->result_array();
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile01/pengalaman_v', $data);
	}

	public function peralatan()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$fasilitas = $this->db->get('vnd_fasilitas');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['fasilitas'] = $fasilitas->result_array();
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile01/peralatan_v', $data);
	}

	public function produk()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$produk = $this->db->get('vnd_product');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['produk'] = $produk->result_array();
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile01/produk_v', $data);
	}

	public function catatan()
	{
		$vendor_id = $this->session->userdata("userid");
		
		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');
		
		$data = array();
		$data['dir'] = 'vendor';
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['comment_list'] = $this->Profile->getVendorComment($vendor_id, '')->result_array();
		$this->layout->view('_profile01/catatan_v', $data);
	}	

	public function documents()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');
		
		$this->db->where('vendor_id', $vendor_id);
		$dnb = $this->db->get('vnd_dnb');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['dnb'] = $dnb->result_array();

		$this->layout->view('_profile01/documents_v', $data);
	}

	public function tambahan()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$adm_cot = $this->db->get('adm_cot_kelompok');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');
		
		$this->db->where('vendor_id', $vendor_id);
		$company = $this->db->get('vnd_company');
		
		$this->db->where('vendor_id', $vendor_id);
		$bidang = $this->db->get('vnd_bidang_usaha');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['anak_1'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Bangunan Gedung Tbk')->get('vnd_anak_perusahaan')->num_rows();
		$data['anak_2'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Rekayasa Konstruksi')->get('vnd_anak_perusahaan')->num_rows();
		$data['anak_3'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Realty')->get('vnd_anak_perusahaan')->num_rows();
		$data['anak_4'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Serang Panimbang')->get('vnd_anak_perusahaan')->num_rows();
		$data['anak_5'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT WIKA Tirta Jaya Jatiluhur')->get('vnd_anak_perusahaan')->num_rows();
		$data['anak_6'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Beton Tbk')->get('vnd_anak_perusahaan')->num_rows();
		$data['anak_7'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Industri Konstruksi')->get('vnd_anak_perusahaan')->num_rows();
		$data['anak_8'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Bitumen')->get('vnd_anak_perusahaan')->num_rows();
		$data['company'] = $company->result_array();
		$data['bidang'] = $bidang->result_array();
		$data['adm_cot'] = $adm_cot->result_array();
		$this->layout->view('_profile01/tambahan_v', $data);
	}

	public function cqsms()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');
		
		$this->db->where('vendor_id', $vendor_id);
		$cqsms = $this->db->get('vnd_cqsms');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['cqsms'] = $cqsms->result_array();
		$this->layout->view('_profile01/cqsms_v', $data);
	}

	public function katalog()
	{
		$vendor_id = $this->session->userdata("userid");	

		$curl_uom = curl_init();
		$curl_tod = curl_init();

		$data = array();
		$data_uom = array();
		$data_tod = array();

		$no_uom = 0;
		$no_tod = 0;

		// uom
		curl_setopt_array($curl_uom, array(
			CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/uoms',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET'
		));

		$response_uom = curl_exec($curl_uom);

		curl_close($curl_uom);

		$arrays_uom = json_decode($response_uom, true);

		foreach ($arrays_uom["data"] as $key => $v) {
			$data_uom[$no_uom]['id'] = $v['id'];
			$data_uom[$no_uom]['name'] = $v['name'] . '(' . $v['description'] . ')';
			$no_uom++;
		}

		// tod
		curl_setopt_array($curl_tod, array(
			CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/tod',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET'
		));

		$response_tod = curl_exec($curl_tod);

		curl_close($curl_tod);

		$arrays_tod = json_decode($response_tod, true);

		foreach ($arrays_tod["data"] as $key => $v) {
			$data_tod[$no_tod]['id'] = $v['id'];
			$data_tod[$no_tod]['name'] = $v['name'];
			$no_tod++;
		}

		$data['title'] = 'Registrasi Vendor';
		$data['katalog'] = $this->db->get_where('vnd_product', array('status' => 2, 'vendor_id' => $vendor_id))->result_array();

		$data['level1'] = $this->db->get('vw_catalogue_level_1')->result_array();
		$data['get_uoms'] = $data_uom;
		$data['get_tod'] = $data_tod;

		$data['detail_vendor'] = $this->db->get_where('vnd_header', array('vendor_id' => $vendor_id))->row_array();
		$this->layout->view('_profile01/katalog_v', $data);
	}

	public function submit_data_utama()
	{
		$vendor_id = $this->session->userdata("userid");	
		$post = $this->input->post();
		$files = "";

		$n = 0;
		
		$input_bidang_usaha = array();
		$input_anak_perusahaan = array();

		if (is_uploaded_file($_FILES['upload_bukti_kontrak']['tmp_name'])) {
			$files = $this->do_upload('upload_bukti_kontrak', 'vendor', $vendor_id);
		}

		if ($this->input->post('file_lama') != NULL && $files == NULL) {
			$files = $this->input->post('file_lama');
		}

		if ($files != NULL) {

			foreach ($post as $key => $value) {

				if(is_array($value)){
		
					foreach ($value as $key2 => $value2) { 
		
						if(isset($post['tipe_bidang'][$key2])){
							$input_bidang_usaha[$key2]['type'] = $post['tipe_bidang'][$key2];
							$input_bidang_usaha[$key2]['bidang_name'] = $post['nama_bidang'][$key2];
							$input_bidang_usaha[$key2]['sub_bidang_name'] = $post['nama_sub_bidang'][$key2];
							$input_bidang_usaha[$key2]['created_date'] = date('Y-m-d h:i:s');
						}
						
						if(isset($post['anak_perusahaan'][$key2])){
							$input_anak_perusahaan[$key2]['nama_perusahaan'] = $post['anak_perusahaan'][$key2];
							$input_anak_perusahaan[$key2]['created_at'] = date('Y-m-d h:i:s');
						}
					}
		
					$n++;
		
				}
		
			}

			$this->db->trans_begin();

			if(!empty($input_bidang_usaha)){

				$deleted = array();
			
				foreach ($input_bidang_usaha as $key => $value) {
				  $value['vendor_id'] = $vendor_id;
				  $act = $this->Profile->replaceBidangUsaha($key,$value);
				  if($act){
					$deleted[] = $act;
				  }
				}
			
				$this->Profile->deleteIfNotExistBidangUsaha($vendor_id,$deleted);
			
			}

			if(!empty($input_anak_perusahaan)){

				$deleted = array();
			
				foreach ($input_anak_perusahaan as $key => $value) {
				  $value['vendor_id'] = $vendor_id;
				  $act = $this->Profile->replaceAnakPerusahaan($key,$value);
				  if($act){
					$deleted[] = $act;
				  }
				}
			
				$this->Profile->deleteIfNotExistAnakPerusahaan($vendor_id,$deleted);
			
			}

			$arr_data = [
				'fin_class' => $this->input->post('fin_class'),
				'cot_kelompok' => $this->input->post('cot_kelompok'),
				'mu_mata_uang' => $this->input->post('mu_mata_uang'),
				'md_mata_uang' => $this->input->post('md_mata_uang'),
				'nilai_pengalaman' => str_replace(".","",$this->input->post('nilai_pengalaman')),
				'kemampuan_keuangan' => str_replace(".","",$this->input->post('kemampuan_keuangan')),
				'kapasitas_produk' => str_replace(".","",$this->input->post('kapasitas_produk')),
				'mu_nilai' => str_replace(".","",$this->input->post('mu_nilai')),
				'md_nilai' => str_replace(".","",$this->input->post('md_nilai')),
				'satuan' => $this->input->post('satuan'),
				'upload_bukti_kontrak' => $files ? $files : '',
				'modified_date' => date('Y-m-d H:i:s')
			];

			$this->db->where('vendor_id', $vendor_id);
			$result = $this->db->update('vnd_header', $arr_data);

			
			$this->session->set_flashdata('tab', 'tambahan');
			if ($result) {
				$this->db->trans_commit();
				$this->session->set_flashdata('res', '1');
				return redirect('registrasi_vendor/tambahan');

			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata('res', '2');
				return redirect('registrasi_vendor/tambahan');
			}
		} else {
			$this->session->set_flashdata('tab', 'tambahan');
			$this->session->set_flashdata('res', '3');
			redirect('registrasi_vendor/tambahan');
		}
	}

	public function submit_data_profile()
	{
		$vendor_id = $this->session->userdata("userid");	
		$post = $this->input->post();
		$files = "";

		$n = 0;
	

		if (is_uploaded_file($_FILES['lampiran_profile']['tmp_name'])) {
			$files = $this->do_upload('lampiran_profile', 'vendor', $vendor_id);
		}

		if ($files != NULL) {

			$this->db->trans_begin();

			$arr_data = [
				'vendor_id' => $vendor_id,
				'tipe_file' => $this->input->post('tipe_file'),
				'lampiran' => $files ? $files : '',
				'created_at' => date('Y-m-d H:i:s')
			];

			$result = $this->db->insert('vnd_company', $arr_data);

			
			$this->session->set_flashdata('tab', 'tambahan');
			if ($result) {
				$this->db->trans_commit();
				$this->session->set_flashdata('res', '1');
				return redirect('registrasi_vendor/tambahan');

			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata('res', '2');
				return redirect('registrasi_vendor/tambahan');
			}
		} else {
			$this->session->set_flashdata('tab', 'tambahan');
			$this->session->set_flashdata('res', '5');
			redirect('registrasi_vendor/tambahan');
		}
	}

	public function submit_katalog()
	{
		$vendor_id = $this->session->userdata("userid");	
		$post = $this->input->post();

		$this->db->trans_begin();

		$level = $post['level1'];
		$product_name = '';

		if ($post['level2'] != '') { $level = $post['level2']; } 
		if ($post['level3'] != '') { $level = $post['level3']; }
		if ($post['level4'] != '') { $level = $post['level4']; }
		if ($post['level5'] != '') { $level = $post['level5']; }
		if ($post['level6'] != '') { $level = $post['level6']; }
		if ($post['level7'] != '') { $level = $post['level7']; }
		if ($post['level8'] != '') { $level = $post['level8']; }

		$cek_nama = $this->db->get_where('adm_catalogue', ['resources_code_id' => $level])->row_array();

		$item_data = array(
			'vendor_id' => $vendor_id,
			'product_name' => $cek_nama['name'],
			'product_code' => $cek_nama['code'],
			'product_description' => $cek_nama['description'],
			'level' => $cek_nama['level'],
			'tod' => $post['tod_id'],
			'uom' => $post['uom_id'],
			'note' => $post['note'],
			'status' => 2,
			'created_at' => date('Y-m-d h:i:s')
		);
		
		$result = $this->db->insert('vnd_product', $item_data);

		$this->session->set_flashdata('tab', 'katalog');

		if ($result) {
			$this->db->trans_commit();

			// $curl_log = curl_init();

			// curl_setopt_array($curl_log, array(
			// 	CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/users/token',
			// 	CURLOPT_RETURNTRANSFER => true,
			// 	CURLOPT_ENCODING => '',
			// 	CURLOPT_MAXREDIRS => 10,
			// 	CURLOPT_TIMEOUT => 0,
			// 	CURLOPT_FOLLOWLOCATION => true,
			// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// 	CURLOPT_CUSTOMREQUEST => 'POST',
			// 	CURLOPT_POSTFIELDS =>'{
			// 		"username": "admin",
			// 		"password": "wika123"
			// 	}',
			// 	CURLOPT_HTTPHEADER => array(
			// 		'Content-Type: text/plain'
			// 	),
			// ));

			// $response_log = curl_exec($curl_log);

			// curl_close($curl_log);			

			// $curl = curl_init();
			// curl_setopt_array($curl, array(
			// 	CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/product/create',
			// 	CURLOPT_RETURNTRANSFER => true,
			// 	CURLOPT_ENCODING => '',
			// 	CURLOPT_MAXREDIRS => 10,
			// 	CURLOPT_TIMEOUT => 0,
			// 	CURLOPT_FOLLOWLOCATION => true,
			// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// 	CURLOPT_CUSTOMREQUEST => 'POST',
			// 	CURLOPT_POSTFIELDS =>'{
			// 		"level1": "'.$post['level1'].'",
			// 		"level2": "'.$post['level2'].'",
			// 		"level3": "'.$post['level3'].'",
			// 		"level4": "'.$post['level4'].'",
			// 		"level5": "'.$post['level5'].'",
			// 		"level6": "'.$post['level6'].'",
			// 		"level7": "'.$post['level7'].'",
			// 		"level8": "'.$post['level8'].'",
			// 		"name": "'.$post['product_name'].'",
			// 		"note": "'.$post['note'].'",
			// 		"vendor_id": '.$vendor_id.',
			// 		"term_of_delivery_id": "'.$post['tod_id'].'",
			// 		"berat_unit": 1,
			// 		"uom_id": '.$post['uom_id'].',
			// 		"tgl_harga_valid": "",
			// 		"image": [],
			// 		"payment_product":[]
			// 	}',
			// 	CURLOPT_HTTPHEADER => array(
			// 		'token: Bearer ',
			// 		'Content-Type: text/plain'
			// 	),
			// ));

			// $response = curl_exec($curl);

			// curl_close($curl);
			$status = 1;
			echo $status;

		} else {
			$status = 3;
			$this->db->trans_rollback();
			echo $status;
		}
		
	}

	public function submit_comment()
	{
		$vendor_id = $this->session->userdata("userid");	
		$post = $this->input->post();

		$this->db->trans_begin();

		$com_data = array(
			'vendor_id' => $vendor_id,
			'vc_name' => $post['vendor_name'],
			'vc_activity' => 'Data Registrasi Telah Dilengkapi',
			'vc_start_date' => $post['syncron_date'],
			'vc_position' => 404,
			'vc_end_date' => date('Y-m-d h:i:s'),
			'vc_response' => 'Submit Data Vendor',
			'vc_comment' => $post['vc_comment'],
			'vc_activity_code' => 6089,
			'vc_active' => 1
		);
		
		$this->db->insert('vnd_comment', $com_data);

		$arr_data = [
			'reg_status_id' => 14,
			'state_now' => 1,
			'modified_date' => date('Y-m-d H:i:s')
		];

		$this->db->where('vendor_id', $vendor_id);
		$result = $this->db->update('vnd_header', $arr_data);

		$this->session->set_flashdata('tab', 'catatan');
		if ($result) {
			$this->db->trans_commit();
			$this->session->set_flashdata('res', '1');
			return redirect('registrasi_vendor/catatan');

		} else {
			$this->db->trans_rollback();
			$this->session->set_flashdata('res', '2');
			return redirect('registrasi_vendor/catatan');
		}
		
	}

	public function submit_lampiran()
	{
		$vendor_id = $this->session->userdata("userid");	
		$post = $this->input->post();
		$files = '';

		$this->db->trans_begin();

		if (is_uploaded_file($_FILES['vendor_lampiran']['tmp_name'])) {
			$files = $this->do_upload('vendor_lampiran', 'vendor', $vendor_id);
		}

		if ($this->input->post('file_lama') != NULL && $files == NULL) {
			$files = $this->input->post('file_lama');
		}

		if ($files != NULL) {
			$arr_data = [
				'vendor_lampiran' => $files ? $files : '',
				'modified_date' => date('Y-m-d H:i:s')
			];
		}


		$this->db->where('vendor_id', $vendor_id);
		$result = $this->db->update('vnd_header', $arr_data);

		$this->session->set_flashdata('tab', 'catatan');
		if ($result) {
			$this->db->trans_commit();
			$this->session->set_flashdata('res', '1');
			return redirect('registrasi_vendor/catatan');

		} else {
			$this->db->trans_rollback();
			$this->session->set_flashdata('res', '2');
			return redirect('registrasi_vendor/catatan');
		}
		
	}

	public function delete_vendor_lampiran($file) {
		
		$vendor_id = $this->session->userdata("userid");	
		$path = base_url('attachment/vendor/' . $this->session->userdata('userid') . '/') . $file;

		$this->db->trans_begin();

		$arr_data = [
			'vendor_lampiran' => '',
			'modified_date' => date('Y-m-d H:i:s')
		];

		$this->db->where('vendor_id', $vendor_id);
		$result = $this->db->update('vnd_header', $arr_data);

		$this->session->set_flashdata('tab', 'catatan');
		if ($result) {
			$this->db->trans_commit();
			
			unlink($path);

			$this->session->set_flashdata('res', '1');
			return redirect('registrasi_vendor/catatan');

		} else {
			$this->db->trans_rollback();
			$this->session->set_flashdata('res', '2');
			return redirect('registrasi_vendor/catatan');
		}
	
	}
	public function delete_katalog($id) {
		
		$vendor_id = $this->session->userdata("userid");	

		$this->db->trans_begin();

		$this->db->where('product_id', $id);
		$result = $this->db->delete('vnd_product');

		$this->session->set_flashdata('tab', 'katalog');
		if ($result) {

			$this->db->trans_commit();			
			$this->session->set_flashdata('res', '1');
			return redirect('registrasi_vendor/katalog');

		} else {

			$this->db->trans_rollback();
			$this->session->set_flashdata('res', '2');
			return redirect('registrasi_vendor/katalog');
		}
	}

	public function delete_profile_lampiran($id, $file) {
		$path = base_url('attachment/vendor/' . $this->session->userdata('userid') . '/') . $file;

		$this->db->trans_begin();
		
		$this->db->where('id', $id);
		$result = $this->db->delete('vnd_company');
		
		$this->session->set_flashdata('tab', 'tambahan');
		if ($result) {
			$this->db->trans_commit();	

			unlink($path);
			
			$this->session->set_flashdata('res', '1');
			return redirect('registrasi_vendor/tambahan');

		} else {
			$this->db->trans_rollback();
			$this->session->set_flashdata('res', '2');
			return redirect('registrasi_vendor/tambahan');
		}
	}

	public function get_level2()
    {
		$kategori = $this->input->post('kategori', true);

		$resc = $this->db->get_where('vw_catalogue_level_1', ['resources_code_id' => $kategori])->row_array();

		$level2 = $this->db->get_where('vw_catalogue_level_2', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level2 as $v2) {
			$data[$no]['id'] = $v2['id'];
			$data[$no]['resources_code_id'] = $v2['resources_code_id'];
			$data[$no]['code'] = $v2['code'];
			$data[$no]['parent_code'] = $v2['parent_code'];
			$data[$no]['name'] = $v2['name'];
			$no++;
		}
		
        echo json_encode($data);
    }

    public function get_level3()
    {
        $level2 = $this->input->post('level2', true);

		$resc = $this->db->get_where('vw_catalogue_level_2', ['resources_code_id' => $level2])->row_array();

        $level3 = $this->db->get_where('vw_catalogue_level_3', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level3 as $v3) {
			$data[$no]['id'] = $v3['id'];
			$data[$no]['resources_code_id'] = $v3['resources_code_id'];
			$data[$no]['code'] = $v3['code'];
			$data[$no]['parent_code'] = $v3['parent_code'];
			$data[$no]['name'] = $v3['name'];
			$no++;
		}

        echo json_encode($data);
    }

    public function get_level4()
    {
        $level3 = $this->input->post('level3', true);

		$resc = $this->db->get_where('vw_catalogue_level_3', ['resources_code_id' => $level3])->row_array();

        $level4 = $this->db->get_where('vw_catalogue_level_4', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level4 as $v4) {
			$data[$no]['id'] = $v4['id'];
			$data[$no]['resources_code_id'] = $v4['resources_code_id'];
			$data[$no]['code'] = $v4['code'];
			$data[$no]['parent_code'] = $v4['parent_code'];
			$data[$no]['name'] = $v4['name'];
			$no++;
		}

        echo json_encode($data);
    }

    public function get_level5()
    {
        $level4 = $this->input->post('level4', true);

		$resc = $this->db->get_where('vw_catalogue_level_4', ['resources_code_id' => $level4])->row_array();

        $level5 = $this->db->get_where('vw_catalogue_level_5', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level5 as $v5) {
			$data[$no]['id'] = $v5['id'];
			$data[$no]['resources_code_id'] = $v5['resources_code_id'];
			$data[$no]['code'] = $v5['code'];
			$data[$no]['parent_code'] = $v5['parent_code'];
			$data[$no]['name'] = $v5['name'];
			$no++;
		}

        echo json_encode($data);
    }

    public function get_level6()
    {
        $level5 = $this->input->post('level5', true);

		$resc = $this->db->get_where('vw_catalogue_level_5', ['resources_code_id' => $level5])->row_array();
        
        $level6 = $this->db->get_where('vw_catalogue_level_6', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level6 as $v6) {
			$data[$no]['id'] = $v6['id'];
			$data[$no]['resources_code_id'] = $v6['resources_code_id'];
			$data[$no]['code'] = $v6['code'];
			$data[$no]['parent_code'] = $v6['parent_code'];
			$data[$no]['name'] = $v6['name'];
			$no++;
		}

        echo json_encode($data);
    }

    public function get_level7()
    {
        $level6 = $this->input->post('level6', true);

		$resc = $this->db->get_where('vw_catalogue_level_6', ['resources_code_id' => $level6])->row_array();
        
        $level7 = $this->db->get_where('vw_catalogue_level_7', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level7 as $v7) {
			$data[$no]['id'] = $v7['id'];
			$data[$no]['resources_code_id'] = $v7['resources_code_id'];
			$data[$no]['code'] = $v7['code'];
			$data[$no]['parent_code'] = $v7['parent_code'];
			$data[$no]['name'] = $v7['name'];
			$no++;
		}

        echo json_encode($data);
    }

    public function get_level8()
    {
        $level7 = $this->input->post('level7', true);

		$resc = $this->db->get_where('vw_catalogue_level_7', ['resources_code_id' => $level7])->row_array();
        
        $level8 = $this->db->get_where('vw_catalogue_level_8', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level8 as $v8) {
			$data[$no]['id'] = $v8['id'];
			$data[$no]['resources_code_id'] = $v8['resources_code_id'];
			$data[$no]['code'] = $v8['code'];
			$data[$no]['parent_code'] = $v8['parent_code'];
			$data[$no]['name'] = $v8['name'];
			$no++;
		}

        echo json_encode($data);
    }

	public function get_regency()
    {
        $prop = $this->input->post('prop', true);
        $data = $this->db->get_where('adm_ref_locations', ['province_name' => $prop, 'stereotype' => 'REGENCY', 'row_status' => 'ACTIVE'])->result_array();
        echo json_encode($data);
    }

	public function get_district()
    {
        $prop = $this->input->post('prop', true);
        $city = $this->input->post('city', true);
        $data = $this->db->get_where('adm_ref_locations', ['province_name' => $prop, 'regency_name' => $city, 'stereotype' => 'DISTRICT', 'row_status' => 'ACTIVE'])->result_array();
        echo json_encode($data);
    }

	public function get_village()
    {
		$prop = $this->input->post('prop', true);
        $city = $this->input->post('city', true);
        $district = $this->input->post('district', true);
        $data = $this->db->get_where('adm_ref_locations', ['province_name' => $prop, 'regency_name' => $city, 'district_name' => $district, 'stereotype' => 'VILLAGE', 'row_status' => 'ACTIVE'])->result_array();
        echo json_encode($data);
    }
}
