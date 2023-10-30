<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commodity extends Telescoope_Controller {

  var $data;

  public function __construct(){

        // Call the Model constructor
    parent::__construct();

    $this->load->model(array("Commodity_m","Administration_m","Comment_m","Administration_m"));

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'commodity';

    $this->data['controller_name'] = $this->uri->segment(1);

    $dir = './uploads/'.$this->data['dir'];

    if (!file_exists($dir)){
      mkdir($dir, 0777, true);
    }

    $config['allowed_types'] = '*';
    $config['overwrite'] = false;
    $config['max_size'] = 3064;
    $config['upload_path'] = $dir;
    $this->load->library('upload', $config);

    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
    
    $selection = array(
      "selection_mat_catalog",
      "selection_srv_catalog",
      "selection_mat_group",
      "selection_srv_group",
      "selection_mat_price",
      "selection_srv_price",
      "selection_sourcing",
      "selection_catalog",
      );
    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    if(empty($userdata)){
     redirect(site_url('log/in'));
   }
   
 }

 public function panduan(){
  redirect(base_url("guide/WIKA_eSCM_Quick Guide_Commodity_v0.1.pptx"));
 }

 public function daftar_pekerjaan($param1 = "" ,$param2 = ""){

  $this->data['workflow_list'] = array("R"=>"Ditolak","A"=>"Disetujui");

  switch ($param1) {

    case 'approval_grup_brg':
    $this->approval_grup_brg();
    break;

    case 'approval_grup_jasa':
    $this->approval_grup_jasa();
    break;

    case 'approval_kat_brg':
    $this->approval_kat_brg();
    break;

    case 'approval_kat_brg_smbd':
    $this->approval_kat_brg(1);
    break;

    case 'approval_kat_jasa':
    $this->approval_kat_jasa();
    break;

    case 'approval_kat_jasa_smbd':
    $this->approval_kat_jasa(1);
    break;

    case 'approval_hrg_brg':
    $this->approval_hrg_brg();
    break;

    case 'approval_hrg_jasa':
    $this->approval_hrg_jasa();
    break;

    case 'approval_hrg_brg_smbd':
    $this->approval_hrg_brg_smbd();
    break;

    case 'approval_hrg_jasa_smbd':
    $this->approval_hrg_jasa_smbd();
    break;

    default:
    $this->view_daftar_pekerjaan();
    break;

  }

}

public function data_referensi($param1 = "", $param2 = ""){

  switch ($param1) {

    case 'sumber':

    switch ($param2) {

      case 'add':
      $this->add_sumber();
      break;

      case 'edit':
      $this->edit_sumber();
      break;

      case 'delete':
      $this->delete_sumber();
      break;

      default:
      $this->view_sumber();
      break;

    }

    break;

    default:
      # code...
    break;
  }

}

public function daftar_harga($param1 = "", $param2 = ""){

  switch ($param1) {

    case 'daftar_harga_barang':

    switch ($param2) {

      case 'add':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->add_hrg_brg();
      break;

      case 'edit':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->edit_hrg_brg();
      break;

      case 'delete':
      $this->delete_hrg_brg();
      break;

      case 'picker':
      $this->picker_hrg_brg();
      break;

      default:
      $this->view_hrg_brg();
      break;

    }

    break;

    case 'daftar_harga_jasa':

    switch ($param2) {

      case 'add':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->add_hrg_jasa();
      break;

      case 'edit':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->edit_hrg_jasa();
      break;

      case 'delete':
      $this->delete_hrg_jasa();
      break;

      case 'picker':
      $this->picker_hrg_jasa();
      break;

      default:
      $this->view_hrg_jasa();
      break;

    }

    break;

    case 'daftar_harga_barang_sumberdaya':

    switch ($param2) {

      case 'add':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->add_hrg_brg_smbd();
      break;

      case 'edit':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->edit_hrg_brg_smbd();
      break;

      case 'delete':
      $this->delete_hrg_brg_smbd();
      break;

      case 'picker':
      $this->picker_hrg_brg_smbd();
      break;

      default:
      $this->view_hrg_brg_smbd();
      break;

    }

    break;

    case 'daftar_harga_jasa_sumberdaya':

    switch ($param2) {

      case 'add':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->add_hrg_jasa_smbd();
      break;

      case 'edit':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->edit_hrg_jasa_smbd();
      break;

      case 'delete':
      $this->delete_hrg_jasa_smbd();
      break;

      case 'picker':
      $this->picker_hrg_jasa();
      break;

      default:
      $this->view_hrg_jasa_smbd();
      break;

    }

    break;

    case 'daftar_harga_barang_sumberdaya_matgis':

    switch ($param2) {

      case 'add':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->add_hrg_brg_smbd_matgis();
      break;

      case 'edit':
      $this->session->set_userdata("module",$this->data['dir']);
      $this->edit_hrg_brg_smbd_matgis();
      break;

      case 'delete':
      $this->delete_hrg_brg_smbd_matgis();
      break;

      case 'picker':
      $this->picker_hrg_brg_smbd_matgis();
      break;

      default:
      $this->view_hrg_brg_smbd_matgis();
      break;

    }

    break;

    default:
      # code...
    break;
  }

}

public function katalog($param1 = "", $param2 = ""){

  switch ($param1) {

    case 'katalog_barang':

    switch ($param2) {

      case 'add':
      $this->add_mat_catalog();
      break;

      case 'edit':
      $this->edit_mat_catalog();
      break;

      case 'delete':
      $this->delete_mat_catalog();
      break;

      case 'picker':
      $this->picker_mat_catalog();
      break;
     //=================tambah===================
      case 'picker_inv':
      $this->picker_mat_catalog_inv();
      break;
    //========================================
    case 'picktik':
      $this->picker_tiket_catalog();
      break;

      default:
      $this->view_mat_catalog();
      break;

    }

    break;

    case 'grup_barang':

    switch ($param2) {

      case 'add':
      $this->add_grup_brg();
      break;

      case 'edit':
      $this->edit_grup_brg();
      break;

      case 'delete':
      $this->delete_grup_brg();
      break;
    
    case 'picker':
      $this->picker_grup_brg();
      break;

      default:
      $this->view_grup_brg();
      break;

    }

    break;

    //haq

    case 'grup_barang_sumberdaya':

    switch ($param2) {

      case 'add':
      $this->add_grup_brg_sumberdaya();
      break;

      case 'edit':
      $this->edit_grup_brg_sumberdaya();
      break;

      case 'delete':
      $this->delete_grup_brg_sumberdaya();
      break;
    
      case 'picker':
      $this->picker_grup_brg_sumberdaya();
      break;

      default:
      $this->view_grup_brg_sumberdaya();
      break;

    }

    break;

    case 'katalog_barang_sumberdaya':
    switch ($param2) {
      case 'add':
      $this->add_mat_catalog_smbd();
      break;

      case 'edit':
      $this->edit_mat_catalog_smbd();
      break;

      case 'delete':
      $this->delete_mat_catalog_smbd();
      break;
      
      case 'picker':
      $this->picker_mat_catalog_smbd();
      break;

      default:
      $this->view_mat_catalog_smbd();
      break;
    }

    break;

    case 'katalog_all_sumberdaya':
      switch ($param2) {        
        case 'picker':
        $this->picker_all_catalog_smbd();
        break;
      }
  
      break;

    case 'grup_jasa_sumberdaya':

    switch ($param2) {

      case 'add':
      $this->add_grup_jasa_sumberdaya();
      break;

      case 'edit':
      $this->edit_grup_jasa_sumberdaya();
      break;

      case 'delete':
      $this->delete_grup_jasa_sumberdaya();
      break;
    
      case 'picker':
      $this->picker_grup_jasa_sumberdaya();
      break;

      default:
      $this->view_grup_jasa_sumberdaya();
      break;

    }

    break;

    case 'katalog_jasa_sumberdaya':

    switch ($param2) {

      case 'add':
      $this->add_kat_jasa_smbd();
      break;

      case 'edit':
      $this->edit_kat_jasa_smbd();
      break;

      case 'delete':
      $this->delete_kat_jasa_smbd();
      break;

      case 'picker':
      $this->picker_kat_jasa_smbd();
      break;

      default:
      $this->view_kat_jasa_smbd();
      break;

    }

    break;

    //end

    case 'katalog_jasa':

    switch ($param2) {

      case 'add':
      $this->add_kat_jasa();
      break;

      case 'edit':
      $this->edit_kat_jasa();
      break;

      case 'delete':
      $this->delete_kat_jasa();
      break;

      case 'picker':
      $this->picker_kat_jasa();
      break;

      default:
      $this->view_kat_jasa();
      break;

    }

    break;

    case 'grup_jasa':

    switch ($param2) {

      case 'add':
      $this->add_grup_jasa();
      break;

      case 'edit':
      $this->edit_grup_jasa();
      break;

      case 'delete':
      $this->delete_grup_jasa();
      break;
    
    case 'picker':
      $this->picker_grup_jasa();
      break;

      default:
      $this->view_grup_jasa();
      break;

    }

    break;

    case 'grup_matgis':

    switch ($param2) {
    
    case 'picker':
      $this->picker_grup_matgis();
      break;

    }

    break;
    
    default:
      # code...
    break;
  }

}

public function submit_approval_grup_brg(){
  include("commodity/daftar_pekerjaan/submit_approval_grup_brg.php");
}

public function view_daftar_pekerjaan(){
  include("commodity/daftar_pekerjaan/daftar_pekerjaan.php");
}

public function approval_kat_brg($isSmbd = ""){
  include("commodity/daftar_pekerjaan/approval_kat_brg.php");
}

public function submit_approval_kat_brg(){
  include("commodity/daftar_pekerjaan/submit_approval_kat_brg.php");
}

public function submit_approval_kat_brg_smbd(){
  include("commodity/daftar_pekerjaan/submit_approval_kat_brg_smbd.php");
}

public function approval_kat_jasa($isSmbd=""){
  include("commodity/daftar_pekerjaan/approval_kat_jasa.php");
}

public function submit_approval_kat_jasa_smbd(){
  include("commodity/daftar_pekerjaan/submit_approval_kat_jasa_smbd.php");
}

public function submit_approval_kat_jasa(){
  include("commodity/daftar_pekerjaan/submit_approval_kat_jasa.php");
}

public function approval_hrg_brg(){
  include("commodity/daftar_pekerjaan/approval_hrg_brg.php");
}

public function submit_approval_hrg_brg(){
  include("commodity/daftar_pekerjaan/submit_approval_hrg_brg.php");
}

public function approval_hrg_jasa(){
  include("commodity/daftar_pekerjaan/approval_hrg_jasa.php");
}

public function submit_approval_hrg_jasa(){
  include("commodity/daftar_pekerjaan/submit_approval_hrg_jasa.php");
}

public function approval_hrg_brg_smbd(){
  include("commodity/daftar_pekerjaan/approval_hrg_brg_smbd.php");
}

public function submit_approval_hrg_brg_smbd(){
  include("commodity/daftar_pekerjaan/submit_approval_hrg_brg_smbd.php");
}

public function approval_hrg_jasa_smbd(){
  include("commodity/daftar_pekerjaan/approval_hrg_jasa_smbd.php");
}

public function submit_approval_hrg_jasa_smbd(){
  include("commodity/daftar_pekerjaan/submit_approval_hrg_jasa_smbd.php");
}

public function view_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/view_mat_catalog_smbd.php");
}

