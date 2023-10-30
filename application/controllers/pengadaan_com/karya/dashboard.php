<?php 

$param = $_GET;
$dateStart = isset($param['dateStart']) ? $param['dateStart']."%2000%3A00%3A00" : date('Y-m-d')."%2000%3A00%3A00"; //'2022-05-10%2000%3A00%3A00'; // date('Y-m-d')." 00:00:00";
$dateEnd = isset($param['dateEnd']) ? $param['dateEnd']."%2000%3A00%3A00" : date('Y-m-d')."%2000%3A00%3A00";//'2022-05-15%2000%3A00%3A00';//date('Y-m-d')." 00:00:00";

$view = 'pengadaan_com/karya/dashboard_v';

$this->load->library('pengadaan_com/Security_controller',null,"karya_security");
$this->load->library('pengadaan_com/Karya_controller',null,"karya");

$login = $this->karya_security->login();
$accessToken = $login != null ? $login->accessToken : "";
$tokenType = $login != null ? $login->tokenType : "";

$dataDashboard = $this->karya->getDashboard($accessToken,$tokenType);

$dataDashboardSummary = $this->karya->getDashboardSummary($accessToken,$tokenType,$dateStart,$dateEnd);

$data = [
		  'jumlah' => 1,
		  'totalVndActive' => $dataDashboard == null ? 0 : $dataDashboard->data->totalVndActive,
          'totalVndSuspend' => $dataDashboard == null ? 0 : $dataDashboard->data->totalVndSuspend,
          'totalVndWarning' => $dataDashboard == null ? 0 : $dataDashboard->data->totalVndWarning,
          'totalVndBlacklist' => $dataDashboard == null ? 0 : $dataDashboard->data->totalVndBlacklist,
          'listVndActive' => $dataDashboard == null ? json_encode([]) : json_encode($dataDashboard->data->listVndActive),
          'listVndSuspend' => $dataDashboard == null ? json_encode([]) : json_encode($dataDashboard->data->listVndSuspend),
          'listVndWarning' => $dataDashboard == null ? json_encode([]) : json_encode($dataDashboard->data->listVndWarning),
          'listVndBlacklist' => $dataDashboard == null ? json_encode([]) : json_encode($dataDashboard->data->listVndBlacklist),
          'status' => $dataDashboard == null ? false : true,
          'dateStart' => str_replace("%2000%3A00%3A00","",$dateStart),
          'dateEnd' => str_replace("%2000%3A00%3A00","",$dateEnd)
		];

$data['vndNewRegister'] = json_encode([]);
$data['vndNewActivated'] = json_encode([]);

$data['listVndStatus'] = json_encode([]);
$data['listVndCqsms'] = json_encode([]);

$data['listTopTenUnspsc'] = json_encode([]);
$data['listTopTenKbli'] = json_encode([]);

$data['listVndSkn'] = json_encode([]);
$data['listVndLocation'] = json_encode([]);

$data['dashboardSummary'] = $dataDashboardSummary;

if($dataDashboardSummary!= null)
{
    //vndNewRegister
    $vndNewRegister[0]["register"]= 'Total';
    $vndNewRegister[0]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->totalAll;
    $vndNewRegister[1]["register"]= 'Total Current Year';
    $vndNewRegister[1]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->totalCurrentYear;
    $vndNewRegister[2]["register"]= 'Total Last Month';
    $vndNewRegister[2]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->totalLastMonth;
    $vndNewRegister[3]["register"]= 'Average Last Month';
    $vndNewRegister[3]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->avgLastMonth;
    $vndNewRegister[4]["register"]= 'Total Current Month';
    $vndNewRegister[4]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->totalCurrentMonth;
    $vndNewRegister[5]["register"]= 'Average Current Month';
    $vndNewRegister[5]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->avgCurrentMonth;
    $vndNewRegister[6]["register"]= 'Total Last Week';
    $vndNewRegister[6]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->totalLastWeek;
    $vndNewRegister[7]["register"]= 'Average Last Week';
    $vndNewRegister[7]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->avgLastWeek;
    $vndNewRegister[8]["register"]= 'Total Current Week';
    $vndNewRegister[8]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->totalCurrentWeek;
    $vndNewRegister[9]["register"]= 'Average Current Week';
    $vndNewRegister[9]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewRegister->avgCurrentWeek;
    $vndNewRegister = json_encode($vndNewRegister);
    $vndNewRegister = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $vndNewRegister);


    $data['vndNewRegister'] = $vndNewRegister;


    $vndNewActivated[0]['register']= 'Total';
    $vndNewActivated[0]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->totalAll;
    $vndNewActivated[1]['register']= 'Total Current Year';
    $vndNewActivated[1]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->totalCurrentYear;
    $vndNewActivated[2]['register']= 'Total Last Month';
    $vndNewActivated[2]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->totalLastMonth;
    $vndNewActivated[3]['register']= 'Average Last Month';
    $vndNewActivated[3]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->avgLastMonth;
    $vndNewActivated[4]['register']= 'Total Current Month';
    $vndNewActivated[4]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->totalCurrentMonth;
    $vndNewActivated[5]['register']= 'Average Current Month';
    $vndNewActivated[5]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->avgCurrentMonth;
    $vndNewActivated[6]['register']= 'Total Last Week';
    $vndNewActivated[6]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->totalLastWeek;
    $vndNewActivated[7]['register']= 'Average Last Week';
    $vndNewActivated[7]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->avgLastWeek;
    $vndNewActivated[8]['register']= 'Total Current Week';
    $vndNewActivated[8]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->totalCurrentWeek;
    $vndNewActivated[9]['register']= 'Average Current Week';
    $vndNewActivated[9]['val']= $dataDashboardSummary->data->vndAnalytic->vndNewActivated->avgCurrentWeek;
    $vndNewActivated = json_encode($vndNewActivated);
    $vndNewActivated = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $vndNewActivated);

    $data['vndNewActivated'] = $vndNewActivated;

    $listVndStatus = json_encode($dataDashboardSummary->data->listVndStatus);
    $listVndStatus = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $listVndStatus);

    $listVndCqsms = json_encode($dataDashboardSummary->data->listVndCqsms);
    $listVndCqsms = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $listVndCqsms);

    $listTopTenUnspsc = json_encode($dataDashboardSummary->data->listTopTenUnspsc);
    $listTopTenUnspsc = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $listTopTenUnspsc);

    $listTopTenKbli = json_encode($dataDashboardSummary->data->listTopTenKbli);
    $listTopTenKbli = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $listTopTenKbli);

    $listVndSkn = json_encode($dataDashboardSummary->data->listVndSkn);
    $listVndSkn = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $listVndSkn);
    
    $listVndLocation = json_encode($dataDashboardSummary->data->listVndLocation);
    $listVndLocation = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $listVndLocation);

    $data['listTopTenUnspsc'] = $listTopTenUnspsc;
    $data['listTopTenKbli'] = $listTopTenKbli;
    $data['listVndStatus'] = $listVndStatus;
    $data['listVndCqsms'] = $listVndCqsms;
    $data['listVndSkn'] = $listVndSkn;
    $data['listVndLocation'] = $listVndLocation;
    
}

       
$this->template($view,"BUMN KARYA",$data);

?>