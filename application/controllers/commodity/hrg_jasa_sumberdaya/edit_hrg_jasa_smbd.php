<?php 

  $this->data['dir'] = COMMODITY_KATALOG_JASA_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $data = array();

  $data['list_sourcing'] = $this->Commodity_m->getSourcing()->result_array();

  $data['list_del_point'] = $this->Administration_m->getDistrict()->result_array();
  // $data['list_del_point'] = $this->Administration_m->getDelPoint()->result_array();

  $data['list_catalog'] = $this->Commodity_m->getSrvCatalogSmbd()->result_array();

  $post = $this->input->post();

  $selection = $this->data['selection_srv_price'];

    if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/daftar_harga/daftar_harga_jasa_sumberdaya'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat mengubah harga jasa komoditi");
}

  foreach($selection as $k => $v){

    $getdata = $this->Commodity_m->getSrvSmbdPrice($v, "")->row_array();

    if(!empty($getdata)){
      $data["srv_price"][] = $getdata;
    }
    
    if ($getdata['status'] == "R") {
      $this->db->limit(2);
      $getdata = $this->Comment_m->getCommodity("",$v)->result_array();
    }else{
      $getdata = NULL;
    }

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

  $view = 'commodity/hrg_jasa_sumberdaya/form_edit_hrg_jasa_smbd_v';

  $this->template($view,"Ubah Harga Jasa Sumberdaya",$data);