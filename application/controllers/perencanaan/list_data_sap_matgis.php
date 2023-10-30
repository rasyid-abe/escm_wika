<?php

$view = 'perencanaan/sap/list_data_matgis_v';
$data = array();

$sql_div = "
    select
        distinct(ppm.ppm_planner_pos_name),
        case
            when (ppm.ppm_planner_pos_code::text notnull ) then ppm.ppm_planner_pos_code::text
            else ppm.ppms_planner_pos_code
        end as ppm_planner_pos_code
    from prc_plan_main ppm
    join prc_plan_item ppi on ppm.ppm_id = ppi.ppm_id
    join adm_dept on adm_dept.dept_id = ppm.ppm_dept_id
    where ppm.ppm_planner_pos_name notnull and ppm.ppm_is_sap = 1
    and ppi.ppis_pr_type in ('ZPW1') and adm_dept.dept_id = 13
";

$data['div'] = $this->db->query($sql_div)->result_array();

$this->template($view, "Perencanaan Proyek (SAP) - Matgis", $data);
?>
