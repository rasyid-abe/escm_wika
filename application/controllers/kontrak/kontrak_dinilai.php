<?php

$data = array();

$this->db->select('cch.contract_id, cch.ptm_number, cch.contract_number, vpm.ptm_buyer, vpm.ptm_dept_name,vpm.ptm_project_name,cch.subject_work, cch.scope_work, cch.vendor_name, cch.contract_type, cch.start_date, cch.end_date, cch.contract_amount, vssr.subtotal_rab');
$this->db->from('vw_vpi_asserted vva');
$this->db->join('ctr_contract_header cch', 'vva.ptm_number = cch.ptm_number');
$this->db->join('vw_prc_monitor vpm', 'vva.ptm_number = vpm.ptm_number');
$this->db->join('vw_smbd_sum_rab vssr', 'vva.contract_id = vssr.contract_id');
$this->db->where('vva.vvh_contract_id is NOT NULL', NULL, FALSE);
$this->db->order_by('cch.start_date', 'DESC');
$rows =  $this->db->get()->result_array();
$data['rows'] = $rows;
echo json_encode($data);

// echo "<pre>";
// print_r($data);
// die;
