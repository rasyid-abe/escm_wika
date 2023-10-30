<?php


$tglMulai = $this->input->post('tglMulai');
$tglAkhir = $this->input->post('tglAkhir');


if(empty($tglMulai) || empty($tglAkhir)){
	$wheree = '';
	$link = '';
} else {
	$wheree = 'and (date(d.ptm_completed_date) between "'.$tglMulai.'" and "'.$tglAkhir.'")';
	$link = "$tglMulai/$tglAkhir";
}


// price penawaran
	$table          = "vw_jumlah_belanja";


/*var_dump($table);
exit();*/
$condition			=[];

if (!empty($tglMulai && !empty($tglAkhir))) {
	$condition[] 		= ['date >=',date('Y-m-d',strtotime($tglMulai)) ,'where'];
	$condition[] 		= ['date <=',date('Y-m-d',strtotime($tglAkhir)) ,'where'];

}


$column_order   = array(null, 'name',  'total', 'nilai'); 
$column_search  = array('name', 'total', 'nilai'); 
$order          = array('name' => 'asc');

$list_data      = $this->M_global->get_datatables($table, $column_order, $column_search, $order, $condition);
$data           = array();
$no             = $_POST['start'];

foreach ($list_data as $key => $value) { 
    $no++;
    $row            = array();
    $row[] = $no;
    $row[] = $value->kode_group.' - '.$value->name;
    $row[] = '<a href="'.site_url().'/laporan/detail_rfq/lap_proc_value/vendor_rfq/'.$value->kode_group.'/'.$link.'">'.$value->total.'</a>';
    $row[] = 'Rp &nbsp;<a style="float:right">'.inttomoney($value->nilai).'</a>';

    $data[] = $row;

}
// echo "<pre/>";var_dump($data);

$output = array(
        "draw" => $_POST['draw'],
        "recordsFiltered" => $this->M_global->count_filtered($table, $column_order, $column_search, $order, $condition),
        "recordsTotal" => $this->M_global->count_all($table, $condition),
        "data" => $data,
    );

echo json_encode($output);