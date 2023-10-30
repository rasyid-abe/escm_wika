<?php

$post= $this->input->post();

$input=array();

$n = 0;

$this->db->trans_begin();

foreach ($post as $key => $value) {

  if(is_array($value)){ 

    foreach ($value as $key2 => $value2) { 

      $this->form_validation->set_rules("level4_inp[$key2]", "lang:name #level_2", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("name_inp[$key2]", "lang:name #name_inp", 'required|max_length['.DEFAULT_MAXLENGTH.']');
      $this->form_validation->set_rules("code_inp[$key2]", "lang:name #code_inp", 'required|max_length['.DEFAULT_MAXLENGTH.']');

       $data = array(
            'unspsc_code'=>$post['level4_inp'][$key2],
            'group_code'=>$post['code_inp'][$key2],
			'group_name'=>$post['name_inp'][$key2],
          );

      $act = $this->Commodity_m->updateDataMatGroupSmbd($data);

    }

    $n++;

  }

}

if ($this->form_validation->run() == FALSE){

  $this->form_validation->set_error_delimiters('<p>', '</p>');

  $this->db->trans_rollback();

  $this->edit_grup_brg();

} else {

if ($this->db->trans_status() === FALSE)
{
  $this->setMessage("Gagal mengubah data");
  $this->db->trans_rollback();
}
else
{
  $this->setMessage("Sukses mengubah data");
  $this->db->trans_commit();
  redirect(site_url("commodity/katalog/grup_barang_sumberdaya"));
}

}
