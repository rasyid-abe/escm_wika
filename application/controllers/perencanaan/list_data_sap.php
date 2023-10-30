<?php

$userdata = $this->data['userdata'];

$view = 'perencanaan/sap/list_data_v';
$data = array();

$allppm = array();

$query_emp_id = $this->db->where('employee_id', $userdata['employee_id'])->get('adm_employee_proyek')->result_array(); 

foreach ($query_emp_id as $key => $r) {
    $allppm[] = $r['ppm_id'];
}

$this->db->distinct();
$this->db->select("ppm.ppm_planner_pos_name");
$this->db->join('prc_plan_item ppi', 'ppi.ppm_id = ppm.ppm_id');      
if ($userdata['job_title'] != 'GENERAL MANAJER') {
    $this->db->where_in("ppm.ppm_id", $allppm);
} else {
    $this->db->where("ppm.ppm_is_sap", 1);
    $this->db->where("ppi.ppis_pr_type", "ZPW2");
    $this->db->where("ppi.ppis_pr_type", "ZPW3");
    $this->db->where("ppi.ppis_pr_type", "ZPW4");
}

$data['div'] = $this->db->get('prc_plan_main ppm')->result_array();

$this->template($view, "Perencanaan Proyek (SAP)", $data);
?>
