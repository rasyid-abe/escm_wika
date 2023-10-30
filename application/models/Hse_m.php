<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hse_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getVendorActive($id = ""){


	}

	public function statusHseVendor($vendorId)
	{
		# code...
		$ret = false;

		$this->db->where('vendor_id', (int)$vendorId);
		$query = $this->db->get('vnd_cqsms_trx_h')->row_array();

		if($query != NULL) {
			if($query['cqsms_status'] == 0 || $query['cqsms_status'] == NULL) {
				$ret = true;
			}
		}

		return $ret;

	}

	public function statusHseVendorVerification($vendorId)
	{
		# code...
		$ret = false;

		$this->db->where('vendor_id', (int)$vendorId);
		$query = $this->db->get('vnd_cqsms_trx_h')->row_array();

		if($query != NULL) {
			if($query['cqsms_status'] == 1) {
				$ret = true;
			}
		}

		return $ret;

	}

	public function getHseByVendor($vendorId)
	{
		# code...
		$data = array();

		$this->db->where('vendor_id', (int)$vendorId);
		$query = $this->db->get('vnd_cqsms_trx_h')->row_array();
		if($query != NULL) {
			$data['header'] = $query;
			if($query['cqsms_type'] == 0){
				$this->db->where('vendor_id', (int)$vendorId);
				$detail = $this->db->get('vw_cqsms_pertanyaan')->result_array();
				foreach ($detail as $value) {
					# code...
					$data['detail'][$value['pertanyaan_id']] = $value;
					//$data['detail'][$value['bobot']] = $value;

				}
				
				//get total score pertanyaan
				$this->db->where('vendor_id', (int)$vendorId);
				$score = $this->db->get('vw_cqsms_score')->row_array();
				$data['header']['cqsms_total_score'] = $score['total_score'];
				$data['header']['cqsms_risk_status'] = $score['risk_status'];

			} else {
				//get detail
				$this->db->where('cqsms_trx_h_id', (int)$query['id']);
				$detail = $this->db->get('vnd_cqsms_trx_h_detail')->result_array();
				$data['detail'] = $detail;
				$score = $data['header']['cqsms_total_score']; 
				switch ($score) {
					case $score > 80:
						$data['header']['cqsms_risk_status'] = 'HIGH RISK';
						break;
					case $score > 60:
						$data['header']['cqsms_risk_status'] = 'MEDIUM RISK';
						break;
					default:
						$data['header']['cqsms_risk_status'] = 'LOW RISK';
						break;
				}
			}
		}

		return $data;
	}

	public	function GetVendorQuestionList($cot_id = null)
	{
		# code...
		$ret = array();

		if($cot_id != null) $this->db->where('pertanyaan_classification', $cot_id);
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
			$ret[$key]['pertanyaan_classification'] = $value['pertanyaan_classification'];
			$ret[$key]['is_show'] = $value['is_show'];
			$ret[$key]['is_template'] =  $value['is_template_catatan_kecelakaan'];

			$ret[$key]['jawaban'] = $this->getjawaban($value['id']);
			$ret[$key]['petunjuk_score'] = $this->get_petunjuk_score($value['id']);


		}
	
		return $ret;

	}

	public function get_petunjuk_score($pertanyaanId)
	{
		# code...
		$data = array();
		$this->db->where('pertanyaan_id', $pertanyaanId);

		$data = $this->db->get('vnd_cqsms_petunjuk_score')->result_array();

		return $data;
	}


	public function getjawaban($pertanyaanId)
	{
		# code...
		$data = array();
		$this->db->where('pertanyaan_id', $pertanyaanId);

		$data = $this->db->get('vnd_cqsms_jawaban')->result_array();

		return $data;
		
		
	}

	public function get_vendor_type($ackId)
	{
		# code...
		$this->db->where('ack_id', $ackId);
		
		return $this->db->get('adm_cot_kelompok')->row_array();
		
	}

	public function get_adm_cqsms_kecelakaan($headerId)
	{
		# code...
		$this->db->where('trxh_id', $headerId);
		
		return $this->db->get('vnd_cqsms_trx_catatan_kecelakaan')->result_array();
		
	}

	public function get_kategory_hse()
	{
		# code...
		$this->db->order_by('order_no', 'asc');
		
		return $this->db->get('vnd_cqsms_pertanyaan_kategori')->result_array();
		
	}

	public function get_vendor_score($vendor_id)
	{
		$data['score'] = array();
		$data['sub_score_category'] = array();

		$this->db->where('vendor_id', $vendor_id);
		$data['score'] = $this->db->get('vw_cqsms_vendor_score')->row_array();
		$this->db->where('vendor_id', $vendor_id);
		$this->db->order_by('order_no', 'asc');
		
		$data['sub_score_category'] = $this->db->get('vw_cqsms_vendor_score_per_category')->result_array();

		return $data;
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

					return redirect('administration/hse/verifikasi/detail/'.$post['vendor_id']);
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

			return redirect('administration/hse/verifikasi/detail/'.$post['vendor_id']);
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

					return redirect('administration/hse/verifikasi/');
		} else {
			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('message', 'Gagal Di Simpan !');

			return redirect('administration/hse/verifikasi/detail/'.$post['vendor_id']);
		}

		//vallidation if > max score
		// foreach ($post['score'] as $key => $value) {
		// 	# code...
		// 	if($value > $post['max_score'][$key]) {
		// 		$return = false;
		// 	}
		// }

		// if(!$return) {
		// 	$this->session->set_flashdata('error', true);
		// 			$this->session->set_flashdata('message', 'Gagal Di Simpan !');

		// 			return redirect('administration/hse/verifikasi/detail/'.$post['vendor_id']);
		// }

		// foreach ($post['score'] as $key => $value) {
		// 	# code...
		// 	$object['answer_score'] = (int)$value;
		// 	$this->db->where('id', $key);
		// 	$this->db->update('vnd_cqsms_trx_h_detail', $object);
			
		// }

		// $header['cqsms_status'] = 1;
		// $header['updated_status_by'] = $this->session->userdata(do_hash(SESSION_PREFIX));

		// $this->db->where('id', $post['trx_h_id']);
		// $updateHeader = $this->db->update('vnd_cqsms_trx_h', $header);
		
		// if($updateHeader) {
		// 	$this->session->set_flashdata('success', true);
		// 			$this->session->set_flashdata('message', 'Verifikasi Di Simpan !');

		// 			return redirect('administration/hse/verifikasi/');
		// } else {
		// 	$this->session->set_flashdata('error', true);
		// 	$this->session->set_flashdata('message', 'Gagal Di Simpan !');

		// 	return redirect('administration/hse/verifikasi/detail/'.$post['vendor_id']);
		// }

		
	}


}
