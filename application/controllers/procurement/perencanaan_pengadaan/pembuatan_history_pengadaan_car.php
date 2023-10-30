<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$post = $this->input->post();

$userdata = $this->data['userdata'];

$division = array();

$div_data = $this->db->get("adm_dept")->result_array();

foreach ($div_data as $key => $value) {
  $division[$value['dept_id']] = $value['dept_id']." - ".$value['dept_name'];
}

$this->data['division'] = $division;

$data = array();

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat History CAR");
}

$data['pos'] = $position;

$id = "";

$aksi = "tambah";

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'procurement/perencanaan_pengadaan/add_history_car_v';

$data['doc_list'][0] = array(); 

  if(!empty($post)){

  foreach ($post['doc_category_inp'] as $key => $value) {
  	$data['doc_list'][$key]['doc_category_inp'] = $post['doc_category_inp'][$key];
  	$data['doc_list'][$key]['doc_desc_inp'] = $post['doc_desc_inp'][$key];
  	$data['doc_list'][$key]['attachment_inp'] = $post['doc_attachment_inp'][$key];
  }

}

  $this->template($view,"Pembuatan History Pengadaan CAR",$data);