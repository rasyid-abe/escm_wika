<?php

$ap_id = $this->session->userdata('ap_id');

$ap_id = intval($ap_id);


switch ($this->input->get('key')) {
	case 'urutan':
		$data = array("ap_seq"=>intval($this->input->get("data")));
		break;
}

$this->db->trans_begin();

$update = $this->Administration_m->updatePengamanan($ap_id,$data,'jasa');

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

$this->unset_session('ap_id');  
