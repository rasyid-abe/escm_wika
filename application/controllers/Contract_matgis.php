<?php

if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Contract_matgis extends Telescoope_Controller
{
  public function __construct()
  {
    // Call the Model constructor
    parent::__construct();
    $this->load->model(array('Procedure_matgis_m', 'Settings_m', 'Workflow_m', 'Comment_m', 'Procedure2_m', 'Contract_m', 'Contract_matgis_m'));
    $userdata          = $this->Administration_m->getLogin();
    $this->load->model('Global_m');
    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

    if (empty($userdata)) {
      redirect(site_url('log/in')); 
    }
  }

  public function process_matgis($mod, $id=0, $state = 0)
  {
    switch ($mod) {
      case 'po':
      include('matgis/process/process_matgis_po.php');
      break;
      case 'skbdn':
      include('matgis/process/process_matgis_skbdn.php');
      break;
      case 'si':
      include('matgis/process/process_matgis_si.php');
      break;
      case 'sppm':
      include('matgis/process/process_matgis_sppm.php');
      break;
      case 'do':
      include('matgis/process/process_matgis_do.php');
      break;
      case 'sj':
      include('matgis/process/process_matgis_sj.php');
      break;
      case 'bapb':
      include('matgis/process/process_matgis_bapb.php');
      break;
      case 'inv':
      include('matgis/process/process_matgis_inv.php');
      break;

      default:
      // code...
      break;
    }
  }

public function task_lists()
{
  $data      = array();
  $title     = '';
  $sub_title = '';

  $data['sub_title'] = $sub_title;
  $view              = 'contract/matgis/task_lists_matgis_v';
  $this->template($view, $title, $data);
}

public function create_matgis($mod)
{
  switch ($mod) {
    case 'po':
    $title     = 'Pembuatan PO Matgis';
    $sub_title = 'Daftar Kontrak Matgis';
    break;
    case 'skbdn':
    $title     = 'Pembuatan SKBDN Matgis';
    $sub_title = 'Daftar SKBDN';
    break;
    case 'si':
    $title     = 'Pembuatan Shipping Instruction';
    $sub_title = 'Daftar PO Aktif';
    break;
    case 'sppm':
    $title     = 'Pembuatan SPPM';
    $sub_title = 'Daftar SI Aktif';
    break;
    case 'bapb':
    $title     = 'Pembuatan BAST';
    $sub_title = 'Daftar WO Aktif';
    break;

    default:
    // code...
    break;
  }

  $data              = array();
  $data['mod']       = $mod;
  $data['title']     = $title;
  $data['sub_title'] = $sub_title;
  $view              = 'contract/matgis/create_matgis_v';
  $this->template($view, $title, $data);
}

public function monitor_matgis($mod)
{
  //Unutuk melakukan monitoring terhadap WO yg sudah dibuat

  switch ($mod) {
    case 'po':
    $title     = 'Monitor WO Matgis';
    $sub_title = 'List WO Matgis';
    break;
    case 'si':
    $title     = 'Monitor SI';
    $sub_title = 'List SI';
    break;
    case 'sppm':
    $title     = 'Monitor SPPM';
    $sub_title = 'List SPPM';
    break;
    case 'do':
    $title     = 'Monitor Delivery Order(DO)';
    $sub_title = 'List Delivery Order';
    break;
    case 'sj':
    $title     = 'Monitor Surat Jalan(SJ)';
    $sub_title = 'List Surat Jalan';
    break;
    case 'bapb':
    $title     = 'Monitor BASTP';
    $sub_title = 'List BAST';
    break;
    case 'invoice':
    $title     = 'Monitor Tagihan';
    $sub_title = 'List Tagihan';
    break;
    case 'monev':
    $title     = 'Monitor Monev';
    $sub_title = 'List monev';
    break;
    case 'reports':
    $title     = 'Monitor Matgis';
    $sub_title = 'List Status Matgis ';
    break;

    default:
    break;
  }
  $data              = array();
  $data['mod']       = $mod;
  $data['sub_title'] = $sub_title;
  if($mod=='monev'){;
    $view='contract/matgis/monitor_matgis_v';
  }elseif($mod=='reports'){
    $view='contract/matgis/monitor_lists_matgis_v';
  }
  //$data['export'] =$exp;
  $this->template($view, $title, $data);
}

public function submit_process_matgis()
{
  $mod=$this->input->post('mod');
  switch ($mod) {
    case 'po':
    include('matgis/submit_process/submit_process_matgis_po.php');
    break;
    case 'skbdn':
    include('matgis/submit_process/submit_process_matgis_skbdn.php');
    break;
    case 'si':
    include('matgis/submit_process/submit_process_matgis_si.php');
    break;
    case 'sppm':
    include('matgis/submit_process/submit_process_matgis_sppm.php');
    break;
    case 'bapb':
    include('matgis/submit_process/submit_process_matgis_bapb.php');
    break;
    case 'inv':
    include('matgis/submit_process/submit_process_matgis_inv.php');
    break;

    default:
    // code...
    break;
  }
}

public function get_vendor_address($id)
{
  $feedback = $this->Global_m->get_data('vnd_header', array('vendor_id'=>$id))['address_street'];
  header('Content-Type: application/json');
  echo json_encode($feedback);
}

public function get_vendor_transporter_address($id)
{
  $feedback = $this->db->where('vendor_id',$id)->get('ctr_vnd_transporter')->row_array();
  header('Content-Type: application/json');
  echo json_encode($feedback);
}

public function number_exist($table, $number)
{
  $feedback = '';
  if ($this->Procedure_matgis_m->number_exist($table, strtoupper($number))) {
    $feedback = true;
  } else {
    $feedback = false;
  }

  return $feedback;
}


}
