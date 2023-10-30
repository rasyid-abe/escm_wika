<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi_perorangan extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array("Profile"));
		$this->token_katalog = isset($_COOKIE["token_katalogue"]) ? $_COOKIE["token_katalogue"] : '';
		if($this->session->userdata('vendor_type') != 2 || $this->session->userdata('reg_status_id') != 0){
            redirect(site_url());
		};
	}

	public function utama()
	{
		$vendor_id = $this->session->userdata("userid");		
	
		$this->db->where('vendor_id', $vendor_id);
		$vnd_header = $this->db->get('vnd_header');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['detail_vendor'] = $vnd_header->row_array();
		$this->layout->view('_profile02/utama_v', $data);
	}

	public function pendidikan()
	{
		$vendor_id = $this->session->userdata("userid");
		
		$this->db->where('vendor_id', $vendor_id);
		$education = $this->db->get('vnd_education');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['education'] = $education->result_array();
		$this->layout->view('_profile02/pendidikan_v', $data);
	}

	public function pengalaman_cv()
	{
		$vendor_id = $this->session->userdata("userid");	
		
		$this->db->where('vendor_id', $vendor_id);
		$exp_work = $this->db->get('vnd_exp_work');
		
		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['exp_work'] = $exp_work->result_array();
		$this->layout->view('_profile02/pengalaman_cv_v', $data);
	}
	
	public function pelatihan()
	{
		$vendor_id = $this->session->userdata("userid");		

		$this->db->where('vendor_id', $vendor_id);
		$training = $this->db->get('vnd_training');

		$data = array();
		$data['title'] = 'Registrasi Vendor';
		$data['training'] = $training->result_array();
		$this->layout->view('_profile02/pelatihan_v', $data);
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
		$this->layout->view('_profile02/catatan_v', $data);
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
			return redirect('registrasi_perorangan/catatan');

		} else {
			$this->db->trans_rollback();
			$this->session->set_flashdata('res', '2');
			return redirect('registrasi_perorangan/catatan');
		}
		
	}

}
