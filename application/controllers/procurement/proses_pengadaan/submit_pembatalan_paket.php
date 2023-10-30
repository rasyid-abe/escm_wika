<?php

$userdata = $this->data['userdata'];

$error = false;

$post = $this->input->post();

$pr_number = $post['id'];

$activity = 1906;

$tender = $this->Procrfq_m->getRFQbyPR($pr_number);

$contract = $this->Procrfq_m->getCtrbyRFQ($tender['ptm_number']);

foreach ($contract as $key => $value) {
	
	$number = ($value['contract_number'] == NULL) ? "pengadaan ".$tender['ptm_number'] : $value['contract_number'];

	if ($tender['ptm_number'] != NULL && $value['ptm_number'] != NULL && $value['status'] != "2902") {
		$this->setMessage("Kontrak dengan no ".$number." harus dibatalkan terlebih dulu");
		$error = TRUE;
	}	
}

if ($tender != NULL && $tender['ptm_status'] != "1902") {
	$this->setMessage("Pengadaan dengan no ".$tender['ptm_number']." harus dibatalkan terlebih dulu");
	$error = TRUE;
}



$input = array();
$input2 = array('pr_status'=>$activity);
$anggaran = $post['remain']+$post['hps'];

$this->db->trans_begin();

$updateanggaran = $this->Procplan_m->updateDataPerencanaanPengadaan($post['plan'], array('ppm_sisa_anggaran'=>$anggaran));

if ($updateanggaran) {

	$planhist = [
		'ppm_id' => $post['plan'],
		'pph_main' => $post['remain'],
		'pph_plus' => $post['hps'],
		'pph_remain' => $anggaran,
		'pph_date' => date("Y-m-d H:i:s"),
		'pph_desc' => 1906,
		'pph_first' => $pr_number,
		'pph_mod' => $pr_number
	];

	$inserthist = $this->Procplan_m->insertHist($planhist);
}

$update = $this->Procpr_m->updateDataPR($pr_number,$input2);

if($update){

	$this->db->order_by("ppc_id", "desc");
	$com = $this->db->where("pr_number", $pr_number)->get("prc_pr_comment")->row_array();

	$input['pr_number'] = $pr_number;
	$input['ppc_pos_code'] = $userdata['pos_id'];
	$input['ppc_position'] =  $userdata['pos_name'];
	$input['ppc_name'] =  $userdata['complete_name'];
	$input['ppc_activity'] = $activity;
	$input['ppc_comment'] = $post['comment_inp'][0];
	$input['ppc_start_date'] = date("Y-m-d H:i:s");
	$input['ppc_response'] = "Pembatalan pengadaan melalui procurement tools";
	if ($com['ppc_user'] == NULL) {
		$this->db->where("ppc_id", $com['ppc_id'])->update("prc_pr_comment", array("ppc_name"=>" ", "ppc_user"=>$userdata['employee_id']));
	}

	$this->db->insert("prc_pr_comment",$input);

}


$check_vol = $this->Procplan_m->getVolumeHist("",$post['plan'])->result_array();

$item = $this->Procpr_m->getItemPR("", $pr_number)->result_array();

if (count($check_vol) > 0) {

  	foreach ($item as $key2 => $value2) { 

    	$getVolumeHist = $this->Procplan_m->getVolumeHist($value2['ppi_code'],$post['plan'])->row_array();

    	$dataVolume = array(
            'ppm_id' => $post['plan'],
            'ppv_main' => $getVolumeHist['ppv_remain'],
            'ppv_plus' => $value2['ppi_quantity'],
            'ppv_minus' => 0,
            'ppv_remain' => ($getVolumeHist['ppv_main'] + $value2['ppi_quantity']),
            'ppv_activity' => 1906,
            'ppv_no' => $pr_number,
            'ppv_smbd_code' => $value2['ppi_code'],
            'ppv_unit' => $getVolumeHist['ppv_unit'],
            'ppv_prc' => "PR",
            'created_datetime' => date("Y-m-d H:i:s"),
          );

    	$volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
    }
 }



if ($this->db->trans_status() === FALSE || $error === TRUE)
{
	$this->db->trans_rollback();
	$this->setMessage("Gagal mengubah data");
	$this->renderMessage("error");
}
else
{
	$this->db->trans_commit();
	$this->renderMessage("success");
}
