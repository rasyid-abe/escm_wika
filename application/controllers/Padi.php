<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Padi extends Telescoope_Controller {

	var $data;

    public function __construct(){

        // Call the Model constructor
        parent::__construct();

        $this->load->model(array("Padi_m", "Administration_m"));

        $this->data['date_format'] = "h:i A | d M Y";

        $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

        $this->data['data'] = array();

        $this->data['post'] = $this->input->post();

        $userdata = $this->Administration_m->getLogin();

        $this->data['dir'] = 'padi';

        $this->data['controller_name'] = $this->uri->segment(1);

        $dir = './uploads/'.$this->data['dir'];

        $this->session->set_userdata("module",$this->data['dir']);

        if (!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['overwrite'] = false;
        $config['max_size'] = 50000;
        $config['upload_path'] = $dir;
        $config['encrypt_name'] = TRUE;
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

    public function transaksi($param = ""){
        switch ($param) {
            case 'detail':
                include("padi/lihat_detail_transaksi.php");
                break;
        
            default:
                include("padi/transaksi.php");
                break;
        }
    }

    public function umkm($param = ""){
        switch ($param) {
            case 'detail':
                include("padi/lihat_detail_umkm.php");
                break;
        
            default:
                include("padi/umkm.php");
                break;
        }
    }

    public function data_transaksi(){
        include("padi/data_transaksi.php");
    }

    public function data_umkm(){
        include("padi/data_umkm.php");
    }

    public function upload_transaksi(){
        include("padi/upload_transaksi.php");
    }

    public function upload_umkm(){
        include("padi/upload_umkm.php");
    }

    public function push_transaksi($id){
        include("padi/push_transaksi.php");
    }

    public function push_umkm($id){
        include("padi/push_umkm.php");
    }
    public function push_umkm_all(){
        include("padi/push_umkm_all.php");
    }

    public function push_transaksi_all(){
        include("padi/push_transaksi_all.php");
    }
}
