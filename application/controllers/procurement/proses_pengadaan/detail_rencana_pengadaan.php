<?php
$view = 'perencanaan/pmcs/detail_pengadaan_pmcs_v';
$data = array();

$this->db->select('
    prc_plan_integrasi.smbd_code,
    prc_plan_integrasi.smbd_name,
    prc_plan_integrasi.unit,
    SUM ( prc_plan_integrasi.smbd_quantity )::float AS smbd_quantity,
    SUM ( prc_plan_integrasi.price )::float AS price,
    SUM ( prc_plan_integrasi.smbd_quantity )::float  * SUM ( prc_plan_integrasi.price )::float AS total,
    prc_plan_integrasi.updated_date
');
$this->db->from('prc_plan_integrasi');
$this->db->where('prc_plan_integrasi.smbd_code', $kode_smbd);
$this->db->group_by([
    'prc_plan_integrasi.smbd_code',
    'prc_plan_integrasi.smbd_name',
    'prc_plan_integrasi.unit',
    'prc_plan_integrasi.updated_date',
]);
$smbd = $this->db->get()->row_array();

$data['head'] = $smbd;

$this->db->select("
    EXTRACT ( YEAR FROM MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) as min,
    EXTRACT ( YEAR FROM MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) as max
");
$year = $this->db->get_where('prc_plan_integrasi', ['smbd_code' => $kode_smbd])->row_array();

$data['year'] = $year;
$data['kode_smbd'] = $kode_smbd;

$this->template($view,"DETAIL PENGADAAN PMCS",$data);
