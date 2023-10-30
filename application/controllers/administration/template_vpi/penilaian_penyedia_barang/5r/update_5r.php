<?php

$ar_id = $this->session->userdata('ar_id');

$ar_id = intval($ar_id);


switch ($this->input->get('key')) {
	case 'urutan':
		$data = array("ar_seq"=>intval($this->input->get("data")));
		break;
}

$this->db->trans_begin();

$update = $this->Administration_m->update5r($ar_id,$data,'barang');

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

$this->unset_session('ar_id');  
