<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Base_Api_Controller.php';
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

use chriskacerguis\RestServer\RestController;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class Api extends Base_Api_Controller {

	public function __construct($config = 'rest'){

      	// Call the Model constructor
		parent::__construct($config);
		$this->load->model('sync_postgre_model');
		$this->load->model('Administration_m');
		$this->load->model('Vendor_m');
		$this->load->model('Procpr_m');
		$this->load->model('Procrfq_m');
		$this->load->model('Procedure_m');
		$this->load->model('Workflow_m');
		$this->load->model('Comment_m');
		$this->load->model('Procevaltemp_m');
		
		$this->load->config('privy');
        $this->load->config('whatsapp');
	}

	function configToken(){
		$cnf['exp'] = 3600;
		$cnf['secretkey'] = 'WSUI9GHUSDGUAHGJKASBGDJA3OIDB8BSDIFHNSDFUTTOIU00PI';
		return $cnf;
	}

	public function authtoken(){
		$secret_key = $this->configToken()['secretkey'];
		$token = null;
		$authHeader = !empty($this->input->request_headers()['Authorization']) ? $this->input->request_headers()['Authorization'] : 'Token null';
		$arr = explode(" ", $authHeader);
		$token = $arr[1];
		if ($token){
			try {
				JWT::$leeway = 60 * 60 * 24;
				$decoded = JWT::decode($token, $secret_key, array('HS256'));
				if ($decoded){
					return 'success';
				}
			} catch (\Exception $e) {
				$result = array('message' => 'Invalid Signature Code');
				return 'fail';

			}
		}
	}

	public function login_post(){
		$exp = time() + 10000; // 3 hours
		$date = date("H:i:s d-M-Y", $exp);
		$token = array(
			"iss" => 'apprestservice',
			"aud" => 'lcts',
			"iat" => time(),
			"nbf" => time() + 10,
			"exp" => $exp,
			"data" => array(
				"username" => $this->input->post('username'),
				"password" => $this->input->post('password')
			)
		);

		$check = $this->Administration_m->checkLogin($this->input->post('username'), $this->input->post('password'))->row_array();

		if(!empty($check)){

			if(empty($check['is_locked']) && empty($check['status'])){

				$jwt = JWT::encode($token, $this->configToken()['secretkey']);

				$data_pos = $this->db->where("employee_id", $check['employeeid'])->order_by('is_main_job', 'desc')->get("vw_adm_pos")->row_array();
				$this->session->set_userdata(do_hash("ROLE"), $data_pos['pos_id']);
				$this->session->set_userdata(do_hash(SESSION_PREFIX), $check['id']);

				$data = array(
					'code' => 200,
					'message' => 'Success generate token.',
					'data' => array(
						'token' => $jwt,
						'user_id' => $check['id'],
						'pos_id' => $data_pos['pos_id'],
						'pos_name' => $data_pos['pos_name'],
						'full_name' => $check['complete_name'],
						'dept_name' => $data_pos['dept_name'],
						'expired' => $date
					)
				);

				$this->response($data, 200);

			} else {
				$data = array(
					'code' => 423,
					'message' => 'Sorry, your account is suspended.'
				);

				$this->response($data, 423);
			}

		} else {
			$data = array(
			'code' => 404,
			'message' => 'Wrong username and password.'
			);

			$this->response($data, 404);
		}

	}

	// start modul vendor

	public function vendor_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');
		$name = $this->get('name');
		$nasabah_code = $this->get('nasabah_code');
		$address = $this->get('address');
		$email = $this->get('email');
		$type = $this->get('type');
		$reg_status = $this->get('reg_status');
		$limit = $this->get('limit');
		$offset = $this->get('offset');
		$dinamic = $this->get('dinamic');

		$data = $this->sync_postgre_model->get_all_vendor($vendor_id, $name, $nasabah_code, $address, $email, $type, $reg_status, $limit, $offset, $dinamic)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['vendor_id'] = $value['vendor_id'];
				$vendor[$key]['no_dppm'] = $value['vendor_code'];
				$vendor[$key]['prefix'] = $value['prefix'];
				$vendor[$key]['vendor_name'] = $value['vendor_name'];
				$vendor[$key]['email_address'] = $value['email_address'];
				$vendor[$key]['address_street'] = $value['address_street'];
				$vendor[$key]['address_city'] = $value['address_city'];
				$vendor[$key]['address_postcode'] = $value['address_postcode'];
				$vendor[$key]['address_phone_no'] = $value['address_phone_no'];
				$vendor[$key]['address_domisili_no'] = $value['address_domisili_no'];
				$vendor[$key]['address_domisili_date'] = $value['address_domisili_date'];
				$vendor[$key]['npwp_no'] = $value['npwp_no'];
				$vendor[$key]['npwp_address'] = $value['npwp_address'];
				$vendor[$key]['npwp_city'] = $value['npwp_city'];
				$vendor[$key]['npwp_pkp_no'] = $value['npwp_pkp_no'];
				$vendor[$key]['nib_no'] = $value['nib_no'];
				$vendor[$key]['vendor_type'] = $value['vendor_type'];
				$vendor[$key]['siup_type'] = $value['siup_type'];
				$vendor[$key]['fin_class'] = $value['fin_class'];
				$vendor[$key]['vnd_jenis'] = $value['vnd_jenis'];
				$vendor[$key]['birth_date'] = $value['birth_date'];
				$vendor[$key]['id_card'] = $value['id_card'];
				$vendor[$key]['contract_attachment'] = $value['contract_attachment'];
				$vendor[$key]['sim_attachment'] = $value['sim_attachment'];
				$vendor[$key]['id_attachment'] = $value['id_attachment'];
				$vendor[$key]['ref_doc_attachment'] = $value['ref_doc_attachment'];
				$vendor[$key]['tax_attachment'] = $value['tax_attachment'];
				$vendor[$key]['vendor_lampiran'] = $value['vendor_lampiran'];
				$vendor[$key]['mu_mata_uang'] = $value['mu_mata_uang'];
				$vendor[$key]['mu_nilai'] = $value['mu_nilai'];
				$vendor[$key]['md_mata_uang'] = $value['md_mata_uang'];
				$vendor[$key]['md_nilai'] = $value['md_nilai'];
				$vendor[$key]['nilai_pengalaman'] = $value['nilai_pengalaman'];
				$vendor[$key]['kemampuan_keuangan'] = $value['kemampuan_keuangan'];
				$vendor[$key]['kapasitas_produk'] = $value['kapasitas_produk'];
				$vendor[$key]['satuan'] = $value['satuan'];
				$vendor[$key]['npwp_nama'] = $value['npwp_nama'];
				$vendor[$key]['npwp_district'] = $value['npwp_district'];
				$vendor[$key]['npwp_lampiran'] = $value['npwp_lampiran'];
				$vendor[$key]['pkp_lampiran'] = $value['pkp_lampiran'];
				$vendor[$key]['anak_perusahaan'] = $value['anak_perusahaan'];
				$vendor[$key]['cot_kelompok'] = $value['cot_kelompok'];
				$vendor[$key]['reg_status'] = $value['reg_status_id'] == 8 ? 'Active' : 'Inactive';
				$vendor[$key]['notBankruptAtt'] = $value['notBankruptAtt'];
				$vendor[$key]['kemampuanNyata'] = $value['kemampuanNyata'];
				$vendor[$key]['nilaiPekerjaanBerjalan'] = $value['nilaiPekerjaanBerjalan'];
				$vendor[$key]['sisaKemampuanNyata'] = $value['sisaKemampuanNyata'];
				$vendor[$key]['totalModalTahunTerakhir'] = $value['totalModalTahunTerakhir'];
				$vendor[$key]['antiBriberyAtt'] = $value['antiBriberyAtt'];
				$vendor[$key]['antiBriberyPolicyAtt'] = $value['antiBriberyPolicyAtt'];
				$vendor[$key]['domesticAtt'] = $value['domesticAtt'];
				$vendor[$key]['organizationAtt'] = $value['organizationAtt'];
				$vendor[$key]['paktaAtt'] = $value['paktaAtt'];
				$vendor[$key]['umkmAtt'] = $value['umkmAtt'];
				$vendor[$key]['lastCqsmsApprovedDate'] = $value['lastCqsmsApprovedDate'];
				$vendor[$key]['categoryIdBumnkarya'] = $value['categoryIdBumnkarya'];
				$vendor[$key]['companyProfile'] = $value['companyProfile'];
				$vendor[$key]['contactMobileNo'] = $value['contactMobileNo'];
				$vendor[$key]['facebook'] = $value['facebook'];
				$vendor[$key]['instagram'] = $value['instagram'];
				$vendor[$key]['linkGoogleMaps'] = $value['linkGoogleMaps'];
				$vendor[$key]['linkedin'] = $value['linkedin'];
				$vendor[$key]['twitter'] = $value['twitter'];
				$vendor[$key]['qualification'] = $value['qualification'];
				$vendor[$key]['website'] = $value['website'];
				$vendor[$key]['domisiliEnd'] = $value['domisiliEnd'];
				$vendor[$key]['industryKey'] = $value['industryKey'];
				$vendor[$key]['instanceName'] = $value['instanceName'];
				$vendor[$key]['upload_bukti_kontrak'] = $value['upload_bukti_kontrak'] != NULL ? base_url('/uploads/vendor/'. $value['vendor_id'] . '/' .  $value['upload_bukti_kontrak']) : '';
				$vendor[$key]['type_file'] = pathinfo($vendor[$key]['upload_bukti_kontrak'], PATHINFO_EXTENSION);
				$vendor[$key]['creation_date'] = $value['creation_date'];
			}

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No vendor were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_alamat_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_alamat($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['type'] = $value['type'];
				$vendor[$key]['alamat'] = $value['alamat'];
				$vendor[$key]['kode_pos'] = $value['kode_pos'];
				$vendor[$key]['no_telp'] = $value['no_telp'];
				$vendor[$key]['fax'] = $value['fax'];
				$vendor[$key]['province_name'] = $value['province_name'];
				$vendor[$key]['city_name'] = $value['city_name'];
				$vendor[$key]['district_name'] = $value['district_name'];
				$vendor[$key]['phone1'] = $value['phone1'];
				$vendor[$key]['phone2'] = $value['phone2'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No address were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_kontak_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_kontak($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['nama_lengkap'] = $value['nama_lengkap'];
				$vendor[$key]['email'] = $value['email'];
				$vendor[$key]['no_telp'] = $value['no_telp'];
				$vendor[$key]['jabatan'] = $value['jabatan'];
				$vendor[$key]['mobile_phone'] = $value['mobile_phone'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contact were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_akta_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_akta($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['type_akta'] = $value['type_akta'];
				$vendor[$key]['nomor_akta'] = $value['nomor_akta'];
				$vendor[$key]['tgl_buat'] = $value['tgl_buat'];
				$vendor[$key]['nama_notaris'] = $value['nama_notaris'];
				$vendor[$key]['alamat_notaris'] = $value['alamat_notaris'];
				$vendor[$key]['lampiran'] = $value['lampiran'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No akta were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_sk_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_sk($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['nomor_sk'] = $value['nomor_sk'];
				$vendor[$key]['nomor_akta'] = $value['nomor_akta'];
				$vendor[$key]['tgl_buat'] = $value['tgl_buat'];
				$vendor[$key]['sk_type'] = $value['sk_type'];
				$vendor[$key]['lampiran'] = $value['lampiran'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No sk were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_izin_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_izin($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['type_izin'] = $value['type_izin'];
				$vendor[$key]['penerbit'] = $value['penerbit'];
				$vendor[$key]['nomor_izin'] = $value['nomor_izin'];
				$vendor[$key]['kategori'] = $value['kategori'];
				$vendor[$key]['tgl_buat'] = $value['tgl_buat'];
				$vendor[$key]['tgl_kadaluarsa'] = $value['tgl_kadaluarsa'];
				$vendor[$key]['lampiran'] = $value['lampiran'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No izin were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_sertifikat_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_sertifikat($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['type_sertifikat'] = $value['type_sertifikat'];
				$vendor[$key]['nama_sertifikat'] = $value['nama_sertifikat'];
				$vendor[$key]['penerbit'] = $value['penerbit'];
				$vendor[$key]['nomor_sertifikat'] = $value['nomor_sertifikat'];
				$vendor[$key]['tgl_buat'] = $value['tgl_buat'];
				$vendor[$key]['tgl_kadaluarsa'] = $value['tgl_kadaluarsa'];
				$vendor[$key]['lampiran'] = $value['lampiran'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No sertifikat were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_spt_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_spt($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['tahun'] = $value['tahun'];
				$vendor[$key]['tgl_lapor'] = $value['tgl_lapor'];
				$vendor[$key]['spt_lampiran'] = $value['spt_lampiran'];
				$vendor[$key]['bukti_lampiran'] = $value['bukti_lampiran'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No spt were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_bank_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_bank($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['account_name'] = $value['account_name'];
				$vendor[$key]['account_no'] = $value['account_no'];
				$vendor[$key]['address'] = $value['address'];
				$vendor[$key]['bank_branch'] = $value['bank_branch'];
				$vendor[$key]['bank_id'] = $value['bank_id'];
				$vendor[$key]['bank_name'] = $value['bank_name'];
				$vendor[$key]['currency'] = $value['currency'];
				$vendor[$key]['country'] = $value['country'];
				$vendor[$key]['rek_koran_lampiran'] = $value['rek_koran_lampiran'];
				$vendor[$key]['surat_pernyataan'] = $value['surat_pernyataan'];
				$vendor[$key]['transactionalAtt'] = $value['transactionalAtt'];
				$vendor[$key]['statementLetterAtt'] = $value['statementLetterAtt'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No bank were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_lap_tahun_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_lap_tahun($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['tahun'] = $value['year'];
				$vendor[$key]['mata_uang'] = $value['currency'];
				$vendor[$key]['jml_aset'] = $value['asset'];
				$vendor[$key]['hutang'] = $value['hutang'];
				$vendor[$key]['pendapatan'] = $value['income'];
				$vendor[$key]['laba_rugi'] = $value['netprofit'];
				$vendor[$key]['total_beban'] = $value['operatingexpenses'];
				$vendor[$key]['isaudit'] = $value['finaudittype'];
				$vendor[$key]['nama_auditor'] = $value['auditorname'];
				$vendor[$key]['alamat_auditor'] = $value['auditoraddress'];
				$vendor[$key]['tgl_laporan'] = date("d-m-Y", strtotime($value['reportdate']));
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No laporan were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_saham_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_saham($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['tipe_saham'] = $value['tipe_saham'];
				$vendor[$key]['nama_pemegang'] = $value['nama_pemegang'];
				$vendor[$key]['jml_kepemilikan'] = $value['jml_kepemilikan'];
				$vendor[$key]['address'] = $value['address'];
				$vendor[$key]['country'] = $value['country'];
				$vendor[$key]['prop'] = $value['prop'];
				$vendor[$key]['city'] = $value['city'];
				$vendor[$key]['district'] = $value['district'];
				$vendor[$key]['kode_pos'] = $value['kode_pos'];
				$vendor[$key]['no_telp'] = $value['no_telp'];
				$vendor[$key]['lampiran_npwp'] = $value['lampiran_npwp'];
				$vendor[$key]['lampiran_ktp'] = $value['lampiran_ktp'];
				$vendor[$key]['type'] = $value['type'];
				$vendor[$key]['category'] = $value['category'];
				$vendor[$key]['id_card'] = $value['id_card'];
				$vendor[$key]['nationality'] = $value['nationality'];
				$vendor[$key]['tax_id'] = $value['tax_id'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No saham were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_pengurus_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_pengurus($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['ktp'] = $value['ktp'];
				$vendor[$key]['name'] = $value['name'];
				$vendor[$key]['npwp'] = $value['npwp'];
				$vendor[$key]['position'] = $value['position'];
				$vendor[$key]['phone'] = $value['phone'];
				$vendor[$key]['type'] = $value['type'];
				$vendor[$key]['country'] = $value['country'];
				$vendor[$key]['province'] = $value['province'];
				$vendor[$key]['city'] = $value['city'];
				$vendor[$key]['district'] = $value['district'];
				$vendor[$key]['address'] = $value['address'];
				$vendor[$key]['post_code'] = $value['post_code'];
				$vendor[$key]['nationality'] = $value['nationality'];
				$vendor[$key]['lampiran_ktp'] = $value['lampiran_ktp'];
				$vendor[$key]['lampiran_npwp'] = $value['lampiran_npwp'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No pengurus were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_personil_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_personil($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['nama_karyawan'] = $value['nama_karyawan'];
				$vendor[$key]['gender'] = $value['gender'];
				$vendor[$key]['kewarganegaraan'] = $value['kewarganegaraan'];
				$vendor[$key]['nomor_ktp'] = $value['nomor_ktp'];
				$vendor[$key]['nomor_npwp'] = $value['nomor_npwp'];
				$vendor[$key]['tempat_lahir'] = $value['tempat_lahir'];
				$vendor[$key]['alamat'] = $value['alamat'];
				$vendor[$key]['country'] = $value['country'];
				$vendor[$key]['city'] = $value['city'];
				$vendor[$key]['district'] = $value['district'];
				$vendor[$key]['kode_pos'] = $value['kode_pos'];
				$vendor[$key]['no_telp'] = $value['no_telp'];
				$vendor[$key]['status_karyawan'] = $value['status_karyawan'];
				$vendor[$key]['jenjang_pendidikan'] = $value['jenjang_pendidikan'];
				$vendor[$key]['nama_lembaga_pendidikan'] = $value['nama_lembaga_pen'];
				$vendor[$key]['lokasi_pendidikan'] = $value['lokasi_pen'];
				$vendor[$key]['jurusan'] = $value['jurusan'];
				$vendor[$key]['tahun_lulus'] = $value['tahun_lulus'];
				$vendor[$key]['ijazah_lampiran'] = $value['ijazah_lampiran'];
				$vendor[$key]['nama_pelatihan'] = $value['nama_pelatihan'];
				$vendor[$key]['nama_lembaga_pelatihan'] = $value['nama_lembaga_pel'];
				$vendor[$key]['lokasi_pelatihan'] = $value['lokasi_pel'];
				$vendor[$key]['sertifikat_lampiran'] = $value['sertifikat_lampiran'];
				$vendor[$key]['tahun_pelatihan'] = $value['tahun_pelatihan'];
				$vendor[$key]['nama_pekerjaan'] = $value['nama_pekerjaan'];
				$vendor[$key]['lokasi_pekerjaan'] = $value['lokasi_pekerjaan'];
				$vendor[$key]['posisi'] = $value['posisi'];
				$vendor[$key]['pengguna_jasa'] = $value['pengguna_jasa'];
				$vendor[$key]['tgl_mulai'] = $value['tgl_mulai'];
				$vendor[$key]['tgl_selesai'] = $value['tgl_selesai'];
				$vendor[$key]['pendukung_lampiran'] = $value['pendukung_lampiran'];
				$vendor[$key]['ktp_lampiran'] = $value['ktp_lampiran'];
				$vendor[$key]['sim_lampiran'] = $value['sim_lampiran'];
				$vendor[$key]['npwp_lampiran'] = $value['npwp_lampiran'];
				$vendor[$key]['ref_client_lampiran'] = $value['ref_client_lampiran'];
				$vendor[$key]['kontrak_kerja_lampiran'] = $value['kontrak_kerja_lampiran'];
				$vendor[$key]['province'] = $value['province'];
				$vendor[$key]['last_work_date'] = $value['last_work_date'];
				$vendor[$key]['project_name'] = $value['project_name'];
				$vendor[$key]['project_owner'] = $value['project_owner'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No personil were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_pengalaman_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_pengalaman($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['nama_pekerjaan'] = $value['nama_pekerjaan'];
				$vendor[$key]['ruang_lingkup'] = $value['ruang_lingkup'];
				$vendor[$key]['lokasi_kerja'] = $value['lokasi_kerja'];
				$vendor[$key]['nama_pemberi'] = $value['nama_pemberi'];
				$vendor[$key]['alamat'] = $value['alamat'];
				$vendor[$key]['no_telp'] = $value['no_telp'];
				$vendor[$key]['nomor_kontrak'] = $value['nomor_kontrak'];
				$vendor[$key]['tgl_kontrak'] = $value['tgl_kontrak'];
				$vendor[$key]['currency'] = $value['currency'];
				$vendor[$key]['nilai'] = $value['nilai'];
				$vendor[$key]['tgl_selesai'] = $value['tgl_selesai'];
				$vendor[$key]['kontrak_lampiran'] = $value['kontrak_lampiran'];
				$vendor[$key]['referensi_lampiran'] = $value['referensi_lampiran'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No pengalaman were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_fasilitas_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_fasilitas($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['tipe_fasilitas'] = $value['tipe_fasilitas'];
				$vendor[$key]['nama_fasilitas'] = $value['nama_fasilitas'];
				$vendor[$key]['jumlah'] = $value['jumlah'];
				$vendor[$key]['specification'] = $value['specification'];
				$vendor[$key]['merek'] = $value['merek'];
				$vendor[$key]['tahun'] = $value['tahun'];
				$vendor[$key]['kondisi'] = $value['kondisi'];
				$vendor[$key]['lokasi'] = $value['lokasi'];
				$vendor[$key]['kepemilikan'] = $value['kepemilikan'];
				$vendor[$key]['lampiran'] = $value['lampiran'];
				$vendor[$key]['purchase_date'] = $value['purchase_date'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No fasilitas were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_produk_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');

		$data = $this->sync_postgre_model->get_vendor_produk($vendor_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['product_name'] = $value['product_name'];
				$vendor[$key]['product_code'] = $value['product_code'];
				$vendor[$key]['name_group'] = $value['name_group'];
				$vendor[$key]['brand'] = $value['brand'];
				$vendor[$key]['source'] = $value['source'];
				$vendor[$key]['type'] = $value['type'];
				$vendor[$key]['islisted'] = $value['islisted'];
				$vendor[$key]['product_description'] = $value['product_description'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No produk were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_catatan_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');
		$data = $this->Vendor_m->getVendorComment($vendor_id, '')->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['start_date'] = (isset($value['comment_date']) && !empty(strtotime($value['comment_date']))) ? date(DEFAULT_FORMAT_DATETIME,strtotime($value['comment_date'])) : "";
				$vendor[$key]['end_date'] = (isset($value['comment_end_date']) && !empty(strtotime($value['comment_end_date']))) ? date(DEFAULT_FORMAT_DATETIME,strtotime($value['comment_end_date'])) : "";
				$vendor[$key]['comment_name'] = $value['comment_name'];
				$vendor[$key]['position'] = $value['position'];
				$vendor[$key]['activity_name'] = $value['activity_name'];
				$vendor[$key]['response'] = $value['response'];
				$vendor[$key]['comments'] = $value['comments'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No catatan were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_cqsms_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');
		$data = $this->sync_postgre_model->get_vendor_cqsms($vendor_id, '')->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['vendor_id'] = $value['vendor_id'];
				$vendor[$key]['cqsmsapproveddate'] = $value['cqsmsapproveddate'];
				$vendor[$key]['cqsmsgrade'] = $value['cqsmsgrade'];
				$vendor[$key]['cqsmsnilaiakhir'] = $value['cqsmsnilaiakhir'];
				$vendor[$key]['cqsmsnilaiawal'] = $value['cqsmsnilaiawal'];
				$vendor[$key]['cqsmspenguranganqhse'] = $value['cqsmspenguranganqhse'];
				$vendor[$key]['cqsmstype'] = $value['cqsmstype'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No cqsms were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_dnb_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');
		$data = $this->sync_postgre_model->get_vendor_dnb($vendor_id, '')->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['vendor_id'] = $value['vendor_id'];
				$vendor[$key]['attachment'] = $value['attachment'];
				$vendor[$key]['docname'] = $value['docname'];
				$vendor[$key]['doctype'] = $value['doctype'];
				$vendor[$key]['notes'] = $value['notes'];
				$vendor[$key]['jenis'] = $value['jenis'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_account_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');
		$data = $this->sync_postgre_model->get_vendor_account($vendor_id, '')->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['vendor_id'] = $value['vendor_id'];
				$vendor[$key]['email'] = $value['email'];
				$vendor[$key]['ismaster'] = $value['ismaster'];
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_bidang_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');
		$data = $this->sync_postgre_model->get_vendor_bidang($vendor_id, '')->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['vendor_id'] = $value['vendor_id'];
				$vendor[$key]['type'] = $value['type'];
				$vendor[$key]['bidang_name'] = $value['bidang_name'];
				$vendor[$key]['sub_bidang_name'] = $value['sub_bidang_name'];
				$vendor[$key]['created_date'] = $value['created_date'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_company_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$vendor_id = $this->get('vendor_id');
		$data = $this->sync_postgre_model->get_vendor_company($vendor_id, '')->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['vendor_id'] = $value['vendor_id'];
				$vendor[$key]['tipe_file'] = $value['tipe_file'];
				$vendor[$key]['lampiran'] = $value['lampiran'] != NULL ? base_url('/uploads/vendor/'. $value['vendor_id'] . '/' .  $value['lampiran']) : '';
				$vendor[$key]['type_file'] = pathinfo($vendor[$key]['lampiran'], PATHINFO_EXTENSION);
				$vendor[$key]['created_at'] = $value['created_at'];
			}

			$this->response([
				'status' => true,
				'vendor_id' => $vendor_id,
				'total' => $total,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vendor_summary_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$vendor = array();

		$data = $this->sync_postgre_model->get_vendor_summary()->result_array();

		if ($data) {
			foreach ($data as $key => $value) {
				$vendor[$key]['total_suspend'] = $value['total_suspend'];
				$vendor[$key]['total_active'] = $value['total_active'];
				$vendor[$key]['total_blacklist'] = $value['total_blacklist'];
				$vendor[$key]['total_proses_registrasi'] = $value['total_proses_kualifikasi'];
			}

			$this->response([
				'status' => true,
				'data' => $vendor
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	// end modul vendor

	// start modul kontrak

	public function contract_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$contract = array();

		$contract_id = $this->get('contract_id');
		$ptm_number = $this->get('ptm_number');
		$start_date = $this->get('start_date');
		$end_date = $this->get('end_date');
		$divisi = $this->get('divisi');
		$status = $this->get('status');
		$year = $this->get('year');
		$limit = $this->get('limit');
		$offset = $this->get('offset');
		
		$data = $this->sync_postgre_model->get_all_contract($contract_id, $ptm_number, $start_date, $end_date, $divisi, $status, $year, $limit, $offset)->result_array();

		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$contract[$key]['contract_id'] = $value['contract_id'];				
				$contract[$key]['item_type'] = $value['ctr_item_type'];
				$contract[$key]['type_of_plan'] = $value['type_of_plan'];
				$contract[$key]['kd_divisi'] = $value['dep_code'];
				$contract[$key]['nama_divisi'] = $value['dept_name'];
				$contract[$key]['buyer'] = $value['ptm_buyer'];
				$contract[$key]['kode_spk'] = $value['kode_spk'];
				$contract[$key]['ptm_number'] = $value['ptm_number'];
				$contract[$key]['contract_number'] = $value['contract_number'];
				$contract[$key]['status_code'] = $value['status'];
				$contract[$key]['status_name'] = $value['awa_name'];
				$contract[$key]['contract_amount'] = $value['contract_amount'];
				$contract[$key]['vendor_id'] = $value['vendor_id'];
				$contract[$key]['vendor_name'] = $value['vendor_name'];
				$contract[$key]['vendor_class'] = $value['fin_class'];
				$contract[$key]['country'] = $value['address_country'];
				$contract[$key]['province_name'] = $value['addres_prop'];
				$contract[$key]['city_name'] = $value['city_name'];
				$contract[$key]['vendor_address'] = $value['address_street'];
				$contract[$key]['address_postcode'] = $value['address_postcode'];
				$contract[$key]['subject_work'] = $value['subject_work'];
				$contract[$key]['scope_work'] = $value['scope_work'];
				$contract[$key]['contract_type'] = $value['contract_type'];
				$contract[$key]['currency'] = $value['currency'];
				$contract[$key]['ctr_jenis'] = $value['ctr_jenis'];
				$contract[$key]['kategori_pekerjaan'] = $value['kategori_pekerjaan'];
				$contract[$key]['sign_date'] = $value['sign_date'];
				$contract[$key]['start_date'] = $value['start_date'];
				$contract[$key]['end_date'] = $value['end_date'];
				$contract[$key]['nomor_kontrak_sebelumnya'] = $value['amandemen_number'];
				$contract[$key]['is_3pl_ins'] = $value['is_3pl_ins'];
				$contract[$key]['notes'] = $value['notes'];
				$contract[$key]['spe_pos_name'] = $value['ctr_spe_pos_name'];
				$contract[$key]['type_winner'] = $value['type_winner'];
				$contract[$key]['subtotal_rab'] = $value['subtotal_rab'];
				$contract[$key]['created_date'] = $value['created_date'];
			}

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $contract
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_item_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$items = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_item($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$items[$key]['vendor_code'] = $value['vendor_code'];
				$items[$key]['item_code'] = $value['item_code'];
				$items[$key]['short_description'] = $value['short_description'];
				$items[$key]['price'] = $value['price'];
				$items[$key]['qty'] = $value['qty'];
				$items[$key]['uom'] = $value['uom'];
				$items[$key]['sub_total'] = $value['sub_total'];
				$items[$key]['incoterm'] = $value['incoterm'];
				$items[$key]['lokasi_incoterm'] = $value['lokasi_incoterm'];
			}

			$this->response([
				'status' => true,
				'total_item' => $total,
				'contract_id' => $contract_id,
				'data_item' => $items
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_doc_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];

		$dokumen = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_dokumen($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$dokumen[$key]['description'] = $value['description'];
				$dokumen[$key]['file_name'] = $value['filename'];
				$dokumen[$key]['file_url'] = $value['filename'] != NULL ? $protocol . $domainName . "/log/download_attachment/contract/document/" . $value['filename'] : '';
				$dokumen[$key]['type_file'] = pathinfo($dokumen[$key]['file_url'], PATHINFO_EXTENSION);
				$dokumen[$key]['kirim_vendor?'] = $value['publish'] == 1 ? 'Ya' : 'Tidak';
				$dokumen[$key]['name_input'] = $value['name_input'];
				$dokumen[$key]['upload_date'] = $value['upload_date'];
			}

			$this->response([
				'status' => true,
				'total_doc' => $total,
				'contract_id' => $contract_id,
				'data_doc' => $dokumen
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_jaminan_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];

		$jaminan = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_jaminan_api($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$jaminan[$key]['jenis_jaminan'] = $value['cj_jenis_jaminan'];
				$jaminan[$key]['tipe_jaminan'] = $value['cj_tipe_jaminan'];
				$jaminan[$key]['nama_perusahaan'] = $value['cj_nama_perusahaan'];
				$jaminan[$key]['nomor_jaminan'] = $value['cj_nomor_jaminan'];
				$jaminan[$key]['alamat'] = $value['cj_alamat'];
				$jaminan[$key]['nilai'] = $value['cj_nilai'];
				$jaminan[$key]['date_start'] = $value['cj_date_start'];
				$jaminan[$key]['date_end'] = $value['cj_date_end'];
				$jaminan[$key]['lampiran'] = $value['cj_lampiran'] != NULL ? $protocol . $domainName . "/log/download_attachment/contract/jaminan/" . $value['cj_lampiran'] : '';
				$catatan[$key]['type_file'] = pathinfo($jaminan[$key]['lampiran'], PATHINFO_EXTENSION);
				$jaminan[$key]['created_by'] = $value['cj_created_by'];
				$jaminan[$key]['created_date'] = $value['cj_created_date'];
			}

			$this->response([
				'status' => true,
				'total_jaminan' => $total,
				'contract_id' => $contract_id,
				'data_jaminan' => $jaminan
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_risiko_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$risiko = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_risiko($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				if (isset($value['pr_number'])) {
					$risiko[$key]['pr_number'] = $value['pr_number'];
					$risiko[$key]['ptm_number'] = $value['ptm_number'];
					$risiko[$key]['risiko'] = $value['risiko'];
					$risiko[$key]['penyebab'] = $value['penyebab'];
					$risiko[$key]['dampak'] = $value['dampak'];
					$risiko[$key]['rating_probabilitas'] = $value['rating_probabilitas'];
					$risiko[$key]['rating_dampak'] = $value['rating_dampak'];
					$risiko[$key]['level_risiko'] = $value['level_risiko'];
					$risiko[$key]['pic'] = $value['pic'];
					$risiko[$key]['mitigasi'] = $value['mitigasi'];
					$risiko[$key]['kategori'] = $value['kategori'];
					$risiko[$key]['date_created'] = $value['date_created'];
					$risiko[$key]['created_by'] = $value['created_by'];
				} else {
					$this->response([
						'status' => FALSE,
						'message' => 'No data were found'
					], REST_Controller::HTTP_NOT_FOUND);
				}
			}

			$this->response([
				'status' => true,
				'total_risiko' => $total,
				'contract_id' => $contract_id,
				'data_risiko' => $risiko
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_opportunity_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$opportunity = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_opportunity($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				if (isset($value['pr_number'])) {
					$opportunity[$key]['pr_number'] = $value['pr_number'];
					$opportunity[$key]['ptm_number'] = $value['ptm_number'];
					$opportunity[$key]['pengusul'] = $value['pengusul'];
					$opportunity[$key]['area'] = $value['area'];
					$opportunity[$key]['opportunity'] = $value['opportunity'];
					$opportunity[$key]['benefit'] = $value['benefit'];
					$opportunity[$key]['nilai_benefit'] = $value['nilai_benefit'];
					$opportunity[$key]['probabilitas'] = $value['probabilitas'];
					$opportunity[$key]['rtl'] = $value['rtl'];
					$opportunity[$key]['biaya'] = $value['biaya'];
					$opportunity[$key]['hambatan'] = $value['hambatan'];
					$opportunity[$key]['date_created'] = $value['date_created'];
					$opportunity[$key]['created_by'] = $value['created_by'];

				} else {
					$this->response([
						'status' => FALSE,
						'message' => 'No data were found'
					], REST_Controller::HTTP_NOT_FOUND);
				}
			}

			$this->response([
				'status' => true,
				'total_opportunity' => $total,
				'contract_id' => $contract_id,
				'data_opportunity' => $opportunity
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_milestone_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];

		$milestone = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_milestone_api($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$milestone[$key]['description'] = $value['description'];
				$milestone[$key]['percentage'] = $value['percentage'];
				$milestone[$key]['target_date'] = $value['target_date'];
				$milestone[$key]['nilai'] = $value['nilai'];
				$milestone[$key]['note'] = $value['note'];
				$milestone[$key]['milestone_file'] = $value['milestone_file'] != NULL ? $protocol . $domainName . "/log/download_attachment/contract/milestone/" . $value['milestone_file'] : '';
				$milestone[$key]['type_file'] = pathinfo($milestone[$key]['milestone_file'], PATHINFO_EXTENSION);
			}

			$this->response([
				'status' => true,
				'total_milestone' => $total,
				'contract_id' => $contract_id,
				'data_milestone' => $milestone
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_person_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$person = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_person_api($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$person[$key]['nama_lengkap'] = $value['cp_nama_lengkap'];
				$person[$key]['jabatan'] = $value['cp_jabatan'];
				$person[$key]['divisi'] = $value['cp_divisi'];
				$person[$key]['nama_perusahaan'] = $value['cp_nama_perusahaan'];
				$person[$key]['no_telp'] = $value['cp_no_telp'];
				$person[$key]['email'] = $value['cp_email'];
				$person[$key]['note'] = $value['cp_note'];
				$person[$key]['created_by'] = $value['cp_created_by'];
				$person[$key]['created_date'] = $value['cp_created_date'];
			}

			$this->response([
				'status' => true,
				'total_person' => $total,
				'contract_id' => $contract_id,
				'data_person' => $person
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_aktivitas_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];

		$aktivitas = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_aktivitas($contract_id)->result_array();
		$total = count($data);

		if ($data) {
			foreach ($data as $key => $value) {
				$aktivitas[$key]['ptm_number'] = $value['ptm_number'];
				$aktivitas[$key]['pos_code'] = $value['ccc_pos_code'];
				$aktivitas[$key]['position'] = $value['ccc_position'];
				$aktivitas[$key]['name'] = $value['ccc_name'];
				$aktivitas[$key]['aktifitas'] = $value['awa_name'];
				$aktivitas[$key]['start_date'] = $value['ccc_start_date'];
				$aktivitas[$key]['end_date'] = $value['ccc_end_date'];
				$aktivitas[$key]['response'] = $value['ccc_response'];
				$aktivitas[$key]['comment'] = $value['ccc_comment'];
				$aktivitas[$key]['user_id'] = $value['ccc_user'];
				$aktivitas[$key]['user_name'] = $value['complete_name'];
			}

			$this->response([
				'status' => true,
				'total_aktivitas' => $total,
				'contract_id' => $contract_id,
				'data_aktivitas' => $aktivitas
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_catatan_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];

		$catatan = array();

		$contract_id = $this->get('contract_id');

		$data = $this->sync_postgre_model->get_contract_catatan($contract_id)->result_array();
		$total = $this->sync_postgre_model->get_contract_catatan($contract_id)->num_rows();

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}
		
		if ($data) {
			foreach ($data as $key => $value) {
				$catatan[$key]['id'] = $value['id'];
				$catatan[$key]['ptm_number'] = $value['cad_ptm_number'];
				$catatan[$key]['comment'] = $value['cad_comment'];
				$catatan[$key]['user_id'] = $value['cad_user_id'];
				$catatan[$key]['user_name'] = $value['cad_user_name'];
				$catatan[$key]['position'] = $value['cad_position'];
				$catatan[$key]['obj_nilai'] = $value['cad_obj_nilai'];
				$catatan[$key]['lampiran'] = $value['cad_lampiran'] != NULL ? $protocol . $domainName . "/log/download_attachment/contract/comment/" . $value['cad_lampiran'] : '';
				$catatan[$key]['type_file'] = pathinfo($catatan[$key]['lampiran'], PATHINFO_EXTENSION);
				$catatan[$key]['respon'] = $value['cad_respon'];
				$catatan[$key]['no_telp'] = $value['cad_no_telp'];
				$catatan[$key]['divisi'] = $value['cad_divisi'];
				$catatan[$key]['created_date'] = $value['cad_created_date'];
			}

			$this->response([
				'status' => true,
				'total_catatan' => $total,
				'contract_id' => $contract_id,
				'data_catatan' => $catatan
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_timeline_get(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$data = array();
		$result = array();

		$contract_id = $this->get('contract_id');
		$ptm_number = $this->get('ptm_number');

		if(!isset($contract_id) || !isset($ptm_number)) {
			return $this->notfound();
			die();
		}

		$data["pembuatan"] = $this->Comment_m->getEndDateApi($ptm_number, ['2010'], $contract_id)->row_array();	
		$data["approval"] = $this->Comment_m->getEndDateApi($ptm_number, ['2027'], $contract_id)->row_array();	
		$data["finalisasi"] = $this->Comment_m->getEndDateApi($ptm_number, ['2030'], $contract_id)->row_array();	
		$data["kontrak_aktif"] = $this->Comment_m->getEndDateApi($ptm_number, ['2901'], $contract_id)->row_array();	
		$data["kontrak_selesai"] = $this->Comment_m->getEndDateApi($ptm_number, ['2903'], $contract_id)->row_array();		

		
		if(isset($data["pembuatan"])) {

			$result["pembuatan"] = $data["pembuatan"]["comment_date"];
			$result["approval"] = $data["approval"]["comment_date"];
			$result["finalisasi"] = $data["finalisasi"]["comment_date"];
			$result["kontrak_aktif"] = $data["kontrak_aktif"]["comment_date"];
			$result["kontrak_selesai"] = $data["kontrak_selesai"]["comment_date"];

			$this->response([
				'status' => true,
				'contract_id' => $contract_id,
				'ptm_number' => $ptm_number,
				'data' => $result
			], REST_Controller::HTTP_OK);

		} else {

			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}

	}

	public function contract_catatan_add_post(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}
		
		$uploaddir = './uploads/contract/comment/';
		$file_name = NULL;
		
		$config['allowed_types'] = '*';
		$config['overwrite'] = false;
		$config['max_size'] = 3064;
		$config['upload_path'] = $uploaddir;
		$this->load->library('upload', $config);
		
		if(isset($_FILES['lampiran']['name'])) {
			$file_name = underscore($_FILES['lampiran']['name']);
			$uploadfile = $uploaddir.$file_name;
			move_uploaded_file($_FILES['lampiran']['tmp_name'], $uploadfile);
		}
	
		$data = array(
			'cad_contract_id' => $this->post('contract_id'),
			'cad_ptm_number' => $this->post('ptm_number'),
			'cad_comment' => $this->post('comment'),
			'cad_user_id' => $this->post('user_id'),
			'cad_position' => $this->post('pos_name'),
			'cad_user_name' => $this->post('complete_name'),
			'cad_created_date' => date("Y-m-d H:i:s"),
			'cad_obj_nilai' => $this->post('obj_nilai'),
			'cad_lampiran' => $file_name,
			'cad_respon' => $this->post('respon'),
			'cad_no_telp' => $this->post('no_telp'),
			'cad_divisi' => $this->post('dept_name'));

		$insert = $this->db->insert('ctr_comment_all_div', $data);

		if ($insert) {
			$this->response([
				'status' => true,
				'message' => 'Success insert data',
				'data' => $data
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Failed insert data'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_catatan_update_post(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$id = $this->post('id');

		$uploaddir = './uploads/contract/comment/';
		$file_name = NULL;

		$sql_cek = "
			select cad_lampiran from ctr_comment_all_div
			where id = '" . $id . "'
		";
		$data_cek = $this->db->query($sql_cek)->row_array();

		$config['allowed_types'] = '*';
		$config['overwrite'] = false;
		$config['max_size'] = 5064;
		$config['upload_path'] = $uploaddir;
		$this->load->library('upload', $config);

		if(isset($_FILES['lampiran']['name'])) {
			$file_name = underscore($_FILES['lampiran']['name']);
			$uploadfile = $uploaddir.$file_name;
			move_uploaded_file($_FILES['lampiran']['tmp_name'], $uploadfile);

		} else {
			
			$file_name = $data_cek['cad_lampiran'];
		}

		$data = array(
			'cad_contract_id' => $this->post('contract_id'),
			'cad_ptm_number' => $this->post('ptm_number'),
			'cad_comment' => $this->post('comment'),
			'cad_user_id' => $this->post('user_id'),
			'cad_position' => $this->post('pos_name'),
			'cad_user_name' => $this->post('complete_name'),
			'cad_obj_nilai' => $this->post('obj_nilai'),
			'cad_lampiran' => $file_name,
			'cad_respon' => $this->post('respon'),
			'cad_no_telp' => $this->post('no_telp'),
			'cad_divisi' => $this->post('dept_name')
		);

		$this->db->where('id', $id);
		$update = $this->db->update('ctr_comment_all_div', $data);

		if ($update) {
			$this->response([
				'status' => true,
				'message' => 'Success update data',
				'data' => $data
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Failed update data'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_catatan_del_delete(){
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$catatan_id = $this->delete('id');

		if(!isset($catatan_id)) {
			return $this->notfound();
			die();
		} 

		$data = $this->db->where('id', $catatan_id)->delete('ctr_comment_all_div');

		if ($data) {	
			$this->response([
				'status' => true,
				'catatan_id' => $catatan_id,
				'message' => 'Success delete data'
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Failed delete data'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	// end modul kontrak

	public function list_divisi_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}

		$this->db->select('DISTINCT(kddivisi) kddivisi, divisiname');
		$where = "kddivisi is  NOT NULL";
		$this->db->where($where);
		$data = $this->db->get('project_info')->result_array();
		$total = count($data);

		$divisi = array();
		if ($data) {
			foreach ($data as $key => $value) {
				$divisi[$key]['kddivisi'] = $value['kddivisi'];
				$divisi[$key]['divisiname'] = $value['divisiname'];
			}

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $divisi
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No divisi were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_list_divisi_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}

		$this->db->where('dept_active', 1);
		$this->db->order_by('dept_id', 'asc');
		$data = $this->db->get('adm_dept')->result_array();
		$total = count($data);

		$divisi = array();
		if ($data) {
			foreach ($data as $key => $value) {
				$divisi[$key]['dept_id'] = $value['dept_id'];
				$divisi[$key]['dept_name'] = $value['dept_name'];
				$divisi[$key]['dep_code'] = $value['dep_code'];
				$divisi[$key]['district_id'] = $value['district_id'];
			}

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $divisi
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No divisi were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function pmcs_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$filter = array();
		$filter['divisi'] = $this->get('kd_divisi');
		$filter['period'] = $this->get('period');
		$filter['b_date'] = $this->get('date_range'); // 2022/07/01 11:00 - 2022/07/02 19:00
		$filter['free_text'] = $this->get('str_like');

		$limit = $this->get('limit');
		$offset = $this->get('offset');

		$data = $this->Procpr_m->get_prcplanintegrasi($filter, $limit, $offset)->result_array();
		$total =  $this->Procpr_m->get_prcplanintegrasi($filter,'','')->num_rows();

		$pmcs = array();
		if ($data) {
			foreach ($data as $key => $value) {
				$pmcs[$key]['smbd_code'] = $value['smbd_code'];
				$pmcs[$key]['smbd_name'] = $value['smbd_name'];
				$pmcs[$key]['project_name'] = $value['project_name'];
				$pmcs[$key]['unit'] = $value['unit'];
				$pmcs[$key]['smbd_quantity'] = $value['smbd_quantity'];
				$pmcs[$key]['price'] = $value['price'];
				$pmcs[$key]['total'] = $value['total'];
				$pmcs[$key]['ppv_remain'] = $value['ppv_remain'];
				$pmcs[$key]['ppv_main'] = $value['ppv_main'];
				$pmcs[$key]['spk_code'] = $value['spk_code'];
				$pmcs[$key]['user_name'] = $value['user_name'];
				$pmcs[$key]['updated_date'] = $value['updated_date'];
				$pmcs[$key]['sbu'] = $value['sbu'];
				$pmcs[$key]['lokasi'] = $value['lokasi'];
				$pmcs[$key]['divisiname'] = $value['divisiname'];
				$pmcs[$key]['kddivisi'] = $value['kddivisi'];
				$pmcs[$key]['periode_pengadaan'] = $value['periode_pengadaan'];
			}

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $pmcs
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No pmcs were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function pmcs_history_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$filter = array();
		$filter['smbd'] = $this->get('smbd_code');
		$filter['dd'] = $this->get('date_range');
		$filter['search'] = $this->get('search');

		$limit = $this->get('limit');
		$offset = $this->get('offset');

		$data = $this->Procpr_m->query_pmcs_hisoty($filter, $limit, $offset)->result_array();
		$total = $this->Procpr_m->query_pmcs_hisoty($filter,'','')->num_rows();

		$history = array();
		if ($data) {
			foreach ($data as $key => $value) {
				$history[$key]['project_name'] = $value['project_name'];
				$history[$key]['ppv_no'] = $value['ppv_no'];
				$history[$key]['user_name'] = $value['user_name'];
				$history[$key]['created_datetime'] = $value['created_datetime'];
				$history[$key]['lokasi'] = $value['lokasi'];
				$history[$key]['ppv_remain'] = $value['ppv_remain'];
			}

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $history
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No pmcs history were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}

	}

	public function pmcs_volume_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$kode_smbd = $this->get('smbd_code');

		$s_sql = "
            select prc_plan_integrasi.unit
            from prc_plan_integrasi
            where
                prc_plan_integrasi.smbd_code = '".$kode_smbd."'
        ";


        $smbd = $this->db->query($s_sql)->row_array();

		$f_year = $this->get('year');

		$this->db->select("
            EXTRACT ( YEAR FROM MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) as min,
            EXTRACT ( YEAR FROM MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) as max
        ");
		if (isset($f_year)) {
			$this->db->where("EXTRACT ( YEAR FROM TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) =". $f_year);
		}
        $year = $this->db->get_where('prc_plan_integrasi', ['smbd_code' => $kode_smbd])->row_array();

		## clone
        $month = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        for ($i=$year['min']; $i <= $year['max']; $i++) {
            $this->db->select("
                id,
                smbd_quantity,
                EXTRACT ( MONTH FROM TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) as month
            ");
            $this->db->from('prc_plan_integrasi');
            $this->db->where("EXTRACT ( YEAR FROM TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) =". $i);
            $this->db->where('smbd_code', $kode_smbd);
            $this->db->order_by("EXTRACT ( MONTH FROM TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ");

            $clone = $this->db->get()->result_array();
            foreach ($clone as $k => $v) {
                if ($v['smbd_quantity'] > 0) {
                    $cc = $this->db->get_where('prc_plan_change_period', ['id_ppi' => $clone[$k]['id']])->num_rows();
                    if ($cc < 1) {
                        $inn = [
                            'id_ppi' => $clone[$k]['id'],
                            'volume' => $clone[$k]['smbd_quantity'],
                            'period' => $i.'-'.$month[$clone[$k]['month']-1].'-01',
                            'createdate' => date("Y-m-d H:i:s"),
                            'smbd' => $kode_smbd,
                        ];

                        $this->db->insert('prc_plan_change_period', $inn);
                    }
                }
            }
        }

        $vol = [];
        for ($i=$year['min']; $i <= $year['max']; $i++) {
            $vl = [0,0,0,0,0,0,0,0,0,0,0,0];
            $ids = [0,0,0,0,0,0,0,0,0,0,0,0];
            $ch = array();

            $ch['year'] = $i;
            $ch['unit'] = $smbd['unit'];

            $sqll = "
                SELECT *,
                EXTRACT ( MONTH FROM TO_DATE( period, 'YYYY-MM-DD' ) ) as month,
                EXTRACT ( YEAR FROM TO_DATE( period, 'YYYY-MM-DD' ) ) as year
                FROM prc_plan_change_period
                WHERE smbd = '$kode_smbd' AND EXTRACT ( YEAR FROM TO_DATE( period, 'YYYY-MM-DD' ) ) = '$i'
            ";
            $sv = $this->db->query($sqll)->result_array();

            if (count($sv) > 0) {
                foreach ($sv as $k => $v) {
                    $vl[$v['month']-1] = $vl[$v['month']-1] + $v['volume'];
                    $ids[$v['month']-1] = $v['id'];
                }
                $ch['vol'] = $vl;
                $ch['ids'] = $ids;
            } else {
                $ch['vol'] = $vl;
                $ch['ids'] = $ids;
            }


            $vol[] = $ch;
        }

		$data = $vol;
		$total = count($vol);

		$volume = array();
		if ($data) {
			foreach ($data as $key => $value) {
				$volume[$key]['year'] = $value['year'];
				$volume[$key]['unit'] = $value['unit'];
				$volume[$key]['jan'] = $value['vol'][0];
				$volume[$key]['feb'] = $value['vol'][1];
				$volume[$key]['mar'] = $value['vol'][2];
				$volume[$key]['apr'] = $value['vol'][3];
				$volume[$key]['mei'] = $value['vol'][4];
				$volume[$key]['jun'] = $value['vol'][5];
				$volume[$key]['jul'] = $value['vol'][6];
				$volume[$key]['agu'] = $value['vol'][7];
				$volume[$key]['sep'] = $value['vol'][8];
				$volume[$key]['okt'] = $value['vol'][9];
				$volume[$key]['nov'] = $value['vol'][10];
				$volume[$key]['des'] = $value['vol'][11];
				$volume[$key]['id_jan'] = $value['ids'][0];
				$volume[$key]['id_feb'] = $value['ids'][1];
				$volume[$key]['id_mar'] = $value['ids'][2];
				$volume[$key]['id_apr'] = $value['ids'][3];
				$volume[$key]['id_mei'] = $value['ids'][4];
				$volume[$key]['id_jun'] = $value['ids'][5];
				$volume[$key]['id_jul'] = $value['ids'][6];
				$volume[$key]['id_agu'] = $value['ids'][7];
				$volume[$key]['id_sep'] = $value['ids'][8];
				$volume[$key]['id_okt'] = $value['ids'][9];
				$volume[$key]['id_nov'] = $value['ids'][10];
				$volume[$key]['id_des'] = $value['ids'][11];
			}

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $volume
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No pmcs volume were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}

	}

	public function pmcs_volume_change_post()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$m = $this->post('month');
		$y = $this->post('year');
		$i = $this->post('ids');
		$s = $this->post('smbd_code');


        $bulan = ["Januari",		"Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $period = $y.'-'.$m.'-01';
        $prev = $this->db->get_where('prc_plan_integrasi', ['id' => $i])->row_array();

        $upd = [
            'period' => $period,
            'createdate' => date("Y-m-d H:i:s"),
        ];
        $this->db->where('id', $i);
        $insert = $this->db->update('prc_plan_change_period', $upd);

		$hist = $this->Procpr_m->get_prcplanintegrasismbd($s)->row_array();

        $arr_hist = [
            'kode_spk' => $hist['spk_code'],
            'nama_spk' => $hist['project_name'],
            'desc' => "Mengubah periode pengadaan ke ". $bulan[$m-1]. ' ' .$y,
            'kasie_pengadaan' => $hist['user_name'],
            'lokasi' => $hist['lokasi'],
            'sisa_volume' => $hist['ppv_remain'],
            'updatedate' => date("Y-m-d H:i:s"),
            'smbd' => $s,
        ];

        $this->db->insert('prc_plan_history', $arr_hist);

		if ($insert) {
			$this->response([
				'status' => true,
				'message' => 'Success, Period volume has changed!'
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function pemaketan_pmcs_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}
		include('api/pemaketan_pmcs.php');
	}
	
	public function pemaketan_detail_pmcs_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}
		include('api/pemaketan_detail_pmcs.php');
	}

	public function tender_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}
		include('api/tender_list.php');
	}

	public function tender_detail_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}
		include('api/tender_detail.php');
	}

	public function privy_tender_detail_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}
		include('api/tender_detail.php');
	}

	public function privy_search_list_doc_status_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}
		//include('api/privy_doc_sign_process.php');

		$param = $this->get('param');
		$status = $this->get('status');

		
		$this->db->select('*');
		if(isset($status))
		{
			$this->db->where('status', $status);
			
		}
		$this->db->group_start();
		$this->db->like('ptm_number',$param);
		$this->db->or_like('ptm_subject_of_work',$param);
		$this->db->or_like('ptm_packet',$param);
		$this->db->or_like('date',$param);
		$this->db->or_like('status',$param);
		$this->db->group_end();
		$res = $this->db->get('vw_tender_privy_status')->result_array();
		

		$data = $res;

		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function privy_list_doc_status_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}
		//include('api/privy_doc_sign_process.php');
		$res = $this->db->get('vw_tender_privy_status')->result_array();
		

		$data = $res;

		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function project_info_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}
			
		$data = $this->db->get('project_info')->result_array();
	
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function department_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$data = $this->db->get('adm_dept')->result_array();
	
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function inconterm_get()
	{
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}

		$data = $this->db->get('adm_incoterm')->result_array();
	
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}	

	private function send_message_wa($rfqNo,$privyId,$fullname = 'ADIP', $numberTo = '081316448288')
    {
        $ret = false;

        $url =  $this->config->item('URL');
        $numberFrom =  $this->config->item('SENDER');
        $api_key =  $this->config->item('API_KEY');
        $url_request = base_url()."procurement/privy/request_sign_bakp?rfqno=".$rfqNo."&privyid=".$privyId;
        $message = "hello ".$fullname.", SISTEM USKEP ONLINE sudah di share. untuk melalakukan e-sign, cek link berikut : ".$url_request;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "api_key": "'.$api_key.'",
            "sender": "'.$numberFrom.'",
            "number": "'.$numberTo.'",
            "message": "'.$message.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        if($response->status == true) {
            $ret = true;
        }

        return $ret;

    }

	public function profile_get() {
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
		}

		$user_id = $this->uri->segment(3, 0);
		
		if($user_id > 0) {

			$userdata = $this->Administration_m->getUser($user_id)->row_array();

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
		
		if ($userdata) {
			$this->response([
				'status' => true,
				'data' => $userdata
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}

	}

	// connect privy 

		public function privy_detail_document_get()
		{
			if ($this->authtoken() == 'fail'){
				return $this->unauthorized();
				die();
			}
			
			$rfqNo = $this->uri->segment(3, 0);
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$domainName = $_SERVER['HTTP_HOST'];

			$output_filename = "uploads/USKEP_BAKP_".$rfqNo.".pdf";
			$documentDetail = $this->document_detail($rfqNo);
			$host = $documentDetail->data->document_url->signed->url == "" ? $documentDetail->data->document_url->original->url : $documentDetail->data->document_url->signed->url;

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $host);
					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_AUTOREFERER, false);
					curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					$result = curl_exec($ch);
					curl_close($ch);
				
					// the following lines write the contents to a file in the same directory (provided permissions etc)
					$fp = fopen($output_filename, 'wb');
					fwrite($fp, $result);
					fclose($fp);

				$full_url = base_url().$output_filename;
				$data = $full_url;

			if ($data) {
				$this->response([
					'status' => true,
					'data' => $data,
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'No data were found'
				], REST_Controller::HTTP_NOT_FOUND);
			}

		}

		public function privy_request_otp_get()
		{
			if ($this->authtoken() == 'fail'){
				return $this->unauthorized();
				die();
			}
			//include('api/privy_doc_send_request_otp.php');

			$rfqId = $this->uri->segment(3, 0);
			$privyId = $this->uri->segment(4, 0);

			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$domainName = $_SERVER['HTTP_HOST'];

				# code...
				$timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
				$privyId = $privyId != "" ? $privyId : "DEVWI6049"; //testing;
				$URL =  $this->config->item('URL_DEV_HASH').'/document/sign';
				$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
				$config['USERNAME'] = $this->config->item('USERNAME');
				$config['PASSWORD'] = $this->config->item('PASSWORD');
				$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
				$config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
				$config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

				//base64 imaage
				$getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
				$docToken = $getDataUskep['doc_token'];

				

				$data['doc_token'] = $docToken;
				$data['identifier'] = $privyId;
				
				
				$body = $data;
				$signature = $this->signature($body, 'POST', $timestamp);


				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL => $URL,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_POST => 1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => json_encode($body),
					CURLOPT_HTTPHEADER => array(
						'X-Authorization-Signature: ' . $signature,
						'X-Authorization-Timestamp: ' . $timestamp,
						'X-Flow-Process: default',
						'cache-control: no-cache',
						'Content-Type: application/json',
						'Merchant-Key:' . $config['MERCHANT_KEY'],
						'User-Agent: wika/1.0'
					),
				));


				$response = curl_exec($curl);

				curl_close($curl);
				$res = json_decode($response);
				

				$data = $res;

			if ($data) {
				$this->response([
					'status' => true,
					'data' => $data,
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'No data were found'
				], REST_Controller::HTTP_NOT_FOUND);
			}

		}

		public function privy_sign_doc_post()
		{
			if ($this->authtoken() == 'fail'){
				return $this->unauthorized();
				die();
			}
			//include('api/privy_doc_sign_process.php');

			$rfqId = $this->input->post('rfq_no');
			$privyId = $this->input->post('privy_id');
			$otp_code = $this->input->post('otp_code');


			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$domainName = $_SERVER['HTTP_HOST'];

			# code...
			$timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
			$privyId = $privyId != "" ? $privyId : "DEVWI6049";

			$URL =  $this->config->item('URL_DEV_HASH').'/document/sign/process';
			$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
			$config['USERNAME'] = $this->config->item('USERNAME');
			$config['PASSWORD'] = $this->config->item('PASSWORD');
			$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
			$config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
			$config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

			//base64 imaage
			$getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
			$docToken = $getDataUskep['doc_token'];

			$data['doc_token'] = $docToken;
			$data['identifier'] = $privyId;
			$data['reason'] = "For testing only";
			$data['otp_code'] = $otp_code;
			
			$body = $data;
			$signature = $this->signature($body, 'POST', $timestamp);

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $URL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_POST => 1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($body),
				CURLOPT_HTTPHEADER => array(
					'X-Authorization-Signature: ' . $signature,
					'X-Authorization-Timestamp: ' . $timestamp,
					'X-Flow-Process: default',
					'cache-control: no-cache',
					'Content-Type: application/json',
					'Merchant-Key:' . $config['MERCHANT_KEY'],
					'User-Agent: wika/1.0'
				),
			));

			$response = curl_exec($curl);
			$response = trim(str_replace('\u0026', '&', $response));
			curl_close($curl);
			$res = json_decode($response);
				
			$data = $res;

			//$data = true;

			if ($data) {
			
			$insert['rfq_no'] = str_replace(' ','',$rfqId); //$getDataUskep['rfq_number'];
			$insert['privy_id'] =  $privyId;
			$insert['type'] = 'BAKP';

			$this->db->insert('prc_tender_privy_sign', $insert);

			$this->db->where('rfq_no', $rfqId);
			$ttdList = $this->db->get('VW_TENDER_PRIVY_HAS_SIGN')->result_array();
			$listTtd = explode(";",$getDataUskep['bakp_nip']);
			$recipients_wa = [];
			$response = 0;

			if(count($ttdList) > 0)
			{
				
				foreach ($listTtd as $key => $value) {
					# code...
					if($key == 0){
						$response = 321;
					} else {
						$response = 479;

					}

					$this->db->where('nip', $value);
					$usr = $this->db->get('vw_user_employee_hcis')->row_array();

					if($usr != null)
					{
						
						if((count($listTtd) - 1) - count($ttdList) == $key)
						{
							$recipients_wa = [
								[
									'number' => $usr['handphone_1'] != null ? str_replace("62","0",$usr['handphone_1']) : "0"  ,
									'name' => $usr['nm_peg'],
									'privy'=> $usr['signer_id']
					
								]
							];
							
							// $last_comment = $this->Comment_m->getProcurementRFQ($rfqId,"")->row_array();

							// $last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 0;
						
							// $ptm_number = $last_comment['tender_id'];
						
							// $tender = $this->Procrfq_m->getRFQ($last_comment['tender_id'])->row_array();

							// $ranked_index = [];

							// $winner_quota = [];

							// $response_name = "";
							
							// if($response > 0){
						
							// 	$resp = $this->db
							// 	->where("awr_id",$response)
							// 	->get("adm_wkf_response")
							// 	->row_array();
						
							// 	$response_name = url_title($resp['awr_name'],"_",true);
						
							// }

							// $p = [
							// 			'set' => NULL,
							// 			'panitia_id' => $usr['user_id']
							// 		];

							// $return = $this->Procedure_m->prc_tender_comment_complete($ptm_number,$usr['fullname'],$last_activity,$response_name,"PRIVY","",$last_comment['comment_id'],$usr['employeeid'],$tender['ptm_type_of_plan'],$ranked_index, $winner_quota, $p);
						
							// if(!empty($return['nextactivity'])){
							// 	if(count($ttdList) != count($listTtd))
							// 	{
							// 		if($key > 0)
							// 		{
							// 			$return['nextactivity'] == 1141;
							// 		}
							// 	}
							// 	$update = $this->db
							// 	->where(array("ptm_number"=>$ptm_number))
							// 	->update("prc_tender_main",array(
							// 		"ptm_status" => $return['nextactivity'],
							// 	));
					
							// 	if($return['nextjobtitle'] == "MANAJER PENGADAAN" && empty($user_id)){
							// 		$user_id = $tender['ptm_man_emp_id'];
							// 	}
					
							// 	$comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$return['nextactivity'],"","","",$return['nextposcode'],$return['nextposname'],$usr['user_id']);
								
							// }

						}

					}
				}

				if(count($ttdList) == count($listTtd)) {
					//update privy sign complete
					$response = 670;
					$object['is_complete'] = 1;
					$object['is_complete_by'] = $usr['nm_peg'];

					$this->db->where('rfq_number', str_replace(' ','',$rfqId));
					$this->db->update('prc_tender_uskep_online', $object);

					//generate po
					$rfqId = str_replace(' ','',$rfqId);
					$idko = "";
					$oop = $this->db->get_where('prc_tender_item', ['ptm_number' => $rfqId])->row_array();
					$aa = "
						cci.tit_code,
						cci.tit_quantity,
						cci.tit_unit,
						(select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
					";
					$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";

					if ($oop['tit_acc_assig'] == "Q" && $oop['tit_cat_tech'] == 0) {
						$idko = "B";              
						$aa = "
							cci.tit_code,
							cci.tit_quantity,
							cci.tit_unit,
							(select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
							";
						$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
					}

					if ($oop['tit_acc_assig'] == "X" && $oop['tit_cat_tech'] == 5) {
						$idko = "B";              
						$aa = "
							cci.tit_code,
							cci.tit_quantity,
							cci.tit_unit,
							(select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
							";
						$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
					} 

					if ($oop['tit_acc_assig'] == "P" && $oop['tit_cat_tech'] == 0) {
						$idko = "B";              
						$aa = "
							cci.tit_code,
							cci.tit_quantity,
							cci.tit_unit,
							(select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
							";
						$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
					}

					if ($oop['tit_acc_assig'] == "N" && $oop['tit_cat_tech'] == 9) {
						$idko = "J";
						$aa = "'' as service, '' as quantity, '' as uoms, '' as prices,";
						$bb = "
							cci.tit_code,
							cci.tit_quantity,
							cci.tit_unit,
							(select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
							";
					} 

					if ($oop['tit_acc_assig'] == "U" && $oop['tit_cat_tech'] == 0) {
						$idko = "A";
						$aa = "
							cci.tit_code,
							cci.tit_quantity,
							cci.tit_unit,
							(select min(pqi_price) sub_total from vw_prc_evaluation_sap where pass_price = 'Lulus' and ptm_number = '".$rfqId."') as sub_total,
							";
						$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
					}
					// case
						// when cch.ptm_created_date is not null 
						// then concat(to_char(cch.ptm_created_date, 'YYYY'), '.', to_char(cch.ptm_created_date, 'MM'), '.', to_char(cch.ptm_created_date, 'DD')) 
						// else null
						// end as start_date,
					$sql = "
					select
						cch.ptm_doc_type_sap,
						vnd.code_bp,
						concat(to_char(now(), 'YYYY'), '.', to_char(now(), 'MM'), '.', to_char(now(), 'DD')) start_date,
						admi.code,
						cci.tit_lokasi_incoterm,
						cci.tit_retention,
						case 
						when cch.ctr_down_payment = 0 then null
						else cch.ctr_down_payment
						end as ctr_down_payment,
						case
						when cch.ctr_down_payment_date is not null 
						then concat(to_char(cch.ctr_down_payment_date, 'YYYY'), '.', to_char(cch.ctr_down_payment_date, 'MM'), '.', to_char(cch.ctr_down_payment_date, 'DD'))
						else null
						end as ctr_down_payment_date,
						(ROW_NUMBER () OVER (ORDER BY cci.tit_id) * 10 ) tit_item_po,
						$aa
						cci.tit_pr_number,
						cci.tit_pr_item,
						'' contract_number,
						case
						when cch.ctr_delivery_date is not null 
						then concat(to_char(cch.ctr_delivery_date, 'YYYY'), '.', to_char(cch.ctr_delivery_date, 'MM'), '.', to_char(cch.ctr_delivery_date, 'DD'))
						else null
						end as ptm_created_date,
						cci.tit_no_asset,
						cci.tit_sub_number,
						cci.tit_tax_code,
						$bb
						cch.ctr_scope,
						concat(concat(to_char(cch.ctr_start_date, 'YYYY'),'.',to_char(cch.ctr_start_date, 'MM'),'.',to_char(cch.ctr_start_date, 'DD')),' - ',concat(to_char(cch.ctr_end_date, 'YYYY'),'.',to_char(cch.ctr_end_date, 'MM'),'.',to_char(cch.ctr_end_date, 'DD'))) as rangedate
					from
						prc_tender_main cch
						left join prc_tender_item cci on cch.ptm_number = cci.ptm_number
						left join adm_incoterm admi on cci.tit_incoterm = admi.description
						left join (select ptm_number,ptv_vendor_code vendor_id from vw_prc_evaluation where ptm_number = '".$rfqId."' order by total desc limit 1) ptw on cch.ptm_number = ptw.ptm_number
						left join vnd_header vnd on ptw.vendor_id = vnd.vendor_id
					where
						cch.ptm_number = '$rfqId'
					";

					$data = $this->db->query($sql)->result_array();

					$newl = "\n";
					$body = "";
					foreach ($data as $k => $v) {
						$body .= 1 .'|'. implode("|",$v) . $newl;

						//insert to table po
						$po['DOC_NO'] = 1;
						$po['DOC_TYPE'] = $v['ptm_doc_type_sap'];
						$po['VENDOR'] = $v['code_bp'];
						$po['DOC_DATE'] = $v['ptm_doc_type_sap'];
						$po['INCOTERMS1'] = $v['ptm_doc_type_sap'];
						$po['INCOTERMS2'] = $v['ptm_doc_type_sap'];
						$po['RETENTION_PERCENTAGE'] = $v['ptm_doc_type_sap'];
						$po['DOWNPAY_PERCENT'] = $v['ptm_doc_type_sap'];
						$po['DOWNPAY_DUEDATE'] = $v['ptm_doc_type_sap'];
						$po['PO_ITEM'] = $v['ptm_doc_type_sap'];
						$po['MATERIAL'] = $v['ptm_doc_type_sap'];
						$po['QUANTITY'] = $v['ptm_doc_type_sap'];
						$po['PO_UNIT'] = $v['ptm_doc_type_sap'];
						$po['NET_PRICE'] = $v['ptm_doc_type_sap'];
						$po['PREQ_NO'] = $v['ptm_doc_type_sap'];
						$po['PREQ_ITEM'] = $v['ptm_doc_type_sap'];
						$po['VEND_MAT'] = $v['ptm_doc_type_sap'];
						$po['DELIVERY_DATE'] = $v['ptm_doc_type_sap'];
						$po['ASSET_NO'] = $v['ptm_doc_type_sap'];
						$po['SUB_NUMBER'] = $v['ptm_doc_type_sap'];
						$po['TAX_CODE'] = $v['ptm_doc_type_sap'];
						$po['SERVICE'] = $v['ptm_doc_type_sap'];
						$po['SERVICE_QTY'] = $v['ptm_doc_type_sap'];
						$po['BASE_UOM'] = $v['ptm_doc_type_sap'];
						$po['GR_PRICE'] = $v['ptm_doc_type_sap'];
						$po['RUANG_LINGKUP'] = $v['ptm_doc_type_sap'];
						$po['JANGKA_WAKTU'] = $v['ptm_doc_type_sap'];
						$po['SOURCE'] = "E";
						$po['RFQ_NO'] = $rfqId;

						$this->db->insert('prc_tender_po', $po);
						

					}

					$todaydate = date('Ymd');
					$time_utc=mktime(date('G'),date('i'),date('s'));
					$NowisTime=date('Gis',$time_utc);

					$hex = bin2hex(openssl_random_pseudo_bytes(16));

					$hea2 = "YMMI005".$idko."|".strtoupper($hex)."|A000||".$todaydate.$NowisTime;
					$head = 'DOC_NO|DOC_TYPE|VENDOR|DOC_DATE|INCOTERMS1|INCOTERMS2|RETENTION_PERCENTAGE|DOWNPAY_PERCENT|DOWNPAY_DUEDATE|PO_ITEM|MATERIAL|QUANTITY|PO_UNIT|NET_PRICE|PREQ_NO|PREQ_ITEM|VEND_MAT|DELIVERY_DATE|ASSET_NO|SUB_NUMBER|TAX_CODE|SERVICE|SERVICE_QTY|BASE_UOM|GR_PRICE|RUANG_LINGKUP|JANGKA_WAKTU';

					$directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound';

					$path = 'uploads/PO';
					if (!is_dir($path))
						mkdir($path, 0777, true);

					$filename = 'YMMI005'.$idko.'_'.$todaydate.$NowisTime.'.txt';

					$output = $hea2.$newl.$head.$newl.$body;
					file_put_contents($path.'/'.$filename, $output);
					//print_r(file_put_contents($path.'/'.$filename, $output));
					// exit;
					copy($path.'/'.$filename, $directory.'/'.$filename);

						//update field generate po contract
					$update['ctr_generate_text_number'] = $filename;

					$this->db->where('ptm_number', $rfqId);
					$this->db->update('prc_tender_main', $update);
				}

				foreach ($recipients_wa as $key => $value) {
					# code...
					$this->send_message_wa($rfqId,$value['privy'],$value['name'],$value['number']);
					
				}
			}

				$this->response([
					'status' => true,
					'data' => $data,
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'No data were found'
				], REST_Controller::HTTP_NOT_FOUND);
			}
		}

		public function privy_reject_doc_get()
		{
			if ($this->authtoken() == 'fail'){
				return $this->unauthorized();
				die();
			}
			//include('api/privy_doc_sign_process.php');

			$rfqId = $this->get('rfq_id');
			$privyId = $this->get('privy_id');
			$notes = $this->get('notes');
			
			# code...
			$timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
			//$privyId = "DEVWI0989"; //testing;
			$URL =  $this->config->item('URL_DEV_HASH').'/document/reject';
			$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
			$config['USERNAME'] = $this->config->item('USERNAME');
			$config['PASSWORD'] = $this->config->item('PASSWORD');
			$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
			$config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
			$config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');
	
			//base64 imaage
			$getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
			$docToken = $getDataUskep['doc_token'];
			
			if($getDataUskep == null)
			{
				$this->response([
					'status' => false,
					'message' => "RFQ TIDAK DI TEMUKAN"
				], REST_Controller::HTTP_NOT_FOUND);
			}

			if($docToken == null || $docToken == '')
			{
				$this->response([
					'status' => false,
					'message' => "DOC TOKEN TIDAK DI TEMUKAN"
				], REST_Controller::HTTP_NOT_FOUND);
			}
			
			$data['doc_token'] = $docToken;
			$data['identifier'] = $privyId;
			
			$body = $data;
			$signature = $this->signature($body, 'POST', $timestamp);
	
	
			$curl = curl_init();
	
			curl_setopt_array($curl, array(
				CURLOPT_URL => $URL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_POST => 1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($body),
				CURLOPT_HTTPHEADER => array(
					'X-Authorization-Signature: ' . $signature,
					'X-Authorization-Timestamp: ' . $timestamp,
					'X-Flow-Process: default',
					'cache-control: no-cache',
					'Content-Type: application/json',
					'Merchant-Key:' . $config['MERCHANT_KEY'],
					'User-Agent: wika/1.0'
				),
			));
	
	
			$response = curl_exec($curl);
			$response = trim(str_replace('\u0026', '&', $response));
			curl_close($curl);
			$res = json_decode($response);
			

			$data = $res;

			if ($data) {
				//reject
				$this->db->where('signer_id', $privyId);
				$user = $this->db->get('adm_user')->row_array();
				
				$update['is_reject'] = 1;
				$update['is_reject_reason'] = $notes;
				$update['is_reject_by'] = $user['complete_name'];

				$this->db->where('rfq_number', $rfqId);
				$this->db->update('prc_tender_uskep_online', $update);

				
				

				$this->response([
					'status' => true,
					'data' => $data,
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => $data
				], REST_Controller::HTTP_NOT_FOUND);
			}
		}

		private function signature($jsonBody, $method, $timestamp)
		{
			# code...
			$clientId = $this->config->item('CLIENT_ID');
			$clientSecret = $this->config->item('CLIENT_SECRET');
			$jsonBody2 = json_encode($jsonBody);
			$jsonBody2 = trim(preg_replace('/\s/', '', $jsonBody2));
			$jsonBody2 = trim(preg_replace('/\n/', '', $jsonBody2));
			$jsonBody2 = trim(str_replace('\\', '', $jsonBody2));
			$bodyMD5 = md5($jsonBody2, true);
			$bodyMD5 = base64_encode($bodyMD5);

			$hmac_signature = $timestamp . ":" . $clientId . ":" . $method . ":" . $bodyMD5;
			$hmac = hash_hmac('sha256', $hmac_signature, $clientSecret, true);
			$hmac_base64 = base64_encode($hmac);

			$signature = "#" . $clientId . ":#" . $hmac_base64;
			$signature = base64_encode($signature);

			return $signature;
		}

		private function document_detail($rfqId,$privyId = "")
		{
			
			# code...
			$timestamp = date("c",strtotime(date('Y-m-d H:i:s')));
			$privyId = "DEVWI0989"; //testing;
			$URL =  $this->config->item('URL_DEV_HASH').'/document/detail';
			$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
			$config['USERNAME'] = $this->config->item('USERNAME');
			$config['PASSWORD'] = $this->config->item('PASSWORD');
			$config['MERCHANT_KEY'] = $this->config->item('MERCHANT_KEY');
			$config['CLIENT_ID'] = $this->config->item('CLIENT_ID');
			$config['CLIENT_SECRET'] = $this->config->item('CLIENT_SECRET');

			//base64 imaage
			$getDataUskep = $this->Procrfq_m->getUskepData($rfqId)->row_array();
			$docToken = $getDataUskep['doc_token'];

		

			$data['doc_token'] = $docToken;
			//$data['identifier'] = $privyId;
			
			$body = $data;
			$signature = $this->signature($body, 'POST', $timestamp);


			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $URL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_POST => 1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($body),
				CURLOPT_HTTPHEADER => array(
					'X-Authorization-Signature: ' . $signature,
					'X-Authorization-Timestamp: ' . $timestamp,
					'X-Flow-Process: default',
					'cache-control: no-cache',
					'Content-Type: application/json',
					'Merchant-Key:' . $config['MERCHANT_KEY'],
					'User-Agent: wika/1.0'
				),
			));


			$response = curl_exec($curl);
			$response = trim(str_replace('\u0026', '&', $response));
			curl_close($curl);
			$res = json_decode($response);
		


			return $res;

		}

	// end connect privy

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */
