<?php 


//$id = $this->uri->segment(5,0);

$view = 'pengadaan_com/karya/dashboard_summary_v';

$this->load->library('pengadaan_com/security_controller',null,"karya_security");
$this->load->library('pengadaan_com/karya_controller',null,"karya");


$login = $this->karya_security->login();
$accessToken = $login != null ? $login->accessToken : "";
$tokenType = $login != null ? $login->tokenType : "";

$dataDashboard = $this->karya->getDashboard($accessToken,$tokenType);
print_r($dataDashboard);
exit;
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
          'status' => $dataDashboard == null ? false : true
		];
       
$this->template($view,"BUMN KARYA",$data);

?>