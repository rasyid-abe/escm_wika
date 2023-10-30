<?php 

  $view = $id== 0 ?  'administration/master_data/hse/template_hse_percategory_v' : 'administration/master_data/hse/template_hse_v';
  
  $data = array();		
  $data['title'] = 'Template Health Safety Environment';
  $data['get_list'] =  $this->db->get('vw_cqms_master_pertanyaan')->result_array(); //json_decode($get_url, true);
  //$data['get_list_vendor_bidang'] = json_decode($get_urlVendorBidang, true);
  $data['cod_kelompok_list'] = json_encode($this->db->get('adm_cot_kelompok')->result_array());
  $data['kategori'] =  $this->db->get('vnd_cqsms_pertanyaan_kategori')->result_array();
  $data['id'] = $id == 0 ? 0 : $id;


  if($id != 0)
  {
    $data['vendor_type_name'] = $this->db->where("ack_id",$id)->get("adm_cot_kelompok")->row_array()['ack_name'];
		$data['title'] = 'Template Health Safety Environment '.$data['vendor_type_name'];
		$data['get_list'] =  $this->db->where('pertanyaan_classification', $id)->get('vw_cqms_master_pertanyaan')->result_array();
		$data['vendor_type'] = $id;
  }
 
  $this->template($view,$data['title'],$data);