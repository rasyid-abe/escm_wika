<?php 

  $view = $id== 0 ?  'administration/master_data/hse/template_hse_verivikasi_v' : 'administration/master_data/hse/template_hse_verivikasi_detail_v';
  
  $data = array();		

  $data = array();
  $data['title'] = 'List Verifikasi Data Hse';
  
  if($id != 0)
  {
	$this->load->model('Hse_m');
	
	$vendor = $this->db->where('vendor_id',$id)->get('vnd_header')->row_array();
	
  	$data['title'] = 'Verifikasi Data Hse '.$vendor['vendor_name'];
	
		//$data['hse'] = $this->getHse();
		$data['hasSubmitHse'] = $this->Hse_m->statusHseVendor($id);
		$data['hseData'] = $this->Hse_m->getHseByVendor($id);
		$vendor_type = $this->Hse_m->get_vendor_type($vendor['cot_kelompok']);
		
		$data['hseQuestionList'] = $this->Hse_m->GetVendorQuestionList($vendor['cot_kelompok']);				
		$data['vendor_id'] = $id;

		$data['vendor_score'] = $this->Hse_m->get_vendor_score($id);
		$data['catatanKecelakaan'] = $this->Hse_m->get_adm_cqsms_kecelakaan($data['hseData']['header']['id']);

		$data['hse_cat'] = $this->Hse_m->get_kategory_hse();

		$type = ($data['hseData']['header']['cqsms_type'] == 1) ? 'Sertifikat' : 'Pertanyaan';
		$data['title'] = 'Verifikasi Data Hse '.$vendor['vendor_name'].' - '.$vendor_type['ack_name'];

  }

  $this->template($view,$data['title'],$data);