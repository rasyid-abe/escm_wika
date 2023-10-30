<?php

$ahm_id = $this->session->userdata('ahm_id');

$ahm_id = intval($ahm_id);


switch ($this->input->get('key')) {
  case 'urutan':
    $data = array("ahm_seq"=>intval($this->input->get("data")));
    break;
}

$this->db->trans_begin();

$update = $this->Administration_m->updateHasilMutuPekerjaan($ahm_id,$data,'konsultan');

if ($this->db->trans_status() === FALSE)
  {
    $this->db->trans_rollback();
    echo "Gagal Mengubah data";
  }
  else
  {
    $this->db->trans_commit();
    echo "Sukses Mengubah data";

  }

$this->unset_session('ahm_id');  
