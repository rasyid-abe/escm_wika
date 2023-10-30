<?php
if(!empty($param2)){

    $this->db->join('prc_tender_main b', 'b.ptm_number = vw_efisiensi.ptm_number', 'left');
    $this->db->join('prc_pr_main c', 'b.pr_number = c.pr_number', 'left');
    $this->db->join('prc_plan_main d', 'c.ppm_id = d.ppm_id', 'left');
    $this->db->join('prc_plan_integrasi e', 'e.spk_code = d.ppm_project_id', 'left');
    $this->db->limit(5, 0);
    $this->db->where('ppm_project_id', $param2);
    $this->db->select(' DISTINCT ON (b.ptm_number) * ');
    $this->db->order_by('b.ptm_number', 'asc');
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
        $data['data'][0]['data'][$key]['project_name'] = $value['project_name'];
        
        $data['data'][1]['data'][$key]['name'] = $value['ptm_number'];
        $data['data'][1]['data'][$key]['y'] = $value['efisiensi'];
        $data['data'][1]['data'][$key]['hps'] = $value['hps'];
        $data['data'][1]['data'][$key]['project_name'] = $value['project_name'];
        

        $data['data'][2]['data'][$key]['name'] = $value['ptm_number'];
        $data['data'][2]['data'][$key]['y'] = $value['contract_amount'];
        $data['data'][2]['data'][$key]['hps'] = $value['hps'];
        $data['data'][2]['data'][$key]['project_name'] = $value['project_name'];

    }

$data['data'] = array_values($data['data']);

$this->db->join('prc_tender_main b', 'b.ptm_number = vw_efisiensi.ptm_number', 'left');
$this->db->join('prc_pr_main c', 'b.pr_number = c.pr_number', 'left');
$this->db->join('prc_plan_main d', 'c.ppm_id = d.ppm_id', 'left');
$this->db->limit(5, 0);
$this->db->where('ppm_project_id', $param2);
$this->db->select(' DISTINCT ON (b.ptm_number) * ');
$this->db->order_by('b.ptm_number', 'asc');
$this->db->order_by('efisiensi_percent', 'desc');
$data['num_rows'] = $this->db->get('vw_efisiensi')->num_rows();

