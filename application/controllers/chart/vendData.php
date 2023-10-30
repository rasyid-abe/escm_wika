<?php
$this->db->where(array(
    'vpi_month' => date('n'), 
    'vpi_year' => date('Y')
));
$vpi = $this->db->get('vw_vpi_score_per_bulan')->result_array();
$data = array();
foreach ($vpi as $key => $value) {
	if (strlen($value['vpi_month']) == 1) {
		$value['vpi_month'] = '0'.$value['vpi_month'];
	}

	if (strlen($value['vpi_date']) == 1) {
		$value['vpi_date'] = '0'.$value['vpi_date'];
	}

	// if (strlen($value['vpi_hour']) == 1) {
	// 	$value['vpi_hour'] = '0'.$value['vpi_hour'];
	// }

	// if (strlen($value['vpi_minute']) == 1) {
	// 	$value['vpi_minute'] = '0'.$value['vpi_minute'];
	// }

	// if (strlen($value['vpi_second']) == 1) {
	// 	$value['vpi_second'] = '0'.$value['vpi_second'];
	// }

    $data[$value['vendor_id']]['name'] = $value['vendor_name'];
    for ($i=0; $i < count($value['vvh_id']) ; $i++) { 
    	$data[$value['vendor_id']]['data'][$i]['key'] = $value['vvh_id'];
    	$data[$value['vendor_id']]['data'][$i]['x'] = $value['vpi_year'].$value['vpi_month'].$value['vpi_date'];
    	$data[$value['vendor_id']]['data'][$i]['y'] = $value['vpi_score'];
    }
    
}

$data = array_values($data);
$data = json_encode($data,JSON_NUMERIC_CHECK);

// $data = '[{
//     "name": "UNION METAL",
//     "data": [{
//             "x": 190.0,
//             "y": 80.6
//         }]
//     },{
//     "name": "TOGO MESH",
//     "data": [{
//             "x": 100.0,
//             "y": 12.6
//         }]
//     },{
//     "name": "SUPRAJAYA DUARIBU SATU",
//     "data": [{
//             "x": 174.0,
//             "y": 65.6
//         }]
//     },{
//     "name": "SRW ASIA",
//     "data": [{
//             "x": 12.0,
//             "y": 32.0
//         }]
//     },{
//     "name": "TOWERS WATSON INDONESIA",
//     "data": [{
//             "x": 74.0,
//             "y": 74.0
//         }]
//     }]';