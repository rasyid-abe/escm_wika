<?php

$post= $this->input->post();

$this->form_validation->set_rules("level2_inp[0]", "lang:name #level_2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
$this->form_validation->set_rules("name_inp[0]", "lang:name #name_inp", 'required|max_length['.DEFAULT_MAXLENGTH.']');

if (!empty($post['level2smbd_inp'][0])) {
  $parent = $post['level2smbd_inp'][0];
} else {
  $parent = $post['level1smbd_inp'][0];
}

if ($this->form_validation->run() == FALSE){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->add_grup_brg_smbd();

} else {

  $this->db->trans_begin();

 if (isset($post['is_matgis_inp'][0]) AND !empty($post['is_matgis_inp'][0])){
  $is_matgis = "t";
 }else{
  $is_matgis = "f";
 }

 if (isset($post['level4_inp'][0]) AND !empty($post['level4_inp'][0])) {
    $unspsc_code = $post['level4_inp'][0];
  }else{
    $unspsc_code = $post['level2_inp'][0];
  }

  $data = array(
            'unspsc_code'=> $unspsc_code,
            'group_parent'=>$parent,
            'name'=>$post['name_inp'][0],
            'is_matgis' => $is_matgis
          );

   $act = $this->Commodity_m->insertDataMatGroupSmbd($data);


if ($this->db->trans_status() === FALSE)
{
  $this->setMessage("Gagal menambah data");
  $this->db->trans_rollback();
}
else
{
  $this->setMessage("Sukses menambah data");
  $this->db->trans_commit();
}

redirect(site_url("commodity/katalog/grup_barang_sumberdaya"));

}
