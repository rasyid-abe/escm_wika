<?php 
$vvh_date = $this->input->get('vvh_date');
$contract_id = $this->input->get('contract_id');
$this->db->select('vvh_tipe');
$this->db->where('vk_response', "0");
$this->db->where('vvh_contract_id', $contract_id);
$this->db->where('vvh_date', $vvh_date);
$this->db->join('vnd_vpi_kompilasi b', 'b.vvh_id = vnd_vpi_header.vvh_id');
$vvh_type = $this->Vendor_m->getVPIHeader()->row_array();

echo json_encode($vvh_type);
?>