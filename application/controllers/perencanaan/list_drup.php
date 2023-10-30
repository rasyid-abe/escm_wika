<?php

$view = 'perencanaan/sap/list_drup_v';
$data = array();

$sql_pg = "
select ppm.ppm_dept_id, ppm_dept_name, ad.dep_code
from prc_plan_main ppm
join adm_dept ad on ppm_dept_id = ad.dept_id
JOIN prc_plan_item ppi ON ppi.ppm_id = ppm.ppm_id
where ppm.ppm_is_sap = 1 and ppi.ppis_pr_type in ('ZPW1')
";

$data['pg'] = $this->db->query($sql_pg)->result_array();

$sql_proj = "
select ppm.ppm_subject_of_work, ppm.ppm_project_id
from prc_plan_main ppm
JOIN prc_plan_item ppi ON ppi.ppm_id = ppm.ppm_id
where ppm.ppm_is_sap = 1 and ppi.ppis_pr_type in ('ZPW1')
";

$data['proj'] = $this->db->query($sql_proj)->result_array();

$sql_type = "
select distinct ppi.ppis_pr_type
from prc_plan_item ppi
where ppi.ppi_is_sap = 1 and ppi.ppis_pr_type in ('ZPW1')
order by ppi.ppis_pr_type asc
";

$data['type'] = $this->db->query($sql_type)->result_array();

$sql_pr = "
select distinct ppi.ppis_pr_number
from prc_plan_item ppi
where ppi.ppi_is_sap = 1 and ppi.ppis_pr_type in ('ZPW1')
order by ppi.ppis_pr_number asc
";

$data['pr'] = $this->db->query($sql_pr)->result_array();

$this->template($view, "Perencanaan Proyek (SAP)", $data);
?>
