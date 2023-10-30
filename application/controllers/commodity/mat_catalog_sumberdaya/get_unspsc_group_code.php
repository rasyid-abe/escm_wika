<?php 
$get = $this->input->get();

$rows = $this->Commodity_m->getUnspscGroupCode($get['group_code']);

echo json_encode($rows);