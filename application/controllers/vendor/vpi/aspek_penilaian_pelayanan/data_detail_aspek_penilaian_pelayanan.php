<?php 

$date = $this->input->get('date');

$this->db->select('vpp_response,vpp_attach,vpp_note,vpp_title,vpp_no_doc,vpp_final_score');
$this->db->where('vpp_contract_id', $param3);
$this->db->where('vpp_date', $date);
$data['data_note'] = $this->db->get('vnd_penilaian_pelayanan')->result_array();

if (count($data['data_note']) != 0) {
	
$this->db->select('app_id,app_value,vppa_value,vppa_pertanyaan_id,vppa_id');
$this->db->join('vnd_penilaian_pelayanan a', 'a.vpp_id = b.vpp_id');
$this->db->join('adm_aspek_penilaian_pelayanan c', 'c.app_id = b.vppa_pertanyaan_id', 'left');
$this->db->where('a.vpp_contract_id', $param3);
$this->db->where('a.vpp_date', $date);
$data['data_pertanyaan'] = $this->db->get('vnd_penilaian_pelayanan_answer b')->result_array();

}else{
	$data = 'empty';
}
echo json_encode($data);
// echo $this->db->last_query();
// echo "<pre>";
// var_dump($get_data_pertanyaan);