public function add_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/add_mat_catalog_smbd.php");
}

public function get_unspsc_code(){
  include("commodity/mat_catalog_sumberdaya/get_unspsc_group_code.php");
}

public function submit_add_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/submit_add_mat_catalog_smbd.php");
}

public function data_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/data_mat_catalog_smbd.php");
}

public function data_kat_smbd(){
  include("commodity/all_catalog_sumberdaya/data_kat_smbd.php");
}

public function edit_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/edit_mat_catalog_smbd.php");
}

public function submit_edit_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/submit_edit_mat_catalog_smbd.php");
}

public function delete_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/delete_mat_catalog_smbd.php");
}

public function view_kat_jasa_smbd(){
 include("commodity/kat_jasa_sumberdaya/view_kat_jasa_smbd.php");
}

public function add_kat_jasa_smbd(){
 include("commodity/kat_jasa_sumberdaya/add_kat_jasa_smbd.php");
}

public function submit_add_kat_jasa_smbd(){
 include("commodity/kat_jasa_sumberdaya/submit_add_kat_jasa_smbd.php");
}

public function data_kat_jasa_smbd(){
 include("commodity/kat_jasa_sumberdaya/data_kat_jasa_smbd.php");
}

public function edit_kat_jasa_smbd(){
 include("commodity/kat_jasa_sumberdaya/edit_kat_jasa_smbd.php");
}

