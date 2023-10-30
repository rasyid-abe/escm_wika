<?php 

$date = $this->input->get('date');

$this->db->select('vpkp_response,vpkp_value,vpkp_value_attach,vpkp_attach,vpkp_note,
	vpkp_title,vpkp_no_doc');
$this->db->where('vpkp_date', $date);
$data['data_note'] = $this->Vendor_m->getDataPenilaianKetepatanProgress("",$param3)->result_array();

if (count($data['data_note']) == 0) {
	$data = 'empty';
}


echo json_encode($data);

