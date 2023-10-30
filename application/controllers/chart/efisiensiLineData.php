<?php

$this->db->where('finished_year', date('Y'));
$this->db->order_by('month_2','asc');
$dept = $this->db->get('vw_dept_efisiensi_per_tahun_2')->result_array();

$n = 0;
$data['data'] = array();
foreach ($dept as $key => $value) {
    if(!empty($value['ptm_dept_name'])){
        $data['data'][$value['ptm_dept_id']]['name'] = $value['ptm_dept_name'];
        $data['data'][$value['ptm_dept_id']]['data'][] = array('month' => $value['month_2'], 'year' => $value['finished_year'], 'y' => $value['efisiensi']);
        $data['data'][$value['ptm_dept_id']]['marker'] = array('symbol' => 'circle');

        $n++;
    }
}
$data['data'] = array_values($data['data']);
$data['num_rows'] = $this->db->get('vw_dept_efisiensi_per_tahun_2')->num_rows();


$data = json_encode($data,JSON_NUMERIC_CHECK);

print_r($data);
die();