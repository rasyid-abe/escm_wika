<?php 

$this->data['workflow_list'] = array(0=>"Simpan Sementara",1=>"Simpan dan Kirim");

$userdata = $this->data['userdata'];

$data = array();

$position = $this->Administration_m->getPosition("PIC USER");

if(!$position){
	$this->noAccess("Hanya PIC USER yang dapat mengelola perencanaan pengadaan");
}

$data['pos'] = $position;

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'procurement/perencanaan_pengadaan/edit_history_car_v';

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(5, 0);

$data['id'] = $id;

$data['perencanaan'] = $this->Procplan_m->getHistoryCar($id)->row_array();

$data['document'] = $this->Procplan_m->getDokumenHistoryCar("",$id)->result_array();

$data["progress"] = $this->Procplan_m->getProgressHistoryCar($id)->result_array();

$this->template($view,"Update History CAR",$data);