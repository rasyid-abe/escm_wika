<?php


$tglMulai = $this->input->post('tglMulai');
$tglAkhir = $this->input->post('tglAkhir');


if(empty($tglMulai) || empty($tglAkhir)){
	$wheree = '';
	$link = '';
} else {
	$wheree = "and ptm_completed_date >= '$tglMulai' and ptm_completed_date <= '$tglAkhir'";
	$link = "$tglMulai/$tglAkhir";
}


// price penawaran
	$table          = "(
       SELECT
        a.ptp_tender_method as kode,
       CASE
        a.ptp_tender_method 
        WHEN 0 THEN
        'Penunjukkan Langsung' 
        WHEN 1 THEN
        'Pemilihan Langsung' ELSE 'Pelelangan' 
        END AS metode,
        SUM( b.ptm_pagu_anggaran ) AS oe,
        SUM( c.contract_amount ) AS kontrak,
        SUM( b.ptm_pagu_anggaran ) - SUM( c.contract_amount ) AS efisiensi_nilai,
        ( ( SUM( b.ptm_pagu_anggaran ) - SUM( c.contract_amount ) ) / SUM( b.ptm_pagu_anggaran ) ) * 100 AS efisiensi_presentasi,
        COUNT( a.ptm_number ) AS jumlah 
       FROM
        ( SELECT ptm_completed_date, ptm_pagu_anggaran, ptm_number FROM prc_tender_main WHERE ptm_completed_date IS NOT NULL $wheree ) b
        JOIN prc_tender_prep a ON a.ptm_number = b.ptm_number
        JOIN ctr_contract_header c ON c.ptm_number = b.ptm_number 
       GROUP BY
        a.ptp_tender_method


    ) AS vw_lap_proc_value_hel";


/*var_dump($table);
exit();*/



$column_order   = array(null, 'ptp_tender_method',  'jumlah', 'oe','kontrak', 'efisiensi_nilai','efisiensi_presentasi'); 
$column_search  = array('ptp_tender_method',  'jumlah', 'oe','kontrak', 'efisiensi_nilai','efisiensi_presentasi'); 
$order          = array('kode' => 'asc');

$list_data      = $this->M_global->get_datatables($table, $column_order, $column_search, $order);
$data           = array();
$no             = $_POST['start'];
foreach ($list_data as $ld) { 
    if($ld->kode == 0) {
       $kodesa = 'Penunjukkan';
    } 
    if($ld->kode == 1) {
       $kodesa = 'Pemilihan';
    } 

    if($ld->kode == 2) {
       $kodesa = 'Pelelanganaa';
    }

    $no++;
    $row = array();
    $row[] = $no;
    $row[] = $ld->metode;
    $row[] = '<a href="'.site_url().'/laporan/detail_rfq/lap_proc_value/'.$kodesa.'/'.$ld->kode.'/'.$link.'">'.$ld->jumlah.'</a>';


    $row[] = 'Rp '.inttomoney($ld->oe);
    $row[] = 'Rp '.inttomoney($ld->kontrak);
    $row[] = 'Rp '.inttomoney($ld->efisiensi_nilai);
    $row[] = substr($ld->efisiensi_presentasi, 0,5).' %';

    $data[] = $row;
}

$output = array(
        "draw" => $_POST['draw'],
        "recordsFiltered" => $this->M_global->count_filtered($table, $column_order, $column_search, $order),
        "recordsTotal" => $this->M_global->count_all($table),
        "data" => $data,
    );

echo json_encode($output);