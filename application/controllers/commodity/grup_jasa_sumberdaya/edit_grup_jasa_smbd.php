<?php

$data = array();

// $data['list_group'] = $this->Commodity_m->getSrvSmbdGroupActive()->result_array();

$post = $this->input->post();

$selection = $this->data['selection_srv_group'];

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/katalog/grup_jasa_sumberdaya'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat mengubah grup barang komoditi");
}

$data["mat_group"] = array();

foreach($selection as $k => $v){

  $getdata = $this->Commodity_m->getSrvGroupSmbd($v)->row_array();

  $status = (isset($getdata['srv_group_status'])) ? $getdata['srv_group_status'] : "";

  $this->db->select('unspsc_code');
  $this->db->where('group_code', $v);
  $data = $this->db->get('com_group_smbd')->row_array();
  $unspsc_code = $data['unspsc_code'];

  //--Validasi ditutup--//
  //if ($unspsc_code == NULL || $status != "A") {

    if(!empty($getdata)){
      $level = $this->Commodity_m->getSrvSmbdLevelGroupList($getdata['srv_group_code']);
      if (!empty($level)) {
        $getdata['level'] = $level;
      }else{
        $getdata['level'] = $this->db->select('group_code')
        ->get('com_group_smbd')->result_array();
      }
      $data["srv_group"][] = $getdata;
      
    }

    $getdata = $this->Comment_m->getCommodity("","",$getdata['srv_group_code'],"JASA")->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  //}

}

if(empty($data['srv_group'])){

  $this->setMessage("Tidak bisa mengubah data yang statusnya aktif");
  redirect(site_url('commodity/katalog/grup_jasa_sumberdaya'));

}


$view = 'commodity/grup_jasa_sumberdaya/form_edit_grup_jasa_smbd_v';

$this->template($view,"Ubah Grup Jasa Sumberdaya",$data);
