<?php

$kode_group = $this->input->post('kode_group');

/*var_dump($wheree);
exit();
*/

if ($tipe == 'utama') {
	// $table          = "(Select kode_group,kualifikasi, sum(jml) as jumlah,fin_class from vw_statistik_vendor group by kualifikasi) AS vw_statistik_vendor";
	$table = 'vw_statistik_vendor_res';

	$condition 	    = '';
	$column_order   = array(null, 'kode_group',  'kualifikasi', 'jumlah'); 
	$column_search  = array('kode_group',  'kualifikasi', 'jumlah'); 
	$order          = array('kode_group' => 'asc');

	$list_data      = $this->M_global->get_datatables($table, $column_order, $column_search, $order);
	$data           = array();
	$no             = $_POST['start'];
	foreach ($list_data as $ld) { 
	   

	    $no++;
	    $row = array();
	    $row[] = $no;
	    $row[] = $ld->kode_group;
	    $row[] = '<a class="action" data-kode_group='.$ld->kode_group.'>'.$ld->kualifikasi.'</a>';
	    $row[] = $ld->jumlah;
	    $data[] = $row;
	}
} 

if ($tipe == 'detail') {
	$table          = "vw_statistik_vendor";

	/*$condition		=[];
	$condition		= ['kode_group',$kode_group,'where'];
*/
	$condition 	    = [];
			if($kode_group != '') {
				$condition[]  = ['kode_group', $kode_group, 'where'];
			}

	$column_order   = array(null, 'kode_group',  'kualifikasi', 'jumlah'); 
	$column_search  = array('kode_group',  'kualifikasi', 'jumlah'); 
	$order          = array('kode_group' => 'asc');
	
	$list_data      = $this->M_global->get_datatables($table, $column_order, $column_search, $order, $condition);
	$data           = array();
	$no             = $_POST['start'];
	foreach ($list_data as $ld) { 
	   

	    $no++;
	    $row = array();
	    $row[] = $no;
	    $row[] = $ld->klasifikasi;
	    $row[] = '<a href='.site_url().'/laporan/detail_rfq/lap_proc_value/vendor_id/'.$ld->kode_group.'/'.$ld->fin_class.'>'.$ld->jml.'</a>';
	    $data[] = $row;
	}
}


$output = array(
        "draw" => $_POST['draw'],
        "recordsFiltered" => $this->M_global->count_filtered($table, $column_order, $column_search, $order, $condition),
        "recordsTotal" => $this->M_global->count_all($table, $condition),
        "data" => $data,
    );

echo json_encode($output);


















