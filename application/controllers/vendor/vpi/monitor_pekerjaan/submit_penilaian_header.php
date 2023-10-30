<?php 

 $post= $this->input->post();

  $input=array();

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("date_inp", "Bulan", 'required');
     
  $data['vvh_contract_id'] = $post['contract_id_inp'];
  $data['vvh_date'] = $post['date_inp'];
  $data['vvh_tipe'] = $post['tipe_inp'];


  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('monitor_pekerjaan/penilaian_header/'.$post['contract_id_inp']);

  } else {
    
   $this->db->select('vvh_id'); 
   $where = array('vvh_contract_id' => $data['vvh_contract_id'], "vvh_date" => $post['date_inp']);
   $check_data = $this->Vendor_m->getVPIHeader($data['vvh_vendor_id'],"",$where)->row_array();

   if (count($check_data) < 1 ) {
	   $this->setMessage("Data tidak ditemukan");
      $this->vpi('daftar_pekerjaan/penilaian_header/'.$post['contract_id_inp']);
   }else{
      redirect(site_url("vendor/vpi/monitor_pekerjaan/penilaian_vpi/".$check_data['vvh_id']));
   }
  

  }