$data = json_encode($data,JSON_NUMERIC_CHECK);
   
    // switch ($param2) {
    //     case 'spk1':
    //         $data = '[{
    //             "id": "spk1",
    //             "name": "Nilai Kontrak",
    //             "data": [{
    //                 "name": "RFQ.201902.00042",
    //                 "y": 4,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00062",
    //                 "y": 9,
    //                 "hps": 9
    //             },{
    //                 "name": "RFQ.201902.00033",
    //                 "y": 2,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00043",
    //                 "y": 3,
    //                 "hps": 8
    //             },{
    //                 "name": "RFQ.201902.00088",
    //                 "y": 5,
    //                 "hps": 6
    //             }]
    //             }]';
    //         break;

    //     case 'spk2':
    //         $data = '[{
    //             "id": "spk2",
    //             "name": "Nilai Kontrak",
    //             "data": [{
    //                 "name": "RFQ.201902.00042",
    //                 "y": 4,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00062",
    //                 "y": 9,
    //                 "hps": 9
    //             },{
    //                 "name": "RFQ.201902.00033",
    //                 "y": 2,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00043",
    //                 "y": 3,
    //                 "hps": 8
    //             },{
    //                 "name": "RFQ.201902.00088",
    //                 "y": 5,
    //                 "hps": 6
    //             }]
    //         }]';
    //         break;

    //     case 'spk3':
    //         $data = '[{
    //             "id": "spk3",
    //             "name": "Nilai Kontrak",
    //             "data": [{
    //                 "name": "RFQ.201902.00042",
    //                 "y": 4,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00062",
    //                 "y": 9,
    //                 "hps": 9
    //             },{
    //                 "name": "RFQ.201902.00033",
    //                 "y": 2,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00043",
    //                 "y": 3,
    //                 "hps": 8
    //             },{
    //                 "name": "RFQ.201902.00088",
    //                 "y": 5,
    //                 "hps": 6
    //             }]
    //         }]';
    //         break;

    //     case 'spk4':
    //         $data = '[{
    //             "id": "spk4",
    //             "name": "Nilai Kontrak",
    //             "data": [{
    //                 "name": "RFQ.201902.00042",
    //                 "y": 4,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00062",
    //                 "y": 9,
    //                 "hps": 9
    //             },{
    //                 "name": "RFQ.201902.00033",
    //                 "y": 2,
    //                 "hps": 4
    //             },{
    //                 "name": "RFQ.201902.00043",
    //                 "y": 3,
    //                 "hps": 8
    //             },{
    //                 "name": "RFQ.201902.00088",
    //                 "y": 5,
    //                 "hps": 6
    //             }]
    //         }]';

    //     case 'spk5':
    //         $data = '[{
    //             "id": "spk5",
    //             "name": "Nilai Kontrak",
    //             "data": [{
    //                     "name": "RFQ.201902.00042",
    //                     "y": 4,
    //                     "hps": 4
    //                 },{
    //                     "name": "RFQ.201902.00062",
    //                     "y": 9,
    //                     "hps": 9
    //                 },{
    //                     "name": "RFQ.201902.00033",
    //                     "y": 2,
    //                     "hps": 4
    //                 },{
    //                     "name": "RFQ.201902.00043",
    //                     "y": 3,
    //                     "hps": 8
    //                 },{
    //                     "name": "RFQ.201902.00088",
    //                     "y": 5,
    //                     "hps": 6
    //                 }]
    //         }]';
    //         break;
        
    //     default:
    //         $data = '[{
    //             "id": "spk5",
    //             "name": "Nilai Kontrak",
    //             "data": [{
    //                     "name": "RFQ.201902.00042",
    //                     "y": 4,
    //                     "hps": 4
    //                 },{
    //                     "name": "RFQ.201902.00062",
    //                     "y": 9,
    //                     "hps": 9
    //                 },{
    //                     "name": "RFQ.201902.00033",
    //                     "y": 2,
    //                     "hps": 4
    //                 },{
    //                     "name": "RFQ.201902.00043",
    //                     "y": 3,
    //                     "hps": 8
    //                 },{
    //                     "name": "RFQ.201902.00088",
    //                     "y": 5,
    //                     "hps": 6
    //                 }]
    //         }]';
    //         break;
    // }
}else{

$this->db->limit($limit, $offset);
$this->db->order_by('ptm_dept_id');
$dept = $this->db->get('vw_top_5_efisiensi_proyek')->result_array();

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
    
    $data['data'][2]['data'][$key]['name'] = $value['ppm_project_id'];
    $data['data'][2]['data'][$key]['y'] = $value['contract_amount'];
    $data['data'][2]['data'][$key]['hps'] = $value['hps'];
    $data['data'][2]['data'][$key]['drilldown'] = $value['ppm_project_id']; 
    $data['data'][2]['data'][$key]['project_name'] = $value['project_name']; 

    $data['data'][1]['data'][$key]['name'] = $value['ppm_project_id'];
    $data['data'][1]['data'][$key]['y'] = $value['efisiensi'];
    $data['data'][1]['data'][$key]['hps'] = $value['hps'];
    $data['data'][1]['data'][$key]['drilldown'] = $value['ppm_project_id']; 
    $data['data'][1]['data'][$key]['project_name'] = $value['project_name']; 

    
    $data['data'][0]['data'][$key]['name'] = $value['ppm_project_id'];
    $data['data'][0]['data'][$key]['y'] = $value['inefisiensi'];
    $data['data'][0]['data'][$key]['hps'] = $value['hps'];
    $data['data'][0]['data'][$key]['drilldown'] = $value['ppm_project_id']; 
    $data['data'][0]['data'][$key]['project_name'] = $value['project_name']; 

}

$data['data'] = array_values($data['data']);
$data['num_rows'] = $this->db->get('vw_top_5_efisiensi_proyek')->num_rows();

$data = json_encode($data,JSON_NUMERIC_CHECK);
}