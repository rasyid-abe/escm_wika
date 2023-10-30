<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hse extends MY_Controller {

	function __construct()
    {
        parent::__construct();         
    }
	
	public function index()
	{	
		
		$data = array();
		$hasHseCertificate = $this->GetVendorHaveHseCertificate();
		$hasHseQuestion = $this->GetVendorHaveHseCertificate();

		$vendor = $this->get_vendor();

		$data['title'] = 'Verifikasi Health Safety Environment';
		$data['hasHse'] = $this->GetCheckCqmsTrxHByVendor();//($hasHseCertificate == true || $hasHseQuestion == true) ? true : false;
		$data['questionList'] = $this->GetVendorQuestionList($vendor['cot_kelompok']);
		$data['catatanKecelakaan'] = $this->get_adm_cqsms_kecelakaan();

		$data['actionPost'] = site_url().'/hse/post_hse_certificate';
		$data['vendor_lengkap'] = ($vendor['vendor_name'] == "" || $vendor['cot_kelompok'] == NULL) ? 'false' : 'true';

		$data['actionPostPertanyaan'] = site_url().'/hse/post_hse_question';
		
		$data['type'] = $vendor['vendor_type'] == 2 ? "NON PERORANGAN" : "PERORANGAN";
		$data['cot_kelompok'] = $this->get_cot_name($vendor['cot_kelompok']);
		$data['hse_cat'] = $this->get_kategory_hse();
		
		$this->layout->view('_profile01/hse_v', $data);

		//$this->load->view('_profile01/hse_v', $data);
	}

	public function get_adm_cqsms_kecelakaan()
	{
		# code...
		$this->db->order_by('order_no', 'asc');
		
		return $this->db->get('adm_cqsms_kecelakaan')->result_array();
		
	}

	public function get_kategory_hse()
	{
		# code...
		$this->db->order_by('order_no', 'asc');
		
		return $this->db->get('vnd_cqsms_pertanyaan_kategori')->result_array();
		
	}

	public function get_vendor()
	{
		# code...
		$this->db->where('vendor_id', (int)$this->session->userdata("userid"));

		return $this->db->get('vnd_header')->row_array();
		
	}

	private function get_cot_name($id) {
		$this->db->where('ack_id', $id);
		$res = $this->db->get('adm_cot_kelompok')->row_array();
		
		return $res['ack_name'];
	}

	public function post_hse_certificate()
	{
		$post = $this->input->post();

		$data = array();
		$files = '-';

		if((int)$post['cqsms_score'] > 100) {
			$this->session->set_flashdata('error', 'Gagal Simpan, Score melebihi 100 !');
			return redirect('hse',301);
		}
		

		if (is_uploaded_file($_FILES['cqsms_certificate']['tmp_name'])) {
            $files = $this->do_upload('cqsms_certificate','vendor', "CQSMS_".$this->session->userdata('userid'));
        } else {
			$this->session->set_flashdata('error', 'Gagal Upload !');
			return redirect('hse');
		}

		


		$data['vendor_id'] =(int)$this->session->userdata("userid");
		$data['cqsms_type'] =1;
		$data['cqsms_score'] = (int)$post['cqsms_score'];
		$data['certificate'] =  $files ? $files : '-';
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['created_by'] = (int)$this->session->userdata("userid");

		$url = $this->config->item('api_url').'api/v1/vendor/cqsms-trx-h/certificate';
        $curl = curl_init($url);

		$payload = json_encode($data);
			
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type:application/json',
				'Accept:application/json',
				'Authorization:Bearer ' . $this->session->userdata("token")
		));            
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				
		$result = curl_exec($curl);
		$response = json_decode($result, true); 
			
        curl_close($curl);

		
        if ($response["data"] != NULL) {
			$this->session->set_flashdata('success', 'Berhasil Di Kirim !');
			return redirect('hse');
		} else {
			$this->session->set_flashdata('error', $response['message'][0]);
			return redirect('hse');
		}

	}

	public function post_hse_question()
	{
		$post = $this->input->post();

		

		$data = array();
		$files = '-';
		$data_post = array();
		$i = 0;
		$totalScore = 0;
		$catatan_kecelakaan = array();

		$data['vendor_id'] =(int)$this->session->userdata("userid");
		$data['cqsms_type'] ='0';
		$data['created_at'] = date('Y-m-d H:i:s');

		//create header
		$response = $this->db->insert('vnd_cqsms_trx_h', $data);
		$lastId = $this->db->insert_id();

		if(isset($post['klasifikasi_kecelakaan'])){
			foreach ($post['klasifikasi_kecelakaan'] as $key => $value) {
				# code...
				$catatan_kecelakaan[$key]['trxh_id'] = $lastId;
				$catatan_kecelakaan[$key]['klasifikasi'] = $value;
				$catatan_kecelakaan[$key]['jawaban'] = $post['jumlah_kecelakaan'][$key];

				if($key == 0) {
					$catatan_kecelakaan[$key]['tahun'] = $post['tahun_kecelakaan'][0];

				} else if($key == 6) {
					$catatan_kecelakaan[$key]['tahun'] = $post['tahun_kecelakaan'][1];

				}else if($key == 12) {
					$catatan_kecelakaan[$key]['tahun'] = $post['tahun_kecelakaan'][2];

				} else {
					$catatan_kecelakaan[$key]['tahun'] = 0;
				}

			}
			
			$this->db->insert_batch('vnd_cqsms_trx_catatan_kecelakaan', $catatan_kecelakaan);


		}

		foreach(array_values($post['jawaban'])  as $answer) {
		$detail = explode('_',$answer);

		  $_FILES['file']['name'] = $_FILES['cqsms_certificate']['name'][$detail[0]];
          $_FILES['file']['type'] = $_FILES['cqsms_certificate']['type'][$detail[0]];
          $_FILES['file']['tmp_name'] = $_FILES['cqsms_certificate']['tmp_name'][$detail[0]];
          $_FILES['file']['error'] = $_FILES['cqsms_certificate']['error'][$detail[0]];
          $_FILES['file']['size'] = $_FILES['cqsms_certificate']['size'][$detail[0]];

			if($_FILES['cqsms_certificate']['name'][$detail[0]] != ""){
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {
					$files = $this->do_upload('file','vendor', "CQSMS_".$this->session->userdata('userid'));
				}
			}
			
		
			$data_post[$i]['pertanyaan_id'] = $detail[0];
			$data_post[$i]['jawaban_id'] = $detail[1];
			$data_post[$i]['cqsms_trx_h_id'] = $lastId;
			$data_post[$i]['notes'] = $post['desc'][$detail[0]];
			$data_post[$i]['sertifikat'] = ($files != '-') ? $files : '-';
			
			$files = '-';

			$i++;
		}



		// print_r($post);
		// exit;

		$this->db->insert_batch('vnd_cqsms_trx_h_detail', $data_post);
		

        if ($response) {
			
			$this->session->set_flashdata('success', 'Berhasil Di Kirim !');
			return redirect('hse');
		} else {
			$this->session->set_flashdata('error', $response['message'][0]);
			return redirect('hse');
		}

	}

	private function GetCheckCqmsTrxHByVendor()
	{
		# code...
		$ret = false;

		$this->db->where('vendor_id', (int)$this->session->userdata("userid"));
		$query = $this->db->get('vnd_cqsms_trx_h')->row_array();
		if($query != NULL) {
			$ret = true;
		}

		return $ret;
		
		
	}

	private	function GetVendorHaveHseCertificate()
	{
		# code...
		$ret = false;

		// $opts = 
		// array('http' =>
		// 	array(
		// 		'method'  => 'GET',
		// 		'header'  => "Content-Type: application/json\r\n".
		// 		"Authorization: Bearer ".$this->session->userdata("token")."\r\n",
		// 		'timeout' => 60
		// 	)
		// );
					
		// $context = stream_context_create($opts);
		// $url = $this->config->item('api_url').'api/v1/vendor/cqsms-trx-h/certificate';
		// $get_url = file_get_contents($url, false, $context);

		
		// $res = json_decode($get_url, true);

		// if($res['data']['totalCount'] > 0 ) {
		// 	$ret = true;
		// }

		
		

		return $ret;

	}

	private	function GetVendorHaveHseQuestion()
	{
		# code...
		$ret = false;

		$opts = 
		array('http' =>
			array(
				'method'  => 'GET',
				'header'  => "Content-Type: application/json\r\n".
				"Authorization: Bearer ".$this->session->userdata("token")."\r\n",
				'timeout' => 60
			)
		);
					
		$context = stream_context_create($opts);
		$url = $this->config->item('api_url').'api/v1/vendor/cqsms-trx-h/certificate';
		$get_url = file_get_contents($url, false, $context);

		
		$res = json_decode($get_url, true);
	
		if($res['data']['totalCount'] > 0 ) {
			$ret = true;
		}
		

		return $ret;

	}

	private	function GetVendorQuestionList($vendorType = null)
	{
		# code...
		$ret = array();

		if($vendorType != null) $this->db->where('pertanyaan_classification', $vendorType);
		$this->db->order_by('order_no', 'asc');
		
		$res = $this->db->get('vnd_cqsms_pertanyaan')->result_array();

		foreach ($res as $key => $value) {
			# code...
			$ret[$key]['id'] = $value['id'];
			$ret[$key]['pertanyaan'] = $value['pertanyaan'];
			$ret[$key]['bobot'] = $value['bobot'];
			$ret[$key]['pertanyaan_is_active'] = $value['pertanyaan_is_active'];
			$ret[$key]['kategori_id'] = $value['kategori_id'];
			$ret[$key]['pertanyaan_type'] = $value['pertanyaan_type'];
			$ret[$key]['petunjuk_pertanyaan'] = $value['petunjuk_pertanyaan'];
			$ret[$key]['pertanyaan_classification'] = $value['pertanyaan_classification'];
			$ret[$key]['is_show'] = $value['is_show'];
			$ret[$key]['is_template'] =  $value['is_template_catatan_kecelakaan'];

			$ret[$key]['jawaban'] = $this->getjawaban($value['id']);
			$ret[$key]['petunjuk_score'] = $this->get_petunjuk_score($value['id']);


		}
	
		return $ret;

	}

	private function get_petunjuk_score($pertanyaanId)
	{
		# code...
		$data = array();
		$this->db->where('pertanyaan_id', $pertanyaanId);

		$data = $this->db->get('vnd_cqsms_petunjuk_score')->result_array();

		return $data;
	}

	private function getjawaban($pertanyaanId)
	{
		# code...
		$data = array();
		$this->db->where('pertanyaan_id', $pertanyaanId);

		$data = $this->db->get('vnd_cqsms_jawaban')->result_array();

		return $data;
		
		
	}
}

