<?php 

$post = $this->input->post();
$userdata = $this->data['userdata'];

if(!empty($post)){

	$id = $post['id'];

	$data = [
        'region_name' => $this->security->xss_clean(strtoupper($post['region_inp'])),
        'updated_datetime' => date("Y-m-d H:i:s"),
        'pos_code_modifier' => $userdata['pos_id'],
        'pos_name_modifier' => $userdata['pos_name'],
        'employee_id_modifier' => $userdata['employee_id'],
        'employee_modifier' => $userdata['complete_name']
     ];
  
		   
    $update = $this->Administration_m->updateRegion($id, $data);

	if($update){
		$this->setMessage("Berhasil mengubah lokasi proyek");
	}

}

redirect(site_url('administration/master_data/lokasi_proyek'));