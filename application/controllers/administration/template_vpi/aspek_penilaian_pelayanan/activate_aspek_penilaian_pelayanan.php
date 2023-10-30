<?php
$selection = $this->data['selection_aspek_penilaian_pelayanan'];

$this->db->trans_begin();

$nonaktifkan = $this->Administration_m->ActivateAspekPenilaianPelayanan($selection);

if ($this->db->trans_status() === FALSE)
  {
    $this->db->trans_rollback();
    echo "Gagal Mengaktifkan data";
  }
  else
  {
    $this->db->trans_commit();
    echo "Sukses Mengaktifkan data";

  }

$this->unset_session('selection_aspek_penilaian_pelayanan');
