<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi_luar_negeri extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array("Profile"));
		$this->token_katalog = isset($_COOKIE["token_katalogue"]) ? $_COOKIE["token_katalogue"] : '';
		if($this->session->userdata('vendor_type') != 3 || $this->session->userdata('reg_status_id') != 0){
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
		$data['locations'] = $locations->result_array();
		$this->layout->view('_profile03/utama_v', $data);
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
		$this->layout->view('_profile03/legal_v', $data);
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
		$this->layout->view('_profile03/pajak_v', $data);
	}

	public function keuangan()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$this->db->where('vendor_id', $vendor_id);
		$bank = $this->db->get('vnd_bank');

		$this->db->where('vendor_id', $vendor_id);
		$lap_keuangan = $this->db->get('vnd_lap_keuangan');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['bank'] = $bank->result_array();
		$data['laporan'] = $lap_keuangan->result_array();
		$this->layout->view('_profile03/keuangan_v', $data);
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
		$this->layout->view('_profile03/saham_v', $data);
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
		$this->layout->view('_profile03/pengurus_v', $data);
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
		$this->layout->view('_profile03/personil_v', $data);
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
		$this->layout->view('_profile03/pengalaman_v', $data);
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
		$this->layout->view('_profile03/peralatan_v', $data);
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
		$this->layout->view('_profile03/produk_v', $data);
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
		$this->layout->view('_profile03/catatan_v', $data);
	}	

	public function documents()
	{
		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['documents'] = glob("attachment/*.pdf");

		$this->layout->view('_profile03/documents_v', $data);
	}

	public function tambahan()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$adm_cot = $this->db->get('adm_cot_kelompok');

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');
		
		$this->db->select('vendor_id, vendor_name');
		$this->db->where('reg_status_id', 8);
		$anak_perusahaan = $this->db->get('vnd_header');

		$this->db->where('vendor_id', $vendor_id);
		$company = $this->db->get('vnd_company');
		
		$this->db->where('vendor_id', $vendor_id);
		$bidang = $this->db->get('vnd_bidang_usaha');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$data['anak_perusahaan'] = $anak_perusahaan->result_array();
		$data['company'] = $company->result_array();
		$data['bidang'] = $bidang->result_array();
		$data['adm_cot'] = $adm_cot->result_array();
		$this->layout->view('_profile03/tambahan_v', $data);
	}

	public function katalog()
	{
		$vendor_id = $this->session->userdata("userid");	

		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');
		
		$this->db->where('vendor_id', $vendor_id);
		$vnd_pengalaman = $this->db->get('vnd_pengalaman');

		$this->db->where('vendor_id', $vendor_id);
		$this->db->where('status', 1);
		$query = $this->db->get('vnd_product_ekatalog');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['katalog'] = $query->result_array();
		$data['level1m'] = '';
		$data['level1a'] = '';
		$data['level1u'] = '';
		$data['level1s'] = '';
		$data['get_uoms'] = '';
		$data['get_tod'] = '';

		if ($this->token_katalog != '') {
			$opts_item =
				array(
					'http' =>
					array(
						'method'  => 'GET',
						'header'  => "Content-Type: application/json\r\n" .
							"Authorization: " . $this->token_katalog . "\r\n",
						'timeout' => 60
					)
				);

			$context_list = stream_context_create($opts_item);

			$url_level1m = $this->config->item('api_ekatalog').'api_new/Kode_sda?name=MATERIAL';			
			$url_level1a = $this->config->item('api_ekatalog').'api_new/Kode_sda?name=ALAT';			
			$url_level1u = $this->config->item('api_ekatalog').'api_new/Kode_sda?name=UPAH';			
			$url_level1s = $this->config->item('api_ekatalog').'api_new/Kode_sda?name=SUBKON';			

			$get_level1m = file_get_contents($url_level1m, false, $context_list);				
			$get_level1a = file_get_contents($url_level1a, false, $context_list);				
			$get_level1u = file_get_contents($url_level1u, false, $context_list);				
			$get_level1s = file_get_contents($url_level1s, false, $context_list);	
			
			$opts_uoms =
				array(
					'http' =>
					array(
						'method'  => 'GET',
						'header'  => "Content-Type: application/json\r\n" .
							"Authorization: " . $this->token_katalog . "\r\n",
						'timeout' => 60
					)
				);

			$context_uoms = stream_context_create($opts_uoms);

			$url_uoms = $this->config->item('api_ekatalog').'api_new/Uoms';		

			$get_uoms = file_get_contents($url_uoms, false, $context_uoms);

			// tod
			$opts_tod =
				array(
					'http' =>
					array(
						'method'  => 'GET',
						'header'  => "Content-Type: application/json\r\n" .
							"Authorization: " . $this->token_katalog . "\r\n",
						'timeout' => 60
					)
				);

			$context_tod = stream_context_create($opts_tod);

			$url_tod = $this->config->item('api_ekatalog').'api_new/tod';		

			$get_tod = file_get_contents($url_tod, false, $context_tod);

			// pay method
			$opts_pay =
				array(
					'http' =>
					array(
						'method'  => 'GET',
						'header'  => "Content-Type: application/json\r\n" .
							"Authorization: " . $this->token_katalog . "\r\n",
						'timeout' => 60
					)
				);

			$context_pay = stream_context_create($opts_pay);

			$url_pay = $this->config->item('api_ekatalog').'api_new/Payment_method';		

			$get_pay = file_get_contents($url_pay, false, $context_pay);

			$data['level1m'] = json_decode($get_level1m, true);
			$data['level1a'] = json_decode($get_level1a, true);
			$data['level1u'] = json_decode($get_level1u, true);
			$data['level1s'] = json_decode($get_level1s, true);
			$data['get_uoms'] = json_decode($get_uoms, true);
			$data['get_tod'] = json_decode($get_tod, true);
		}

		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile03/katalog_v', $data);
	}

	public function submit_data_utama()
	{
		$vendor_id = $this->session->userdata("userid");	
		$post = $this->input->post();
		$files = "";

		$n = 0;
		
		$input_bidang_usaha = array();

		if (is_uploaded_file($_FILES['upload_bukti_kontrak']['tmp_name'])) {
			$files = $this->do_upload('upload_bukti_kontrak', 'vendor', $this->session->userdata('npwp_no_s'));
		}

		if ($this->input->post('file_lama') != NULL && $files == NULL) {
			$files = $this->input->post('file_lama');
		}

		if ($files != NULL) {

			foreach ($post as $key => $value) {

				if(is_array($value)){
		
					foreach ($value as $key2 => $value2) { 
		
						if(isset($post['tipe_bidang'][$key2])){
							$input_bidang_usaha[$key2]['vendor_id'] = $vendor_id;
							$input_bidang_usaha[$key2]['type'] = $post['tipe_bidang'][$key2];
							$input_bidang_usaha[$key2]['bidang_name'] = $post['nama_bidang'][$key2];
							$input_bidang_usaha[$key2]['sub_bidang_name'] = $post['nama_sub_bidang'][$key2];
							$input_bidang_usaha[$key2]['created_date'] = date('Y-m-d h:i:s');
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
				'anak_perusahaan' => $this->input->post('anak_perusahaan'),
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

	public function get_jenis()
    {
		$kategori = $this->input->post('kategori', true);

		$token = $_COOKIE["token_katalogue"];

		$opts_item =
			array(
				'http' =>
				array(
					'method'  => 'GET',
					'header'  => "Content-Type: application/json\r\n" .
						"Authorization: " . $this->token_katalog . "\r\n",
					'timeout' => 60
				)
			);

		$context_list = stream_context_create($opts_item);

		$url_level2 = $this->config->item('api_ekatalog').'api_new/Kode_sda?parent_code=' . $kategori;

		$get_level2 = file_get_contents($url_level2, false, $context_list);

        $data = json_decode($get_level2, true);
		
        echo json_encode($data);
    }

    public function get_level3()
    {
        $jenis = $this->input->post('jenis', true);

        $opts_item =
			array(
				'http' =>
				array(
					'method'  => 'GET',
					'header'  => "Content-Type: application/json\r\n" .
						"Authorization: " . $this->token_katalog . "\r\n",
					'timeout' => 60
				)
			);

		$context_list = stream_context_create($opts_item);

		$url_level3 = $this->config->item('api_ekatalog').'api_new/Kode_sda?parent_code=' . $jenis;

		$get_level3 = file_get_contents($url_level3, false, $context_list);

        $data = json_decode($get_level3, true);

        echo json_encode($data);
    }

    public function get_level4()
    {
        $level3 = $this->input->post('level3', true);

        $opts_item =
			array(
				'http' =>
				array(
					'method'  => 'GET',
					'header'  => "Content-Type: application/json\r\n" .
						"Authorization: " . $this->token_katalog . "\r\n",
					'timeout' => 60
				)
			);

		$context_list = stream_context_create($opts_item);

		$url_level4 = $this->config->item('api_ekatalog').'api_new/Kode_sda?parent_code=' . $level3;

		$get_level4 = file_get_contents($url_level4, false, $context_list);

        $data = json_decode($get_level4, true);

        echo json_encode($data);
    }

    public function get_level5()
    {
        $level4 = $this->input->post('level4', true);

        $opts_item =
			array(
				'http' =>
				array(
					'method'  => 'GET',
					'header'  => "Content-Type: application/json\r\n" .
						"Authorization: " . $this->token_katalog . "\r\n",
					'timeout' => 60
				)
			);

		$context_list = stream_context_create($opts_item);

		$url_level5 = $this->config->item('api_ekatalog').'api_new/Kode_sda?parent_code=' . $level4;

		$get_level5 = file_get_contents($url_level5, false, $context_list);

        $data = json_decode($get_level5, true);

        echo json_encode($data);
    }

    public function get_level6()
    {
        $level5 = $this->input->post('level5', true);
        
        $opts_item =
			array(
				'http' =>
				array(
					'method'  => 'GET',
					'header'  => "Content-Type: application/json\r\n" .
						"Authorization: " . $this->token_katalog . "\r\n",
					'timeout' => 60
				)
			);

		$context_list = stream_context_create($opts_item);

		$url_level6 = $this->config->item('api_ekatalog').'api_new/Kode_sda?parent_code=' . $level5;

		$get_level6 = file_get_contents($url_level6, false, $context_list);

        $data = json_decode($get_level6, true);

        echo json_encode($data);
    }

	public function get_berat()
    {
        $level = $this->input->post('level');
        $data = $this->db->get_where('resources_berat', ['code' => $level])->result_array();
        for ($x = 1; $x <= 3; $x++) {
            foreach ($data as $row) {
                $coba[$x]['berat'] = $row['berat' . $x];
                $coba[$x]['satuan'] = $row['satuan' . $x];
            }
        }
        echo json_encode($coba);
    }
	
    public function get_uom()
    {
        $satuan = $this->input->post('satuan');
        $data = $this->db->get_where('uoms', ['id' => $satuan])->result_array();
        echo json_encode($data);
    }

}