public function submit_edit_kat_jasa_smbd(){
 include("commodity/kat_jasa_sumberdaya/submit_edit_kat_jasa_smbd.php");
}

public function picker_mat_catalog_smbd(){
  include("commodity/mat_catalog_sumberdaya/picker_mat_catalog_smbd.php");
}

public function picker_kat_jasa_smbd(){
  include("commodity/kat_jasa_sumberdaya/picker_kat_jasa_smbd.php");
}

public function picker_all_catalog_smbd(){
  include("commodity/all_catalog_sumberdaya/picker_all_catalog_smbd.php");
}

public function delete_kat_jasa_smbd(){
  include("commodity/kat_jasa_sumberdaya/delete_kat_jasa_smbd.php");
}

public function view_mat_catalog(){
  include("commodity/mat_catalog/view_mat_catalog.php");
}

public function data_mat_catalog(){
  include("commodity/mat_catalog/data_mat_catalog.php");
}


//=============================tambah==================================
public function data_mat_catalog_inv(){
  include("commodity/mat_catalog/data_mat_catalog_inv.php");
}
//=====================================================================
public function data_tiket_catalog(){
  include("commodity/mat_catalog/data_tiket_catalog.php");
}

public function alias_mat_catalog(){
  include("commodity/mat_catalog/alias_mat_catalog.php");
}

