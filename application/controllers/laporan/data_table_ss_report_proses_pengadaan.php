<?php
/*
$get = $this->input->get();

$userdata = $this->data['userdata'];

$id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";
$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(name)",$search);
  $this->db->or_like("LOWER(total)",$search);
  $this->db->group_end();
}

$rows = $this->db->get('vw_jumlah_belanja')->result_array();

foreach ($rows as $key => $value) {
	 $rows[$key]['jumlah_total'] = (isset($value['nilai'])) ? inttomoney($value['nilai']) : 0;
}

$data['rows'] = $rows;


$this->output->set_content_type('application/json')->set_output(json_encode($data));*/

$tglMulai = $this->input->post('tglMulai');
$tglAkhir = $this->input->post('tglAkhir');

/*var_dump($tglMulai);
exit();*/

if(empty($tglMulai) || empty($tglAkhir)){
	$wheree = '';
	$link = '';
} else {
	$wheree = 'and (date(d.ptm_completed_date) between "'.$tglMulai.'" and "'.$tglAkhir.'")';
	$link = "$tglMulai/$tglAkhir";
}


$table          = "(
	select  ptp_tender_method as ptp_tender_method, count(ptp_id) as total,
	case ptp_tender_method
	WHEN 0 then 'Penunjukkan Langsung'
	WHEN 1 then 'Pemilihan Langsung'
	WHEN 2 then 'Pelelangan'
	end as proses_pengadaan 
	from prc_tender_prep 
	left join prc_tender_main d on d.ptm_number = prc_tender_prep.ptm_number

	
	where ptp_tender_method is not null $wheree
	GROUP BY ptp_tender_method) AS vw_report_proses_pengadaan"; 


/*var_dump($table);
exit();*/

$column_order   = array(null, 'ptp_tender_method',  'total'); 
$column_search  = array('ptp_tender_method', 'total'); 
$order          = array('ptp_tender_method' => 'asc');

$list_data      = $this->M_global->get_datatables($table, $column_order, $column_search, $order);
$data           = array();
$no             = $_POST['start'];
foreach ($list_data as $ld) { 

    $no++;
    $row = array();
    $row[] = $no;
    $row[] = $ld->proses_pengadaan;
    $row[] = '<a href="'.site_url().'/laporan/detail_rfq/lap_proc_value/'.$ld->ptp_tender_method.'/'.$link.'">'.$ld->total.'</a>';
    $data[] = $row;
}

$output = array(
        "draw" => $_POST['draw'],
        "recordsFiltered" => $this->M_global->count_filtered($table, $column_order, $column_search, $order),
        "recordsTotal" => $this->M_global->count_all($table),
        "data" => $data,
    );

echo json_encode($output);