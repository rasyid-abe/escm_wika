<?php

$data = array();

// $data['list_group'] = $this->Commodity_m->getMatSmbdGroupActive()->result_array();

$post = $this->input->post();

$selection = $this->data['selection_mat_group'];

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/katalog/grup_barang_sumberdaya'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat mengubah grup barang komoditi");
}

$data["mat_group"] = array();

foreach($selection as $k => $v){

  $getdata = $this->Commodity_m->getMatGroupSmbd($v)->row_array();

  $status = (isset($getdata['mat_group_status'])) ? $getdata['mat_group_status'] : "";

  $this->db->select('unspsc_code');
  $this->db->where('group_code', $v);
  $data = $this->db->get('com_group_smbd')->row_array();
  $unspsc_code = $data['unspsc_code'];

  //--Validasi ditutup--//
  //if ($unspsc_code == NULL || $status != "A") {

    if(!empty($getdata)){
      $level = $this->Commodity_m->getMatSmbdLevelGroupList($getdata['mat_group_code']);
      if (!empty($level)) {
        $getdata['level'] = $level;
      }else{
        $getdata['level'] = $this->db->select('group_code')
        ->get('com_group_smbd')->result_array();
      }
      
      $data["mat_group"][] = $getdata;
      
    }

    $getdata = $this->Comment_m->getCommodity("","",$getdata['mat_group_code'],"MATERIAL")->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  //}

}

if(empty($data['mat_group'])){

  $this->setMessage("Tidak bisa mengubah data yang statusnya aktif");
  redirect(site_url('commodity/katalog/grup_barang_sumberdaya'));

}


$view = 'commodity/grup_brg_sumberdaya/form_edit_grup_brg_smbd_v';

$this->template($view,"Ubah Grup Barang Sumberdaya",$data);
