<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hse extends Telescoope_Controller {

	var $code;
	var $message;

	public function __construct()
	{
		parent::__construct();
		$this->code = "";
		$this->message = "";
	}
	
	public function index()
	{
		
		$opts = 
		array('http' =>
			array(
				'method'  => 'GET',
				'header'  => "Content-Type: application/json\r\n".
				"Authorization: Bearer ".$this->session->userdata("token")."\r\n",
				'timeout' => 60
			)
		);
		$view = 'administration/master_data/hse/template_hse_index_v';

		
		// $context = stream_context_create($opts);
		// $url = $this->config->item('api_url').'api/v1/vendor/cqsms-pertanyaan';
		// $urlVendorBidang =  $this->config->item('api_url').'api/v1/vendor/bidang';
		// $get_url = file_get_contents($url, false, $context);
		// $get_urlVendorBidang = file_get_contents($urlVendorBidang, false, $context);

		
		$data = array();		
		$data['sync_btn'] = true;
		$data['title'] = 'Template Health Safety Environment';
		$data['get_list'] = $this->get_pertanyaan_list(); //json_decode($get_url, true);
		$data['get_list_vendor_bidang'] = json_encode(array());
		$data['cod_kelompok_list'] = json_encode($this->get_cod_kelompok());
		$data['kategori'] = $this->get_kategori();


		$this->template($view,"USER HCIS",$data);
	}

	public function create($vendorType)
	{		
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
		$url = $this->config->item('api_url').'api/v1/vendor/cqsms-pertanyaan';
		$urlVendorBidang =  $this->config->item('api_url').'api/v1/vendor/bidang';
		$get_url = file_get_contents($url, false, $context);
		$get_urlVendorBidang = file_get_contents($urlVendorBidang, false, $context);

		
		$data = array();		
		$data['vendor_type_name'] = $this->get_cod_kelompok($vendorType)['ack_name'];
		$data['title'] = 'Template Health Safety Environment '.$this->get_cod_kelompok($vendorType)['ack_name'];;
		$data['get_list'] = $this->get_pertanyaan_list($vendorType); //json_decode($get_url, true);
		$data['get_list_vendor_bidang'] = json_decode($get_urlVendorBidang, true);
		$data['cod_kelompok_list'] =$this->get_cod_kelompok();
		$data['kategori'] = $this->get_kategori();
		$data['vendor_type'] = $vendorType;


		$this->load->view('administration/master_data/template_hse_v',$data);
	}


	public function get_persentase_pertanyaan($katId = null,$ackId = null)
	{
		# code...
		$this->db->where('ack_id', $ackId);
		$this->db->where('kategori_id', $katId);
		$data = $this->db->get('vw_cqsms_master_pertanyaan_bobot')->row_array();
		

		return $data;
		
	}

	private function get_kategori()
	{
		# code...
		return $this->db->get('vnd_cqsms_pertanyaan_kategori')->result_array();
		
	}

	private function get_pertanyaan_list($vendorType = null)
	{
		# code...
		$data = array();
		if($vendorType != null) $this->db->where('pertanyaan_classification', $vendorType);
		
		$data = $this->db->get('vw_cqms_master_pertanyaan')->result_array();
		return $data;
		
	}

	public function ajax_get_pertanyaan_list($vendorType = null)
	{
		# code...
		$data = array();
		if($vendorType != null) $this->db->where('pertanyaan_classification', $vendorType);
		$data['data'] = $this->db->get('vw_cqms_master_pertanyaan')->result_array();
		echo json_encode($data);
		exit;
		
	}

	public function ajax_update_pertanyaan_list()
	{
		# code...
		$id = $this->input->post('key');
		
		$post = json_decode($this->input->post('values'));
		//$data['pertanyaan'] = $post->pertanyaan;

		
		$this->db->where('id', $id);
		$dataOld = $this->db->get('vnd_cqsms_pertanyaan')->row_array();
		
		$this->db->where('id', $id);
		$ret = $this->db->update('vnd_cqsms_pertanyaan', $post);

		$bobot = $this->get_persentase_pertanyaan((int)$dataOld['kategori_id'],(int)$dataOld['pertanyaan_classification']);

			if((int)$bobot['bobot'] > 100) {
				$post->bobot = $dataOld['bobot'];
				$this->db->where('id', $id);
				$this->db->update('vnd_cqsms_pertanyaan', $post);
				$this->session->set_flashdata('error', true);
				$this->session->set_flashdata('message', 'Gagal Di Simpan, melebihi bobot !');

				echo json_encode(array('code'=>403,'message'=>'gagal simpan, bobot mencapai 100'));
				exit;
			}else {
				echo json_encode(array('code'=>200,'message'=>'Edit Berhasil'));
				
				exit;
			}

		
	}

	public function ajax_delete_pertanyaan_list()
	{
		# code...
		$id = $this->input->post('key');
		
		$this->db->where('id', $id);
		$ret = $this->db->delete('vnd_cqsms_pertanyaan');

		$this->db->where('pertanyaan_id', $id);
		$ret = $this->db->delete('vnd_cqsms_jawaban');

		$this->db->where('pertanyaan_id', $id);
		$ret = $this->db->delete('vnd_cqsms_petunjuk_score');


		if($ret) {
			echo json_encode(array("message"=>"Delete berhasil !","code"=>200));
		} else {
			echo json_encode(array("message"=>"Delete gagal !","code"=>403));
		}
		
		exit;
		
	}

	public function ajax_get_jawaban($pertanyaanId)
	{
		# code...
		$data = array();
		$this->db->where('pertanyaan_id', $pertanyaanId);
		
		$data['data'] = $this->db->get('vnd_cqsms_jawaban')->result_array();
		echo json_encode($data);
		exit;
		
	}


	public function ajax_get_petunjuk_score($pertanyaanId)
	{
		# code...
		$data = array();
		$this->db->where('pertanyaan_id', $pertanyaanId);
		
		$data['data'] = $this->db->get('vnd_cqsms_petunjuk_score')->result_array();
		echo json_encode($data);
		exit;
		
	}

	public function ajax_insert_petunjuk_score($pertanyaanId)
	{
		# code...		
		$post = json_decode($this->input->post('values'));
		$post->pertanyaan_id = $pertanyaanId;

		$insert = $this->db->insert('vnd_cqsms_petunjuk_score', $post);

		if($insert) {
			echo json_encode(array("message"=>"simpan berhasil !","code"=>200));
		} else {
			echo json_encode(array("message"=>"simpan gagal !","code"=>403));

		}
		
		exit;
		
	}


	public function ajax_update_petunjuk_score()
	{
		# code...
		$id = $this->input->post('key');
		
		$post = json_decode($this->input->post('values'));

		$this->db->where('id', $id);
		$ret = $this->db->update('vnd_cqsms_petunjuk_score', $post);
		
		if($ret) {
			echo json_encode(array("message"=>"edit berhasil !","code"=>200));
		} else {
			echo json_encode(array("message"=>"edit gagal !","code"=>403));

		}
		
		exit;
		
	}

	public function ajax_delete_petunjuk_score()
	{
		# code...
		$id = $this->input->post('key');
		
		$this->db->where('id', $id);
		$ret = $this->db->delete('vnd_cqsms_petunjuk_score');
		if($ret) {
			echo json_encode(array("message"=>"Delete berhasil !","code"=>200));
		} else {
			echo json_encode(array("message"=>"Delete gagal !","code"=>403));
		}
		
		exit;
		
	}

	


	public function ajax_getListCategory()
	{
		# code...
		$data = array();
		$data = $this->db->get('vw_cqsms_list_category')->result_array();
		echo json_encode($data);
		exit;
		
	}
	

	public function ajax_insert_jawaban($pertanyaanId)
	{
		# code...
		//$id = $this->input->post('key');
		
		$post = json_decode($this->input->post('values'));
		$data['pertanyaan_id'] = $pertanyaanId;
		$data['jawaban'] = $post->jawaban;
		$data['score'] = $post->score;

		$ret = $this->db->insert('vnd_cqsms_jawaban', $data);
		echo 200;
		
		
		exit;
		
	}

	

	private function get_cod_kelompok($id = null)
	{
		if($id != null) {
			$this->db->where('ack_id', $id);
			return $this->db->get('adm_cot_kelompok')->row_array();
		} else {
			return $this->db->get('adm_cot_kelompok')->result_array();
		}
		
	}

	public function post_pertanyaan()
	{
		$post = $this->input->post();

		$data['pertanyaan'] = $post['pertanyaan'];
		$data['pertanyaan_classification'] = $post['pertanyaan_classification'];
		$data['is_template_catatan_kecelakaan'] = $post['is_template'];
		$data['order_no'] = $post['pertanyaan_order'];

		

		$data['kategori_id'] =(int)$post['kategori_id'];
		$data['bobot'] =(int)$post['bobot'];


		$data['created_at'] = date("Y-m-d H:i:s");
		$data['created_by'] = (int)$this->session->userdata(do_hash(SESSION_PREFIX));

		if(count($post['petunjuk_score_nilai']) == 0 ){
			$this->code = 403;
			$this->message = "GAGAL SAVE";
			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('message', 'Gagal Di Simpan, Petunjuk Tidak Di isi !');

			return redirect('administration/master_data/hse/'.$post['pertanyaan_classification']);
		}

		$bobot = $this->get_persentase_pertanyaan((int)$post['kategori_id'],(int)$post['pertanyaan_classification']);
		
		try
		{
			if(((int)$bobot['bobot'] + (int)$post['bobot']) > 100  ) {
				$this->code = 403;
				$this->message = 'Gagal Simpan, Bobot Mencapai lebh dari 100';
				$this->session->set_flashdata('error', true);
				$this->session->set_flashdata('message',$this->message);

				return redirect('administration/master_data/hse/create/'.$post['pertanyaan_classification']);
			}
			
			$response = $this->db->insert('vnd_cqsms_pertanyaan', $data);
			$lastId = $this->db->insert_id();
			$petunjuk_score = array();
			$bobot = 0;

			$jawaban[0]['pertanyaan_id'] = $lastId;
			$jawaban[0]['jawaban'] = 'YA';

			$jawaban[1]['pertanyaan_id'] = $lastId;
			$jawaban[1]['jawaban'] = 'TIDAK';

			$this->db->insert_batch('vnd_cqsms_jawaban', $jawaban);

			foreach ($post['petunjuk_score_nilai'] as $key => $value) {
				# code...
				$petunjuk_score[$key]['pertanyaan_id'] = $lastId;
				$petunjuk_score[$key]['bobot_petunjuk'] = $value;
				$petunjuk_score[$key]['deskripsi'] = $post['petunjuk_score_deskripsi'][$key];				

			}

			$this->db->insert_batch('vnd_cqsms_petunjuk_score', $petunjuk_score);

						
			if($response){
					$this->code = 200;
					$this->message = "SAVE BERHASIL";
					$this->session->set_flashdata('success', true);
					$this->session->set_flashdata('message', 'Berhasil Di Simpan !');

					return redirect('administration/master_data/hse/create/'.$post['pertanyaan_classification']);

			} else {
					$this->code = 403;
					$this->message = "GAGAL SAVE";
					$this->session->set_flashdata('error', true);
					$this->session->set_flashdata('message', 'Gagal Di Simpan !');

					return redirect('administration/master_data/hse/create/'.$post['pertanyaan_classification']);
					
				}
			

		} catch(Exception $e) {
			$this->code = 403;
			$this->message = $e->getMessage();

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		}
		
		exit;
	}

	public function delete_pertanyaan()
	{
		$id = $this->input->post('id');

		$url = $this->config->item('api_url').URL_VND_CQMS_PERTANYAAN.'/'.$id;
		$curl = curl_init();
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Accept:application/json',
			'Authorization:Bearer ' . $this->session->userdata("token")
		));            
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);
		$response = json_decode($result, true); 
		
		if(isset($response['data'])){
			$this->code = 200;
			$this->message = MESSAGE_SUCCESS_DELETE;

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		} else {
			$this->code = 403;
			$this->message = MESSAGE_ERROR;

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		}

		exit;
	}


	public function put_pertanyaan()
	{
		$post = $this->input->post();
		
		$data['pertanyaan'] = $post['pertanyaan'];
		$data['pertanyaan_type'] =(int)$post['pertanyaan_type'];
		$data['pertanyaan_classification'] = (int)$post['pertanyaan_classification'];
		$data['updated_at'] = date("Y-m-d H:i:s");
		$data['updated_by'] = (int)$this->session->userdata(do_hash(SESSION_PREFIX));

		try
		{
			$url = $this->config->item('api_url').URL_VND_CQMS_PERTANYAAN.'/'.$post['pertanyaan_id'];;
			$curl = curl_init($url);
	
			$payload = json_encode($data);
			
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type:application/json',
				'Accept:application/json',
				'Authorization:Bearer ' . $this->session->userdata("token")
			));            
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				
			$result = curl_exec($curl);
			$response = json_decode($result, true); 
			
			if(isset($response['data'])){
				$this->code = 200;
				$this->message = MESSAGE_SUCCESS;

				echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
			} else {
				$this->code = 403;
				$this->message = MESSAGE_ERROR;

				echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
			}

		} catch(Exception $e) {
			$this->code = 403;
			$this->message = $e->getMessage();

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		}
		
		exit;
	}

	public function post_jawaban()
	{
		$post = $this->input->post();
		
		$data['pertanyaan_id'] = $post['pertanyaan_id'];
		$data['jawaban'] = $post['jawaban'];
		$data['score'] = (int)$post['score'];
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['created_by'] = (int)$this->session->userdata(do_hash(SESSION_PREFIX));
		
		try
		{
			$url = $this->config->item('api_url').URL_VND_CQMS_JAWABAN;
			$curl = curl_init($url);
	
			$payload = json_encode($data);
			
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type:application/json',
				'Accept:application/json',
				'Authorization:Bearer ' . $this->session->userdata("token")
			));            
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				
			$result = curl_exec($curl);
			$response = json_decode($result, true); 
			
			if(isset($response['data'])){
				$this->code = 200;
				$this->message = MESSAGE_SUCCESS;

				echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
			} else {
				$this->code = 403;
				$this->message = MESSAGE_ERROR;

				echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
			}

		} catch(Exception $e) {
			$this->code = 403;
			$this->message = $e->getMessage();

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		}
		
		exit;
	}


	public function put_jawaban()
	{
		$post = $this->input->post();
		 
		$data['pertanyaan_id'] = $post['pertanyaan_id'];
		$data['jawaban'] =$post['jawaban'];
		$data['score'] = (int)$post['score'];

		$data['updated_at'] = date("Y-m-d H:i:s");
		$data['updated_by'] = (int)$this->session->userdata(do_hash(SESSION_PREFIX));

		try
		{
			$url = $this->config->item('api_url').URL_VND_CQMS_JAWABAN.'/'.(int)$post['jawaban_id'];
			$curl = curl_init($url);
	
			$payload = json_encode($data);
			
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type:application/json',
				'Accept:application/json',
				'Authorization:Bearer ' . $this->session->userdata("token")
			));            
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				
			$result = curl_exec($curl);
			$response = json_decode($result, true); 
			
			if(isset($response['data'])){
				$this->code = 200;
				$this->message = MESSAGE_SUCCESS;

				echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
			} else {
				$this->code = 403;
				$this->message = MESSAGE_ERROR;

				echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
			}

		} catch(Exception $e) {
			$this->code = 403;
			$this->message = $e->getMessage();

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		}
		
		exit;		
	}

	public function delete_jawaban()
	{
		$id = $this->input->post('id');
		
		$url = $this->config->item('api_url').URL_VND_CQMS_JAWABAN.'/'.$id;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Accept:application/json',
			'Authorization:Bearer ' . $this->session->userdata("token")
		));            
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);
		$response = json_decode($result, true); 
		
		if(isset($response['data'])){
			$this->code = 200;
			$this->message = MESSAGE_SUCCESS_DELETE;

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		} else {
			$this->code = 403;
			$this->message = MESSAGE_ERROR;

			echo json_encode(array('code'=>$this->code, 'message'=> $this->message));
		}

		exit;		
	}

	public function post_pertanyaan_settings()
	{
		# code...
		$post = $this->input->post();
		$codList = $this->get_cod_kelompok()['data']['rows'];
		$cod = "";
		$dataCod = array();
		$dataType = array();
		$type1 = "type_1";
		$type2 = "type_2";
		$pertanyaanList = $this->get_pertanyaan()['data']['rows'];
		$dataTypeList = array();
		$dataCodList = array();

		
		foreach ($codList as $keyCod => $valueCod) {
			# code...
			foreach ($post as $key => $value) {
				# code...
				$cod = $valueCod['ack_id'];
				if(preg_match("/\b$cod\b/i", $value)) {
					$dataCod[$key] = $value;
				}				
			}
		}

		foreach ($post as $key => $value) {
			# code...			
			if(preg_match("/\b$type1\b/i", $value)) {
				$dataType[$key] = $value;
			}

			if(preg_match("/\b$type2\b/i", $value)) {
				$dataType[$key] = $value;
			}			
		}

		
		// print_r($dataCod);
		// exit;


		
		$this->db->truncate('vnd_cqsms_pertanyaan_settings_type');
		$i= 0;
		foreach ($dataType as $key => $value) {
			# code...
			$typeExplode =  explode('_',$key);
			$pertanyaanId = $typeExplode[1];
			$type = $typeExplode[2];
			$dataTypeList[$i]['pertanyaan_id'] = $pertanyaanId;
			$dataTypeList[$i]['vendor_type'] = $type;
			$i++;
		}

		$this->db->insert_batch('vnd_cqsms_pertanyaan_settings_type', $dataTypeList);
	
		$this->db->truncate('vnd_cqsms_pertanyaan_settings_cod');
		$i= 0;
		foreach ($dataCod as $key => $value) {
			# code...
			$codExplode =  explode('_',$key);
			$pertanyaanId = $codExplode[1];
			$codId = $codExplode[2];
			$dataCodList[$i]['pertanyaan_id'] = $pertanyaanId;
			$dataCodList[$i]['cot_kelompok_id'] = $codId;

			$i++;

		}

		$this->db->insert_batch('vnd_cqsms_pertanyaan_settings_cod', $dataCodList);
		$this->db->truncate('vnd_cqsms_pertanyaan_settings');
		foreach ($pertanyaanList as $key => $value) {
			# code...
			$data[$key]['pertanyaan_id'] = $value['id'];
			$data[$key]['created_at'] = date('Y-m-d h:i:s');

			$data[$key]['json_cod'] = json_encode($dataCod);
			$data[$key]['json_type'] = json_encode($dataType);
		}

		$ret = $this->db->insert_batch('vnd_cqsms_pertanyaan_settings', $data);
		
		if ($ret) {
			$this->session->set_flashdata('success', true);
			$this->session->set_flashdata('message', 'Berhasil di Simpan');

			return redirect('administration/template_hse');
		} else {
			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('message', 'Gagal di Simpan');

			return redirect('administration/template_hse');
		}
	}

	private function get_pertanyaan()
	{
		# code...
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
		$url = $this->config->item('api_url').'api/v1/vendor/cqsms-pertanyaan';
		
		$get_url = file_get_contents($url, false, $context);

		return json_decode($get_url, true);
	}

	private function get_pertanyaan_settings()
	{
		$data = array();
		$query = $this->db->get('vnd_cqsms_pertanyaan_settings')->result_array();

		if(count($query) > 0) {
			foreach ($query as $key => $value) {
				# code...
				$data[$key]['pertanyaan_id'] = $value['pertanyaan_id'];
				$data[$key]['json_cod'] = $value['json_cod'];
				$data[$key]['json_type'] = $value['json_type'];
				$data[$key]['cod'] = json_decode($value['json_cod'],true);
				$data[$key]['type'] = json_decode($value['json_type'],true);
			}
		}

		return $data;
	}

	public function ajax_vendor_list_hse()
	{
		# code...
		$data = array();

		$data = $this->db->get('vw_cqsms_vendor_list')->result_array();

		echo json_encode($data);
		exit;
		
	}

	
	public function post_score()
	{
		# code...
		$return = true;
		$post = $this->input->post();
		//vallidation if > max score
		// foreach ($post['score'] as $key => $value) {
		// 	# code...
		// 	if($value > $post['max_score'][$key]) {
		// 		$return = false;
		// 	}
		// }
		

		if(!$return) {
			$this->session->set_flashdata('error', true);
					$this->session->set_flashdata('message', 'Gagal Di Simpan !');

					return redirect('administration/master_data/hse/verivikasi/'.$post['vendor_id']);
		}

		foreach ($post['score'] as $key => $value) {
			# code...
			$object['answer_score'] = (int)$value;
			$this->db->where('id', $key);
			$this->db->update('vnd_cqsms_trx_h_detail', $object);
			
		}

		$header['cqsms_status'] = 1;
		$header['updated_status_by'] = $this->session->userdata(do_hash(SESSION_PREFIX));

		$this->db->where('id', $post['trx_h_id']);
		$updateHeader = $this->db->update('vnd_cqsms_trx_h', $header);
		
		if($updateHeader) {
			$this->session->set_flashdata('success', true);
					$this->session->set_flashdata('message', 'Verifikasi Di Simpan !');

					return redirect('administration/hse/verifikasi/');
		} else {
			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('message', 'Gagal Di Simpan !');

			return redirect('administration/master_data/hse/verivikasi/'.$post['vendor_id']);
		}

		
	}

	public function post_hse_certificate()
	{
		# code...
		$return = true;
		$post = $this->input->post();

		$header['cqsms_status'] = 1;
		$header['updated_status_by'] = $this->session->userdata(do_hash(SESSION_PREFIX));

		$this->db->where('id', $post['trx_h_id']);
		$updateHeader = $this->db->update('vnd_cqsms_trx_h', $header);
		
		if($updateHeader) {
			$this->session->set_flashdata('success', true);
					$this->session->set_flashdata('message', 'Verifikasi Di Simpan !');

					return redirect('administration/master_data/hse/verivikasi/');
		} else {
			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('message', 'Gagal Di Simpan !');

			return redirect('administration/master_data/hse/verivikasi/'.$post['vendor_id']);
		}

	

		
	}

	
}
