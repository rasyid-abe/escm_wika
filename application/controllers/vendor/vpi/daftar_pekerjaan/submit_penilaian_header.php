<?php 

 $post= $this->input->post();

  $input=array();

  $userdata = $this->data['userdata'];

  $this->form_validation->set_rules("contract_id_inp", "contract ID", 'required');
  $this->form_validation->set_rules("dept_id_inp", "departemen ID", 'required');
  $this->form_validation->set_rules("vendor_id_inp", "vendor ID", 'required');
  $this->form_validation->set_rules("date_inp", "Bulan", 'required');
  $this->form_validation->set_rules("tipe_inp", "Tipe", 'required');
     

  $data['vvh_contract_id'] = $post['contract_id_inp'];
  $data['vvh_dept_id'] = $post['dept_id_inp'];
  $data['vvh_vendor_id'] = $post['vendor_id_inp'];
  $data['vvh_date'] = $post['date_inp'];
  $data['vvh_tipe'] = $post['tipe_inp'];
  $data['vvh_employee_id'] = $userdata["employee_id"];
  $data['vvh_pos_id'] = $userdata["pos_id"];
  $data['created_datetime'] = date('Y-m-d h:i:s');



  if ($this->form_validation->run() == FALSE){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $this->vpi('daftar_pekerjaan/penilaian_header/'.$post['contract_id_inp']);

  } else {
    
   $this->db->trans_begin();
   $this->db->select('vvh_id'); 
   $where = array('vvh_contract_id' => $data['vvh_contract_id'], "vvh_date" => $post['date_inp']);
   $check_data = $this->Vendor_m->getVPIHeader($data['vvh_vendor_id'],"",$where)->row();
   // echo $this->db->last_query();
   // var_dump($check_data);exit();
   if (count($check_data) < 1 ) {
	 $get_id = $this->Vendor_m->insertVPIHeader($data);
   }else{
   	 $this->Vendor_m->UpdateVPIHeader($data, $where);
   	 $get_id = $check_data->vvh_id;
   }
  
  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
    $this->vpi('daftar_pekerjaan/penilaian_header/'.$post['contract_id_inp']);
  }
  else
  {

    // $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
    redirect(site_url("vendor/vpi/daftar_pekerjaan/penilaian_vpi/$get_id"));
    
  }

  }
