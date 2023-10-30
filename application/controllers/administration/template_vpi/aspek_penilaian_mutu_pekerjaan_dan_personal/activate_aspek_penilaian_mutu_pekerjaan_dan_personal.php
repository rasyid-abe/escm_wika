<?php
$selection = $this->data['selection_aspek_penilaian_mutu_pekerjaan_dan_personal'];

$this->db->trans_begin();

$nonaktifkan = $this->Administration_m->ActivateAspekPenilaianMutu($selection);

if ($this->db->trans_status() === FALSE)
  {
    // $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
    echo "Gagal Mengaktifkan data";
  }
  else
  {

    // $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
    echo "Sukses Mengaktifkan data";

  }

$this->unset_session('selection_aspek_penilaian_mutu_pekerjaan_dan_personal');
