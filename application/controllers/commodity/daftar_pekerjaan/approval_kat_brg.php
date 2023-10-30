<?php 

  $this->data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $data = array();

  $post = $this->input->post();

   $selection = array(0=>$this->uri->segment(4, 0));

  if (!empty($isSmbd)) {
   $data['list_group'] = $this->Commodity_m->getMatGroupSmbd(substr($this->uri->segment(4, 0), 0, 3))->result_array(); 
  } else {
    $parent = strlen($this->uri->segment(4, 0) >= 14) ? substr($this->uri->segment(4, 0), 0, 8) : (strlen($this->uri->segment(4, 0) == 10) ? substr($this->uri->segment(4, 0), 0, 4) : "");
   $data['list_group'] = $this->Commodity_m->getMatGroup($parent)->result_array();
  }

   $position = $this->Administration_m->getPosition("APPROVAL KOMODITI");

if(!$position){
  $this->noAccess("Hanya APPROVAL KOMODITI yang dapat approve katalog barang komoditi");
}

  foreach($selection as $k => $v){

    if (!empty($isSmbd)) {
      $getdata = $this->Commodity_m->getMatCatalogSmbd($v)->row_array();
    } else {
      $getdata = $this->Commodity_m->getMatCatalog($v)->row_array();
    }
      

    if(!empty($getdata)){
        $data["mat_catalog"][] = $getdata;
    }

       $getdata = $this->Comment_m->getCommodity($v)->result_array();

    if(!empty($getdata)){
        $data["comment_list"][$v] = $getdata;
    }

  }


  if (!empty($isSmbd)) {
    $view = 'commodity/daftar_pekerjaan/approval_kat_brg_smbd_v';
    $this->template($view,"Approval Katalog Barang Sumberdaya",$data);
  } else {
    $view = 'commodity/daftar_pekerjaan/approval_kat_brg_v';
    $this->template($view,"Approval Katalog Barang",$data);
  }
  