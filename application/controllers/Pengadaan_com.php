<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengadaan_com extends Telescoope_Controller
{

  var $data;

  public function __construct()
  {

    // Call the Model constructor
    parent::__construct();

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
    
    $this->data['controller_name'] = $this->uri->segment(1);

    if (empty($userdata)) {
      redirect(site_url('log/in'));
    }
  }

  public function karya($param1 = "")
  {
    switch ($param1) {
      default:
        $this->karya_dashboard();
        break;
    }
  }

  public function karya_dashboard_summary($param1 = "", $param2 = "", $param3 = "")
  {
    switch ($param1) {
      default:
        $this->karya_dashboard();
        break;
    }
  }

  function karya_dashboard()
  {
    include("pengadaan_com/karya/dashboard.php");
  }

  function karya_dashboard_sum()
  {
    include("pengadaan_com/karya/dashboard_summary.php");
  }

  

}
