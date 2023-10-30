<?php

$apm_id = $this->session->userdata('apm_id');

$apm_id = intval($apm_id);


switch ($this->input->get('key')) {
	case 'urutan':
		$data = array("apm_seq"=>intval($this->input->get("data")));
		break;
}

$this->db->trans_begin();

$update = $this->Administration_m->updateAspekPenilaianMutu($apm_id,$data);

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

$this->unset_session('apm_id');  
