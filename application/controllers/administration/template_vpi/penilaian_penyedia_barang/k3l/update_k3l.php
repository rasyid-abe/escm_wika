<?php

$ak_id = $this->session->userdata('ak_id');

$ak_id = intval($ak_id);


switch ($this->input->get('key')) {
	case 'urutan':
		$data = array("ak_seq"=>intval($this->input->get("data")));
		break;
}

$this->db->trans_begin();

$update = $this->Administration_m->updateK3l($ak_id,$data,'barang');

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

$this->unset_session('ak_id');  
