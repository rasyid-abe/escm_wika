<?php

$view = 'pemaketan/sap/daftar_perencanaan_sap_v';

$userdata = $this->data['userdata'];

$data = array();

$allppm = array();

$query_emp_id = $this->db->where('employee_id', $userdata['employee_id'])->get('adm_employee_proyek')->result_array();

foreach ($query_emp_id as $key => $r) {
    $allppm[] = $r['ppm_id'];
}

$job_title = array("GENERAL MANAJER", "MANAJER USER", "KEPALA DIVISI", "PELAKSANA PENGADAAN");

if (!in_array($userdata['job_title'], $job_title)) {
    $this->db->distinct();
    $this->db->select("ppm.ppm_dept_id, ppm_dept_name, ad.dep_code");
    $this->db->join('adm_dept ad', 'ppm_dept_id = ad.dept_id');
    $this->db->join('prc_plan_item ppi', 'ppi.ppm_id = ppm.ppm_id');
    $this->db->where_in("ppm.ppm_id", $allppm);
} else {
    $this->db->distinct();
    $this->db->select("ppm.ppm_dept_id, ppm_dept_name, ad.dep_code");
    $this->db->join('adm_dept ad', 'ppm_dept_id = ad.dept_id');
    $this->db->join('prc_plan_item ppi', 'ppi.ppm_id = ppm.ppm_id');
    $this->db->where("ppm.ppm_is_sap", 1);
}

$data['pg'] = $this->db->get('prc_plan_main ppm')->result_array();

if (!in_array($userdata['job_title'], $job_title)) {
    $this->db->distinct();
    $this->db->select("ppm.ppm_subject_of_work, ppm.ppm_project_id");
    $this->db->join('prc_plan_item ppi', 'ppi.ppm_id = ppm.ppm_id');
    $this->db->where_in("ppm.ppm_id", $allppm);
} else {
    $this->db->distinct();
    $this->db->select("ppm.ppm_subject_of_work, ppm.ppm_project_id");
    $this->db->join('prc_plan_item ppi', 'ppi.ppm_id = ppm.ppm_id');
    $this->db->where("ppm.ppm_is_sap", 1);
}

$data['proj'] = $this->db->get('prc_plan_main ppm')->result_array();

$sql_type = "select * from adm_pr_type order by id";
$data['type'] = $this->db->query($sql_type)->result_array();

$this->template($view,"PERENCANAAN PENGADAAN",$data);

?>
