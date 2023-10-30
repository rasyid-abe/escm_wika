<?php

$get = $this->input->get();
$ppm_id = $get['ppm_id'];

$rows = $this->Procplan_m->getProjectCost($ppm_id)->result_array();

$data['rows'] = $rows;
echo json_encode($data);