public function add_mat_catalog(){
  include("commodity/mat_catalog/add_mat_catalog.php");
}

public function submit_add_mat_catalog(){
  include("commodity/mat_catalog/submit_add_mat_catalog.php");
}

public function edit_mat_catalog(){
  include("commodity/mat_catalog/edit_mat_catalog.php");
}

public function submit_edit_mat_catalog(){
  include("commodity/mat_catalog/submit_edit_mat_catalog.php");
}

public function delete_mat_catalog(){
  include("commodity/mat_catalog/delete_mat_catalog.php");
}

public function picker_mat_catalog(){
  include("commodity/mat_catalog/picker_mat_catalog.php");
}
//=========================tambah===================
public function picker_mat_catalog_inv(){
  include("commodity/mat_catalog/picker_mat_catalog_inv.php");
}
//==================================================
public function picker_tiket_catalog(){
  include("commodity/mat_catalog/picker_tiket_catalog.php");
}

public function picker_hrg_brg(){
  include("commodity/hrg_brg/picker_hrg_brg.php");
}

public function picker_hrg_jasa(){
  include("commodity/hrg_jasa/picker_hrg_jasa.php");
}

public function picker_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/picker_hrg_brg_smbd.php");
}

public function picker_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/picker_hrg_jasa_smbd.php");
}

public function view_kat_jasa(){
 include("commodity/kat_jasa/view_kat_jasa.php");
}

public function data_kat_jasa(){
 include("commodity/kat_jasa/data_kat_jasa.php");
}

public function alias_kat_jasa(){
 include("commodity/kat_jasa/alias_kat_jasa.php");
}

public function add_kat_jasa(){
 include("commodity/kat_jasa/add_kat_jasa.php");
}

public function submit_add_kat_jasa(){
 include("commodity/kat_jasa/submit_add_kat_jasa.php");
}

public function edit_kat_jasa(){
 include("commodity/kat_jasa/edit_kat_jasa.php");
}

public function submit_edit_kat_jasa(){
 include("commodity/kat_jasa/submit_edit_kat_jasa.php");
}

public function delete_kat_jasa(){
  include("commodity/kat_jasa/delete_kat_jasa.php");
}

