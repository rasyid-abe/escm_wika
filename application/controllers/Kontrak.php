<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kontrak extends Telescoope_Controller {

	  var $data;

    public function __construct(){

          // Call the Model constructor
      parent::__construct();

      $this->load->model(array("Procedure2_m","Procedure3_m","Contract_m","Procrfq_m","Administration_m","Comment_m","Administration_m","Workflow_m","Addendum_m","Procplan_m","Procpr_m"));

      $this->data['date_format'] = "h:i A | d M Y";

      $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

      $this->data['data'] = array();

      $this->data['post'] = $this->input->post();

      $userdata = $this->Administration_m->getLogin();

      $this->data['dir'] = 'kontrak';

      $this->data['controller_name'] = $this->uri->segment(1);

      $dir = './uploads/'.$this->data['dir'];

      $this->session->set_userdata("module",$this->data['dir']);

      if (!file_exists($dir)){
        mkdir($dir, 0777, true);
      }

      $config['allowed_types'] = '*';
      $config['overwrite'] = false;
      $config['max_size'] = 3064;
      $config['upload_path'] = $dir;
      $this->load->library('upload', $config);
      $this->load->model("Global_m");
      $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

      $selection = array(
        "selection_milestone"
        );
      foreach ($selection as $key => $value) {
        $this->data[$value] = $this->session->userdata($value);
      }

      if(empty($userdata)){
      redirect(site_url('log/in'));
    }

  }

  public function amandemen(){
    include("kontrak/amandemen.php");
  }

  public function kontrak_dinilai() {
    include("kontrak/kontrak_dinilai.php");
  }
  public function kontrak_tidak_dinilai() {
    include("kontrak/kontrak_tidak_dinilai.php");
  }
}
