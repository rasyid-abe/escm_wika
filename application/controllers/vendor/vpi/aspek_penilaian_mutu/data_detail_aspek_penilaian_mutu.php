<?php 

$date = $this->input->get('date');

$this->db->select('vpm_response,vpm_apm_id,vpm_attach,vpm_answer,vpm_note,vpm_title,vpm_no_doc');
$this->db->where('vpm_date', $date);
$data['data_note'] = $this->Vendor_m->getDataPenilaianMutu("",$param3)->result_array();

if (count($data['data_note']) != 0) {
	$data['data_pertanyaan'] = $this->Administration_m->getAspekPenilaianMutu($data['data_note'][0]['vpm_apm_id'])->result_array();
}else{
	$data = 'empty';
}


echo json_encode($data);