public function picker_kat_jasa(){
  include("commodity/kat_jasa/picker_kat_jasa.php");
}

//haq
public function view_grup_brg_sumberdaya(){
  include("commodity/grup_brg_sumberdaya/view_grup_brg_sumberdaya.php");
}

public function data_grup_brg_smbd(){
  include("commodity/grup_brg_sumberdaya/data_grup_brg_smbd.php");
}

public function dropdown_grup_brg_smbd(){
  include("commodity/grup_brg_sumberdaya/dropdown_grup_brg_smbd.php");
}

public function add_grup_brg_sumberdaya(){
  include("commodity/grup_brg_sumberdaya/add_grup_brg_smbd.php");
}

public function submit_add_grup_brg_smbd(){
  include("commodity/grup_brg_sumberdaya/submit_add_grup_brg_smbd.php");
}

public function submit_edit_grup_brg_smbd(){
  include("commodity/grup_brg_sumberdaya/submit_edit_grup_brg_smbd.php");
}

public function edit_grup_brg_sumberdaya(){
  include("commodity/grup_brg_sumberdaya/edit_grup_brg_smbd.php");
}

public function submit_edit_grup_brg_sumberdaya(){
  $this->noAccess("Tidak dapat mengubah grup barang. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_brg/submit_edit_grup_brg.php");
}

public function delete_grup_brg_sumberdaya(){
  $this->noAccess("Tidak dapat menghapus grup barang. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_brg/delete_grup_brg.php");
}

public function picker_grup_brg_sumberdaya(){
  include("commodity/grup_brg_sumberdaya/picker_grup_brg_smbd.php");
}

public function picker_grup_matgis(){
  include("commodity/grup_brg_sumberdaya/picker_grup_matgis.php");
}

public function add_grup_jasa_sumberdaya(){
  include("commodity/grup_jasa_sumberdaya/add_grup_jasa_smbd.php");
}

public function edit_grup_jasa_sumberdaya(){
  include("commodity/grup_jasa_sumberdaya/edit_grup_jasa_smbd.php");
}

public function view_grup_jasa_sumberdaya(){
  include("commodity/grup_jasa_sumberdaya/view_grup_jasa_sumberdaya.php");
}
public function data_grup_jasa_smbd(){
  include("commodity/grup_jasa_sumberdaya/data_grup_jasa_smbd.php");
}
public function dropdown_grup_jasa_smbd(){
  include("commodity/grup_jasa_sumberdaya/dropdown_grup_jasa_smbd.php");
}
public function submit_add_grup_jasa_smbd(){
  include("commodity/grup_jasa_sumberdaya/submit_add_grup_jasa_smbd.php");
}
public function submit_edit_grup_jasa_smbd(){
  include("commodity/grup_jasa_sumberdaya/submit_edit_grup_jasa_smbd.php");
}
public function picker_grup_jasa_sumberdaya(){
  include("commodity/grup_jasa_sumberdaya/picker_grup_jasa_smbd.php");
}

//end

public function view_grup_brg(){
  include("commodity/grup_brg/view_grup_brg.php");
}

public function data_grup_brg(){
  include("commodity/grup_brg/data_grup_brg.php");
}

public function dropdown_grup_brg(){
  include("commodity/grup_brg/dropdown_grup_brg.php");
}

public function alias_grup_brg(){
  include("commodity/grup_brg/alias_grup_brg.php");
}

public function add_grup_brg(){
  include("commodity/grup_brg/add_grup_brg.php");
}

public function submit_add_grup_brg(){
  include("commodity/grup_brg/submit_add_grup_brg.php");
}

public function edit_grup_brg(){
  $this->noAccess("Tidak dapat mengubah grup barang. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_brg/edit_grup_brg.php");
}

public function submit_edit_grup_brg(){
  $this->noAccess("Tidak dapat mengubah grup barang. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_brg/submit_edit_grup_brg.php");
}

public function delete_grup_brg(){
  $this->noAccess("Tidak dapat menghapus grup barang. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_brg/delete_grup_brg.php");
}

public function picker_grup_brg(){
  include("commodity/grup_brg/picker_grup_brg.php");
}

