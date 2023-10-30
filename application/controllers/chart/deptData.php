<?php
if(!empty($param2)){

    $this->db->limit(5, 0);
    $this->db->where('ptm_dept_id', $param2);
    $this->db->order_by('efisiensi_percent', 'desc');
    $dept = $this->db->get('vw_efisiensi')->result_array();

    $data['data'][0]['type'] = 'column';
    $data['data'][1]['type'] = 'column';
    $data['data'][2]['type'] = 'column';

    $data['data'][0]['id'] = $param2;
    $data['data'][1]['id'] = $param2;
    $data['data'][2]['id'] = $param2;

    $data['data'][0]['name'] = 'Inefisiensi';
    $data['data'][1]['name'] = 'Efisiensi';
    $data['data'][2]['name'] = 'Nilai Kontrak';
    
    $data['data'][0]['color'] = '#FF0000';
    $data['data'][1]['color'] = '#A9D18E';
    $data['data'][2]['color'] = '#2E75B6';
    
    $data['data'][0]['index'] = 0;
    $data['data'][1]['index'] = 1;
    $data['data'][2]['index'] = 2;

    foreach ($dept as $key => $value) {

        
        $data['data'][0]['data'][$key]['name'] = $value['ptm_number'];
        $data['data'][0]['data'][$key]['y'] = $value['inefisiensi'];
        $data['data'][0]['data'][$key]['hps'] = $value['hps'];
        
        $data['data'][1]['data'][$key]['name'] = $value['ptm_number'];
        $data['data'][1]['data'][$key]['y'] = $value['efisiensi'];
        $data['data'][1]['data'][$key]['hps'] = $value['hps'];
        

        $data['data'][2]['data'][$key]['name'] = $value['ptm_number'];
        $data['data'][2]['data'][$key]['y'] = $value['contract_amount'];
        $data['data'][2]['data'][$key]['hps'] = $value['hps'];
    }

$data['data'] = array_values($data['data']);

$this->db->limit(5, 0);
$this->db->where('ptm_dept_id', $param2);
$data['num_rows'] = $this->db->get('vw_efisiensi')->num_rows();

$data = json_encode($data,JSON_NUMERIC_CHECK);
}else{

    $this->db->limit($limit, $offset);
    $this->db->order_by('efisiensi', 'desc');
    $dept = $this->db->get('vw_dept_efisiensi')->result_array();

    $data['data'][0]['name'] = 'Inefisiensi';
    $data['data'][1]['name'] = 'Efisiensi';
    $data['data'][2]['name'] = 'Nilai Kontrak';
    
    $data['data'][0]['color'] = '#FF0000';
    $data['data'][1]['color'] = '#A9D18E';
    $data['data'][2]['color'] = '#2E75B6';
    
    $data['data'][0]['index'] = 0;
    $data['data'][1]['index'] = 1;
    $data['data'][2]['index'] = 2;
    foreach ($dept as $key => $value) {

        
        $data['data'][0]['data'][$key]['name'] = $value['ptm_dept_name'];
        $data['data'][0]['data'][$key]['y'] = $value['inefisiensi'];
        $data['data'][0]['data'][$key]['hps'] = $value['hps'];
        $data['data'][0]['data'][$key]['drilldown'] = $value['ptm_dept_id'];
        
        $data['data'][1]['data'][$key]['name'] = $value['ptm_dept_name'];
        $data['data'][1]['data'][$key]['y'] = $value['efisiensi'];
        $data['data'][1]['data'][$key]['hps'] = $value['hps'];
        $data['data'][1]['data'][$key]['drilldown'] = $value['ptm_dept_id']; 
        

        $data['data'][2]['data'][$key]['name'] = $value['ptm_dept_name'];
        $data['data'][2]['data'][$key]['y'] = $value['contract_amount'];
        $data['data'][2]['data'][$key]['hps'] = $value['hps'];
        $data['data'][2]['data'][$key]['drilldown'] = $value['ptm_dept_id'];  
    }

$data['data'] = array_values($data['data']);
$data['num_rows'] = $this->db->get('vw_dept_efisiensi')->num_rows();

$data = json_encode($data,JSON_NUMERIC_CHECK);

// print_r($data);
//     $data = '[{
//         "name": "Efisiensi",
//         "data": [{
//             "name": "DSU 1",
//             "y": 1,
//             "hps": 4,
//             "drilldown": "dsu1"
//         }, {
//             "name": "DSU 2",
//             "y": 4,
//             "hps": 9,
//             "drilldown": "dsu2"
//         }, {
//             "name": "DSU 3",
//             "y": 2,
//             "hps": 4,
//             "drilldown": "dsu3"
//         }, {
//             "name": "DLN",
//             "y": 5,
//             "hps": 8,
//             "drilldown": "dln"
//         }, {
//             "name": "DBG",
//             "y": 1,
//             "hps": 6,
//             "drilldown": "dbg"
//         }]
// },{
//     "name": "Nilai Kontrak",
//     "data": [{
//         "name": "DSU 1",
//         "y": 3,
//         "hps": 4,
//         "drilldown": "dsu1"
//     }, {
//         "name": "DSU 2",
//         "y": 5,
//         "hps": 9,
//         "drilldown": "dsu2"
//     }, {
//         "name": "DSU 3",
//         "y": 2,
//         "hps": 4,
//         "drilldown": "dsu3"
//     }, {
//         "name": "DLN",
//         "y": 3,
//         "hps": 8,
//         "drilldown": "dln"
//     }, {
//         "name": "DBG",
//         "y": 5,
//         "hps": 6,
//         "drilldown": "dbg"
//     }]
// }]';
}
// print_r(json_decode($data));