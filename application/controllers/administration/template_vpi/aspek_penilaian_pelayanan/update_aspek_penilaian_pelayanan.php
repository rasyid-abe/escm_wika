<?php

$app_id = $this->session->userdata('app_id');

$app_id = intval($app_id);


switch ($this->input->get('key')) {
	case 'urutan':
		$data = array("app_seq"=>intval($this->input->get("data")));
		break;
}

$this->db->trans_begin();

$update = $this->Administration_m->updateAspekPenilaianPelayanan($app_id,$data);

if ($this->db->trans_status() === FALSE)
  {
    // $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
    echo "Gagal Mengubah data";
  }
  else
  {

    // $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
    echo "Sukses Mengubah data";

  }

$this->unset_session('app_id');  