public function view_grup_jasa(){
  include("commodity/grup_jasa/view_grup_jasa.php");
}

public function data_grup_jasa(){
  include("commodity/grup_jasa/data_grup_jasa.php");
}

public function dropdown_grup_jasa(){
  include("commodity/grup_jasa/dropdown_grup_jasa.php");
}

public function alias_grup_jasa(){
  include("commodity/grup_jasa/alias_grup_jasa.php");
}

public function picker_grup_jasa(){
  include("commodity/grup_jasa/picker_grup_jasa.php");
}

public function add_grup_jasa(){
  include("commodity/grup_jasa/add_grup_jasa.php");
}

public function submit_add_grup_jasa(){
  include("commodity/grup_jasa/submit_add_grup_jasa.php");
}

public function edit_grup_jasa(){
  $this->noAccess("Tidak dapat mengubah grup jasa. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_jasa/edit_grup_jasa.php");
}

public function submit_edit_grup_jasa(){
  $this->noAccess("Tidak dapat mengubah grup jasa. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_jasa/submit_edit_grup_jasa.php");
}

public function delete_grup_jasa(){
  $this->noAccess("Tidak dapat menghapus grup jasa. Karena data terintergrasi pengadaan.com");
  //include("commodity/grup_jasa/delete_grup_jasa.php");
}

public function view_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/view_hrg_brg_smbd.php");
}

public function data_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/data_hrg_brg_smbd.php");
}

public function alias_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/alias_hrg_brg_smbd.php");
}

public function add_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/add_hrg_brg_smbd.php");
}

public function submit_add_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/submit_add_hrg_brg_smbd.php");
}

public function edit_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/edit_hrg_brg_smbd.php");
}

public function submit_edit_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/submit_edit_hrg_brg_smbd.php");
}

public function delete_hrg_brg_smbd(){
  include("commodity/hrg_brg_sumberdaya/delete_hrg_brg_smbd.php");
}

public function view_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/view_hrg_jasa_smbd.php");
}

public function data_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/data_hrg_jasa_smbd.php");
}

public function alias_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/alias_hrg_jasa_smbd.php");
}

public function add_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/add_hrg_jasa_smbd.php");
}

public function submit_add_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/submit_add_hrg_jasa_smbd.php");
}

public function edit_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/edit_hrg_jasa_smbd.php");
}

public function submit_edit_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/submit_edit_hrg_jasa_smbd.php");
}

public function delete_hrg_jasa_smbd(){
  include("commodity/hrg_jasa_sumberdaya/delete_hrg_jasa_smbd.php");
}

public function view_hrg_brg(){
  include("commodity/hrg_brg/view_hrg_brg.php");
}

public function data_hrg_brg(){
  include("commodity/hrg_brg/data_hrg_brg.php");
}

public function alias_hrg_brg(){
  include("commodity/hrg_brg/alias_hrg_brg.php");
}

public function add_hrg_brg(){
  include("commodity/hrg_brg/add_hrg_brg.php");
}

public function submit_add_hrg_brg(){
  include("commodity/hrg_brg/submit_add_hrg_brg.php");
}

public function edit_hrg_brg(){
  include("commodity/hrg_brg/edit_hrg_brg.php");
}

public function submit_edit_hrg_brg(){
  include("commodity/hrg_brg/submit_edit_hrg_brg.php");
}

public function delete_hrg_brg(){
  include("commodity/hrg_brg/delete_hrg_brg.php");
}

public function view_hrg_jasa(){
  include("commodity/hrg_jasa/view_hrg_jasa.php");
}

public function data_hrg_jasa(){
  include("commodity/hrg_jasa/data_hrg_jasa.php");
}

public function alias_hrg_jasa(){
  include("commodity/hrg_jasa/alias_hrg_jasa.php");
}

public function add_hrg_jasa(){
  include("commodity/hrg_jasa/add_hrg_jasa.php");
}

public function submit_add_hrg_jasa(){
  include("commodity/hrg_jasa/submit_add_hrg_jasa.php");
}

public function edit_hrg_jasa(){
  include("commodity/hrg_jasa/edit_hrg_jasa.php");
}

