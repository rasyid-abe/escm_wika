<?php
$selection = $this->data['selection_hasil_mutu_pekerjaan'];

$this->db->trans_begin();

$nonaktifkan = $this->Administration_m->ActivateHasilMutuPekerjaan($selection,'barang');

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

$this->unset_session('selection_hasil_mutu_pekerjaan');
