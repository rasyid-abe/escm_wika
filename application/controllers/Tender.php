<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tender extends Telescoope_Controller {

  var $data;

  public function __construct(){

    parent::__construct();

    $this->load->model(array("Workflow_m","Procurement_m","Procpagu_m","Procrfq_m","Procpr_m","Procplan_m","Procevaltemp_m","Administration_m","Comment_m","Administration_m","Procedure_m","Commodity_m"));

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'tender';

    $this->data['controller_name'] = $this->uri->segment(1);

    $this->session->set_userdata("module",$this->data['dir']);

    // haqim
    switch ($this->uri->segment(2)) {
      case 'submit_chat_pr':
        $dir = './uploads/'.PROCUREMENT_PERENCANAAN_CHAT_SPPBJ_FOLDER;
        break;
      case 'submit_chat_rfq':
        $dir = './uploads/'.PROCUREMENT_PERENCANAAN_CHAT_RFQ_FOLDER;
        break;

      default:
        $dir = './uploads/'.$this->data['dir'];
        break;
    }
    // end

    if (!file_exists($dir)){
      mkdir($dir, 0777, true);
    }

    $config['allowed_types'] = '*';
    $config['overwrite'] = false;
    $config['max_size'] = 3064;
    $config['upload_path'] = $dir;
    $this->load->library('upload', $config);

    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

    $this->data['doc_category'] = $this->Procurement_m->getKategoriDokumen()->result_array();

    $selection = array (
      "selection_mata_anggaran",
      "selection_perencanaan_pengadaan",
      "selection_permintaan_pengadaan",
      "selection_template_evaluasi",
      "selection_vendor_tender",
      "selection_vendor_tender_hadir",
      "selection_vendor_tender_hadir_2",
      "selection_panitia",
      "selection_klasifikasi",
      "selection_district",
      "selection_pr",
      "selection_group"
    );

    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    $this->data['workflow_list'] = array(3=>"Ditolak",2=>"Disetujui");

    if(empty($userdata)){
      redirect(site_url('log/in'));
    }

 }

  public function proyek_pmcs(){
    include("tender/proyek_pmcs.php");
  }

}