public function submit_edit_hrg_jasa(){
  include("commodity/hrg_jasa/submit_edit_hrg_jasa.php");
}

public function delete_hrg_jasa(){
  include("commodity/hrg_jasa/delete_hrg_jasa.php");
}

//katalog matgis
public function view_hrg_brg_smbd_matgis(){
  include("commodity/hrg_brg_sumberdaya_matgis/view_hrg_brg_smbd_matgis.php");
}

public function data_hrg_brg_smbd_matgis(){
  include("commodity/hrg_brg_sumberdaya_matgis/data_hrg_brg_smbd_matgis.php");
}

public function alias_hrg_brg_smbd_matgis(){
  include("commodity/hrg_brg_sumberdaya/alias_hrg_brg_smbd.php");
}

public function add_hrg_brg_smbd_matgis($is_matgis=true){
  include("commodity/hrg_brg_sumberdaya/add_hrg_brg_smbd.php");
}

public function submit_add_hrg_brg_smbd_matgis(){
  include("commodity/hrg_brg_sumberdaya/submit_add_hrg_brg_smbd.php");
}

public function edit_hrg_brg_smbd_matgis($is_matgis=true){
  include("commodity/hrg_brg_sumberdaya/edit_hrg_brg_smbd.php");
}

public function submit_edit_hrg_brg_smbd_matgis(){
  include("commodity/hrg_brg_sumberdaya/submit_edit_hrg_brg_smbd.php");
}

public function delete_hrg_brg_smbd_matgis(){
  include("commodity/hrg_brg_sumberdaya/delete_hrg_brg_smbd.php");
}
//end

public function view_sumber(){
  include("commodity/sumber/view_sumber.php");
}

public function data_sumber(){
  include("commodity/sumber/data_sumber.php");
}

public function alias_sumber(){
  include("commodity/sumber/alias_sumber.php");
}

public function add_sumber(){
  include("commodity/sumber/add_sumber.php");
}

public function submit_add_sumber(){
  include("commodity/sumber/submit_add_sumber.php");
}

public function edit_sumber(){
  include("commodity/sumber/edit_sumber.php");
}

public function submit_edit_sumber(){
  include("commodity/sumber/submit_edit_sumber.php");
}

public function delete_sumber(){
  include("commodity/sumber/delete_sumber.php");
}

public function approval_grup_brg(){
  include("commodity/daftar_pekerjaan/approval_grup_brg.php");
}

public function approval_grup_jasa(){
  include("commodity/daftar_pekerjaan/approval_grup_jasa.php");
}

public function submit_approval_grup_jasa(){
  include("commodity/daftar_pekerjaan/submit_approval_grup_jasa.php");
}

public function lihat_katalog_jasa($id = ""){
  include("commodity/kat_jasa/lihat_katalog_jasa.php");
}
public function lihat_katalog_barang($id = ""){
  include("commodity/mat_catalog/lihat_katalog_barang.php");
}

public function lihat_katalog_jasa_sumberdaya($id = ""){
  include("commodity/kat_jasa_sumberdaya/lihat_katalog_jasa_smbd.php");
}

public function lihat_katalog_barang_sumberdaya($id = ""){
  include("commodity/mat_catalog_sumberdaya/lihat_katalog_barang_smbd.php");
}

public function data_history_barang($id = ""){
  include("commodity/hrg_brg/data_history_barang.php");
}

public function detail_history_barang($id = ""){
  include("commodity/hrg_brg/detail_hist_hrg_brg.php");
}

public function detail_barang($id = ""){
  include("commodity/hrg_brg/detail_hrg_brg.php");
}
public function detail_barang_sumberdaya($id = ""){
  include("commodity/hrg_brg_sumberdaya/detail_hrg_brg_smbd.php");
}
public function data_history_jasa($id = ""){
  include("commodity/hrg_jasa/data_history_jasa.php");
}

public function detail_history_jasa($id = ""){
  include("commodity/hrg_jasa/detail_hist_hrg_jasa.php");
}

public function detail_jasa($id = ""){
  include("commodity/hrg_jasa/detail_hrg_jasa.php");
}
}
